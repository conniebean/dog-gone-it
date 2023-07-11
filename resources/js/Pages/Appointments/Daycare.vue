<script setup>
defineProps(['appointments', 'dogs']);
</script>

<template>
    <div class="overflow-x-auto">
        <table class="table table-xs table-pin-rows table-pin-cols">
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
                <td>{{ appointment.check_in }}</td>
                <td>{{ appointment.check_out }}</td>
                <td><input type="checkbox" checked="checked" class="checkbox checkbox-xs" /></td>
            </tr>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
</template>

<style scoped>

</style>
