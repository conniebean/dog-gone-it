<template>
    <div>
        <div class="flex justify-center pb-4 font-bold text-black">
            <h3>Enter Vaccine Info</h3>
        </div>
        <form method="post" @submit.prevent="addVaccines" class="flex flex-col justify-between h-full">
                <div v-for="vaccine in vaccines" :key="vaccine.id" class="mb-2">
                    <label>{{ vaccine.name }}</label>
                    <input
                        type="date"
                        v-model="vaccineExpiryDates[vaccine.id]"
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

const vaccineExpiryDates = ref({});

const errors = ref({
    message: ''
});

const vaccine = ref({
    dog_id: '',
    vaccine_id: '',
    expiry_date: null
})

props.vaccines.forEach(vaccine => {
    vaccineExpiryDates.value[vaccine.id] = null;
});

const addVaccines = () => {

    const newVaccines = props.vaccines.map(vaccine => ({
        dog_id: props.dog_id,
        vaccine_id: vaccine.id,
        expiry_date: vaccineExpiryDates.value[vaccine.id] // The date input from the form
    }));

    fetch(`/api/vaccine/store/` + props.dog_id, {
        method: 'POST',
        body: JSON.stringify(newVaccines),
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
                Inertia.visit(`/api/owner/${props.owner_id}/profile`);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error.message);
        });
}

</script>

<style>

</style>
