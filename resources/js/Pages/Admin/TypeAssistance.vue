<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import { ref, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../../components/Pagination.vue";

const props = defineProps({
    assistanceType: {
        type: Object,
    },
    search: {
        type: String,
        default: "",
    },
});

const search = ref(props.search || "");

watch(
    search,
    debounce(() => {
        router.visit(`/type-assistance?search=${search.value}`, {
            preserveState: true,
            preserveScroll: true,
        });
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
                <h5 class="fw-bold">Type Assistance</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-space-around mb-4">
                    <div class="col-lg-6">
                        <input
                            type="text"
                            v-model="search"
                            class="form-control border border-dark"
                            autofocus
                            placeholder="Search here.."
                        />
                    </div>
                    <div class="col-lg-6">
                        <Link
                            :href="`/type-assistance/create`"
                            class="btn btn-md btn-primary float-end"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Create New
                        </Link>
                    </div>
                </div>
                <div class="table-responsive mt-4">
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
                            v-for="(data, index) in assistanceType.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.name }}</td>
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
                    <pagination
                        :records="assistanceType"
                        :link="assistanceType.path"
                    />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
