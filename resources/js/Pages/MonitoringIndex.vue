<script setup>
import { defineComponent, watch, ref } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../components/Pagination.vue";

const props = defineProps({
    monitoring: {
        type: Object,
        requried: true,
    },
    search: {
        type: String,
        default: "",
    },
});

const page = usePage();

const hasAccess = (type) => {
    type = type.map((t) => t.toUpperCase());
    return type.includes(page.props.role_type);
};

const search = ref(props.search || "");

const formatDate = (dateString) => {
    const date = new Date(dateString);

    // Custom formatting: Day, 3-letter month, and year
    const options = { year: "numeric", month: "short", day: "numeric" };

    // Format the date using toLocaleDateString
    let formattedDate = date.toLocaleDateString("en-US", options);

    // Add a period after the 3-letter month
    formattedDate = formattedDate.replace(/([a-zA-Z]{3})/, "$1.");

    return formattedDate;
};

defineComponent({
    LayoutApp,
    Pagination,
});

watch(
    search,
    debounce(() => {
        router.visit(`/monitoring?search=${search.value}`, {
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
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                Monitoring Lists
            </div>
            <div class="card-body">
                <div class="d-flex justify-space-around mt-4">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <input
                                type="text"
                                v-model="search"
                                class="form-control border border-dark"
                                autofocus
                                placeholder="Search here.."
                            />
                        </div>
                    </div>
                    <div
                        class="col-lg-6 float-end"
                        v-if="hasAccess(['admin', 'user'])"
                    >
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
                                <th>No.</th>
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
                            v-for="(data, index) in monitoring.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.assistance_type }}</td>
                                <td>
                                    {{
                                        data.claimant
                                            .split(" ")
                                            .map(
                                                (word) =>
                                                    word
                                                        .charAt(0)
                                                        .toUpperCase() +
                                                    word.slice(1).toLowerCase()
                                            )
                                            .join(" ")
                                    }}
                                </td>
                                <td class="text-primary">
                                    {{ formatDate(data.date_intake) }}
                                </td>
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
                                    <!-- For ADMIN and USER role button -->
                                    <Link
                                        :href="`/monitoring/edit/${data.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['admin', 'user'])"
                                        >Edit</Link
                                    >
                                    <!-- For LIAISON role button -->
                                    <Link
                                        :href="`/liaison/edit-liaison/${data.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['liaison'])"
                                        >Update</Link
                                    >
                                    <!-- For ADMIN and USER role button -->
                                    <Link
                                        href=""
                                        class="btn btn-sm btn-info me-2"
                                        v-if="hasAccess(['admin', 'user'])"
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
