<script setup>
import LayoutApp from "../Pages/LayoutApp.vue";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";
import Footer from "@/components/Footer.vue";
import { defineComponent } from "vue";

defineComponent({
    LayoutApp,
    Navbar,
    Sidebar,
    Footer,
});
</script>

<template>
    <Navbar />
    <Sidebar />
    <main id="main" class="main">
        <h1>Social Welfare And Development System Dashboard</h1>
    </main>
    <Footer />
</template>
