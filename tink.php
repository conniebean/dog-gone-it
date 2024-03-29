<?php

use App\Http\Resources\AppointmentResource;
use App\Jobs\SendReminderEmail;
use App\Mail\AppointmentBooked;
use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use App\Models\Dog;
use App\Models\Owner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
$appt = Appointment::factory()->create();

Appointment::factory(3)->sequence(
    ['appointment_date' => Carbon::now()->addDay()->toDateString()],
    ['appointment_date' => Carbon::now()->addWeek()->toDateString()],
)->create();

SendReminderEmail::dispatch();
