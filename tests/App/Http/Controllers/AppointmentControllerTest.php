<?php

namespace Tests\App\Http\Controllers;

use App\Jobs\SendReminderEmail;
use App\Mail\AppointmentBooked;
use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use App\Models\Daycare;
use App\Models\Dog;
use App\Models\Facility;
use App\Models\Owner;
use App\Models\User;
use App\Models\Vaccine;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AppointmentControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->date = Carbon::now();
        $this->vaccineExpiryDate = Carbon::now()->addWeek();
        $this->employee = User::factory()->create();
        $this->owner = Owner::factory()->create();
        $this->dog = Dog::factory()->for($this->owner)->create();
        $this->vaccines = Vaccine::where('required', 1)->get();
        $this->facility = Facility::factory()->create();

        $this->attachVaccines($this->dog, $this->vaccineExpiryDate->toDateString());
    }

    /** @test */
    public function it_can_add_a_dog_to_the_daycare()
    {
        $this->postToDaycare($this->dog, $this->date->toDateString())->assertSuccessful();

        $this->assertDatabaseHas('appointments', ['dog_id' => $this->dog->id]);
    }

    /** @test */
    public function it_sends_a_confirmation_email_upon_successful_appointment_booking()
    {
        Mail::fake();
        $dog = Dog::factory()->create(['owner_id' => $this->owner]);
        $this->attachVaccines($dog, $this->vaccineExpiryDate->toDateString());

        $this->postToDaycare($dog, $this->date->addWeek()->toDateString());

        Mail::assertSent(AppointmentBooked::class, function ($mail){
            return $mail->hasTo($this->owner->email);
        });
    }

    /** @test */
    public function it_sends_a_reminder_notification_email_24_hours_before_an_appointment()
    {
        Mail::fake();
        Event::fake();

        Appointment::factory(10)->sequence(
            ['appointment_date' => $this->date->addDay()->toDateString()],
            ['appointment_date' => $this->date->addWeek()->toDateString()],
        )->create();

        SendReminderEmail::dispatch();

        Mail::assertSent(AppointmentReminder::class, 5);
    }

    /** @test */
    public function it_can_show_the_list_of_daycare_appointments_for_a_single_day()
    {
        Appointment::factory(10)->sequence(
            ['appointment_date' => Carbon::today()],
            ['appointment_date' => Carbon::tomorrow()]
        )->create();

        $this->assertEquals(5, Appointment::today()->get()->count());
    }

    /** @test */
    public function it_cannot_add_a_dog_to_the_daycare_on_a_date_in_the_past()
    {
        $this->postToDaycare($this->dog, $this->date->subMonth()->toDateString())
            ->assertJsonFragment(['message' => "Daycare-date must be today or a date in the future."]);

        $this->assertDatabaseMissing('appointments', ['dog_id' => $this->dog->id]);
    }

    /** @test */
    public function it_cannot_add_a_dog_to_daycare_with_expired_vaccines()
    {
        $dogWithoutUpToDateVaccines = Dog::factory()
            ->for($this->owner)
            ->create();

        $this->attachVaccines($dogWithoutUpToDateVaccines);

        $this->postToDaycare($dogWithoutUpToDateVaccines, $this->date->addWeek()->toDateString())->assertUnprocessable();

        $this->assertDatabaseMissing('appointments', ['dog_id' => $dogWithoutUpToDateVaccines->id]);
    }

    /** @test */
    public function it_cannot_add_a_dog_more_than_once_on_the_same_day()
    {
        $this->postToDaycare($this->dog, $this->date->toDateString())->assertSuccessful();

        $this->assertDatabaseHas('appointments', ['dog_id' => $this->dog->id]);

        $this->postToDaycare($this->dog, $this->date->toDateString())->assertUnprocessable();
    }

    /** @test */
    public function it_cannot_add_a_dog_if_they_do_not_have_all_required_vaccines()
    {
        $newDog = Dog::factory()->create();
        $newDog->vaccines()->attach(Vaccine::where('required', 1)->first(), [
            'expiry_date' => '2023-12-24'
        ]);

        $this->postToDaycare($newDog, $this->date->toDateString())->assertUnprocessable();
        $this->assertEquals(false, $newDog->hasAllRequiredVaccines());
    }

    /** @test */
    public function it_cannot_add_a_dog_to_daycare_when_the_daycare_is_full()
    {
        Appointment::factory(20)->create([
            'appointment_date' => $this->date->toDateString(),
            'facility_id' => $this->facility->id
        ]);

        $newDog = Dog::factory()->create(['owner_id' => $this->owner->id]);
        $this->attachVaccines($newDog, $this->vaccineExpiryDate->toDateString());

        $this->postToDaycare($newDog, $this->date->toDateString())->assertUnprocessable();
    }

    /** @test */
    public function it_can_remove_a_dog_from_daycare()
    {
        $newDog = Dog::factory()->create();
        $this->attachVaccines($newDog, $this->vaccineExpiryDate->toDateString());
        $appointmentToDelete = Appointment::factory()->create([
            'appointment_date' => $this->date->toDateString(),
            'facility_id' => $this->facility->id,
            'dog_id' => $newDog->id
        ]);
        Appointment::factory(5)->create([
            'appointment_date' => $this->date->toDateString(),
            'facility_id' => $this->facility->id
        ]);

        $this->assertDatabaseHas('appointments', ['dog_id' => $newDog->id]);
        $this->assertEquals(6, Appointment::all()->count());

        $this->actingAs($this->employee)->delete
        (route('appointment.delete', $appointmentToDelete->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('appointments', ['dog_id' => $newDog->id, 'id' => $appointmentToDelete->id]);
        $this->assertEquals(5, Appointment::all()->count());
    }

    /** @test */
    public function it_can_update_an_existing_appointment()
    {
        $appointment = Appointment::factory()->create([
            'dog_id' => $this->dog->id,
            'appointment_date' => $this->date->toDateString(),
            'facility_id' => $this->facility->id,
            'paid' => false
        ]);

        $this->assertEquals(0, $appointment['paid']);

        $this->actingAs($this->employee)->put(route('appointment.update', $appointment),
            $this->baseUpdateAppointment($appointment->dog, $this->date->toDateString(), [
                'paid' => true
            ]))->assertOk();

        $appointment->refresh();

        $this->assertEquals(1, $appointment['paid']);
    }

    public function attachVaccines(Dog $dog, $date = null): void
    {
        foreach ($this->vaccines as $vaccine) {
            $dog->vaccines()->attach($vaccine->id, [
                'expiry_date' => $date,
            ]);
        }
    }

    public function postToDaycare($dog, $date): TestResponse
    {
        return $this->actingAs($this->employee)->postJson(
            route('appointment.store', [
                'dog_id' => $dog->id,
                'facility_id' => $this->facility->id,
                'appointmentable_id' => 1,
                'appointmentable_type' => Daycare::class,
                'check_in' => $this->date->subHour(),
                'check_out' => $this->date->addHour(),
                'appointment_date' => $date,
                'paid' => false
            ])
        );
    }

    public function baseUpdateAppointment($dog, $date, $attributes = []): array
    {
        $appointmentStuff = [
            'dog_id' => $dog->id,
            'facility_id' => $this->facility->id,
            'appointmentable_id' => 1,
            'appointmentable_type' => Daycare::class,
            'check_in' => $this->date->subHour(),
            'check_out' => $this->date->addHour(),
            'appointment_date' => $date,
            'paid' => false
        ];
        return array_merge($appointmentStuff, $attributes);
    }
}
