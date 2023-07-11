<x-mail::message>
# Appointment Booked

Your {{$appointment->appointmentable_type}} appointment has been successfully booked for {{$appointment->dog->name}} on {{$appointment->appointment_date->toDateString()}}! If you want to make changes, feel free to call us at {{$appointment->facility->phone_number}}

<x-mail::button :url="$url">
View your appointment
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
