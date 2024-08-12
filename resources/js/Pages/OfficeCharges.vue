<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent } from "vue";

defineComponent({
    LayoutApp,
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
                        <h5 class="fw-bold">Office Charges</h5>
                    </div>
                    <div class="col-lg-6"></div>
                </div>
            </div>
            <div class="card-body mt-4"></div>
        </div>
    </LayoutApp>
</template>
