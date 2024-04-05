<template>
    <NavLink/>
    <div class="w-1/5 flex mx-auto my-3 justify-center bg-secondary text-white font-bold p-4 rounded">
        <p>Owners</p>
    </div>

    <div class="overflow-x-auto px-12 py-4">
        <div class="flex flex-grow">
            <table class="table table-lg bg-base-200 table-zebra-zebra table-pin-rows table-pin-cols justify-items-center">
                <OwnerTableHeader/>
                <tbody>
                <tr v-for="owner in owners" :key="owner.id">
                    <td>{{ owner.name }}</td>
                    <td>{{ owner.email }}</td>
                    <td>{{ owner.address }}</td>
                    <td>
                        <a :href="'/api/owner/' + owner.id + '/profile'" class="btn btn-secondary text-white">View</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between items-center py-4">
            <h3>Total Owners: {{ total }}</h3>
            <div>
                <button class="btn btn-secondary text-white mr-2" @click="changePage(-1)">Prev</button>
                <button class="btn btn-secondary text-white ml-2" @click="changePage(+1)">Next</button>
            </div>
            <button @click="toggleModal" class="bg-secondary hover:bg-secondary-500 text-white font-bold py-2 px-4 rounded">
                Add Owner
            </button>
        </div>
    </div>
    <BaseModal :modalActive="modalActive" @close-modal="toggleModal">
        <add-owner-modal/>
    </BaseModal>
</template>

<script setup>

import {defineProps, ref} from "vue";
import NavLink from "@/Components/NavLink.vue";
import {Inertia} from "@inertiajs/inertia";
import BaseModal from "@/Modals/Appointments/BaseModal.vue";
import AddOwnerModal from "@/Modals/Owners/AddOwnerModal.vue";
import OwnerTableHeader from "@/Pages/Owners/OwnerTableHeader.vue";

const props = defineProps({
    owners: {
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

const searchTerm = ref('');

let debounceTimer;
const debounce = (func, delay = 500) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(func, delay);
};

const fetchOwners = async () => {
    try {
        const response = await fetch(`/api/owner/search`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({name: searchTerm.value}),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        dogs.value = data;
    } catch (error) {
        console.error('Error fetching owners:', error);
    }
};

const debouncedSearch = () => debounce(fetchOwners, 500);

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
        Inertia.visit(`/api/owner/index?page=${currentPage.value}`, {
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
