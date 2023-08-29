<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
    public function it_searches_by_owner_name()
    {
        $user = User::factory()->create();
        $owner1 = Owner::factory()->create(['name' => 'Wendal']);
        Owner::factory()->create(['name' => 'Randall']);
        $dog1 = Dog::factory()->for($owner1)->create(['name' => 'weeendall']);
        $owner3 = Owner::factory()->create(['name' => 'Wendalll']);

        $response = $this->actingAs($user)
            ->getJson(route('owner.index', ['query' => 'Wend']))
            ->assertSuccessful()
            ->assertJsonCount(2);
        $response->assertJson([
            [
                'name' => $owner1->name,
                'dogs' => [
                    ['name' => $dog1->name]
                ]
            ],
            [
                'name' => $owner3->name,
                'dogs' => []
            ],
        ]);
    }
}
