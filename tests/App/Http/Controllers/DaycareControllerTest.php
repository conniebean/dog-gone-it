<?php

namespace Tests\App\Http\Controllers;

use App\Models\Daycare;
use App\Models\Dog;
use App\Models\Owner;
use App\Models\User;
use App\Models\Vaccine;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class DaycareControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->time = Carbon::now();
        $this->employee = User::factory()->create();
        $this->owner = Owner::factory()->create();
        $this->dog = Dog::factory()
            ->for($this->owner)
            ->hasAttached(Vaccine::where('required', 1)->get())
            ->create();
        $this->dog->vaccines()->update(['up_to_date' => 1]);
    }

    /** @test */
    public function it_can_add_a_dog_to_the_daycare()
    {
        $this->postToDaycare($this->time->toDateString(), $this->dog)->assertSuccessful();

        $this->assertDatabaseHas('daycare', ['dog_id' => $this->dog->id]);
    }

    /** @test */
    public function it_cannot_add_a_dog_to_the_daycare_on_a_date_in_the_past()
    {
        $this->postToDaycare($this->time->subDay()->toDateString(), $this->dog)->assertInvalid();

        $this->assertDatabaseMissing('daycare', ['dog_id' => $this->dog->id]);
    }

    /** @test */
    public function it_cannot_add_a_dog_to_daycare_with_expired_vaccines()
    {
        $dogWithoutUpToDateVaccines = Dog::factory()
            ->for($this->owner)
            ->hasAttached(Vaccine::where('required', 1)->get())
            ->create();
        $dogWithoutUpToDateVaccines->vaccines()->update(['up_to_date' => 0]);

        $this->postToDaycare($this->time->subDay()->toDateString(), $dogWithoutUpToDateVaccines)->assertInvalid();

        $this->assertDatabaseMissing('daycare', ['dog_id' => $dogWithoutUpToDateVaccines->id]);
    }


    /** @test */
    public function it_cannot_add_a_dog_more_than_once_on_the_same_day()
    {
        $this->postToDaycare($this->time->toDateString(), $this->dog)->assertSuccessful();

        $this->assertDatabaseHas('daycare', ['dog_id' => $this->dog->id]);

        $this->postToDaycare($this->time->toDateString(), $this->dog)->assertForbidden();
    }

    /** @test */
    public function it_cannot_add_a_dog_if_they_do_not_have_all_required_vaccines()
    {
        $newDog = Dog::factory()->create();
        $newDog->vaccines()->attach(Vaccine::where('required', 1)->first());

        $this->assertEquals(false, $newDog->hasAllRequiredVaccines());
    }

    /** @test */
    public function it_cannot_add_a_dog_to_daycare_when_the_daycare_is_full()
    {
        Daycare::factory(20)->create(['daycare-date' => $this->time->toDateString()]);
        $newDog = Dog::factory()->create(['owner_id' => $this->owner]);

        $this->postToDaycare($this->time->toDateString(), $newDog)->assertForbidden();
    }

    public function vaccinesUpToDate()
    {
        return $this->dog->hasAllRequiredVaccines();
    }

    public function postToDaycare($time, $dog): TestResponse
    {
        return $this->actingAs($this->employee)->post(
            route('daycare.store', [
                'dog_id' => $dog,
                'visit-type' => 'full-day',
                'paid' => false,
                'daycare-date' => $time
            ])
        );
    }
}
