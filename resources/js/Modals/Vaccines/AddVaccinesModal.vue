<template>
    <div>
        <div class="flex justify-center pb-4 font-bold text-black">
            <h3>Enter Vaccine Info</h3>
        </div>
        <form method="post" @submit.prevent="addVaccines" class="flex flex-col justify-between h-full">
                <div v-for="vaccine in vaccines" class="mb-2">
                    <label>{{ vaccine.name }}</label>
                    <input
                        type="date"
                        v-model="vaccine.expiry_date"
                    >
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
import ForgotPassword from "@/Pages/Auth/ForgotPassword.vue";

let debounceTimer;
const debounce = (func, delay = 500) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(func, delay);
};


const props = defineProps({
    dog_id:{
        type: Number
    },
    vaccines: {
        type: Object
    },
    owner_id:{
        type:Number
    }
});

const errors = ref({
    message: ''
});

const vaccine = ref({
    dog_id: '',
    vaccine_id: '',
    expiry_date: null
})


const addVaccines = () => {

    //gotta figure out how to loop over each vaccine and pass it to our post
    const newVaccines = [{
        dog_id: props.dog_id,
        vaccine_id: vaccine.value.id,
        expiry_date: vaccine.value.expiry_date
        },
        {
            dog_id: props.dog_id,
            vaccine_id: vaccine.value.id,
            expiry_date: vaccine.value.expiry_date
        },
        {
            dog_id: props.dog_id,
            vaccine_id: vaccine.value.id,
            expiry_date: vaccine.value.expiry_date
        }
    ];


    fetch(`/api/vaccine/store/` + props.dog_id, {
        method: 'POST',
        body: JSON.stringify(newVaccines),
        headers: {
            'Accept': 'application/json',
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
            if (!data.errors) {

                Inertia.visit('/api/owner/' + props.owner_id + '/profile');
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

</style>
