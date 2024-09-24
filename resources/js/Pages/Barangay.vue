<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent } from "vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    barangays: {
        type: Object,
    },
});

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
                        <h5 class="fw-bold">Barangay</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            href="/barangay/create"
                            class="btn btn-sm btn-light float-end"
                        >
                            Create
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Barangays</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="barangay in barangays"
                            :key="barangay.id"
                        >
                            <tr>
                                <td>{{ barangay.id }}</td>
                                <td>
                                    {{ barangay.barangay }}
                                    <small class="text-primary"
                                        >|
                                        {{ barangay.municipal.municipality }}
                                    </small>
                                </td>
                                <td>
                                    <Link
                                        href=""
                                        class="btn btn-sm btn-primary me-2"
                                        >Edit</Link
                                    >
                                    <Link
                                        href=""
                                        class="btn btn-sm btn-info me-2"
                                        >Details</Link
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
