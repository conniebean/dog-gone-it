<template>
    <thead>
    <tr class="bg-base-200/10 text-white font-bold text-lg">
        <td>Dog</td>
        <td>Visit Type</td>
        <td>Check In</td>
        <td>Check Out</td>
        <td>Paid</td>
        <td>Owner Info</td>
        <td>Cancel Appointment</td>
    </tr>
    </thead>
</template>
<script>
import Appointment from "@/Pages/Appointments/Appointment.vue";

export default {
    name: 'AppointmentTable',
    components: {Appointment}
}
</script>
