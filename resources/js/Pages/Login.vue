<script setup>
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";
import Footer from "@/components/Footer.vue";
import { defineComponent } from "vue";

defineComponent({
    Navbar,
    Sidebar,
    Footer,
});
</script>

<template>
    <Navbar />
    <Sidebar />
    <main id="main" class="main">
        <h1>LOGIN PAGE</h1>
    </main>
    <Footer />
</template>
