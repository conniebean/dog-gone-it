<?php

namespace App\Http\Controllers;
use App\Http\Requests\DogVaccine\DogVaccineRequest;
use App\Models\DogVaccine;

class DogVaccineController extends Controller
{
    public function store(DogVaccineRequest $request)
    {
        $validated = $request->validated();

        $newRecords = collect($validated)->map(function($record) {
            return DogVaccine::create($record);
        });

        return response()->json([
            'message' => 'Vaccines added successfully',
            'data' => $newRecords
        ], 200);
    }
}
