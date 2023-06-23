<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dog\StoreDogRequest;
use App\Http\Resources\DogResource;
use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Inertia\Inertia;

class DogController extends Controller
{
    public function index()
    {
    }

    public function store(StoreDogRequest $request): DogResource
    {
        return DogResource::make(Dog::create($request->validated()));
    }

    public function show()
    {
        return Inertia::render('Dogs/Index', [
            'dogs' => Dog::all()
        ]);
    }

    public function edit(Dog $dog)
    {
        //
    }

    public function update(Request $request, Dog $dog)
    {
        //
    }

    public function delete($ownerId, $dogId)
    {
        $owner = Owner::findOrFail($ownerId);
        $dog = $owner->dogs()->findOrFail($dogId);

        $dog->delete();
    }
}
