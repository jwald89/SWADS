<script setup>
import { defineComponent, ref, onMounted, watch, watchEffect } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../components/Pagination.vue";
import axios from "axios";
import vSelect from "vue-select";

const props = defineProps({
    medicine: {
        type: Object,
        required: true,
    },
    sectors: {
        type: Object,
        required: true,
    },
    barangays: {
        type: Object,
        required: true,
    },
    municipalities: {
        type: Object,
        required: true,
    },
    search: {
        type: String,
        default: "",
    },
});

const search = ref(props.search || "");
let medicineData = ref([]);
const page = usePage();

const selectedSector = ref({ id: "*", name: "All" });
const selectedMunicipal = ref({ id: "*", municipality: "All" });
const selectedMonth = ref({ id: "*", name: "All" });

const filterMedicineData = async (page = 1) => {
    try {
        const sectorId = selectedSector.value.id || "*";
        const municipalId = selectedMunicipal.value.id || "*";
        const monthId = selectedMonth.value.id || "*";

        const response = await axios.get(
            `/medicine/filter/${sectorId}/${municipalId}/${monthId}?page=${page}`
        );

        // console.log("API Response:", response.data);
        medicineData.value = response.data.data;
        props.medicine.data = medicineData.value;
        props.medicine.last_page = response.data.last_page;
    } catch (error) {
        console.error("Error fetching filtered data:", error);
    }
};

watchEffect(() => {
    props.medicine.data,
        (newMedData) => {
            medicineData.value = newMedData || [];
        };
});

const takeData = async () => {
    try {
        const response = await axios.get("/medicine");
        props.medicine.value = response.data.data;
    } catch (error) {
        console.error("Error submitting form:", error);
    }
};

onMounted(() => {
    takeData();
});

watch([selectedSector, selectedMunicipal, selectedMonth], () => {
    filterMedicineData();
});

defineComponent({
    Pagination,
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

const hasAccess = (type) => {
    type = type.map((t) => t.toUpperCase());
    return type.includes(page.props.role_type);
};

const formatDay = (day) => {
    const days = [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
    ];

    const date = new Date(day);

    return days[date.getDay()];
};

const formatTime = (time) => {
    const date = new Date(time);

    let hr = date.getHours();
    let min = date.getMinutes();

    const minute = min < 10 ? "0" + min : min;
    const ampm = hr >= 12 ? "pm" : "am";
    const hour = hr % 12 || 12;

    return `${hour}:${minute}${ampm}`;
};

watch(
    search,
    debounce(() => {
        router.visit(`/medicine?search=${search.value}`, {
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
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">Medicine List</div>
                    <div
                        class="col-lg-6 text-end"
                        v-if="hasAccess(['supervisor', 'admin', 'user'])"
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
                            <label class="fw-bold" for="">Sector</label>
                            <v-select
                                :options="[
                                    {
                                        id: '*',
                                        name: 'All',
                                    },
                                    ...sectors.data,
                                ]"
                                v-model="selectedSector"
                                label="name"
                            ></v-select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="fw-bold" for="">Municipality</label>
                            <v-select
                                :options="[
                                    {
                                        id: '*',
                                        municipality: 'All',
                                    },
                                    ...municipalities.data,
                                ]"
                                v-model="selectedMunicipal"
                                label="municipality"
                            ></v-select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="fw-bold" for="month">Month</label>
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
                        <div class="col-12 col-md-2 mb-2">
                            <label class="fw-bold" for="">Year</label>
                            <select
                                name=""
                                id=""
                                class="form-select form-select-md"
                            >
                                <option value="">All</option>
                                <option value="">2025</option>
                                <option value="">2024</option>
                            </select>
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

                <div class="table-responsive mt-3">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr class="bg-primary text-white">
                                <th>No.</th>
                                <th class="text-start px-1">Client</th>
                                <th class="text-start px-3">Amount</th>
                                <th class="text-start px-5">Sector</th>
                                <th class="text-start px-3">Date Encoded</th>
                                <th>Print</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" v-if="medicine.data">
                            <tr
                                v-for="(medicine, index) in medicine.data"
                                :key="index"
                            >
                                <td width="5%">
                                    {{ index + 1 }}
                                </td>
                                <td class="fw-bold text-start px-1" width="25%">
                                    {{
                                        medicine.first_name !== null
                                            ? medicine.first_name
                                                  .split(" ")
                                                  .map(
                                                      (word) =>
                                                          word
                                                              .charAt(0)
                                                              .toUpperCase() +
                                                          word
                                                              .slice(1)
                                                              .toLowerCase()
                                                  )
                                                  .join(" ")
                                            : ""
                                    }}
                                    {{
                                        medicine.middle_name !== null
                                            ? medicine.middle_name
                                                  .substr(0, 1)
                                                  .toUpperCase() + "."
                                            : ""
                                    }}
                                    {{
                                        medicine.last_name !== null
                                            ? medicine.last_name
                                                  .split(" ")
                                                  .map(
                                                      (word) =>
                                                          word
                                                              .charAt(0)
                                                              .toUpperCase() +
                                                          word
                                                              .slice(1)
                                                              .toLowerCase()
                                                  )
                                                  .join(" ") +
                                              (medicine.suffix
                                                  ? ", " + medicine.suffix
                                                  : "")
                                            : ""
                                    }}
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center">
                                            <small
                                                class="text-secondary text-center fw-bold"
                                            >
                                                Address:
                                                <span class="text-primary ms-1">
                                                    {{
                                                        medicine.barangay
                                                            .barangay
                                                    }},
                                                    {{
                                                        medicine.municipal
                                                            .municipality
                                                    }}
                                                </span>
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td
                                    class="fw-bold fs-5 text-start px-3"
                                    width="10%"
                                >
                                    ₱
                                    {{
                                        new Intl.NumberFormat("en-US", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        }).format(medicine.amount)
                                    }}
                                </td>
                                <td class="fw-bold text-start px-5" width="15%">
                                    {{ medicine.sector_name.name }}
                                </td>
                                <td class="fw-bold text-start px-3" width="15%">
                                    {{ formatDate(medicine.created_at) }}
                                    <div
                                        class="d-flex flex-column"
                                        style="font-size: 0.9rem"
                                    >
                                        <div class="align-items-center">
                                            <div class="text-secondary fw-bold">
                                                {{
                                                    formatDay(
                                                        medicine.created_at
                                                    )
                                                }}
                                                <span class="fw-normal ms-1">{{
                                                    formatTime(
                                                        medicine.created_at
                                                    )
                                                }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td width="20%">
                                    <a
                                        :href="`/medicine/print-guarant-letter/${medicine.id}`"
                                        class="btn btn-sm btn-outline-success me-2"
                                        target="_blank"
                                        title="Print"
                                    >
                                        <i class="bi bi-printer"></i> Guarante
                                        Letter
                                    </a>
                                    <a
                                        :href="`/medicine/print-assistance-slip/${medicine.id}`"
                                        class="btn btn-sm btn-outline-primary"
                                        target="_blank"
                                        title="Print"
                                    >
                                        <i class="bi bi-printer"></i> Assistance
                                        Slip
                                    </a>
                                </td>
                                <td width="10%">
                                    <Link
                                        :href="`/medicine/edit/${medicine.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="
                                            hasAccess(['supervisor', 'admin'])
                                        "
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </Link>
                                    <a
                                        href="#"
                                        class="btn btn-sm btn-info me-2"
                                        title="Details"
                                    >
                                        <i class="bi bi-eye"></i>
                                        <!-- Details -->
                                    </a>
                                    <a
                                        :href="`/medicine/export/${medicine.id}`"
                                        class="btn btn-sm btn-success me-2"
                                        v-if="
                                            hasAccess(['supervisor', 'admin'])
                                        "
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
                    <pagination
                        :records="medicine"
                        :link="medicine.path"
                        :on-page-change="filterMedicineData"
                    />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
