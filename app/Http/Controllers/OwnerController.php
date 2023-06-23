<?php

namespace App\Http\Controllers;

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
