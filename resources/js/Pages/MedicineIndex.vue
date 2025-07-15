<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import Pagination from "../components/Pagination.vue";
import vSelect from "vue-select";

const props = defineProps({
    medicines: {
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
    months: {
        type: Object,
    },
});

const selectedBrgy = ref({ id: "*", barangay: "All" });
const selectedMunicipal = ref({ id: "*", municipality: "All" });
const selectedMonth = ref({ id: "*", name: "All" });

const page = usePage();

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
                            <label class="fw-bold" for="">Barangay</label>
                            <v-select
                                :options="[
                                    { id: '*', barangays: 'All' },
                                    ...barangays.data,
                                ]"
                                v-model="selectedBrgy"
                                label="barangay"
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
                                <th class="text-start px-3">Client</th>
                                <th>Amount</th>
                                <th>Date Encoded</th>
                                <th>Print</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr
                                v-for="(medicine, index) in props.medicines"
                                :key="index"
                            >
                                <td width="5%">
                                    {{ index + 1 }}
                                </td>
                                <td class="fw-bold text-start px-3" width="30%">
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
                                <td class="fw-bold" width="15%">
                                    {{
                                        new Intl.NumberFormat("en-US", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        }).format(medicine.amount)
                                    }}
                                </td>
                                <td class="fw-bold" width="20%">
                                    {{ formatDate(medicine.created_at) }}
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
                                    <Link
                                        class="btn btn-sm btn-info me-2"
                                        title="Details"
                                    >
                                        <i class="bi bi-eye"></i>
                                        <!-- Details -->
                                    </Link>
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
