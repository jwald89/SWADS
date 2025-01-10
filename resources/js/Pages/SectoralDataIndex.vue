<script setup>
import Layout from "../Shared/Layout.vue";
import vSelect from "vue-select";
import axios from "axios";
import { ref, watch, defineComponent } from "vue";
import { usePage, Link, router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../components/Pagination.vue";
import { toast } from "vue3-toastify";

const props = defineProps({
    municipalities: {
        type: Object,
        required: true,
    },
    sectors: {
        type: Object,
        required: true,
    },
    months: {
        type: Object,
        required: true,
    },
    sectoral: {
        type: Object,
        required: true,
    },
    search: {
        type: String,
        default: "",
    },
});

const search = ref(props.search || "");

const selectedSector = ref("All");
const selectedMunicipal = ref("All");
// const filteredData = ref([...props.sectoral]);
// const filteredData = ref(props.sectoral.data);
// const sectoral = ref(props.sectoral.data);

const filterData = async () => {
    try {
        const response = await axios.get(
            `/api/sectoral-data/filter/${selectedSector.value.id || "*"}/${
                selectedMunicipal.value.id || "*"
            }`
        );
        console.log("API Response:", response.data);
        sectoral.value = response.data;

        console.log("Filtered value :", sectoral.value);
    } catch (error) {
        console.error("Error fetching filtered data:", error);
    }
};

// Watch for changes in props.data and update filteredData accordingly
watch(
    [(() => selectedSector.value.id, () => selectedMunicipal.value.id)],
    () => {
        filterData();
    }
);

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

const delData = async (id) => {
    try {
        alertify.confirm(
            "Delete Record",
            "Are you sure you want to delete this record?",
            function (_, value) {
                axios
                    .post(`/sectoral-data/destroy/${id}`, {
                        key: value,
                        _method: "DELETE",
                    })
                    .then((_) => {
                        toast.success(
                            "You have successfully delete a record!",
                            {
                                autoClose: 2000,
                            }
                        );
                        router.visit("/sectoral-data", {
                            preserveScroll: true,
                        });
                    })
                    .catch((error) => {
                        toast.error(error.response.data.message, {
                            autoClose: 2000,
                        });
                    });
            },
            function () {}
        );
    } catch (error) {
        console.error("Error submitting form:", error);
    }
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
                <div class="col-lg-12 d-flex">
                    <div class="col-lg-6">
                        Sectoral Data
                        <span class="h6">
                            - Inventory of “Pag-asa Youth Association of the
                            Philippines” (PYAP)</span
                        >
                    </div>
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
            <div class="card-body p-4 m-2">
                <div class="d-flex justify-around">
                    <div class="col-lg-6">
                        <button
                            class="btn btn-primary"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseExample"
                            aria-expanded="false"
                            aria-controls="collapseExample"
                        >
                            <i class="bi bi-filter-circle"></i>
                            Filter Column
                        </button>
                    </div>
                    <div class="col-lg-6">
                        <input
                            type="text"
                            v-model="search"
                            class="form-control border border-dark"
                            autofocus
                            placeholder="Search here.."
                        />
                    </div>
                </div>
                <div class="collapse mt-2" id="collapseExample">
                    <div class="card card-body p-4">
                        <!-- FILTER DIVISION -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Filter the sector type</label>
                                <v-select
                                    class="fw-bold"
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
                                class="col-md-3"
                                v-if="hasAccess(['admin', 'user'])"
                            >
                                <label for="">Filter the municipality</label>
                                <v-select
                                    class="fw-bold"
                                    :options="[
                                        { id: '*', municipality: 'All' },
                                        ...municipalities.data,
                                    ]"
                                    v-model="selectedMunicipal"
                                    label="municipality"
                                    placeholder="All"
                                ></v-select>
                            </div>
                            <div
                                class="div col-md-3"
                                v-if="hasAccess(['municipal'])"
                            ></div>
                            <div class="col-md-2 offset-md-2">
                                <label for="">Month</label>
                                <v-select
                                    class="fw-bold"
                                    :options="months"
                                    placeholder="All"
                                ></v-select>
                            </div>
                            <div class="col-md-2">
                                <label for="">Year</label>
                                <select name="" id="" class="form-select">
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                </select>
                            </div>
                        </div>
                        <!-- END FILTER DIVISION -->
                    </div>
                </div>

                <div class="table-responsive mt-5">
                    <!-- <table class="table table-hover" v-if="sectoral.length"> -->
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Sector</th>
                                <th>Client</th>
                                <th>Age</th>
                                <th>Date of Birth</th>
                                <th>Municipality</th>
                                <th>Date Encoded</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <!-- <tbody
                            class="text-center"
                            v-for="(sectoral, index) in sectoral.data"
                            :key="index"
                        > -->
                        <tbody
                            class="text-center"
                            v-for="(sectoral, index) in sectoral.data"
                            :key="index"
                        >
                            <tr>
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
                                        sectoral.middle_name
                                            .substr(0, 1)
                                            .toUpperCase()
                                    }}.
                                    {{
                                        sectoral.last_name
                                            .charAt(0)
                                            .toUpperCase() +
                                        sectoral.last_name.slice(1)
                                    }}
                                </td>
                                <td>{{ sectoral.age }}</td>
                                <td>{{ formatDate(sectoral.birthdate) }}</td>
                                <td>
                                    {{ sectoral.municipality.municipality }}
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
                                        :href="`/municipal/edit-municipal/${sectoral.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['municipal'])"
                                        title="Update"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Update -->
                                    </Link>
                                    <Link
                                        href=""
                                        class="btn btn-sm btn-info me-2"
                                        title="Details"
                                    >
                                        <i class="bi bi-eye"></i>
                                        <!-- Details -->
                                    </Link>
                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        v-if="hasAccess(['admin'])"
                                        title="Delete"
                                        @click="delData(sectoral.id)"
                                    >
                                        <i class="bi bi-trash"></i>
                                        <!-- Delete -->
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <div v-else class="text-center mt-5">
                        <p>No data available for the selected filters.</p>
                    </div> -->
                    <pagination :records="sectoral" :link="sectoral.path" />
                </div>
            </div>
        </div>
    </Layout>
</template>
