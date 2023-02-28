<?php

namespace App\Http\Controllers;

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

    public function test_it_can_create_an_owner()
    {
        $user = User::factory()->create();
        $owner = new Owner(['id' => uniqid(), 'name' => 'Billy']);

        $user->create($owner);

        $expected = DB::table('owners')->where('name', 'billy');

        dump($expected);exit;
    }
}
