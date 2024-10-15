<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent, ref, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../components/Pagination.vue";

const props = defineProps({
    sectors: {
        type: Object,
    },
    search: {
        type: String,
        default: "",
    },
});

const search = ref(props.search || "");

defineComponent({
    LayoutApp,
});

watch(
    search,
    debounce(() => {
        router.visit(`/sectors?search=${search.value}`);
    }, 500)
);
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
                        <h5 class="fw-bold">Sector</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            href="/sectors/create"
                            class="btn btn-sm btn-light float-end"
                            >Create</Link
                        >
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="col col-lg-4 mb-3">
                    <input
                        type="text"
                        class="form-control border border-dark"
                        v-model="search"
                        autofocus
                        placeholder="Search here.."
                    />
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(sector, index) in sectors.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ sector.name }}</td>
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
                    <pagination :records="sectors" :link="sectors.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
