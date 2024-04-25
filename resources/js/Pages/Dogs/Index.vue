<template>
    <NavLink/>
    <div
        class="w-1/5 flex mx-auto my-3 justify-center bg-secondary text-white font-bold p-4 rounded">
        <p>Dogs</p>
    </div>
    <div class="overflow-x-auto px-12 py-4">
        <div class="flex flex-grow">
            <table
                class="table table-lg bg-base-200 table-zebra-zebra table-pin-rows table-pin-cols justify-items-center">
                <thead>
                <tr class="bg-base-200/10 text-white font-bold text-lg">
                    <th>Name</th>
                    <th>Date Of Birth</th>
                    <th>Breed</th>
                    <th>Gender</th>
                    <th>Fixed</th>
                    <th>Owner Profile</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="dog in dogs" :key="dog.id">
                    <td>{{ dog.name }}</td>
                    <td>{{ dog.date_of_birth }}</td>
                    <td>{{ dog.breed }}</td>
                    <td>{{ dog.sex }}</td>
                    <td>{{ dog.fixed }}</td>
                    <td>
                        <a :href="'/api/owner/' + dog.owner_id+ '/profile'"
                           class="btn btn-secondary text-white">View</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between py-4">
            <h3>Total Dogs: {{ total }}</h3>
            <div class="flex justify-center flex-grow">
                <button class="btn btn-secondary text-white mx-2" @click="changePage(-1)">Prev</button>
                <button class="btn btn-secondary text-white mx-2" @click="changePage(+1)">Next</button>
            </div>
        </div>
    </div>
</template>

<script setup>

import {defineProps, ref} from "vue";
import NavLink from "@/Components/NavLink.vue";
import {Inertia} from "@inertiajs/inertia";
import BaseModal from "@/Modals/Appointments/BaseModal.vue";
import AddOwnerModal from "@/Modals/Owners/AddOwnerModal.vue";
import OwnerTableHeader from "@/Pages/Owners/OwnerTableHeader.vue";

const props = defineProps({
    dogs: {
        type: Object,
        default: () => {
        }
    },
    lastPage: {
        type: Number
    },
    total: {
        type: Number
    }
})

const currentPage = ref(1);
const lastPage = props.lastPage
const changePage = async (offset) => {
    let newPage = currentPage.value + offset;
    if (newPage < 1) {
        newPage = 1;
    }
    if (newPage > lastPage) {
        newPage = lastPage
    }
    currentPage.value = newPage;

    await refreshPage()

}

const refreshPage = async () => {
    try {
        Inertia.visit(`/api/dog/index?page=${currentPage.value}`, {
            method: 'get',
            preserveState: true,
            onError: (errors) => {
                console.error('Error fetching owners:', errors);
            }
        });
    } catch (error) {
        console.error('Error fetching owners:', error);
    }
}

const modalActive = ref(false);
const toggleModal = function () {
    return modalActive.value = !modalActive.value;
}


</script>

<style scoped>

</style>
