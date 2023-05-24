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
    public function an_admin_can_create_an_employee()
    {
        self::markTestSkipped();
    }

    /** @test */
    public function an_admin_can_delete_an_employee()
    {
        self::markTestSkipped();
    }

    /** @test */
    public function an_admin_can_update_an_employee()
    {
        self::markTestSkipped();
    }

    /** @test */
    public function an_admin_can_promote_an_employee_to_an_admin()
    {
        $admin = User::factory()->create(['role_id' => 2]);
        $employee = User::factory()->create();

        $this->actingAs($admin)->put(route('employee.promote', $employee), ['id' => $employee->id])->assertSuccessful();

        $this->assertEquals(2, $employee->fresh()->role_id);
    }
}
