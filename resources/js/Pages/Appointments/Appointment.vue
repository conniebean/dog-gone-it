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

</script>

<template>
    <td>{{ appointment.dog.name }}</td>
    <select
        v-model="appointment.visit_type"
        class="select w-full max-w-xs"
        @change="()=>updateVisitType(props.appointment.visit_type)"
    >
        <option disabled>Select One</option>
        <option v-for="type in visitTypes" :key="type">{{ type }}</option>
    </select>
    <td>{{ appointment.check_in }}</td>
    <td>{{ appointment.check_out }}</td>
    <td><input
        v-model="appointment.paid"
        <!--  TODO: figure out the checkbox sheeayt      -->
        @checked="appointment.paid ? 'checked' : ''"
        class="checkbox checkbox-xs"
        @change="()=>updatePayment(props.appointment.paid)"/></td>
</template>
