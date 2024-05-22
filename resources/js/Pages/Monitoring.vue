<script setup>
import { defineComponent } from "vue";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";

defineComponent({
    Navbar,
    Sidebar,
});
</script>

<template>
    <Navbar />
    <Sidebar />
    <main class="main" id="main">
        <h1>MONITORING PAGE</h1>
    </main>
</template>
