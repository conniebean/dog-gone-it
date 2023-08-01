<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Boarding;
use App\Models\Daycare;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BoardingController extends Controller
{
    public function index()
    {
        return Inertia::render('Appointments/Boarding', [
            'appointments' => Appointment::today()->appointmentType(Boarding::class)->with('dog')->get(),
            'visitTypes' => Appointment::boardingVisitTypes()
        ]);
    }
}
