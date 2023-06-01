<?php

namespace Tests\App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use App\Models\User;
use App\Models\Vaccine;
use Tests\TestCase;

class DogControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->employee = User::factory()->create();
        $this->owner = Owner::factory()->create();
        $this->dog = Dog::factory()
            ->hasAttached(Vaccine::factory(3)
                ->sequence(
                    ['name' => Vaccine::REQUIRED_VACCINES['RABIES']],
                    ['name' => Vaccine::REQUIRED_VACCINES['DA2PP']],
                    ['name' => Vaccine::REQUIRED_VACCINES['BORDETELLA']],
                )->create())
            ->create(['owner_id' => $this->owner->id]);
    }

    /** @test */
    public function an_employee_can_add_a_dog_to_an_owner()
    {
        $this->actingAs($this->employee)->post(route(
            'dog.store', ['ownerId' => $this->owner->id]),
            [
                'name' => $this->dog->name,
                'breed' => $this->dog->breed,
                'sex' => $this->dog->sex,
                'date_of_birth' => $this->dog->date_of_birth,
                'owner_id' => $this->owner->id,
                'fixed' => $this->dog->fixed
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('dogs', ['id' => $this->dog->id, 'owner_id' => $this->dog->owner_id]);
    }

    /** @test */
    public function it_can_remove_a_dog_from_an_owner()
    {
        $this->actingAs($this->employee)->delete(route(
            'dog.delete', ['id' => $this->owner->id, 'dogId' => $this->dog->id]))
            ->assertSuccessful();

        $this->assertDatabaseMissing('dogs', ['id' => $this->dog->id]);
        $this->assertDatabaseHas('owners', ['id' => $this->owner->id]);
    }

    /** @test */
    public function it_can_update_a_dogs_vaccines()
    {
        $newDog = Dog::factory()->for($this->owner)->create();
        $vaccines = Vaccine::where('required', 1)->get();
        foreach ($vaccines as $vaccine){
            $newDog->vaccines()->attach($vaccine->id, [
                'expiry_date' => null
            ]);
            $newDog->vaccines()->updateExistingPivot($vaccine->id, [
                'expiry_date' => '2023-12-23'
            ]);
        }

       $this->assertTrue($newDog->isUpToDate());
    }
}
