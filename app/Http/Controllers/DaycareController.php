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
            'appointments' => Appointment::today()->appointmentType(Daycare::class)->with('dog')->get(),
            'visitTypes' => Appointment::daycareVisitTypes()
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
        //todo: move stuff to appointments controller, this stuff
        //  no longer exists
        $validated = $request->validate([
            'dog_id' => 'required|string|max:30',
            'visit-type' => 'required|string|max:30',
            'paid' => 'required|boolean',
            'daycare-date' => 'required|date|after_or_equal:today',
            'check-in' => 'date',
            'check-out' => 'date',
        ],
        [
            'daycare-date.after_or_equal' => 'Daycare-date must be today or a date in the future.'
        ]);

        $dog = Dog::where('id', $validated['dog_id'])->first();
        $alreadyInDaycare = Daycare::where('dog_id', $dog->id)->where('daycare-date', $validated['daycare-date'])->first();

        if(!$dog->isUpToDate()){
            abort(422, 'The vaccines for this pet are out of date, or they do not have all the required vaccines! They cannot come to daycare.');
        }
        if($alreadyInDaycare){
            abort(422, 'Dog already in daycare for the day.');
        }
        //todo: maxReached will exist on the individual facility
//        if(Daycare::maxReached($validated['daycare-date'])){
//            abort(422, 'Daycare is full for this date. Please choose another day to visit.');
//        }

        return Daycare::create($validated);
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
