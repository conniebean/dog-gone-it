<x-mail::message>
# Appointment Reminder

This is a reminder for {{$appointment->dog->name}}'s {{$appointment->appointmentable_type}} appointment for tomorrow,
{{$appointment->appointment_date->toDateString()}}! If you want to make changes, feel free to call us at
{{$appointment->facility->phone_number}}

<x-mail::button :url="$url">
View your appointment
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
