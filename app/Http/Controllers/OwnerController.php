<?php

namespace App\Http\Controllers;

use App\Http\Requests\Owner\StoreOwnerRequest;
use App\Http\Resources\OwnerResource;
use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::query()->paginate(10);
        return Inertia::render('Owners/Index', [
            'owners' => $owners->items(),
            'lastPage' => $owners->lastPage(),
            'total' => $owners->total(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreOwnerRequest $request)
    {
        $validated = $request->validated();

        $owner = Owner::create($validated);
        return response()->json(OwnerResource::make($owner));
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

    public function show(Request $request)
    {
        $owner = Owner::where('id', $request->id)->firstOrFail();

        return Inertia::render('Owners/Profile', [
            'owner' => $owner,
            'dogs' => Dog::where('owner_id', $owner->id)->get(),
        ]);
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
