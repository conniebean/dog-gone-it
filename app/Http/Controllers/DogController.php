<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dog\StoreDogRequest;
use App\Http\Requests\Dog\UpdateDogRequest;
use App\Http\Resources\DogResource;
use App\Models\Dog;
use App\Models\Owner;
use Inertia\Inertia;

class DogController extends Controller
{
    public function index()
    {
        $dogs = Dog::query()->orderBy('name')->paginate(7);
        return Inertia::render('Dogs/Index', [
            'dogs' => $dogs->items(),
            'lastPage' => $dogs->lastPage(),
            'total' => $dogs->total(),
        ]);
    }

    public function store(StoreDogRequest $request): DogResource
    {
        return DogResource::make(Dog::create($request->validated()));
    }

    public function show()
    {
        //
    }

    public function edit(Dog $dog)
    {
        //
    }

    public function update(UpdateDogRequest $request, $dogId, $ownerId)
    {
        return Dog::findOrFail($dogId)->where('owner_id', $ownerId)->update($request->validated());
    }

    public function delete($dogId, $ownerId)
    {
        $owner = Owner::findOrFail($ownerId);
        $dog = $owner->dogs()->findOrFail($dogId);

        return response()->json($dog->delete());
    }
}
