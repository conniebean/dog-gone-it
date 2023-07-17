<script setup>
defineProps({
    appointment: {
        type: Object,
        default: () => {},
    }
});
</script>

<template>
    <td>{{ appointment.dog.name }}</td>
    <td>{{ appointment.visit_type }}</td>
    <td>{{ appointment.check_in }}</td>
    <td>{{ appointment.check_out }}</td>
    <td><input type="checkbox" checked="checked" class="checkbox checkbox-xs"/></td>
</template>
