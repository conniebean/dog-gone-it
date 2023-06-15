<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Daycare;
use App\Models\Dog;
use App\Models\Facility;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            'dog_id' => 'required|string',
            'facility_id' => 'required|string',
            'appointmentable_id' => 'required|integer',
            'appointmentable_type' => 'required|string',
            'check_in' => 'date',
            'check_out' =>  'date',
            'appointment_date' => 'required|date|after_or_equal:today',
            'paid' => 'required|boolean'
        ],
        [
            'appointment_date.after_or_equal' => 'Daycare-date must be today or a date in the future.'
        ]);

        $dog = Dog::where('id', $validated['dog_id'])->first();
        $alreadyInDaycare = Appointment::where('dog_id', $dog->id)->where('appointment_date', $validated['appointment_date'])->first();

        if(!$dog->isUpToDate()){
            abort(422, 'The vaccines for this pet are out of date, or they do not have all the required vaccines! They cannot come to daycare.');
        }
        if($alreadyInDaycare){
            abort(422, 'Dog already in daycare for the day.');
        }

        $facility = Facility::where('id', $validated['facility_id'])->first();
        if(Facility::daycareMaxReached($validated['appointment_date'], $facility->daycare_capacity)){
            abort(422, 'Daycare is full for this date. Please choose another day to visit.');
        }

        return Appointment::create($validated);
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
    public function delete($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();
    }
}
