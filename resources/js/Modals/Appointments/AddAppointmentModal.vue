<template>
    <div>
        <div class="flex justify-center pb-6 font-bold text-black">
            <h3>Add An Appointment</h3>
        </div>
        <form method="get">
            <div>
                <input type="search"
                       class="form-control rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black"
                       placeholder="Find dog by owner" v-model="searchTerm" @input="debouncedSearch">
            </div>
        </form>

        <form method="post" @submit.prevent="addAppointment" class="flex flex-col justify-between h-full">
            <div class="mb-4">
                <select
                    class="mt-8 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black"
                    v-model="appointment.dog_id">
                    <option class="text-black-50" value="" disabled selected>Select A Dog</option>
                    <option class="text-black" v-for="dog in dogs" :key="dog.id" :value="dog.id">{{ dog.name }}</option>
                </select>
            </div>
            <div><p class="font-bold text-red-600 text-sm">{{ errors.message }}</p></div>
            <div class="mb-4">
                <select
                    class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black"
                    v-model="appointment.visit_type">
                    <option class="text-black-50" value="" disabled selected>Visit Type</option>
                    <option class="text-black" v-for="type in visit_types" >{{ type }}
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <input type="date"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="appointment.appointment_date">
            </div>
            <div class="mt-4">
                <button class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded w-full shadow-lg">
                    Submit
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>

import {defineProps, ref} from "vue";
import {Inertia} from "@inertiajs/inertia";

const searchTerm = ref('');
const dogs = ref([]);

let debounceTimer;
const debounce = (func, delay = 500) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(func, delay);
};

const fetchOwners = async () => {
    try {
        const response = await fetch(`/api/owner/search`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({name: searchTerm.value}),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        dogs.value = data;
    } catch (error) {
        console.error('Error fetching owners:', error);
    }
};

const debouncedSearch = () => debounce(fetchOwners, 500);

const props = defineProps({
    visit_types: {
        type: Array
    },
    appointment_type: {
        type: String,
    }
});

const errors = ref({
    message: ''
});

const appointment = ref({
    dog_id: '',
    //todo: this obv needs to change
    facility_id: 1,
    appointmentable_id: 1,
    appointmentable_type: props.appointment_type,
    visit_type: '',
    type: '',
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
            'Accept': 'application/json', // Ensure Laravel returns a JSON response
            'Content-type': 'application/json',
        },
    })
        .then(response => {
            // Check if the response was ok (status in the range 200-299)
            if (!response.ok) {
                // If the server response was not ok, handle 422 or other errors
                if (response.status === 422) {
                    // Parse JSON to get the actual validation errors
                    return response.json().then(data => {
                        let messages = Object.values(data.errors).map((msgs) => msgs.join(', ')).join('. ');
                        errors.value.message = messages;
                        console.log(errors.value.message); // Log or handle errors

                        throw new Error('Validation failed'); // Prevent further processing
                    });
                } else {
                    // Handle other errors
                    throw new Error('Some error occurred');
                }
            }
            // If response was ok, parse it as JSON and proceed
            return response.json();
        })
        .then(data => {
            if (!data.errors){
                const appointmentableType = getAppointmentableType(appointment.value);
                Inertia.visit(`/appointments/${appointmentableType}/index`);
            }
            // Handle success case, data is the JSON object from the response
        })
        .catch(error => {
            // Catch block for network errors or errors thrown from then blocks
            console.error('Fetch error:', error.message);
        });
}

</script>

<style>
input[type="date"] {
    background: white;
    color: black;
    color-scheme: dark;

}

input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(100%);
    -webkit-align-items: center;
    display: -webkit-inline-flex;
    font-family: monospace;
    overflow: hidden;
    -webkit-padding-start: 20px;
    cursor: pointer;
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
