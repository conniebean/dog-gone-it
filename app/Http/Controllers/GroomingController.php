<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Dog;
use App\Models\Facility;
use App\Models\Grooming;
use Carbon\Carbon;
use Inertia\Inertia;

class GroomingController extends Controller
{
    public function index()
    {
        return Inertia::render('Appointments/Grooming', [
            'appointments' => Appointment::today()->appointmentType(Grooming::class)->with('dog', function ($dog) {
                return $dog->with('owner');
            })->get(),
            'visitTypes' => Appointment::groomingVisitTypes(),
            'dogs' => Dog::all()->keyBy('id'),
            'availableSpots' => Facility::getAppointmentCount(10, Carbon::today(), 'grooming'),
        ]);
    }
}
