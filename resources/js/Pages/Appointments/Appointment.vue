<template>
    <td class="font-extrabold">{{ appointment.dog.name }}</td>
    <td><select
        v-model="appointment.visit_type"
        id="visitType"
        class="select w-48 max-w-xs"
        @change="()=>updateVisitType(props.appointment.visit_type)"
    >
        <option disabled>Select One</option>
        <option v-for="type in visitTypes" :key="type">{{ type }}</option>
    </select></td>
    <td><input
        v-model="appointment.check_in"
        class="w-48"
        type="datetime-local"
        @change="()=>updateCheckIn(props.appointment.check_in)"
        />
    </td>
    <td><input
        v-model="appointment.check_out"
        class="w-48"
        type="time"
        @change="()=>updateCheckOut(props.appointment.check_out)"
    /></td>
    <td>
        <div class="cursor-pointer" @click="()=>updatePayment(!props.appointment.paid)">
            <span v-if="appointment.paid">
                <svg class="fill-white" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
            </span>
            <span v-else>
                <svg class="fill-white" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 80c8.8 0 16 7.2 16 16V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V96c0-8.8 7.2-16 16-16H384zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"/></svg>
            </span>
        </div>
    </td>
    <td>
        <button class="btn btn-active" @click="()=>cancelAppointment()">
            Cancel
        </button>
    </td>
</template>

<script setup>
import {defineProps} from "vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    appointment: {
        type: Object,
        default: () => {
        },
    },
    visitTypes: {
        type: Array
    }
});

const updateVisitType = (visitType) => {
    fetch(`/api/appointments/update/${props.appointment.id}`, {
        method: 'PATCH',
        body: JSON.stringify({visit_type: visitType}),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    }).then(function () {
        props.appointment.visit_type = visitType
        Inertia.visit(`/appointments/${props.appointment.appointmentable_type}/index`)
    })
}

const updateCheckIn = (checkIn) => {
    fetch(`/api/appointments/update/${props.appointment.id}`, {
        method: 'PATCH',
        body: JSON.stringify({check_in: checkIn}),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    }).then(function () {
        props.appointment.check_in = checkIn
        Inertia.visit(`/appointments/${props.appointment.appointmentable_type}/index`)
    })
}

const updateCheckOut = (checkOut) => {
    fetch(`/api/appointments/update/${props.appointment.id}`, {
        method: 'PATCH',
        body: JSON.stringify({check_out: checkOut}),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    }).then(function () {
        props.appointment.check_out = checkOut
        Inertia.visit(`/appointments/${props.appointment.appointmentable_type}/index`)
    })
}

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

const cancelAppointment = function () {
    fetch(`/api/appointments/delete/${props.appointment.id}`, {
        method: 'DELETE',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    }).then(function () {
        Inertia.visit(`/appointments/${props.appointment.appointmentable_type}/index`)
    })
}

</script>

