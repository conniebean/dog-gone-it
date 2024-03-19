<template>
    <div>
        <div class="flex justify-center pb-6 font-bold text-black">
            <h3>Add A Dog</h3>
        </div>

        <form method="post" @submit.prevent="addDog" class="flex flex-col justify-between h-full">
            <div class="mb-4">
<!--                this will be on the owner profile page, not the dog view. We'll pass the id down from the
                        selected owner to create the relationship for the dog
                        Got too tired, will have to finish this tomorrow-->
                <input type="text"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="owner.name" placeholder="Owner Name">
            </div>
            <div><p class="font-bold text-red-600 text-sm">{{ errors.message }}</p></div>
            <div class="mb-4">
                <input type="text"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="owner.address" placeholder="address: 420 long grass blv">
            </div>
            <div class="mb-4">
                <input type="tel"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="owner.phone_number" placeholder="contact #: 123-123-1234">
            </div>
            <div class="mb-4">
                <input type="email"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="owner.email" placeholder="email: steve@example.com">
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

let debounceTimer;
const debounce = (func, delay = 500) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(func, delay);
};



const props = defineProps({

});

const errors = ref({
    message: ''
});

const dog = ref({
    owner_id: '',
    name: '',
    date_of_birth: '',
    breed: '',
    sex: '',
    fixed: ''

});



const addDog = () => {
    const newDog = {
        owner_id: dog.value.owner_id,
        name: dog.value.name,
        date_of_birth: dog.value.date_of_birth,
        breed: dog.value.breed,
        sex: dog.value.sex,
        fixed: dog.value.fixed
    }
    fetch(`/api/dog/store`, {
        method: 'POST',
        body: JSON.stringify(newDog),
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
            if (!data.errors){

                Inertia.visit(`/api/dog/index`);
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
