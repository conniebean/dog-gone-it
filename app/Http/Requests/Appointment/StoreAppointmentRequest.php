<?php

namespace App\Http\Requests\Appointment;

use App\Models\Appointment;
use App\Models\Dog;
use App\Rules\DaycareHasCapacity;
use App\Rules\DogAlreadyInDaycare;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $validated = [
            'dog_id' => ['required', 'integer', new DogAlreadyInDaycare($this->validationData()['appointment_date'])],
            'facility_id' => ['required', 'integer',],
            'appointmentable_id' => 'required|integer',
            'appointmentable_type' => 'required|string',
            'check_in' => 'date',
            'check_out' =>  'date',
            'appointment_date' => ['required', 'date', 'after_or_equal:today', new DaycareHasCapacity()],
            'paid' => 'required|boolean'
        ];
        //todo: create more rules, make pretty

        $dog = Dog::query()->where('id', $this->validationData()['dog_id'])->firstOrFail();

//        $alreadyInDaycare = Appointment::query()
//            ->where('dog_id', $dog->id)
//            ->where('appointment_date', $this->validationData()['appointment_date'])->exists();

        if(!$dog->isUpToDate()){
            abort(422, 'The vaccines for this pet are out of date, or they do not have all the required vaccines! They cannot come to daycare.');
        }
//        if($alreadyInDaycare){
//            abort(422, 'Dog already in daycare for the day.');
//        }

        return $validated;
    }

    public function messages()
    {
        return [
            'appointment_date.after_or_equal' => 'Daycare-date must be today or a date in the future.'
        ];
    }
}
