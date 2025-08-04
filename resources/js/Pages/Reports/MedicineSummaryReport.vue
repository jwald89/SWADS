<script setup>
import LayoutApp from "/resources/js/Shared//Layout.vue";
import { defineComponent, ref } from "vue";
import vSelect from "vue-select";

const props = defineProps({
    medicines: {
        type: Object,
        required: true,
    },
    sectorType: Object,
    municipalities: Object,
    classType: Object,
});

const selectedSector = ref({ id: "*", name: "All" });
const selectedMunicipal = ref({ id: "*", municipality: "All" });
const selectedClassification = ref({ id: "*", name: "All" });

const dateFrom = ref("");
const dateTo = ref("");

const generateReportUrl = () => {
    return `/medicine-summary-report/filter/${selectedSector.value.id}/${selectedMunicipal.value.id}/${selectedClassification.value.id}/${dateFrom.value}/${dateTo.value}`;
};

defineComponent({
    vSelect,
});
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                Medicine Report
            </div>

            <div class="card-body mt-3">
                <!-- Filter Card -->
                <h6 class="mt-2">
                    <i class="bi bi-filter-circle-fill"></i> Filter Section
                </h6>
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label class="fw-bold" for="">Sector</label>
                                <v-select
                                    name="sector"
                                    :options="[
                                        { id: '*', name: 'All' },
                                        ...sectorType.data,
                                    ]"
                                    id="sector"
                                    label="name"
                                    v-model="selectedSector"
                                ></v-select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="fw-bold" for=""
                                    >Municipality</label
                                >
                                <v-select
                                    name="municipal"
                                    :options="[
                                        { id: '*', municipality: 'All' },
                                        ...municipalities.data,
                                    ]"
                                    id="municipal"
                                    label="municipality"
                                    v-model="selectedMunicipal"
                                ></v-select>
                            </div>
                            <div class="col-md-3">
                                <label class="fw-bold" for=""
                                    >Classification</label
                                >
                                <v-select
                                    name="classType"
                                    :options="[
                                        { id: '*', name: 'All' },
                                        ...classType.data,
                                    ]"
                                    id="classType"
                                    label="name"
                                    v-model="selectedClassification"
                                ></v-select>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="alert alert-danger d-flex align-items-center d-none"
                    role="alert"
                >
                    <i class="fa-solid fa-circle-info"></i>&nbsp; Please select
                    the date.
                </div>

                <h6 class="mt-2">
                    <i class="bi bi-calendar2-range-fill"></i> Date Section
                </h6>
                <div class="card">
                    <div class="card-body p-4">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between"
                        >
                            <div class="col-12 col-md-5 mb-2">
                                <label class="fw-bold">Date - From</label>
                                <input
                                    type="date"
                                    class="form-control form-control-md"
                                    v-model="dateFrom"
                                />
                            </div>
                            <div class="col-12 col-md-5">
                                <label class="fw-bold ms-1">Date - To</label>
                                <input
                                    type="date"
                                    class="form-control form-control-md"
                                    v-model="dateTo"
                                />
                            </div>
                        </div>

                        <div class="mt-5">
                            <a
                                :href="generateReportUrl()"
                                class="btn btn-md btn-primary float-end"
                                target="_blank"
                            >
                                <i class="bi bi-list-nested"></i>
                                Generate Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
