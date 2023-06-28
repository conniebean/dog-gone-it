<x-mail::message>
# Appointment Booked

Appointment has been successfully booked!.

<x-mail::button :url="''">
Do we need this button?
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
