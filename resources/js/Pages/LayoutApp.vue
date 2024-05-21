<script setup>
import { defineComponent } from "vue";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";
import Footer from "@/components/Footer.vue";

defineComponent({
    Navbar,
    Sidebar,
    Footer,
});
</script>

<template>
    <Navbar />

    <Sidebar />

    <main id="main" class="main"></main>

    <Footer />
</template>
