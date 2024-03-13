<template>
    <NavLink/>
    <div
        class="w-1/5 flex mx-auto my-3 justify-center bg-secondary text-base-100 font-bold p-4 rounded">
        <p>Owner's</p>
    </div>
    <div>
        <input type="text" placeholder="Search..">
        <button class="btn">
            Search
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 512 512">
                <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path fill="#ffffff"
                      d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Profile</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="owner in owners " :key="owner.id">
                <td>{{ owner.name }}</td>
                <td>{{ owner.email }}</td>
                <td>{{ owner.address }}</td>
                <td>
                    <a :href="'/api/owner/' + owner.id + '/profile'" class="btn btn-secondary text-base-100">View</a>
                </td>
            </tr>
            </tbody>
        </table>

        <div>
            <button class="btn btn-secondary text-base-100" @click="changePage(-1)">Prev</button>
            <button class="btn btn-secondary text-base-100" @click="changePage(+1)">Next</button>
        </div>
        <div>
            <h3>Total Owners: {{total}}</h3>
        </div>
    </div>
</template>

<script setup>

import {defineProps, ref} from "vue";
import NavLink from "@/Components/NavLink.vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    owners: {
        type: Object,
        default: () => {}
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
    if (newPage > lastPage){
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
</script>

<style scoped>

</style>
