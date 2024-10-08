<script setup>
import { defineComponent } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import { Link } from "@inertiajs/vue3";
import Pagination from "../components/Pagination.vue";

const props = defineProps({
    monitoring: {
        type: Object,
        requried: true,
    },
});

defineComponent({
    LayoutApp,
    Pagination,
});
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                Monitoring Lists
            </div>
            <div class="card-body">
                <div class="d-flex justify-space-around mt-4">
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search here.."
                            />
                            <button class="btn btn-secondary" type="button">
                                Search
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-6 float-end">
                        <Link
                            class="btn btn-md btn-primary float-end"
                            href="/monitoring/create"
                            >Create New</Link
                        >
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>Assistance Type</th>
                                <th>Name</th>
                                <th>Date of Intake</th>
                                <th>Sector</th>
                                <th>Municipality</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="data in monitoring.data"
                            :key="data.id"
                        >
                            <tr>
                                <td>{{ data.assistance_type }}</td>
                                <td>{{ data.claimant }}</td>
                                <td>{{ data.date_intake }}</td>
                                <td>{{ data.sector }}</td>
                                <td>{{ data.municipality }}</td>
                                <td>
                                    {{
                                        new Intl.NumberFormat("en-US", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        }).format(data.amount)
                                    }}
                                </td>

                                <td
                                    class="badge rounded-pill text-bg-warning mt-2"
                                >
                                    {{ data.status }}
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
                    <pagination :records="monitoring" :link="monitoring.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
