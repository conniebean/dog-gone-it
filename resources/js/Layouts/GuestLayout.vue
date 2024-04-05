<script setup>
import {Link} from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="navbar bg-base-200 glass">
        <div class="navbar-start">
            <div class="drawer z-10">
                <input id="my-drawer" type="checkbox" class="drawer-toggle"/>
                <div class="drawer-content flex">
                    <h2 class="mt-2 ml-2 font-bold text-xl">Dog Gone It</h2>
                </div>
            </div>

        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li>
                    <Link
                        href="#"
                        :class="{'btn btn-outline py-4': $page.url.startsWith('/contact-us')}">
                        Contact Us
                    </Link>
                </li>
                <li>
                    <Link
                        href="#"
                        :class="{'btn btn-outline py-4': $page.url.startsWith('/pricing')}">
                        Pricing
                    </Link>
                </li>
            </ul>
        </div>
        <div class="navbar-end">
            <Link href="#" class="btn btn-secondary text-md text-white hover:text-gray-300">
                Create an account
            </Link>
        </div>
    </div>
    <div class="flex flex-col sm:justify-center items-center mt-24 sm:pt-0 bg-base-50">

        <div>
            <img src="../../images/dog_gone_it.png" alt="dogs"
                 class="w-72 h-72 border-2 border-gray-600 mask mask-circle">
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-base-300 shadow-lg overflow-hidden sm:rounded-lg glass">
            <slot/>
        </div>

    </div>
</template>
