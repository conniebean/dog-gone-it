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

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role_id' => 2]);
        $this->employee = User::factory()->create();

    }

    /** @test */
    public function an_admin_can_create_an_employee()
    {
        $this->actingAs($this->admin)->post(route('employee.create'), [
            'name' => 'Connie Kennedy',
            'email' => 'connie.kennedy@test.com',
            'password' => 'password',
            'role_id' => 1
        ])->assertSuccessful();

        $this->assertDatabaseHas('users', ['id' => $this->employee->id]);
    }

    /** @test */
    public function an_employee_cannot_create_an_employee()
    {
        $this->actingAs($this->employee)->post(route('employee.create'), [
            'id' => 'someId',
            'name' => 'Connie Kennedy',
            'email' => 'connie.kennedy@test.com',
            'password' => 'password',
            'role_id' => 1
        ])->assertUnauthorized();

        $this->assertDatabaseMissing('users', ['id' => 'someId']);
    }

    /** @test */
    public function an_admin_can_delete_an_employee()
    {
        $newEmployee = User::factory()->create();
        $this->actingAs($this->admin)->delete(route(
            'employee.delete',
            ['userId' => $newEmployee->id]),
        )->assertSuccessful();

        $this->assertDatabaseMissing('users', ['id' => $newEmployee->id]);
    }

    /** @test */
    public function an_employee_cannot_delete_an_employee()
    {
        $this->actingAs($this->employee)->delete(route(
            'employee.delete',
            ['userId', $this->employee->id]),
        )->assertUnauthorized();

        $this->assertDatabaseHas('users', ['id' => $this->employee->id]);
    }

    /** @test */
    public function an_admin_can_update_an_employee()
    {
        $originalEmployee = User::factory()->create([
            'name' => 'original name',
            'email' => 'snickers@foobar.com',
        ]);

        $this->actingAs($this->admin)->put(route('employee.update', [
            'id' => $originalEmployee->id
        ]), [
            'name' => 'new name',
            'email' => $originalEmployee->email,
            'password' => $originalEmployee->password,
            'role_id' => $originalEmployee->role_id
        ])->assertSuccessful();

        $originalEmployee->refresh();

        $this->assertEquals('new name', $originalEmployee->name);
    }

    /** @test */
    public function an_admin_can_promote_an_employee_to_an_admin()
    {
        $this->actingAs($this->admin)->put(route('employee.promote', $this->employee), ['id' => $this->employee->id])->assertSuccessful();

        $this->assertEquals(2, $this->employee->fresh()->role_id);
    }
}
