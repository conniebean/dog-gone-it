<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerController extends Controller
{
    public function index()
    {
        return Inertia::render('Owners/Index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner' => 'required'
        ]);
        return Owner::create($request->input('owner'));
    }

    public function search(Request $request)
    {
        $dogs = [];
        if ($request->name) {
            $owners = Owner::where('name', 'like', '%' . $request->name . '%')->with('dogs')->get();
            $dogs = $owners->flatMap->dogs;
            $dogs->each(function ($d) {
               return $d->name;
            });
        } else {
            $dogs = Dog::all();
        }

        return $dogs;
    }

    public function show(Owner $owner)
    {
        return Owner::find($owner->id)->with('dog_id')->get();

        // Check for search input

        return view('welcome')->with('users', $users);
    }

    public function edit(Owner $owner)
    {
        //
    }

    public function update(Request $request, Owner $owner)
    {
        //
    }

    public function delete($id)
    {
        $record = Owner::find($id);
        $record->delete();
    }
}
