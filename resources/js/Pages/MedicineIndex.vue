<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { Link, usePage } from "@inertiajs/vue3";
import Pagination from "../components/Pagination.vue";

const page = usePage();

const hasAccess = (type) => {
    type = type.map((t) => t.toUpperCase());
    return type.includes(page.props.role_type);
};
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">Medicine List</div>
                    <div
                        class="col-lg-6 text-end"
                        v-if="hasAccess(['admin', 'user'])"
                    >
                        <Link
                            :href="`/medicine/create`"
                            class="btn btn-sm btn-light"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Create New
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body mt-4">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between"
                >
                    <div class="row col-md-10">
                        <div class="col-12 col-md-3 mb-2">
                            <label class="fw-bold" for=""
                                >Assistance Type</label
                            >
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="fw-bold" for="">Sector</label>
                        </div>
                        <div class="col-12 col-md-2 mb-2">
                            <label class="fw-bold" for="">Municipality</label>
                        </div>
                        <div class="col-12 col-md-2 mb-2">
                            <label class="fw-bold" for="">Month</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="fw-bold" for="">Search by client </label>
                        <input
                            type="text"
                            v-model="search"
                            class="form-control border border-secondary"
                            autofocus
                            placeholder="search here.."
                        />
                    </div>
                </div>

                <div class="table-responsive mt-5">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr class="bg-primary text-white">
                                <th>No.</th>
                                <th>Client</th>
                                <th>Address</th>
                                <th>Valid Date</th>
                                <th>Pharmacy</th>
                                <th>Amount</th>
                                <th>Prepared By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr></tr>
                        </tbody>
                    </table>
                    <!-- <pagination
                        :records="monitorings"
                        :link="monitorings.path"
                    /> -->
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
