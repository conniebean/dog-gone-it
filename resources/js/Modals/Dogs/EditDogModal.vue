<template>
    <div>
        <div class="flex justify-center pb-4 font-bold text-black">
            <h3>Edit Dog</h3>
        </div>
        <form method="post" @submit.prevent="editDog" class="flex flex-col justify-between h-full">
            <div class="mb-2">
                <input type="text"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="props.dog.name">
            </div>
            <div class="mb-2">
                <input type="date"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="props.dog.date_of_birth">
            </div>
            <div class="mb-2">
                <input type="text"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="props.dog.breed" placeholder="Dutch Shepherd">
            </div>
            <div class="mb-2">
                <select
                    class="mt-8 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black"
                    v-model="props.dog.sex">
                    <option class="text-black-50" value="" disabled selected>Select A Sex</option>
                    <option class="text-black" value="male">Male</option>
                    <option class="text-black" value="female">Female</option>
                </select>
            </div>
            <div class="mb-2">
                <select
                    class="mt-8 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black"
                    v-model="props.dog.fixed">
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
    dog:{
        type: Object
    }
});

const errors = ref({
    message: ''
});

const editDog = () => {
    const editDog = {
        owner_id: props.owner_id,
        name: props.dog.name,
        date_of_birth: props.dog.date_of_birth,
        breed: props.dog.breed,
        sex: props.dog.sex,
        fixed: props.dog.fixed
    }
    fetch(`/api/dog/${props.dog.id}/owner/${props.owner_id}`, {
        method: 'PATCH',
        body: JSON.stringify(editDog),
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
                        console.log(errors.value.message);

                        throw new Error('Validation failed');
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
