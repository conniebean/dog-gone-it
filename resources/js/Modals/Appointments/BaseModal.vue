<template>
    <div v-show="modalActive"
         class="absolute w-full bg-black bg-opacity-30 h-screen top-0 left-0 flex justify-center px-8">
        <div v-if="modalActive" class="p-16 bg-neutral self-start mt-32 max-w-screen-2xl rounded-xl">
            <slot/>
            <button @click="$emit('close-modal')"
                    class="text-white mt-8 bg-gray-700 hover:bg-gray-900 font-bold py-2 px-4 rounded w-full shadow-lg">
                Close
            </button>
            <!--            bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded w-full shadow-lg-->
        </div>
    </div>
</template>

<script setup>
defineEmits(['close-modal'])
defineProps({
    modalActive: {
        type: Boolean,
        default: false
    }
})
</script>

<style scoped>

</style>
