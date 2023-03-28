<?php

namespace Tests\App\Http\Controllers;

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
        $this->dog = Dog::factory()->create(['owner_id' => $this->owner->id]);
    }

    /** @test */
    public function it_can_add_a_dog_to_the_daycare()
    {
        $this->vaccinesUpToDate();

        $this->postToDaycare($this->time->toDateString())->assertSuccessful();

        $this->assertDatabaseHas('daycare', ['dog_id' => $this->dog->id]);
    }

    /** @test */
    public function it_cannot_add_a_dog_to_the_daycare_on_a_date_in_the_past()
    {
        $this->vaccinesUpToDate();

        $this->postToDaycare($this->time->subDay()->toDateString())->assertInvalid();

        $this->assertDatabaseMissing('daycare', ['dog_id' => $this->dog->id]);
    }

    /** @test */
    public function it_cannot_add_a_dog_to_daycare_with_expired_vaccines()
    {
        $this->vaccinesUpToDate(false);

        $this->postToDaycare($this->time->toDateString())->assertForbidden();
    }

    /** @test */
    public function it_cannot_add_a_dog_more_than_once_on_the_same_day()
    {
        $this->vaccinesUpToDate();

        $this->postToDaycare($this->time->toDateString())->assertSuccessful();

        $this->assertDatabaseHas('daycare', ['dog_id' => $this->dog->id]);

        $this->postToDaycare($this->time->toDateString())->assertForbidden();
    }

    /**@test */
    public function it_cannot_add_a_dog_if_they_do_not_have_all_required_vaccines()
    {

    }

    /**@test */
    public function it_cannot_add_a_dog_to_daycare_when_the_daycare_is_full()
    {

    }

    public function vaccinesUpToDate(bool $value = true)
    {
        return Vaccine::factory(3)->for($this->dog)->create(['up_to_date' => $value]);
    }

    public function postToDaycare($time): TestResponse
    {
        return $this->actingAs($this->employee)->post(
            route('daycare.store', [
                'dog_id' => $this->dog->id,
                'visit-type' => 'full-day',
                'paid' => false,
                'daycare-date' => $time
            ])
        );
    }
}
