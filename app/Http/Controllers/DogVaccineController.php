<?php

namespace App\Http\Controllers;
use App\Http\Requests\DogVaccine\DogVaccineRequest;
use App\Models\DogVaccine;

class DogVaccineController extends Controller
{
    public function store(DogVaccineRequest $request)
    {
        return DogVaccine::create($request->validated());
    }
}
