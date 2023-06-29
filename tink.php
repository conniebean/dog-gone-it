<?php

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Support\Facades\Mail;

$owner = Owner::factory()->create(['name' => 'Connie', 'email' => 'conniejeankennedy@gmail.com']);

$dog = Dog::factory()->create(['name' => 'Midna', 'owner_id' => $owner->id]);

$appointment = Appointment::factory()->create(['dog_id' => $dog->id]);

Mail::to($owner->email)->send(new \App\Mail\AppointmentBooked($appointment));
