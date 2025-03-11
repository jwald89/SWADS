<script setup>
import Layout from "../Shared/Layout.vue";
import vSelect from "vue-select";
import axios from "axios";
import { ref, watch, defineComponent } from "vue";
import { usePage, Link, router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../components/Pagination.vue";

const props = defineProps({
    sectoral: {
        type: Object,
        required: true,
    },
    search: {
        type: String,
        default: "",
    },
    sectors: {
        type: Object,
        required: true,
    },
    municipalities: {
        type: Object,
        required: true,
    },
    months: {
        type: Object,
        required: true,
    },
});

const search = ref(props.search || "");

const selectedSector = ref({ id: "*", name: "All" });
const selectedMunicipal = ref({ id: "*", municipality: "All" });
const selectedMonth = ref({ id: "*", name: "All" });

const filterData = async () => {
    try {
        const sectorId = selectedSector.value.id || "*";
        const municipalId = selectedMunicipal.value.id || "*";
        const monthId = selectedMonth.value.id || "*";

        const response = await axios.get(
            `/sectoral-data/filter/${sectorId}/${municipalId}/${monthId}`
        );
        // console.log("API Response:", response.data);
        props.sectoral.data = response.data;
    } catch (error) {
        console.error("Error fetching filtered data:", error);
    }
};

// Watch for changes in props.data and update filteredData accordingly
watch([selectedSector, selectedMunicipal, selectedMonth], () => {
    filterData();
});

const page = usePage();

const hasAccess = (type) => {
    type = type.map((t) => t.toUpperCase());
    return type.includes(page.props.role_type);
};

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
    Pagination,
});

watch(
    search,
    debounce(() => {
        router.visit(`/sectoral-data?search=${search.value}`, {
            preserveState: true,
            preserveScroll: true,
        });
    }, 500)
);
</script>

<template>
    <Layout>
        <div class="card">
            <div
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">Sectoral Data List</div>
                    <div class="col-lg-6 float-end">
                        <Link
                            :href="`/sectoral-data/create`"
                            class="btn btn-sm btn-light float-end"
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
                        <div class="col-12 col-sm-6 col-md-3 mb-3">
                            <label class="fw-bold" for=""
                                >Filter a sector type</label
                            >
                            <v-select
                                :options="[
                                    { id: '*', name: 'All' },
                                    ...sectors.data,
                                ]"
                                v-model="selectedSector"
                                label="name"
                                placeholder="All"
                            ></v-select>
                        </div>
                        <div
                            class="col-12 col-sm-6 col-md-3 mb-3"
                            v-if="hasAccess(['admin', 'user'])"
                        >
                            <label class="fw-bold" for=""
                                >Filter a municipality</label
                            >
                            <v-select
                                :options="[
                                    { id: '*', municipality: 'All' },
                                    ...municipalities.data,
                                ]"
                                v-model="selectedMunicipal"
                                label="municipality"
                                placeholder="All"
                            ></v-select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 mb-3">
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
                        <div class="col-12 col-sm-6 col-md-2 mb-2">
                            <label class="fw-bold" for="">Year</label>
                            <select name="" id="" class="form-select">
                                <option value="2025">2025</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
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
                <div class="table-responsive mt-5">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr class="bg-primary text-white">
                                <th>No.</th>
                                <th>Sector</th>
                                <th>Client</th>
                                <th>Age</th>
                                <th>Date of Birth</th>
                                <th v-if="hasAccess(['admin', 'user'])">
                                    Municipality
                                </th>
                                <th v-if="hasAccess(['municipal'])">
                                    Barangay
                                </th>
                                <th>Date Encoded</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="sectoral.data.length" class="text-center">
                            <tr
                                v-for="(sectoral, index) in sectoral.data"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ sectoral.sector.name }}</td>
                                <td>
                                    {{
                                        sectoral.first_name
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
                                        sectoral.middle_name === null
                                            ? ""
                                            : sectoral.middle_name
                                                  .substr(0, 1)
                                                  .toUpperCase() + "."
                                    }}
                                    {{
                                        sectoral.last_name
                                            .charAt(0)
                                            .toUpperCase() +
                                        sectoral.last_name.slice(1)
                                    }}
                                </td>
                                <td>{{ sectoral.age }}</td>
                                <td>{{ formatDate(sectoral.birthdate) }}</td>
                                <td v-if="hasAccess(['admin', 'user'])">
                                    {{ sectoral.municipality.municipality }}
                                </td>
                                <td v-if="hasAccess(['municipal'])">
                                    {{ sectoral.barangay.barangay }}
                                </td>
                                <td class="text-primary">
                                    {{ formatDate(sectoral.date_encoded) }}
                                </td>
                                <td>
                                    <Link
                                        :href="`/sectoral-data/edit/${sectoral.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['admin', 'user'])"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </Link>
                                    <Link
                                        :href="`/municipal/sectoral/edit/${sectoral.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['municipal'])"
                                        title="Update"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Update -->
                                    </Link>
                                    <Link
                                        :href="`/sectoral-data/show/${sectoral.id}`"
                                        class="btn btn-sm btn-info me-2"
                                        title="Details"
                                    >
                                        <i class="bi bi-eye"></i>
                                        <!-- Details -->
                                    </Link>
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
                    <pagination :records="sectoral" :link="sectoral.path" />
                </div>
            </div>
        </div>
    </Layout>
</template>
