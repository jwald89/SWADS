<script setup>
import LayoutApp from "/resources/js/Shared//Layout.vue";
import { defineComponent, ref } from "vue";
import vSelect from "vue-select";

const props = defineProps({
    monitorings: {
        type: Object,
        required: true,
    },
    assistanceType: Object,
    sectorType: Object,
    municipalities: Object,
    offCharges: Object,
});

const selectedAssistance = ref({ id: "*", name: "All" });
const selectedSector = ref({ id: "*", name: "All" });
const selectedMunicipal = ref({ id: "*", municipality: "All" });
const selectedOffice = ref({ id: "*", description: "All" });

const dateFrom = ref("");
const dateTo = ref("");

const generateReportUrl = () => {
    return `/summary-report/filter/${selectedAssistance.value.id}/${selectedSector.value.id}/${selectedMunicipal.value.id}/${selectedOffice.value.id}/${dateFrom.value}/${dateTo.value}`;
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
                Cash Assistance Report
            </div>

            <div class="card-body mt-3">
                <!-- Filter Card -->
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="fw-bold" for=""
                                    >Assistance Type</label
                                >
                                <v-select
                                    name="assistance"
                                    :options="[
                                        { id: '*', name: 'All' },
                                        ...assistanceType.data,
                                    ]"
                                    id="assistance"
                                    label="name"
                                    v-model="selectedAssistance"
                                ></v-select>
                            </div>
                            <div class="col-lg-3">
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
                            <div class="col-lg-3">
                                <label class="fw-bold" for=""
                                    >Office Charge</label
                                >
                                <v-select
                                    name="officeCharge"
                                    :options="[
                                        { id: '*', description: 'All' },
                                        ...offCharges.data,
                                    ]"
                                    id="officeCharge"
                                    label="description"
                                    v-model="selectedOffice"
                                ></v-select>
                            </div>
                            <div class="col-lg-3">
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

                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div class="form-group col-lg-5 ms-4">
                                <label class="fw-bold">Date - From</label>
                                <input
                                    type="date"
                                    class="form-control form-control-md"
                                    v-model="dateFrom"
                                />
                            </div>
                            <div class="form-group col-lg-5 me-4">
                                <label class="fw-bold ms-1">Date - To</label>
                                <input
                                    type="date"
                                    class="form-control form-control-md"
                                    v-model="dateTo"
                                />
                            </div>
                        </div>

                        <div class="mt-5 me-4">
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
