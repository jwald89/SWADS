<script setup>
import { defineComponent, onMounted, ref, watch } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import axios from "axios";
import { debounce } from "lodash";
import { Link, router, usePage } from "@inertiajs/vue3";
import Pagination from "../components/Pagination.vue";
import vSelect from "vue-select";
import { toast } from "vue3-toastify";

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
    municipalName: {
        type: Object,
        required: true,
    },
    months: {
        type: Object,
        required: true,
    },
});

const search = ref(props.search || "");

// Initialize intakeData with props.intake.data
//let intakeData = ref([]);

const selectedAssistance = ref({ id: "*", name: "All" });
const selectedMunicipal = ref({ id: "*", municipality: "All" });
const selectedMonth = ref({ id: "*", name: "All" });

const filterData = async () => {
    try {
        const assistanceId = selectedAssistance.value.id || "*";
        const municipalId = selectedMunicipal.value.id || "*";
        const monthId = selectedMonth.value.id || "*";

        const response = await axios.get(
            `/intake/filter/${assistanceId}/${municipalId}/${monthId}`
        );
        // console.log("API Response:", response.data);
        // intakeData.value = response.data.data;
        props.intake.data = response.data;
    } catch (error) {
        console.error("Error fetching filtered data:", error);
    }
};

// Watch for changes in intake prop to update intakeData
/**watch(
    () => props.intake.data,
    (newData) => {
        intakeData.value = newData || [];
    }
);*/

const getData = async () => {
    try {
        const response = await axios.get("/intake");
        // props.intake = response.data.data;
        props.value = response.data.data;
        // console.log("INTAKE DATA: ", props.intake);
    } catch (error) {
        console.error("Error submitting form:", error);
    }
};

onMounted(() => {
    //intakeData.value = props.intake.data || [];
    getData();
});

// Watch for changes in props.data and update filteredData accordingly
watch([selectedAssistance, selectedMunicipal, selectedMonth], () => {
    filterData();
});

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

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { year: "numeric", month: "short", day: "numeric" };
    let formattedDate = date.toLocaleDateString("en-US", options);

    return formattedDate.replace(/([a-zA-Z]{3})/, "$1.");
};

defineComponent({
    Pagination,
});

const page = usePage();

const hasAccess = (type) => {
    type = type.map((t) => t.toUpperCase());
    return type.includes(page.props.role_type);
};

const delData = async (id) => {
    try {
        alertify
            .confirm(
                "Are you sure you want to delete this record?",
                "<h5 class='text-danger fw-bold'>Warning!</h5><h5 class='fw-normal'>If you continue to delete this record, it will also delete the existing record in the monitoring module.</h5>",
                function () {
                    axios
                        .delete(`/api/intake/delete/${id}`, {
                            data: {
                                id: id,
                            },
                        })
                        .then((_) => {
                            toast.success(
                                "You have successfully deleted a record!",
                                {
                                    autoClose: 2000,
                                }
                            );
                            router.visit("/intake", {
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
        <!-- <span class="spinner-border spinner-border-sm me-2"></span> -->
        <div class="card">
            <div
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">Intake List</div>
                    <div class="col-lg-6 text-end">
                        <Link
                            :href="`/intake/create`"
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
                                    ...assistance.data,
                                ]"
                                v-model="selectedAssistance"
                                label="name"
                                placeholder="All"
                            ></v-select>
                        </div>
                        <div class="col-12 col-md-2 mb-2">
                            <label class="fw-bold" for="">Municipality</label>
                            <v-select
                                :options="[
                                    { id: '*', municipality: 'All' },
                                    ...municipalName.data,
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
                    <table class="table">
                        <thead class="text-center">
                            <tr class="bg-primary text-white">
                                <th>No.</th>
                                <th class="text-start px-3">Client</th>
                                <th class="text-start">Address</th>
                                <th class="text-start px-4">Assistance</th>
                                <th class="text-start px-4">Sector</th>
                                <th class="text-start">Date Intake</th>
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
                                <td class="text-start fw-bold px-3" width="20%">
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
                                            ? detail.middle_name
                                                  .substr(0, 1)
                                                  .toUpperCase() + ". "
                                            : ""
                                    }}
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
                                            .join(" ") +
                                        (detail.extn_name
                                            ? ", " + detail.extn_name
                                            : "")
                                    }}
                                    <div
                                        class="d-flex flex-column"
                                        style="font-size: 0.9rem"
                                    >
                                        <div class="d-flex align-items-center">
                                            <div class="text-secondary fw-bold">
                                                Sex:
                                                <span class="fw-normal ms-1">
                                                    {{
                                                        detail.sex
                                                            .charAt(0)
                                                            .toUpperCase() +
                                                        detail.sex.slice(1)
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex align-items-center"
                                            style="line-height: 0.9"
                                        >
                                            <div class="text-secondary fw-bold">
                                                Birthdate:
                                                <span class="fw-normal ms-1">
                                                    {{
                                                        formatDate(
                                                            detail.birthdate
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-start" width="20%">
                                    {{
                                        detail.purok
                                            ? "Prk. " +
                                              detail.purok
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
                                              ","
                                            : ""
                                    }}
                                    {{
                                        detail.street
                                            ? detail.street
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
                                                  .join(" ") + " St.,"
                                            : ""
                                    }}
                                    {{ detail.brgy.barangay }},
                                    {{ detail.municipal.municipality }}
                                </td>
                                <td class="text-start px-4" width="15%">
                                    {{ detail.assistance.name }}
                                </td>
                                <td class="text-start px-4" width="10%">
                                    {{ detail.sector_name.name }}
                                </td>
                                <td class="text-start text-primary">
                                    {{ formatDate(detail.date_intake) }}
                                    <div
                                        class="d-flex flex-column"
                                        style="font-size: 0.9rem"
                                    >
                                        <div class="d-flex align-items-center">
                                            <div class="text-secondary fw-bold">
                                                {{
                                                    formatDay(
                                                        detail.date_intake
                                                    )
                                                }}
                                                <span class="fw-normal ms-1">{{
                                                    formatTime(
                                                        detail.created_at
                                                    )
                                                }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td width="5%">
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
                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        v-if="
                                            hasAccess(['admin', 'supervisor'])
                                        "
                                        title="Delete"
                                        @click="delData(detail.id)"
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
                    <pagination :records="intake" :link="intake.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>

<style>
.alertify .ajs-header {
    background-color: #ff0000;
    color: #fff;
}

#nprogress .bar {
    background: #faae2b; /* Your desired color */
}
#nprogress .spinner-icon {
    border-top-color: #faae2b; /* Your desired spinner color */
    border-left-color: #faae2b; /* Your desired spinner color */
}
</style>
