<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref, watch, defineComponent } from "vue";
import { debounce } from "lodash";
import Pagination from "../components/Pagination.vue";
import axios from "axios";
import vSelect from "vue-select";

const props = defineProps({
    childData: {
        type: Object,
    },
    barangays: Object,
    municipalities: Object,
});

const search = ref(props.search || "");

const selectedBrgy = ref({ id: "*", barangay: "All" });
const selectedMunicipal = ref({ id: "*", municipality: "All" });
const selectedMonth = ref({ id: "*", name: "All" });

const filterData = async () => {
    try {
        const brgyId = selectedBrgy.value.id || "*";
        const municipalId = selectedMunicipal.value.id || "*";
        const monthId = selectedMonth.value.id || "*";

        const response = await axios.get(
            `/child-development/filter/${brgyId}/${municipalId}/${monthId}`
        );
        // console.log("API Response:", response.data);
        props.childData.data = response.data;
    } catch (error) {
        console.error("Error fetching filtered data:", error);
    }
};

// Watch for changes in props.data and update filteredData accordingly
watch([selectedBrgy, selectedMunicipal, selectedMonth], () => {
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

defineComponent({
    Pagination,
});

watch(
    search,
    debounce(() => {
        router.visit(`/child-development?search=${search.value}`, {
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
                    <div class="col-lg-6">Child Development Data List</div>
                    <div class="col-lg-6 float-end">
                        <Link
                            :href="`/child-development/create`"
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
                            <label class="fw-bold" for="">Barangay</label>
                            <v-select
                                :options="[
                                    { id: '*', barangay: 'All' },
                                    ...barangays.data,
                                ]"
                                v-model="selectedBrgy"
                                label="barangay"
                                placeholder="All"
                            ></v-select>
                        </div>
                        <div class="col-lg-2 ms-1">
                            <label class="fw-bold" for="">Municipality</label>
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
                        <label class="fw-bold" for="">Search</label>
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
                    <table class="table">
                        <thead class="text-center">
                            <tr class="bg-primary text-white">
                                <th>No.</th>
                                <th>CDC</th>
                                <th>CDW</th>
                                <th>Barangay</th>
                                <th>Municipality</th>
                                <th>Status</th>
                                <th>Recogniton Level</th>
                                <th>Date Encoded</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" v-if="childData.data.length">
                            <tr
                                v-for="(children, index) in childData.data"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ children.cdc_name }}</td>
                                <td>{{ children.cdw_name }}</td>
                                <td>{{ children.brgy.barangay }}</td>
                                <td>{{ children.municipal.municipality }}</td>
                                <td>{{ children.status }}</td>
                                <td>{{ children.lvl_recognition }}</td>
                                <td>
                                    {{ formatDate(children.validity_of_cor) }}
                                </td>
                                <td>
                                    <Link
                                        :href="`/child-development/edit/${children.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </Link>

                                    <Link
                                        href="#"
                                        class="btn btn-sm btn-info me-2"
                                        title="Details"
                                    >
                                        <i class="bi bi-eye"></i>
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
                    <pagination :records="childData" :link="childData.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
