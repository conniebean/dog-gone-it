<template>
    <NavLink/>
    <div class="grid  md:grid-cols-2 grid-cols-1  bg-base-100 rounded-xl">
        <div class="hero min-h-full rounded-l-xl bg-base-200">
            <div class="hero-content">
                <!-- Profile Card -->
                <div class="card bg-white rounded-lg shadow-md">
                    <div class="card-body">
                        <div class="flex justify-between">
                            <h2 class="text-xl font-bold text-gray-700 mb-2">{{ owner.name }}</h2>
                            <button @click="toggleEditOwnerModal">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-8 h-8">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="text-gray-600"><strong>Phone:</strong> {{ owner.phone_number }}</p>
                        <p class="text-gray-600"><strong>Email:</strong> {{ owner.email }}</p>
                        <p class="text-gray-600"><strong>Address:</strong> {{ owner.address }}</p>
                        <button @click="toggleAddDogModal"
                                class="mt-6 bg-gray-800 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Add Dog
                        </button>
                    </div>
                </div>
            </div>
            <BaseModal :modalActive="addDogModalActive" @close-modal="toggleAddDogModal">
                <add-dog-modal :owner_id="owner.id"/>
            </BaseModal>

            <BaseModal :modalActive="editOwnerModalActive" @close-modal="toggleEditOwnerModal">
                <edit-owner-modal :owner="props.owner"></edit-owner-modal>
            </BaseModal>

        </div>

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
                                @click="setActiveDogForVaccines(dog.id)"
                                class="bg-green-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-full transition duration-150 ease-in-out">
                                Add Vaccines
                            </button>
                            <button
                                @click="setActiveDogForRemoval(dog.id); toggleRemoveDogModal"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-full transition duration-150 ease-in-out">
                                Remove
                            </button>
                            <button
                                @click="setActiveDogForEdit(dog); toggleEditDogModal"
                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded-full transition duration-150 ease-in-out">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <BaseModal :modalActive="activeDogForRemoval !== null" @close-modal="nullActiveDogForRemoval">
            <delete-dog-confirmation-modal :dog_id="activeDogForRemoval"
                                           :owner_id="owner.id"></delete-dog-confirmation-modal>
        </BaseModal>

        <BaseModal :modalActive="activeDogForVaccines !== null" @close-modal="nullActiveDogForVaccines">
            <add-vaccines-modal :dog_id="activeDogForVaccines" :owner_id="owner.id"
                                :vaccines="vaccines"></add-vaccines-modal>
        </BaseModal>

        <BaseModal :modalActive="activeDogForEdit !== null" @close-modal="nullActiveDogForEdit">
            <edit-dog-modal :owner_id="owner.id" :dog="activeDogForEdit"/>
        </BaseModal>
    </div>

</template>

<script setup>

import NavLink from "@/Components/NavLink.vue";
import {defineProps, ref} from "vue";
import BaseModal from "@/Modals/Appointments/BaseModal.vue";
import AddDogModal from "@/Modals/Dogs/AddDogModal.vue";
import DeleteDogConfirmationModal from "@/Modals/Dogs/DeleteDogConfirmationModal.vue";
import AddVaccinesModal from "@/Modals/Vaccines/AddVaccinesModal.vue";
import EditDogModal from "@/Modals/Dogs/EditDogModal.vue";
import EditOwnerModal from "@/Modals/Owners/EditOwnerModal.vue";

const props = defineProps({
    owner: {
        type: Object,
        default: () => {}
    },
    dogs: {
        type: Object,
        default: () => {}
    },
    vaccines: {
        type: Object,
        default: () => {}
    }
})

const activeDogForVaccines = ref(null);
const activeDogForRemoval = ref(null);
const activeDogForEdit = ref(null);


const setActiveDogForVaccines = (dogId) => {
    activeDogForVaccines.value = dogId;
    activeDogForRemoval.value = null;
};

const nullActiveDogForVaccines = () => {
    activeDogForVaccines.value = null;
};

const setActiveDogForRemoval = (dogId) => {
    activeDogForRemoval.value = dogId;
    activeDogForVaccines.value = null;
};

const nullActiveDogForRemoval = () => {
    activeDogForRemoval.value = null;
};

const addDogModalActive = ref(false);
const toggleAddDogModal = function () {
    return addDogModalActive.value = !addDogModalActive.value;
}

const removeDogModalActive = ref(false);
const toggleRemoveDogModal = function () {
    return removeDogModalActive.value = !removeDogModalActive.value;
}

const editDogModalActive = ref(false);
const setActiveDogForEdit = (dog) => {
    activeDogForEdit.value = dog;
};
const nullActiveDogForEdit = (dog) => {
    activeDogForEdit.value = null;
};
const toggleEditDogModal = function () {
    return editDogModalActive.value = !editDogModalActive.value;
}

const editOwnerModalActive = ref(false);

const toggleEditOwnerModal = function () {
    return editOwnerModalActive.value = !editOwnerModalActive.value;
}

</script>

<style scoped>

</style>
