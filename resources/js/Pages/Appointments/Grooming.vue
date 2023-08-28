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
    <div>
        <button @click="toggleModal" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">Add Appointment</button>
        <BaseModal :modalActive="modalActive" @close-modal="toggleModal">
            <add-appointment-modal :dogs="dogs" :visit_types="visitTypes" appointment_type="grooming"/>
        </BaseModal>
    </div>
</template>

<script setup>
import NavLink from "@/Components/NavLink.vue";
import Appointment from "@/Pages/Appointments/Appointment.vue";
import BaseModal from "@/Modals/Appointments/BaseModal.vue";
import AddAppointmentModal from "@/Modals/Appointments/AddAppointmentModal.vue";
import {ref} from "vue";

defineProps({
    appointments: {
        type: Array,
        default: () => [],
    },
    visitTypes: {
        type: Array
    },
    dogs: {
        type: Object
    }
});


const modalActive = ref(false);
const toggleModal = function ()  {
    return modalActive.value = !modalActive.value;
}
</script>
