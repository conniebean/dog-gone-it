<?php

namespace Tests\App\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Models\Dog;
use App\Models\Owner;
use App\Models\User;
use App\Models\Vaccine;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function an_employee_can_create_an_owner()
    {
        $employee = User::factory()->create();
        $owner = Owner::factory()->raw();
        $this->actingAs($employee)->post(route('owner.store'), ['owner' => $owner])->assertSuccessful();

        $this->assertDatabaseHas('owners', $owner);
    }

    /** @test */
    public function an_employee_can_not_remove_an_owner()
    {
        $employee = User::factory()->create();
        $owner = Owner::factory()->raw(['id' => 1234]);
        $this->actingAs($employee)->post(route('owner.store'), ['owner' => $owner])->assertSuccessful();

        $this->assertDatabaseHas('owners', $owner);

        $this->actingAs($employee)->delete(route('owner.delete', $owner))->assertUnauthorized();

        $this->assertDatabaseHas('owners', $owner);
    }

    /** @test */
    public function an_employee_can_add_a_dog_to_an_owner()
    {
        $employee = User::factory()->create();
        $owner = Owner::factory()->create();
        $dog = Dog::factory()
            ->hasAttached(Vaccine::factory(3)
                ->sequence(
                   ['name' => Vaccine::REQUIRED_VACCINES['RABIES']],
                   ['name' => Vaccine::REQUIRED_VACCINES['DA2PP']],
                   ['name' => Vaccine::REQUIRED_VACCINES['BORDETELLA']],
                )->create())
            ->create(['owner_id' => $owner->id]);

        $this->actingAs($employee)->post(route(
            'owner.dog.store',
            [
                'name' => $dog->name,
                'breed' => $dog->breed,
                'sex' => $dog->sex,
                'owner_id' => $owner->id,
                'date_of_birth' => $dog->date_of_birth,
                'fixed' => $dog->fixed
            ]))
            ->assertSuccessful();

        $this->assertDatabaseHas('dogs', ['id' => $dog->id, 'owner_id' => $dog->owner_id]);
    }

    /** @test */
    public function an_admin_can_remove_an_owner()
    {
        $admin = User::factory()->create(['role_id' => 2]);
        $owner = Owner::factory()->raw(['id' => 1234]);
        $this->actingAs($admin)->post(route('owner.store'), ['owner' => $owner])->assertSuccessful();

        $this->assertDatabaseHas('owners', $owner);

        $this->actingAs($admin)->delete(route('owner.delete', $owner))->assertSuccessful();

        $this->assertDatabaseMissing('owners', $owner);
    }

    /** @test */
    public function an_admin_can_change_an_employee_to_an_admin()
    {
        $admin = User::factory()->create(['role_id' => 2]);
        $employee = User::factory()->create();

        $this->actingAs($admin)->put(route('employee.promote', $employee), ['id' => $employee->id])->assertSuccessful();

        $this->assertEquals(2, $employee->fresh()->role_id);
    }
}
