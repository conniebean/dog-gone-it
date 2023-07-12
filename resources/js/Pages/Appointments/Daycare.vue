<script setup>
import NavLink from "@/Components/NavLink.vue";

defineProps(['appointments']);
</script>

<template>
    <NavLink></NavLink>
    <div class="overflow-x-auto">
        <table class="table table-sm table-pin-rows table-pin-cols justify-items-center">
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
            <tr v-for="appointment in appointments">
                <td>{{ appointment.dog.name }}</td>
                <td>{{ appointment.visit_type }}</td>
                <td>{{ appointment.check_in }}</td>
                <td>{{ appointment.check_out }}</td>
                <td><input type="checkbox" checked="checked" class="checkbox checkbox-xs"/></td>
            </tr>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
</template>

<style scoped>

</style>
