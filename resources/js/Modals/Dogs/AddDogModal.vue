<template>
    <div>
        <div class="flex justify-center pb-4 font-bold text-black">
            <h3>Add A Dog</h3>
        </div>
        <form method="post" @submit.prevent="addDog" class="flex flex-col justify-between h-full">
            <div class="mb-2">
                <input type="text"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="dog.name" placeholder="Scruffy">
            </div>
            <div class="mb-2">
                <input type="date"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="dog.date_of_birth">
            </div>
            <div class="mb-2">
                <input type="text"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="dog.breed" placeholder="Dutch Shepherd">
            </div>
            <div class="mb-2">
                <select
                    class="mt-8 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black"
                    v-model="dog.sex">
                    <option class="text-black-50" value="" disabled selected>Select A Sex</option>
                    <option class="text-black" value="male">Male</option>
                    <option class="text-black" value="female">Female</option>
                </select>
            </div>
            <div class="mb-2">
                <select
                    class="mt-8 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black"
                    v-model="dog.fixed">
                    <option class="text-black-50" value="" disabled selected>Is Your Dog Fixed?</option>
                    <option class="text-black" value="0">No</option>
                    <option class="text-black" value="1">Yes</option>
                </select>
            </div>

            <div class="mt-4">
                <button class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded w-full shadow-lg">
                    Continue
                </button>
            </div>

        </form>
    </div>
</template>

<script setup>

import {defineProps, ref} from "vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    owner_id:{
        type: Number
    },
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
        owner_id: props.owner_id,
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
            if (!response.ok) {
                if (response.status === 422) {
                    return response.json().then(data => {
                        let messages = Object.values(data.errors).map((msgs) => msgs.join(', ')).join('. ');
                        errors.value.message = messages;
                        console.log(errors.value.message); // Log or handle errors

                        throw new Error('Validation failed'); // Prevent further processing
                    });
                } else {
                    throw new Error('Some error occurred');
                }
            }
            return response.json();
        })
        .then(data => {
            if (!data.errors) {
                Inertia.visit('/api/owner/' + props.owner_id + '/profile');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error.message);
        });

}
</script>

<style>

</style>
