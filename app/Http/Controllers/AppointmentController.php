<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Mail\AppointmentBooked;
use App\Models\Appointment;
use App\Models\Daycare;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index()
    {
        //if date selected is not today, filter appointments by that specific date
        //otherwise, default to today
        return Appointment::today()->get();
    }

    public function store(StoreAppointmentRequest $request): AppointmentResource
    {
        $validated = $request->validated();

        $appointment = Appointment::create($validated);
        Mail::to($appointment->dog->owner->email)->send(new AppointmentBooked($appointment));

        return AppointmentResource::make($appointment);
    }

    public function show(Daycare $daycare)
    {
        //
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment): JsonResponse
    {
        $appointment->update($request->validated());
        return response()->json(AppointmentResource::make($appointment));
    }

    public function delete(Appointment $appointment): JsonResponse
    {
        $appointment->delete();
        return response()->json([], 204);
    }
}
