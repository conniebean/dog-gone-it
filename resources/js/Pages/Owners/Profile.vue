<template>
    <NavLink/>
    <div class="grid  md:grid-cols-2 grid-cols-1  bg-base-100 rounded-xl">
        <div class="hero min-h-full rounded-l-xl bg-base-200">
            <div class="hero-content">
                <!-- Profile Card -->
                <div class="card  bg-white rounded-lg shadow-md">
                    <div class="card-body">
                        <h2 class="text-xl font-bold text-gray-700 mb-2">{{ owner.name }}</h2>
                        <p class="text-gray-600"><strong>Phone:</strong> {{ owner.phone_number }}</p>
                        <p class="text-gray-600"><strong>Email:</strong> {{ owner.email }}</p>
                        <p class="text-gray-600"><strong>Address:</strong> {{ owner.address }}</p>
                        <button @click="toggleModal"
                                class="mt-6 bg-gray-800 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Add Dog
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <BaseModal :modalActive="modalActive" @close-modal="toggleModal">
            <add-dog-modal :owner_id="owner.id" :vaccines="vaccines"/>
        </BaseModal>
        <div class="card glass rounded-lg shadow-md p-6">
            <h1 class="flex justify-center text-2xl text-black font-bold underline">Dogs</h1>
            <div class="card-body ">
                <div v-for="dog in dogs" :key="dog.id">
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">{{ dog.name }}</h2>
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-xl">
                            <p class=" text-gray-600"><strong>Breed:</strong> {{ dog.breed }}</p>
                            <p class=" text-gray-600"><strong>Gender:</strong> {{ dog.sex }}</p>
                            <p class=" text-gray-600"><strong>DOB:</strong> {{ dog.date_of_birth }}</p>
                            <p class=" text-gray-600"><strong>Fixed:</strong> {{ dog.fixed ? 'Yes' : 'No' }}</p>
                            <p class=" text-gray-600"><strong>Vaccines UTD:</strong> {{ dog.is_up_to_date }}</p>
                        </div>
                        <div class="card-actions justify-end">
                            <button
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-full transition duration-150 ease-in-out">
                                Remove
                            </button>
                            <button
                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded-full transition duration-150 ease-in-out">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>

import NavLink from "@/Components/NavLink.vue";
import {defineProps, ref} from "vue";
import BaseModal from "@/Modals/Appointments/BaseModal.vue";
import AddDogModal from "@/Modals/Dogs/AddDogModal.vue";

const props = defineProps({
    owner: {
        type: Object,
        default: () => {
        }
    },
    dogs: {
        type: Object,
        default: () => {
        }
    },
    vaccines: {
        type: Object,
        default: () => {
        }
    }
})

const modalActive = ref(false);
const toggleModal = function () {
    return modalActive.value = !modalActive.value;
}

</script>

<style scoped>

</style>
