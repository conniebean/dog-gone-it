<?php

namespace App\Http\Controllers;

use App\Models\Daycare;
use App\Models\Dog;
use App\Models\Vaccine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Util\Exception;

class DaycareController extends Controller
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

        $upToDate = Vaccine::where('dog_id', $validated['dog_id'])->where('up_to_date', '!=', false)->get();
        if($upToDate->isEmpty()){
            abort(403, 'The vaccines for this pet are out of date! They cannot come to daycare.');
        }


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
