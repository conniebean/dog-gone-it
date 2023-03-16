<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function promote($id)
    {
        $user = User::where('id', $id)->first();

        $user->role_id = 2;

        $user->save();
    }
}
