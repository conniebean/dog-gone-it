<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition  duration-150 ease-in-out'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
);
</script>

<template>
    <div class="navbar bg-base-100">
        <div class="navbar-start">
            <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
                </label>
                <ul tabindex="0" class="menu menu-md dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-30">
                    <li></li>
                    <li><Link href="/appointments/daycare/index">Daycare</Link></li>
                    <li><Link href="/appointments/grooming/index">Grooming</Link></li>
                    <li><Link href="/appointments/boarding/index">Boarding</Link></li>
                </ul>
            </div>
            <a class="btn btn-ghost normal-case text-xl">Dog Gone It</a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><Link href="/appointments/daycare/index" :class="{'btn btn-outline py-4': $page.url.startsWith('/appointments/daycare')}">Daycare</Link></li>
                <li><Link href="/appointments/grooming/index" :class="{'btn btn-outline py-4': $page.url.startsWith('/appointments/grooming')}">Grooming</Link></li>
                <li><Link href="/appointments/boarding/index" :class="{'btn btn-outline py-4': $page.url.startsWith('/appointments/boarding')}">Boarding</Link></li>
            </ul>
        </div>
        <div class="navbar-end">
            <a class="btn btn-sm">Log Out</a>
            <a class="btn btn-sm">Switch User</a>
        </div>
    </div>
</template>
