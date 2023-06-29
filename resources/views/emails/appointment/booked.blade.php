<x-mail::message>
# Appointment Booked

Appointment has been successfully booked for {{$appointment->dog->name}}! If you want to make changes, feel free to call us at {{$appointment->facility->phone_number}}

<x-mail::button :url="''">
View your appointment
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
