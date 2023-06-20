<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Models\Dog;
use App\Models\Facility;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentControllerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //todo: do I want to write this?
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $validated = [
            'dog_id' => 'required|string',
            'facility_id' => 'required|string',
            'appointmentable_id' => 'required|integer',
            'appointmentable_type' => 'required|string',
            'check_in' => 'date',
            'check_out' =>  'date',
            'appointment_date' => 'required|date|after_or_equal:today',
            'paid' => 'required|boolean'
        ];

        $dog = Dog::query()->where('id', $this->validationData()['dog_id'])->first();

        $alreadyInDaycare = Appointment::query()
            ->where('dog_id', $dog->id)
            ->where('appointment_date', $this->validationData()['appointment_date'])->first();

        if(!$dog->isUpToDate()){
            abort(422, 'The vaccines for this pet are out of date, or they do not have all the required vaccines! They cannot come to daycare.');
        }
        if($alreadyInDaycare){
            abort(422, 'Dog already in daycare for the day.');
        }
        $facility = Facility::query()
            ->where('id', $this->validationData()['facility_id'])->first();

        if(Facility::daycareMaxReached($this->validationData()['appointment_date'], $facility->daycare_capacity)){
            abort(422, 'Daycare is full for this date. Please choose another day to visit.');
        }

        return $validated;
    }

    public function messages()
    {
        return [
            'appointment_date.after_or_equal' => 'Daycare-date must be today or a date in the future.'
        ];
    }
}
