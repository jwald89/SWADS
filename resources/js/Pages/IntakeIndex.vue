<script setup>
import { defineComponent, onMounted, ref, watch } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import axios from "axios";
import { debounce } from "lodash";
import { Link, router } from "@inertiajs/vue3";
import Pagination from "../components/Pagination.vue";

const personalData = defineProps({
    intake: {
        type: Object,
    },
    search: {
        type: String,
        default: "",
    },
    famComps: {
        type: Object,
    },
});

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

const search = ref(personalData.search || "");

const getData = async () => {
    try {
        const response = await axios.get("/intake");
        personalData.value = response.data.data;
        console.log("test");
        console.log("Data fetched successfully.");
    } catch (error) {
        console.error("Error submitting form:", error);
    }
};

defineComponent({
    Pagination,
});

onMounted(() => {
    getData();
});

watch(
    search,
    debounce(() => {
        router.visit(`/intake?search=${search.value}`, {
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
                Intake Lists
            </div>
            <div class="card-body">
                <div class="d-flex justify-space-around mt-4">
                    <div class="col-lg-4">
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
                    <div class="col-lg-8 float-end">
                        <Link
                            class="btn btn-md btn-primary float-end"
                            href="/intake/create"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Create New
                        </Link>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Client</th>
                                <th>Assistance</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Address</th>
                                <th>Date Intake</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(detail, index) in intake.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>
                                    {{
                                        detail.first_name
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
                                    {{
                                        detail.middle_name
                                            .substr(0, 1)
                                            .toUpperCase()
                                    }}.
                                    {{
                                        detail.last_name
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
                                <td>
                                    {{
                                        detail.category
                                            .charAt(0)
                                            .toUpperCase() +
                                        detail.category.slice(1)
                                    }}
                                </td>
                                <td>
                                    {{
                                        detail.sex.charAt(0).toUpperCase() +
                                        detail.sex.slice(1)
                                    }}
                                </td>
                                <td>{{ formatDate(detail.birthdate) }}</td>
                                <td>
                                    {{
                                        detail.purok
                                            ? "Prk. " + detail.purok + ","
                                            : ""
                                    }}
                                    {{
                                        detail.street
                                            ? detail.street + " St.,"
                                            : ""
                                    }}
                                    {{ detail.barangay }},
                                    {{ detail.municipality }}
                                </td>
                                <td class="text-primary">
                                    {{ formatDate(detail.date_intake) }}
                                </td>
                                <td>
                                    <Link
                                        :href="`/intake/edit/${detail.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </Link>
                                    <Link
                                        :href="`/intake/show/${detail.id}`"
                                        class="btn btn-sm btn-info me-2"
                                        title="Details"
                                    >
                                        <i class="bi bi-eye"></i>
                                        <!-- Details -->
                                    </Link>
                                    <a
                                        :href="`/intake/print/${detail.id}`"
                                        class="btn btn-sm btn-warning me-2"
                                        target="_blank"
                                        title="Print"
                                    >
                                        <i class="bi bi-printer"></i>
                                        <!-- Print -->
                                    </a>
                                    <a
                                        :href="`/intake/export/${detail.id}`"
                                        class="btn btn-sm btn-success"
                                        title="Export"
                                    >
                                        <i class="bi bi-download"></i>
                                        <!-- Export -->
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :records="intake" :link="intake.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
