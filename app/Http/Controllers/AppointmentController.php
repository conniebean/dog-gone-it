<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentControllerRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Daycare;
use App\Models\Dog;
use App\Models\Facility;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        //todo: find out how to index all appointments on a single date
        return Appointment::all();
    }

    public function store(AppointmentControllerRequest $request)
    {
        $validated = $request->validated();

        return AppointmentResource::make(Appointment::create($validated));
    }

    public function show(Daycare $daycare)
    {
        //
    }

    public function update(AppointmentControllerRequest $request, $id)
    {
        dump('update', $request->all());
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());
        $appointment->save();
    }

    public function delete($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();
    }
}
