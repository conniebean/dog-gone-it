<template>
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
    visitTypes: {
        type: Array
    }
});

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

</script>

<style scoped>

</style>
