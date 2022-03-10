<template>
  <main>
    <slot />
  </main>
</template>

<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<style scoped>
@import "/css/new-dashboard.css";
</style>
