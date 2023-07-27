<script setup>
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
    <td>
        <details class="dropdown my-8">
            <summary class="m-1 btn btn-xs">Select One</summary>
            <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
                <li v-for="type in visitTypes"><a>{{ type }}</a></li>
            </ul>
        </details>
    </td>
    <td>{{ appointment.check_in }}</td>
    <td>{{ appointment.check_out }}</td>
    <td><input type="checkbox" checked="checked" class="checkbox checkbox-xs"/></td>
</template>
