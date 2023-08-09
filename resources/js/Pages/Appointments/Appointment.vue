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
    <td>{{ appointment.check_in }}</td>
    <td>{{ appointment.check_out }}</td>
        <!--  TODO: figure out the checkbox sheeayt  -->
    <td><input
        v-model="appointment.paid"
        @checked="appointment.paid ? 'checked' : ''"
        class="checkbox checkbox-xs"
        @change="()=>updatePayment(props.appointment.paid)"/></td>
    <td>
        <button class="btn btn-active" @click="()=>cancelAppointment()">
            Cancel
        </button>
    </td>
</template>
