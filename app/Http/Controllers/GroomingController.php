<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Boarding;
use App\Models\Grooming;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroomingController extends Controller
{
    public function index()
    {
        return Inertia::render('Appointments/Grooming', [
            'appointments' => Appointment::today()->appointmentType(Grooming::class)->with('dog')->get(),
            'visitTypes' => Appointment::groomingVisitTypes()
        ]);
    }
}
