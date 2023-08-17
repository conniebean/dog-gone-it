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
            <div>
                <form method="post" @submit.prevent="addAppointment">
                    <div>
                        <label for="dogName">Select A Dog</label>
                        <select class="ml-2" v-model="appointment.dog_id">
                            <option v-for="dog in dogs"  :key="dog.id" :value="dog.id">{{ dog.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="visitType" id="visitType">Visit Type</label>
                        <select
                            class="ml-2 mt-2"
                            v-model="appointment.visit_type"
                            id="visitType">
                            <option v-for="type in visitTypes">{{ type }}</option>
                        </select>
                    </div>
                    <div class="flex">
                        <label for="datePicker" class="ml-2 pl-3">Date</label>
                        <datepicker v-model="appointment.appointment_date" week-starts-on="0" id="datePicker" :style="{ '--vdp-bg-color': '#AEAEAE', '--vdp-hover-bg-color': '#50CA96', 'margin-top': '10px', 'margin-bottom': '10px' }" ></datepicker>
                    </div>
                    <button
                        class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                        type="submit"
                    >
                        Submit
                    </button>
                </form>
            </div>
        </BaseModal>
    </div>
</template>

<script setup>
import NavLink from "@/Components/NavLink.vue";
import Appointment from "@/Pages/Appointments/Appointment.vue";
import BaseModal from "@/Modals/Appointments/BaseModal.vue";
import {ref} from "vue";
import {defineProps} from "vue";
import {Inertia} from "@inertiajs/inertia";
import Datepicker from 'vue3-datepicker/src/datepicker/Datepicker.vue';

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
    }
});

const components = {
    Datepicker
};

const appointment = ref({
    dog_id: '',
    //todo: this obv needs to change
    facility_id: 1,
    appointmentable_id: 1,
    appointmentable_type: 'daycare',
    visit_type: '',
    appointment_date: '',
    paid: false
});

const modalActive = ref(false);
const toggleModal = function ()  {
    return modalActive.value = !modalActive.value;
}

const getAppointmentableType = function (appointment) {
    return appointment.appointmentable_type;
}

const addAppointment = () => {
    const apptStuff = {
        dog_id: appointment.value.dog_id,
        appointment_date: appointment.value.appointment_date,
        facility_id: appointment.value.facility_id,
        appointmentable_id: appointment.value.appointmentable_id,
        appointmentable_type: appointment.value.appointmentable_type,
        visit_type: appointment.value.visit_type,
        paid: appointment.value.paid
    }
    fetch(`/api/appointments/store`, {
        method: 'POST',
        body: JSON.stringify(apptStuff),
        headers: {
            'Content-type': 'application/json',
        },
    }).catch(function (e){
        console.error(e)
    })
        .then(function () {
        const appointmentableType = getAppointmentableType(appointment.value)
        Inertia.visit(`/appointments/${appointmentableType}/index`)
    })
}
</script>
