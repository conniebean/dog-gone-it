<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Boarding;
use App\Models\Daycare;
use App\Models\Dog;
use App\Models\Facility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BoardingController extends Controller
{
    public function index()
    {
        return Inertia::render('Appointments/Boarding', [
            'appointments' => Appointment::today()->appointmentType(Boarding::class)->with('dog', function ($dog) {
                return $dog->with('owner');
            })->get(),
            'visitTypes' => Appointment::boardingVisitTypes(),
            'dogs' => Dog::all()->keyBy('id'),
            'availableSpots' => Facility::getAppointmentCount(20, Carbon::today(), 'boarding'),
        ]);
    }
}
