<?php

namespace App\Http\Controllers;

use App\Http\Requests\Owner\StoreOwnerRequest;
use App\Http\Requests\Owner\UpdateOwnerRequest;
use App\Http\Resources\OwnerResource;
use App\Models\Dog;
use App\Models\Owner;
use App\Models\Vaccine;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::query()->orderBy('name')->paginate(7);
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
        if ($request->name) {
            $owners = Owner::where('name', 'like', '%' . $request->name . '%')->get();
            return $owners;

        }
        else{
            return Owner::all();
        }
    }

    public function searchDogs(Request $request)
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
        $dogs = Dog::where('owner_id', $owner->id)->get();

        $dogs->each(function ($dog) {
            $dog->is_up_to_date = $dog->isUpToDate();
        });

        return Inertia::render('Owners/Profile', [
            'owner' => $owner,
            'dogs' => $dogs,
            'vaccines' => Vaccine::where('required', 1)->get(),
        ]);
    }

    public function edit(Owner $owner)
    {
        //
    }

    public function update(UpdateOwnerRequest $request, $id)
    {
        return Owner::findOrFail($id)->update($request->validated());
    }

    public function delete($id): void
    {
        $record = Owner::find($id);
        $record->delete();
    }
}
