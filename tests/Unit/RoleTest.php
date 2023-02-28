<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_user_can_have_a_role_assigned()
    {
        $user = User::factory()->create(['role_id' => 1]);

        $this->assertEquals('employee', $user->role->role_name);
    }
}
