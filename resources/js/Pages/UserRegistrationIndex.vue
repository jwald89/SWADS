<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent } from "vue";
import { Link } from "@inertiajs/vue3";
import Pagination from "../components/Pagination.vue";

const props = defineProps({
    users: {
        type: Object,
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
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-space-around">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Users</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            href="/user-registration/create"
                            class="btn btn-sm btn-light float-end"
                        >
                            Create
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Municipality</th>
                                <th>Role Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(user, index) in users.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ user.username }}</td>
                                <td>
                                    {{ user.first_name }} {{ user.middle_name }}
                                    {{ user.last_name }}
                                </td>
                                <td>{{ user.municipality.municipality }}</td>
                                <td>{{ user.role_type }}</td>
                                <td
                                    class="badge rounded-pill text-bg-warning mt-2"
                                >
                                    {{ user.status }}
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
                    <pagination :records="users" :link="users.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
