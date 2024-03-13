<template>
    <div class="navbar bg-base-100">
        <div class="navbar-start">
            <div class="drawer z-10">
                <input id="my-drawer" type="checkbox" class="drawer-toggle"/>
                <div class="drawer-content flex">

                    <label for="my-drawer" class="btn drawer-button h-full">
                        <SideBar/>
                    </label>
                    <h2 class="mt-2 ml-2 font-bold text-lg">Dog Gone It</h2>
                </div>
                <div class="drawer-side">
                    <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                    <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
                        <!-- Sidebar content here -->
                        <li class="text-lg"><a>Dog Gone It</a></li>
                        <li><Link href="/api/owner/index">Owners</Link></li>
                        <li><a>Dogs</a></li>
                        <li><a>Reports</a></li>
                        <li><h2 class="menu-title">Appointment Types</h2>
                        <ul>
                            <li>
                            <Link href="/appointments/daycare/index">Daycare</Link>
                            </li>
                            <li>
                                <Link href="/appointments/grooming/index">Grooming</Link>
                            </li>
                            <li>
                                <Link href="/appointments/boarding/index">Boarding</Link>
                            </li>
                        </ul>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li>
                    <Link
                        href="/appointments/daycare/index"
                        :class="{'btn btn-outline py-4': $page.url.startsWith('/appointments/daycare')}">
                        Daycare
                    </Link>
                </li>
                <li>
                    <Link
                        href="/appointments/grooming/index"
                        :class="{'btn btn-outline py-4': $page.url.startsWith('/appointments/grooming')}">
                        Grooming
                    </Link>
                </li>
                <li>
                    <Link
                        href="/appointments/boarding/index"
                        :class="{'btn btn-outline py-4': $page.url.startsWith('/appointments/boarding')}">
                        Boarding
                    </Link>
                </li>
            </ul>
        </div>
        <div class="navbar-end">
            <a class="btn btn-sm mr-4">Log Out</a>
            <a class="btn btn-sm mr-4">Switch User</a>
        </div>
    </div>
</template>

<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/inertia-vue3';
import SideBar from "@/Components/SideBar.vue";

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition  duration-150 ease-in-out'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
);
</script>
