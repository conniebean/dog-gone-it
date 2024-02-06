<template >
    <div>
<!--form input for searching the database by owner to get list of registered dogs        -->
        <form>
            <div>
                <input type="search" class="form-control " placeholder="Find dog by owner" name="search">
            </div>
        </form>

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
                    class="select select-bordered ml-2 mt-2"
                    v-model="appointment.visit_type"
                    id="visitType">
                    <option disabled selected>Pick one</option>
                    <option v-for="type in visit_types">{{ type }}</option>
                </select>
            </div>
            <div class="flex items-center my-2">
                <label for="datePicker" class="mr-2 pl-6">Date</label>
                <input type="date" v-model="appointment.appointment_date">
            </div>
            <button
                class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                type="submit"
            >
                Submit
            </button>
        </form>
    </div>
</template>

<script setup>
import {defineProps, ref} from "vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    visit_types: {
        type: Array
    },
    appointment_type: {
        type: String,
    },
    dogs: {
     type: Object
    }
});

const appointment = ref({
    dog_id: '',
    //todo: this obv needs to change
    facility_id: 1,
    appointmentable_id: 1,
    appointmentable_type: props.appointment_type,
    visit_type: '',
    appointment_date: '',
    paid: false
});

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

<style>
input[type="date"] {
    background: transparent;
    color: black;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(100%);
    -webkit-align-items: center;
    display: -webkit-inline-flex;
    font-family: monospace;
    overflow: hidden;
    -webkit-padding-start: 20px;
}

input[type="date"]::-webkit-date-and-time-value {
    filter: invert(100%);
    -webkit-align-items: center;
    display: -webkit-inline-flex;
    font-family: monospace;
    overflow: hidden;
    -webkit-padding-start: 1px;
}
</style>
