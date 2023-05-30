<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        return User::create($validated);
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
    }

    public function promote($id)
    {
        $user = User::where('id', $id)->first();

        $user->role_id = 2;

        $user->save();
    }
}
