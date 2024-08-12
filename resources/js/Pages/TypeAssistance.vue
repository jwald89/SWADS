<script setup>
import LayoutApp from "../Shared/Layout.vue";
import Footer from "@/components/Footer.vue";
import { defineComponent } from "vue";

defineComponent({
    LayoutApp,
    Footer,
});
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-space-around">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Type Assistance</h5>
                    </div>
                    <div class="col-lg-6"></div>
                </div>
            </div>
            <div class="card-body mt-4"></div>
        </div>
    </LayoutApp>
</template>
