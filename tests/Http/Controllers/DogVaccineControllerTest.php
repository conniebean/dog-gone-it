<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\DogVaccineController;
use App\Models\Daycare;
use App\Models\Dog;
use App\Models\Facility;
use App\Models\Owner;
use App\Models\User;
use App\Models\Vaccine;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class DogVaccineControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->date = Carbon::now();
        $this->vaccineExpiryDate = Carbon::now()->addWeek();
        $this->employee = User::factory()->create();
        $this->owner = Owner::factory()->create();
        $this->dog = Dog::factory()->for($this->owner)->create();
        $this->vaccines = Vaccine::where('required', 1)->get();
    }
    public function testStore()
    {

    }
    public function postToVaccines($dog, $vaccine_id, $expiry_date): TestResponse
    {
        return $this->actingAs($this->employee)->postJson(
            route('vaccine.store', [
                'dog_id' => $dog->id,
                'vaccine_id'=>$vaccine_id,
                'expiry_date'=>$expiry_date
            ])
        );
    }




}
