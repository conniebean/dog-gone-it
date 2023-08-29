<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Daycare;
use App\Models\Dog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DaycareController extends Controller
{
    public function index()
    {
        return Inertia::render('Appointments/Daycare', [
            'appointments' => Appointment::today()->appointmentType(Daycare::class)->with('dog', function ($dog){
                return $dog->with('owner');
            })->get(),
            'visitTypes' => Appointment::daycareVisitTypes(),
            'dogs' => Dog::all()->keyBy('id'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Daycare $daycare
     * @return \Illuminate\Http\Response
     */
    public function show(Daycare $daycare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Daycare $daycare
     * @return \Illuminate\Http\Response
     */
    public function edit(Daycare $daycare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Daycare $daycare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Daycare $daycare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Daycare $daycare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Daycare $daycare)
    {
        //
    }
}
