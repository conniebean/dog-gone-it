
<template>
<!--    okay here is where my brain shat, we need to click a confirm button that deletes the dogoo
or we need to cancel which doesn't delete the dog meenss is  so cute-->
 <h1>haaaaaaaay {{props.dog_id}}</h1>
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

    fetch(`/api/owner/` + props.owner_id+ `/dogs/` + props.dog_id, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json',
        },
    })
        .then(response => {
            // Check if the response was ok (status in the range 200-299)
            if (!response.ok) {
                // If the server response was not ok, handle 422 or other errors
                if (response.status === 422) {
                    // Parse JSON to get the actual validation errors
                    return response.json().then(data => {
                        let messages = Object.values(data.errors).map((msgs) => msgs.join(', ')).join('. ');
                        errors.value.message = messages;
                        console.log(errors.value.message); // Log or handle errors

                        throw new Error('Validation failed'); // Prevent further processing
                    });
                } else {
                    // Handle other errors
                    throw new Error('Some error occurred');
                }
            }
            // If response was ok, parse it as JSON and proceed
            return response.json();
        })
        .then(data => {
            if (!data.errors) {
                Inertia.visit(`/api/owner/${props.owner.id}/profile`);
                // Inertia.reload({ only: ['dogs'] });
            }
            // Handle success case, data is the JSON object from the response
        })
        .catch(error => {
            // Catch block for network errors or errors thrown from then blocks
            console.error('Fetch error:', error.message);
        });
}
</script>

<style scoped>

</style>
