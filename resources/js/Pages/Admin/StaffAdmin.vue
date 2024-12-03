<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import { ref, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../../components/Pagination.vue";

const props = defineProps({
    staff: {
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
        router.visit(`/staff-admin?search=${search.value}`, {
            preserveState: true,
            preserveScroll: true,
        });
    })
);
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <h5 class="fw-bold">Staff Administered</h5>
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
                            :href="`/staff-admin/create`"
                            class="btn btn-md btn-primary float-end"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Create New
                        </Link>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Lastname</th>
                                <th>Firstname</th>
                                <th>Middle Initial</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(staff, index) in staff.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ staff.lastname }}</td>
                                <td>{{ staff.firstname }}</td>
                                <td>{{ staff.middlename }}</td>
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
                    <pagination :records="staff" :link="staff.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
