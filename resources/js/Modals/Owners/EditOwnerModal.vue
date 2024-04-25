<template>
    <div>
        <div class="flex justify-center pb-6 font-bold text-black">
            <h3>Update Owner</h3>
        </div>

        <form method="post" @submit.prevent="editOwner" class="flex flex-col justify-between h-full">
            <div class="mb-4">

                <input type="text"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="props.owner.name" placeholder="Owner Name">
            </div>
            <div><p class="font-bold text-red-600 text-sm">{{ errors.message }}</p></div>
            <div class="mb-4">
                <input type="text"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="props.owner.address" placeholder="address: 420 long grass blv">
            </div>
            <div class="mb-4">
                <input type="tel"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="props.owner.phone_number" placeholder="contact #: 123-123-1234">
            </div>
            <div class="mb-4">
                <input type="email"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       v-model="props.owner.email" placeholder="email: steve@example.com">
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

const props = defineProps({
    owner: {
        type: Object
    }
});

const errors = ref({
    message: ''
});

const editOwner = () => {
    const updateOwner = {
        name: props.owner.name,
        address: props.owner.address,
        phone_number: props.owner.phone_number,
        email: props.owner.email
    }
    fetch(`/api/owner/update/${props.owner.id}`, {
        method: 'POST',
        body: JSON.stringify(updateOwner),
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
            if (!data.errors){

                Inertia.visit(`/api/owner/${props.owner.id}/profile`);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error.message);
        });
}

</script>

<style>

</style>
