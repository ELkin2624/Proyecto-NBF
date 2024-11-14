<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'">
        <img
            src="/images/logo.jpg"
            alt="Logo de Galería"
            class="w-24 h-25 object-contain mx-auto rounded-full shadow-md hover:shadow-lg transition-all duration-300 ease-in-out -mt-3"
        />
    </Link>
</template>
