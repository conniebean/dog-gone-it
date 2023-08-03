<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Mail\AppointmentBooked;
use App\Models\Appointment;
use App\Models\Daycare;
use App\Models\Dog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index()
    {
        //
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

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());
        return redirect()->back();
    }

    public function delete(Appointment $appointment): JsonResponse
    {
        $appointment->delete();
        return response()->json([], 204);
    }
}
