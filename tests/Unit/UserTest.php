<?php

namespace Tests\Unit;

use App\Models\Dog;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function an_employee_can_create_an_owner()
    {
        $employee = User::factory()->create(['role_id' => 1]);
        $owner = Owner::factory()->raw();
        $this->actingAs($employee)->post(route('owner.store'), ['owner' => $owner])->assertSuccessful();

        $this->assertDatabaseHas('owners', $owner);
    }

    /** @test */
    public function an_employee_can_not_remove_an_owner()
    {
        $employee = User::factory()->create(['role_id' => 1]);
        $owner = Owner::factory()->raw();
        $this->actingAs($employee)->post(route('owner.store'), ['owner' => $owner])->assertSuccessful();

        $this->assertDatabaseHas('owners', $owner);

        $this->actingAs($employee)->delete(route('owner.delete', $owner))->assertUnauthorized();

        $this->assertDatabaseHas('owners', $owner);
    }

    /** @test */
    public function an_employee_can_add_a_dog_to_an_owner()
    {
        $employee = User::factory()->create(['role_id' => 1]);
        $owner = Owner::factory()->create();
        $dog = Dog::factory()->raw(['owner_id' => $owner->id]);

        $this->actingAs($employee)->post(route('owner/dog', $dog))->assertSuccessful();

        $this->assertDatabaseHas('dogs', ['owner_id' => $dog->owner_id]);
    }

    /** @test */
    public function an_admin_can_remove_an_owner()
    {
        $admin = User::factory()->create(['role_id' => 2]);
        $owner = Owner::factory()->raw();
        $this->actingAs($admin)->post(route('owner.store'), ['owner' => $owner])->assertSuccessful();

        $this->assertDatabaseHas('owners', $owner);

        $this->actingAs($admin)->delete(route('owner.delete', $owner))->assertSuccessful();

        $this->assertDatabaseMissing('owners', $owner);
    }
}
