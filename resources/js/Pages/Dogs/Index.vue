<template>
    <form @submit.prevent="form.post(route('dogs.store'), { onSuccess: () => form.reset() })">
                <textarea
                    v-model="form.message"
                    placeholder="Enter a dog?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
        <InputError :message="form.errors.message" class="mt-2"/>
        <PrimaryButton class="mt-4">Submit Dog</PrimaryButton>
    </form>
    <div>
        <Dog
            v-for="dog in dogs"
            :key="dog.id"
            :dog="dog"
        />
    </div>
</template>

<script setup>
import Dog from '@/Components/Dog';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import {useForm} from "@inertiajs/inertia-vue3";

defineProps(['dogs']);

const form = useForm({
    message: '',
});
</script>

<style scoped>

</style>
