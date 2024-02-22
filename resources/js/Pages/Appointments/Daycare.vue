<template>
    <NavLink/>

    <div class="overflow-x-auto px-12">

        <div class="flex">
            <div class="flex-grow">
                <div class=" w-1/3 flex mx-auto my-3 justify-center bg-secondary text-base-100 font-bold p-4 rounded">
                    <p>{{ availableSpots }} Available spots</p>
                </div>
                <table class="table table-md table-zebra table-pin-rows table-pin-cols justify-items-center">
                    <AppointmentTableHeader/>
                    <tbody>
                    <tr v-for="appointment in appointments" :key="appointment.id">
                        <Appointment :appointment="appointment" :visit-types="visitTypes"/>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="flex justify-end pr-12 py-2">
        <button @click="toggleModal"
                class="bg-secondary hover:bg-secondary-500 text-base-100 font-bold py-2 px-4 rounded">
            Add Appointment
        </button>
        <BaseModal :modalActive="modalActive" @close-modal="toggleModal">
            <add-appointment-modal :dogs="dogs" :visit_types="visitTypes" appointment_type="daycare"/>
        </BaseModal>
    </div>
</template>

<script setup>
import NavLink from "@/Components/NavLink.vue";
import BaseModal from "@/Modals/Appointments/BaseModal.vue";
import {defineProps, ref} from "vue";
import AddAppointmentModal from "@/Modals/Appointments/AddAppointmentModal.vue";
import AppointmentTableHeader from "@/Pages/Appointments/AppointmentTableHeader.vue";
import Appointment from "@/Pages/Appointments/Appointment.vue";

const props = defineProps({
    appointments: {
        type: Array,
        default: () => [],
    },
    visitTypes: {
        type: Array
    },
    dogs: {
        type: Object
    },
    availableSpots: {
        type: Number
    }
});

const modalActive = ref(false);
const toggleModal = function () {
    return modalActive.value = !modalActive.value;
}
</script>
