
<template>
 <p class="font-bold text-xl">Are you sure you wish to delete this dog?</p>
    <div class="mt-4">
        <button
            class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded w-full shadow-lg"
            @click="removeDog"
        >
            Yes
        </button>
    </div>
</template>

<script setup>
import {defineProps} from "vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    dog_id:{
        type: Number
    },
    owner_id: {
        type: Number
    }
});

const removeDog = function () {

    fetch(`/api/dog/${props.dog_id}/owner/${props.owner_id}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json',
        },
    })
        .then(response => {
            if (!response.ok) {
                if (response.status === 422) {
                    return response.json().then(data => {
                        let messages = Object.values(data.errors).map((msgs) => msgs.join(', ')).join('. ');
                        errors.value.message = messages;
                        console.log(errors.value.message);

                        throw new Error('Validation failed');
                    });
                } else {
                    throw new Error('Some error occurred');
                }
            }
            return response.json();
        })
        .then(data => {
            if (!data.errors) {
                Inertia.visit(`/api/owner/${props.owner_id}/profile`);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error.message);
        });
}
</script>

<style scoped>

</style>
