<script setup>
import NavLink from "@/Components/NavLink.vue";
import Appointment from "@/Pages/Appointments/Appointment.vue";

defineProps({
    appointments: {
        type: Array,
        default: () => [],
    },
    visitTypes: {
        type: Array
    }
});
</script>

<template>
    <NavLink/>
    <div class="overflow-x-auto px-48">
        <table class="table table-md table-zebra table-pin-rows table-pin-cols justify-items-center">
            <thead>
            <tr>
                <td>Dog</td>
                <td>Visit Type</td>
                <td>Check In</td>
                <td>Check Out</td>
                <td>Paid</td>
                <td>Cancel Appointment</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="appointment in appointments" :key="appointment.id">
                <Appointment :appointment="appointment" :visit-types="visitTypes"/>
            </tr>
            </tbody>
        </table>
    </div>
</template>
