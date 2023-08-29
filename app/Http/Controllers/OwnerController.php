<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return new JsonResponse(Owner::query()
            ->where('name', 'LIKE', "%{$request->input('query')}%")
            ->with('dogs')->get());
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

    public function show(Owner $owner)
    {
        //
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
