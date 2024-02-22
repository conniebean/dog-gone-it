<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class OwnerControllerTest extends TestCase
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
    public function it_can_update_an_owner()
    {
        self::markTestSkipped();
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
    public function it_can_return_list_of_dogs_belonging_to_an_owner()
    {
        $admin = User::factory()->create(['role_id' => 2]);
        $owner = Owner::factory()->create(['name' => 'John French']);
        $owner1 = Owner::factory()->create(['name' => 'John PaulIII']);
        $owner2 = Owner::factory()->create(['name' => 'Paul English']);
        $owner3 = Owner::factory()->create(['name' => 'Ringo Spanish']);
        $dog = Dog::factory()->for($owner)->create(['name' => 'Fluffy']);
        $dog1 = Dog::factory()->for($owner1)->create(['name' => 'Stubby']);
        $dog2 = Dog::factory()->for($owner2)->create(['name' => 'Charles']);
        $route=$this->actingAs($admin)->post(route('owner.search',['name'=>'John']))->assertSuccessful();

        $route->assertJsonFragment([$dog->name]);
        $route->assertJsonFragment([$dog1->name]);
        $route->assertJsonMissing([$dog2->name]);
    }
}
