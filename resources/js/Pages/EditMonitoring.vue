<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent, watchEffect, computed } from "vue";
import axios from "axios";
import { Link } from "@inertiajs/vue3";
import vSelect from "vue-select";
import { toast } from "vue3-toastify";

const props = defineProps({
    dataMonitors: {
        type: Object,
        required: true,
    },
    sectors: {
        type: Object,
        required: true,
    },
    officeCharge: {
        type: Object,
        required: true,
    },
    users: {
        type: Object,
        required: true,
    },
    staffAdmin: {
        type: String,
    },
});

const submitData = async () => {
    try {
        const response = await axios.put(
            `/monitoring/update/${props.dataMonitors.id}`,
            props.dataMonitors
        );

        toast.success("Record successfully updated.", {
            autoClose: 1000,
        });
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0]; // Capture the first error message for each field
                }
            }

            const errorMsg = error.response.data.error;
            if (errorMsg) {
                toast.error(errorMsg, {
                    autoClose: 10000,
                });
            } else {
                toast.error("Please fill in the blanks error!", {
                    autoClose: 2000,
                });
            }
        }

        console.error("Error submitting form:", error);
    }
};

const claimantName = computed(() => {
    return `${props.dataMonitors.intake.first_name
        .split(" ")
        .map(
            (word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        )
        .join(" ")} ${props.dataMonitors.intake.middle_name
        .charAt(0)
        .toUpperCase()}. ${props.dataMonitors.intake.last_name
        .split(" ")
        .map(
            (word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        )
        .join(" ")}`;
});

watchEffect(() => {
    props.dataMonitors.liaison = parseInt(props.dataMonitors.liaison);
    props.dataMonitors.sector = parseInt(props.dataMonitors.sector);
});

defineComponent({
    vSelect,
});
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-space-around">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Edit Record</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            :href="`/monitoring`"
                        >
                            <i class="bi bi-backspace"></i>
                            Back
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="row g-3 mt-3" @submit.prevent="submitData">
                    <div class="col-md-6">
                        <label for="claimant">Claimant</label>
                        <input
                            class="form-control"
                            name="claimant"
                            id="claimant"
                            v-model="claimantName"
                            disabled
                        />
                    </div>
                    <div class="col-md-6">
                        <label for="beneficiary"
                            >Beneficiary<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="beneficiary"
                            id="beneficiary"
                            v-model="dataMonitors.beneficiary"
                            disabled
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="age">Age</label>
                        <input
                            type="text"
                            class="form-control"
                            id="age"
                            name="age"
                            v-model="dataMonitors.age"
                            disabled
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="gender">Gender</label>
                        <input
                            type="text"
                            class="form-control"
                            name="gender"
                            id="gender"
                            v-model="dataMonitors.sex"
                            disabled
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="contactNo"
                            >Contact No.<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            class="form-control"
                            name="contactNo"
                            id="contactNo"
                            v-model="dataMonitors.contact_no"
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="sector"
                            >Sector<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="sector"
                            :options="sectors.data"
                            :reduce="(data) => data.id"
                            id="sector"
                            label="name"
                            v-model="dataMonitors.sector"
                        >
                        </v-select>
                    </div>

                    <div class="col-md-4">
                        <label for="municipal">Municipality</label>
                        <input
                            type="text"
                            class="form-control"
                            name="municipal"
                            id="municipal"
                            v-model="dataMonitors.municipality"
                            disabled
                        />
                    </div>

                    <div class="col-md-4">
                        <label for="barangay">Barangay</label>
                        <input
                            type="text"
                            class="form-control"
                            name="barangay"
                            id="barangay"
                            v-model="dataMonitors.barangay"
                            disabled
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="clientType"
                            >Type of Client<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <select
                            type="text"
                            class="form-select"
                            name="clientType"
                            id="clientType"
                            v-model="dataMonitors.client_type"
                        >
                            <option value="walk-in">Walk-in</option>
                            <option value="referred">Referred</option>
                            <option value="reach-out">Reach-out</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="assistanceType">Type of Assistance</label>
                        <input
                            type="text"
                            class="form-control"
                            name="assistanceType"
                            id="assistanceType"
                            v-model="dataMonitors.assistance.name"
                            disabled
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="amount"
                            >Amount<span class="text-danger">*</span></label
                        >
                        <input
                            type="number"
                            class="form-control"
                            id="amount"
                            name="amount"
                            v-model="dataMonitors.amount"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="charges"
                            >Charges<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="officeCharge"
                            :options="officeCharge.data"
                            :reduce="(data) => data.description"
                            id="officeCharge"
                            v-model="dataMonitors.charges"
                            label="description"
                        ></v-select>
                    </div>
                    <div class="col-md-3">
                        <label for="intakeDate">Date of Intake</label>
                        <input
                            type="text"
                            class="form-control"
                            id="intakeDate"
                            name="intakeDate"
                            v-model="dataMonitors.date_intake"
                            disabled
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="staff_admin"
                            >Staff Administered<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="staff_admin"
                            name="staff_admin"
                            v-model="props.staffAdmin"
                            disabled
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="liaison"
                            >Liaison<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="liaison"
                            :options="users.data"
                            :reduce="(data) => data.id"
                            id="liaison"
                            v-model="dataMonitors.liaison"
                            label="fullname"
                        >
                        </v-select>
                    </div>
                    <div class="col-md-3">
                        <label for="dateStatus"
                            >Status Date<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="date"
                            class="form-control"
                            id="dateStatus"
                            name="dateStatus"
                            v-model="dataMonitors.status_date"
                        />
                    </div>
                    <div class="col-md-8">
                        <label for="dateStatus"
                            >Remarks<span class="text-danger">*</span></label
                        >
                        <textarea
                            type="date"
                            class="form-control"
                            id="remarks"
                            name="remarks"
                            rows="1"
                            v-model="dataMonitors.remarks"
                        >
                        </textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="status"
                            >Status<span class="text-danger">*</span></label
                        >
                        <select
                            type="text"
                            class="form-control"
                            id="status"
                            name="status"
                            v-model="dataMonitors.status"
                        >
                            <option value="PSWDO">PSWDO</option>
                            <option value="PGO">PGO</option>
                            <option value="PBO">PBO</option>
                            <option value="PACCO">PACCO</option>
                            <option value="PTO">PTO</option>
                            <option value="CLAIMED">CLAIMED</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <button
                            type="submit"
                            class="btn btn-md btn-success float-end"
                        >
                            <i class="bi bi-save"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
