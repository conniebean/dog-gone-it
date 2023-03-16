<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-blue-50">
        <div>
            <Link href="/">
                <img src="../../images/dergs.jpg" alt="dogs">
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-yellow-50 shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
