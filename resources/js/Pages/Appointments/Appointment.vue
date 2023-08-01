<script setup>
import { defineProps } from "vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    appointment: {
        type: Object,
        default: () => {},
    },
    visitTypes: {
        type: Array
    }
});

</script>

<template>
    <td>{{ appointment.dog.name }}</td>
    <td v-if="!appointment.visit_type">
        <details class="dropdown my-8">
            <summary class="m-1 btn btn-xs">Select One</summary>
            <ul
                class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
                <li v-for="type in visitTypes" :key="type">
                    <Link :href="`/appointments/update/${appointment.id}`" method="patch" as="button">{{ type }}</Link>
                </li>
            </ul>
        </details>
    </td>
    <td v-else>
<!--        todo: this is going to have to be changeable-->
        {{ appointment.visit_type }}
    </td>
    <td>{{ appointment.check_in }}</td>
    <td>{{ appointment.check_out }}</td>
    <td><input v-model="appointment" type="checkbox" checked="checked" class="checkbox checkbox-xs"/></td>
</template>
