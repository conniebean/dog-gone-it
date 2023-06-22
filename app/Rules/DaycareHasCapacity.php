<?php

namespace App\Rules;

use App\Models\Facility;
use Illuminate\Contracts\Validation\Rule;

class DaycareHasCapacity implements Rule
{
    public function passes($attribute, $value)
    {
        $facility = Facility::query()
            ->findOrFail(request()->input('facility_id'));

        return !Facility::daycareMaxReached($value, $facility->daycare_capacity);
    }

    public function message()
    {
        return 'Daycare is full for this date. Please choose another day to visit.';
    }
}
