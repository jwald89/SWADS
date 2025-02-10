<script setup>
import { defineComponent, onMounted, ref, watch } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import axios from "axios";
import { debounce } from "lodash";
import { Link, router, usePage } from "@inertiajs/vue3";
import Pagination from "../components/Pagination.vue";
import vSelect from "vue-select";

const props = defineProps({
    intake: {
        type: Object,
        required: true,
    },
    search: {
        type: String,
        default: "",
    },
    famComps: {
        type: Object,
        required: true,
    },
    assistance: {
        type: Object,
        required: true,
    },
    months: {
        type: Object,
        required: true,
    },
});

const search = ref(props.search || "");

const selectedAssistance = ref({ id: "*", name: "All" });
const selectedMonth = ref({ id: "*", name: "All" });

const filterData = async () => {
    try {
        const assistanceId = selectedAssistance.value.id || "*";
        const monthId = selectedMonth.value.id || "*";

        const response = await axios.get(
            `/intake/filter/${assistanceId}/${monthId}`
        );
        // console.log("API Response:", response.data);
        props.intake.data = response.data;
    } catch (error) {
        console.error("Error fetching filtered data:", error);
    }
};

// Watch for changes in props.data and update filteredData accordingly
watch([selectedAssistance, selectedMonth], () => {
    filterData();
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

const getData = async () => {
    try {
        const response = await axios.get("/intake");
        props.value = response.data.data;
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
                <div class="col-lg-12 d-flex">
                    <div class="col-lg-6">Intake List</div>
                    <div class="col-lg-6 float-end">
                        <Link
                            :href="`/intake/create`"
                            class="btn btn-sm btn-light float-end"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Create New
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body mt-4">
                <div class="d-flex justify-around">
                    <div class="row col-lg-10">
                        <div class="col-lg-3">
                            <label class="fw-bold" for=""
                                >Assistance Type</label
                            >
                            <v-select
                                :options="[
                                    { id: '*', name: 'All' },
                                    ...assistance.data,
                                ]"
                                v-model="selectedAssistance"
                                label="name"
                                placeholder="All"
                            ></v-select>
                        </div>
                        <!-- <div class="col-lg-3 ms-1">
                            <label class="fw-bold" for="">Municipality</label>
                            <v-select
                                :options="[
                                    { id: '*', name: 'All' },
                                    { id: '01', name: 'January' },
                                    { id: '02', name: 'February' },
                                    { id: '03', name: 'March' },
                                    { id: '04', name: 'April' },
                                    { id: '05', name: 'May' },
                                    { id: '06', name: 'June' },
                                    { id: '07', name: 'July' },
                                    { id: '08', name: 'August' },
                                    { id: '09', name: 'September' },
                                    { id: '10', name: 'October' },
                                    { id: '11', name: 'November' },
                                    { id: '12', name: 'December' },
                                ]"
                                v-model="selectedMonth"
                                label="name"
                                placeholder="All"
                            ></v-select>
                        </div> -->
                        <div class="col-lg-2 ms-1">
                            <label class="fw-bold" for="">Month</label>
                            <v-select
                                :options="[
                                    { id: '*', name: 'All' },
                                    { id: '01', name: 'January' },
                                    { id: '02', name: 'February' },
                                    { id: '03', name: 'March' },
                                    { id: '04', name: 'April' },
                                    { id: '05', name: 'May' },
                                    { id: '06', name: 'June' },
                                    { id: '07', name: 'July' },
                                    { id: '08', name: 'August' },
                                    { id: '09', name: 'September' },
                                    { id: '10', name: 'October' },
                                    { id: '11', name: 'November' },
                                    { id: '12', name: 'December' },
                                ]"
                                v-model="selectedMonth"
                                label="name"
                                placeholder="All"
                            ></v-select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label class="fw-bold" for=""
                            >Search by client name
                        </label>
                        <input
                            type="text"
                            v-model="search"
                            class="form-control border border-secondary"
                            autofocus
                            placeholder="search here.."
                        />
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
                                <th>COE</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" v-if="intake.data.length">
                            <tr
                                v-for="(detail, index) in intake.data"
                                :key="index"
                            >
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
                                        detail.assistance.name
                                            .charAt(0)
                                            .toUpperCase() +
                                        detail.assistance.name.slice(1)
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
                                    <a
                                        :href="`/intake/print-coe/${detail.id}`"
                                        class="btn btn-sm btn-warning"
                                        target="_blank"
                                        title="Print"
                                    >
                                        <i class="bi bi-printer"></i>
                                    </a>
                                </td>
                                <td>
                                    <Link
                                        :href="`/intake/edit/${detail.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </Link>
                                    <Link
                                        :href="`/intake/show/${detail.id}`"
                                        class="btn btn-sm btn-info me-2"
                                        title="Details"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </Link>
                                    <a
                                        :href="`/intake/intake-sheet-print/${detail.id}`"
                                        class="btn btn-sm btn-warning me-2"
                                        target="_blank"
                                        title="Print"
                                    >
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    <a
                                        :href="`/intake/export/${detail.id}`"
                                        class="btn btn-sm btn-success me-2"
                                        title="Download"
                                    >
                                        <i class="bi bi-download"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="9" class="text-center">
                                    No record found.
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
