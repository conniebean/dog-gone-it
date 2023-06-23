<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(StoreEmployeeRequest $request)
    {
        return User::create($request->validated());
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        return User::findOrFail($id)->update($request->validated());
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
