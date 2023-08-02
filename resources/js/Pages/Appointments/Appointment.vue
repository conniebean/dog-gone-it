<script setup>
import { defineProps } from "vue";
import {Inertia} from "@inertiajs/inertia";

defineProps({
    appointment: {
        type: Object,
        default: () => {},
    },
    visitTypes: {
        type: Array
    }
});
//todo: come back to figure this shit out
function updateVisitType(){
    const appointment = this;
    Inertia.patch('appointment.update', appointment);
}

</script>

<template>
    <td>{{ appointment.dog.name }}</td>
    <td v-if="!appointment.visit_type">
        <details class="dropdown dropdown-hover my-16">
            <summary class="m-1 btn btn-xs">Select One</summary>
            <ul
                class="p-2 shadow menu menu-dropdown-show dropdown-content z-[1] bg-base-100 rounded-box w-52">
                <li v-for="type in visitTypes" :key="type">
                    <button @click="updateVisitType">{{ type }}</button>
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
