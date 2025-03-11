<script setup>
import { defineComponent, watch, ref } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../components/Pagination.vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import vSelect from "vue-select";

const props = defineProps({
    monitorings: {
        type: Object,
        requried: true,
    },
    search: {
        type: String,
        default: "",
    },
    assistanceType: {
        type: Object,
        required: true,
    },
    sectorType: {
        type: Object,
        required: true,
    },
    municipalityName: {
        type: Object,
        required: true,
    },
});

const selectedAssistance = ref({ id: "*", name: "All" });
const selectedSector = ref({ id: "*", name: "All" });
const selectedMunicipal = ref({ id: "*", municipality: "All" });
const selectedMonth = ref({ id: "*", name: "All" });

const filterData = async () => {
    try {
        const assistanceId = selectedAssistance.value.id || "*";
        const sectorId = selectedSector.value.id || "*";
        const municipalId = selectedMunicipal.value.id || "*";
        const month = selectedMonth.value.id || "*";

        const response = await axios.get(
            `/monitoring/filter/${assistanceId}/${sectorId}/${municipalId}/${month}`
        );

        props.monitorings.data = response.data;
    } catch (error) {
        console.error("Error fetching filtered data:", error);
    }
};

// Watch for changes in props.data and update filteredData accordingly
watch(
    [selectedAssistance, selectedSector, selectedMunicipal, selectedMonth],
    () => {
        filterData();
    }
);

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

const delData = async (id) => {
    try {
        alertify
            .confirm(
                "Delete Record",
                "Are you sure you want to delete this record?",
                function () {
                    axios
                        .delete(`/api/monitoring/delete/${id}`, {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem(
                                    "token"
                                )}`,
                            },
                            data: {
                                id: id,
                            },
                        })
                        .then((_) => {
                            toast.success(
                                "You have successfully delete a record!",
                                {
                                    autoClose: 2000,
                                }
                            );
                            router.visit("/monitoring", {
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
            )
            .set("labels", { ok: "Yes" });
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
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">Monitoring List</div>
                    <div
                        class="col-lg-6 text-end"
                        v-if="hasAccess(['admin', 'user'])"
                    >
                        <Link
                            :href="`/monitoring/create`"
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
                            <v-select
                                :options="[
                                    { id: '*', name: 'All' },
                                    ...assistanceType.data,
                                ]"
                                v-model="selectedAssistance"
                                label="name"
                                placeholder="All"
                            ></v-select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="fw-bold" for="">Sector</label>
                            <v-select
                                :options="[
                                    { id: '*', name: 'All' },
                                    ...sectorType.data,
                                ]"
                                v-model="selectedSector"
                                label="name"
                                placeholder="All"
                            ></v-select>
                        </div>
                        <div class="col-12 col-md-2 mb-2">
                            <label class="fw-bold" for="">Municipality</label>
                            <v-select
                                :options="[
                                    { id: '*', municipality: 'All' },
                                    ...municipalityName.data,
                                ]"
                                v-model="selectedMunicipal"
                                label="municipality"
                                placeholder="All"
                            ></v-select>
                        </div>
                        <div class="col-12 col-md-2 mb-2">
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
                    <div class="col-md-2">
                        <label class="fw-bold" for=""
                            >Search by claimant
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
                                <th>Assistance Type</th>
                                <th>Claimant</th>
                                <th>Date Intake</th>
                                <th>Sector</th>
                                <th>Municipality</th>
                                <th>Office Charge</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            v-if="monitorings.data.length"
                            class="text-center"
                        >
                            <tr
                                v-for="(monitoring, index) in monitorings.data"
                                :key="index"
                                :class="{
                                    'bg-claimed':
                                        monitoring.status === 'CLAIMED',
                                }"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ monitoring.assistance.name }}</td>
                                <td>
                                    {{
                                        monitoring.intake.first_name
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
                                        monitoring.intake.middle_name === null
                                            ? ""
                                            : monitoring.intake.middle_name
                                                  .substr(0, 1)
                                                  .toUpperCase() + "."
                                    }}
                                    {{
                                        monitoring.intake.last_name
                                            .split(" ")
                                            .map(
                                                (word) =>
                                                    word
                                                        .charAt(0)
                                                        .toUpperCase() +
                                                    word.slice(1).toLowerCase()
                                            )
                                            .join(" ") +
                                        (monitoring.intake.extn_name
                                            ? ", " + monitoring.intake.extn_name
                                            : "")
                                    }}
                                </td>
                                <td>
                                    {{ formatDate(monitoring.date_intake) }}
                                </td>
                                <td>{{ monitoring.sector_name.name }}</td>
                                <td>{{ monitoring.municipal.municipality }}</td>
                                <td>
                                    {{ monitoring.charging_office.description }}
                                </td>
                                <td class="text-primary">
                                    {{
                                        new Intl.NumberFormat("en-US", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        }).format(monitoring.amount)
                                    }}
                                </td>
                                <td
                                    v-if="monitoring.status == 'PSWDO'"
                                    class="bg-pswdo text-light fw-bold"
                                >
                                    {{ monitoring.status }}
                                </td>
                                <td
                                    v-if="monitoring.status == 'PGO'"
                                    class="bg-pgo text-light fw-bold"
                                >
                                    {{ monitoring.status }}
                                </td>
                                <td
                                    v-if="monitoring.status == 'PBO'"
                                    class="bg-pbo text-dark fw-bold"
                                >
                                    {{ monitoring.status }}
                                </td>
                                <td
                                    v-if="monitoring.status == 'PACCO'"
                                    class="bg-pacco text-dark fw-bold"
                                >
                                    {{ monitoring.status }}
                                </td>
                                <td
                                    v-if="monitoring.status == 'PTO'"
                                    class="bg-pto text-light fw-bold"
                                >
                                    {{ monitoring.status }}
                                </td>
                                <td
                                    v-if="monitoring.status == 'CLAIMED'"
                                    class="fw-bold"
                                >
                                    {{ monitoring.status }}
                                </td>
                                <td>
                                    <!-- For ADMIN and USER role button -->
                                    <Link
                                        :href="`/monitoring/edit/${monitoring.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['admin', 'user'])"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </Link>
                                    <!-- For LIAISON role button -->
                                    <Link
                                        :href="`/liaison/monitoring/edit/${monitoring.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['liaison'])"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Update -->
                                    </Link>
                                    <!-- For ADMIN and USER role button -->
                                    <Link
                                        :href="`/monitoring/show/${monitoring.id}`"
                                        class="btn btn-sm btn-info me-2"
                                        v-if="
                                            hasAccess([
                                                'admin',
                                                'user',
                                                'liaison',
                                            ])
                                        "
                                        title="Details"
                                    >
                                        <i class="bi bi-eye"></i>
                                        <!-- Details -->
                                    </Link>
                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        v-if="hasAccess(['admin', 'user'])"
                                        title="Delete"
                                        @click="delData(monitoring.id)"
                                    >
                                        <i class="bi bi-trash"></i>
                                        <!-- Delete -->
                                    </button>
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
                        :records="monitorings"
                        :link="monitorings.path"
                    />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>

<style scoped>
.bg-claimed {
    background: #a7ff83;
}

.bg-pswdo {
    background: #c300ff;
}

.bg-pbo {
    background: #f5eded;
}

.bg-pto {
    background: #ff6200;
}

.bg-pacco {
    background: #ffbe0a;
}

.bg-pgo {
    background: #2f89fc;
}
</style>
