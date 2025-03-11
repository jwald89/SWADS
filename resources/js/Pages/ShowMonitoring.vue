<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    monitorings: {
        type: Object,
    },
    createdBy: {
        type: String,
    },
    modifiedBy: {
        type: String,
    },
    staffAdmin: {
        type: String,
    },
});

const formatDate = (dateString) => {
    const options = { year: "numeric", month: "short", day: "numeric" };
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", options).replace(".", ",");
};

const formatName = (fName) => {
    return fName
        .split(" ")
        .map(
            (word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        )
        .join(" ");
};
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Details</h5>
                    </div>
                    <div class="col-lg-6 text-end">
                        <Link
                            class="btn btn-sm btn-light"
                            :href="`/monitoring`"
                        >
                            <i class="bi bi-backspace"></i>
                            Back
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="row col-12 col-md-6">
                        <div class="mt-3 mb-4">
                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Claimant:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{
                                        formatName(
                                            monitorings.intake.first_name
                                        )
                                    }}
                                    {{
                                        monitorings.intake.middle_name === null
                                            ? ""
                                            : monitorings.intake.middle_name
                                                  .substr(0, 1)
                                                  .toUpperCase() + "."
                                    }}
                                    {{ formatName(monitorings.intake.last_name)
                                    }}{{
                                        monitorings.intake.extn_name === null
                                            ? ""
                                            : ", " +
                                              monitorings.intake.extn_name
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Age:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ monitorings.age }} years old
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Sex:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ formatName(monitorings.sex) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Contact No.:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ monitorings.contact_no }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Barangay:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ monitorings.brgy.barangay }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Municipality:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ monitorings.municipal.municipality }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Created By:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ createdBy }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Modified By:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ modifiedBy }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Modified Date:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{
                                        monitorings.modified_date === null
                                            ? ""
                                            : formatDate(
                                                  monitorings.modified_date
                                              )
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-12 col-md-6">
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Date Intake:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ formatDate(monitorings.date_intake) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Beneficiary:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ formatName(monitorings.beneficiary) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Sector Type:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ monitorings.sector_name.name }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Type of Assistance:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ monitorings.assistance.name }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Client Type:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ formatName(monitorings.client_type) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Amount:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ monitorings.amount }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Charges:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{
                                        monitorings.charging_office.description
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Staff Administered:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ staffAdmin }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Liaison:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{
                                        formatName(monitorings.user.first_name)
                                    }}
                                    {{
                                        monitorings.user.middle_init !== null
                                            ? monitorings.user.middle_init
                                                  .substr(0, 1)
                                                  .toUpperCase() + "."
                                            : ""
                                    }}
                                    {{ formatName(monitorings.user.last_name) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Status Date:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ formatDate(monitorings.status_date) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Remarks:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{
                                        monitorings.remarks === null
                                            ? ""
                                            : formatName(monitorings.remarks)
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 label fw-bold">
                                    Status:
                                </div>
                                <div class="col-6 col-md-9">
                                    {{ monitorings.status }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
