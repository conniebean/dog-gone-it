
<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import {Head} from "@inertiajs/inertia-vue3";
import {computed} from "vue";

defineProps(['dogs']);

const form = useForm({
    message: '',
});

const currentYear = computed(() => {
    const currentYear = new Date();
    return currentYear.getFullYear() + "-" + currentYear.getMonth() + "-" + currentYear.getDay();
});
</script>

<template>
    <div>
        <head><title>Dog</title></head>
        <div v-for="a in dogs">
            <table>
                <colgroup>
                    <col span="2">
                </colgroup>
                <tr>
                    <td> </td>
                    <th scope="col">Name</th>
                    <th scope="col">Date Of Birth</th>
                    <th scope="col">Sex</th>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>{{a.name}}</td>
                    <td>{{(a.date_of_birth)}}</td>
                    <td>{{a.sex}}</td>
                </tr>
            </table>
        </div>

    </div>
</template>


<style scoped>

</style>
