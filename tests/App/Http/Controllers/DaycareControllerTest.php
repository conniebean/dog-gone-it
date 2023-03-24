<?php

namespace Tests\App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DaycareControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_add_a_dog_to_the_daycare()
    {
        $time = Carbon::now();
        $employee = User::factory()->create();
        $owner = Owner::factory()->create();
        $dog = Dog::factory()->create(['owner_id' => $owner->id]);

        $this->actingAs($employee)->post(route('daycare.store', [
            'dog_id' => $dog->id,
            'visit-type' => 'full-day',
            'paid' => false,
            'daycare-date' => $time->addDays(5)->toDateString()
        ]))->assertSuccessful();

        $this->assertDatabaseHas('daycare', ['dog_id' => $dog->id]);
    }

    /** @test */
    public function it_cannot_add_a_dog_to_the_daycare_on_a_date_in_the_past()
    {
        $time = Carbon::now();
        $employee = User::factory()->create();
        $owner = Owner::factory()->create();
        $dog = Dog::factory()->create(['owner_id' => $owner->id]);

        $this->actingAs($employee)->post(route('daycare.store', [
            'dog_id' => $dog->id,
            'visit-type' => 'full-day',
            'paid' => false,
            'daycare-date' => $time->subDay()->toDateString()
        ]))->assertInvalid();

        $this->assertDatabaseMissing('daycare', ['dog_id' => $dog->id]);
    }
}
