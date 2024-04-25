<template>
    <div>
        <div class="flex justify-center pb-6 font-bold text-black">
            <h3>Make A Payment</h3>
        </div>
        <form method="post" @submit.prevent="submitForm" class="flex flex-col justify-between h-full">
            <div class="mb-4">
                <label for="cardNumber" class="font-bold mb-3">Card number</label>
                <input v-model="cardNumber" @blur="validateCardNumber" id="cardNumber"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       :class="{'border-red-500': cardNumberError}" placeholder="0000 0000 0000 0000"/>
                <span v-if="cardNumberError" class="text-red-500">Invalid card number</span>
            </div>

            <div class="mb-4">
                <label for="expireDate" class="font-bold mb-3">Expire date</label>
                <input v-model="expireDate" @blur="validateExpireDate" id="expireDate"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       :class="{'border-red-500': expireDateError}" placeholder="MM/YY"/>
                <span v-if="expireDateError" class="text-red-500">Invalid expiry date</span>
            </div>

            <div class="mb-4">
                <label for="cardCVC" class="font-bold mb-3">CVC/CVV</label>
                <input v-model="cardCVC" @blur="validateCVC" id="cardCVC"
                       class="mt-4 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       :class="{'border-red-500': cvcError}" placeholder="&bull;&bull;&bull;"/>
                <span v-if="cvcError" class="text-red-500">Invalid CVC</span>
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

import {ref} from 'vue';
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    appointment:{
        type: Object
    }
})

const cardNumber = ref('');
const expireDate = ref('');
const cardCVC = ref('');
const cardNumberError = ref(false);
const expireDateError = ref(false);
const cvcError = ref(false);

const updatePayment = (paid) => {
    fetch(`/api/appointments/update/${props.appointment.id}`, {
        method: 'PATCH',
        body: JSON.stringify({paid: paid}),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    }).then(function () {
        props.appointment.paid = paid
        Inertia.visit(`/appointments/${props.appointment.appointmentable_type}/index`)
    })
}

const validateCardNumber = () => {
    cardNumberError.value = !(cardNumber.value.length >= 16 && cardNumber.value.split(' ').every(chunk => chunk.length === 4));
};

const validateExpireDate = () => {
    const parts = expireDate.value.split('/');
    expireDateError.value = !(parts.length === 2 && parts[0].length === 2 && parts[1].length === 2);
};

const validateCVC = () => {
    cvcError.value = !(cardCVC.value.length === 3 || cardCVC.value.length === 4);
};

const submitForm = () => {
    validateCardNumber();
    validateExpireDate();
    validateCVC();

    updatePayment(true)
};

</script>

<style scoped>

</style>
