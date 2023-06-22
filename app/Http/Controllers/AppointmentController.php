<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Daycare;

class AppointmentController extends Controller
{
    public function index()
    {
        return Appointment::all();
    }

    public function store(StoreAppointmentRequest $request)
    {
        $validated = $request->validated();

        //todo: send our mail in here
        //https://laravel.com/docs/9.x/mail#generating-markdown-mailables

        return AppointmentResource::make(Appointment::create($validated));
    }

    public function show(Daycare $daycare)
    {
        //
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());
        return response()->json(AppointmentResource::make($appointment));
    }

    public function delete(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json([], 204);
    }
}
