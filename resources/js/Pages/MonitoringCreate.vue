<script setup>
import { defineComponent } from "vue";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";
import { Link } from "@inertiajs/vue3";

defineComponent({
    Link,
    Navbar,
    Sidebar,
});
</script>

<template>
    <Navbar />
    <Sidebar />
    <main class="main" id="main">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <div class="d-flex justify-space-around">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Create Record</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            href="/monitoring"
                            >Back</Link
                        >
                    </div>
                </div>
            </div>
            <div class="card-body mt-4">
                <div class="mt-4 float-end">
                    <button type="button" class="btn btn-md btn-success">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>
