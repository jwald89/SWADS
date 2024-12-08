<script setup>
import { defineComponent, ref, watch, reactive, onMounted } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import axios from "axios";
import { Link } from "@inertiajs/vue3";
import vSelect from "vue-select";
import { toast } from "vue3-toastify";

// Props from Inertia
const props = defineProps({
    intakeData: {
        type: Object,
        required: true,
    },
    sectors: {
        type: Object,
        required: true,
    },
    admins: {
        type: Object,
        required: true,
    },
    liaisons: {
        type: Object,
        required: true,
    },
    officeCharge: {
        type: Object,
        required: true,
    },
    status: {
        type: Object,
        required: true,
    },
    users: {
        type: Object,
    },
});

const claimant = ref(null);
const errors = reactive({});
const filteredMonitors = ref([]); // Clone initial options

// Monitor form reactive object
const monitorForm = reactive({
    id: "",
    claimant: "",
    beneficiary: "",
    sector: "",
    client_type: "",
    amount: "",
    staff_admin: "",
    liaison: "",
    status_date: "",
    remarks: "",
    charges: "",
    age: "",
    gender: "",
    contact_no: "",
    barangay: "",
    municipality: "",
    assistance_type: "",
    date_intake: "",
    status: "",
});

const resetForm = () => {
    // Clear all the fields by setting them to their initial empty values
    monitorForm.claimant = "";
    monitorForm.beneficiary = "";
    monitorForm.sector = "";
    monitorForm.client_type = "";
    monitorForm.age = "";
    monitorForm.amount = "";
    monitorForm.charges = "";
    monitorForm.liaison = "";
    monitorForm.status_date = "";
    monitorForm.remarks = "";
    monitorForm.age = "";
    monitorForm.gender = "";
    monitorForm.contact_no = "";
    monitorForm.barangay = "";
    monitorForm.municipality = "";
    monitorForm.assistance_type = "";
    monitorForm.date_intake = "";
    monitorForm.staff_admin = "";
    monitorForm.status = "";
};

// Fetch records from the Monitoring table to filter out existing claimants
const fetchMonitoringRecords = async () => {
    try {
        // Make an API call to get records from the Monitoring table
        const response = await axios.get("/api/monitoring-records");
        const savedRecords = response.data; // Records already saved in Monitoring table

        // Log saved records for debugging
        console.log("Existing Monitoring Records:", savedRecords);

        // Extract claimant IDs from savedRecords for easier comparison
        const savedClaimantIds = savedRecords.map((record) =>
            parseInt(record.claimant)
        );

        // Log claimant IDs for debugging
        console.log("Saved Claimant IDs:", savedClaimantIds);

        // Filter out IDs already present in Monitoring table from `intakeData`
        filteredMonitors.value = props.intakeData.data.filter(
            (monitor) => !savedClaimantIds.includes(monitor.id)
        );

        // Log the filtered list to verify results
        console.log("Filtered Monitors After Removal:", filteredMonitors.value);
    } catch (error) {
        console.error("Error fetching monitoring records:", error);
    }
};

const submitForm = async () => {
    if (monitorForm.claimant) {
        errors.claimant = "";
    }
    if (monitorForm.beneficiary) {
        errors.beneficiary = "";
    }
    if (monitorForm.sector) {
        errors.sector = "";
    }
    if (monitorForm.client_type) {
        errors.client_type = "";
    }
    if (monitorForm.amount) {
        errors.amount = "";
    }
    if (monitorForm.charges) {
        errors.charges = "";
    }
    if (monitorForm.contact_no) {
        errors.contact_no = "";
    }
    if (monitorForm.staff_admin) {
        errors.staff_admin = "";
    }
    if (monitorForm.liaison) {
        errors.liaison = "";
    }
    if (monitorForm.status) {
        errors.status = "";
    }

    try {
        const response = await axios.post(
            "/monitoring/create-post",
            monitorForm
        );

        toast.success("Successfully created.", {
            autoClose: 1000,
        });

        // Clear the form after saving
        resetForm();

        console.log("working..");
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0];
                }
            }
            toast.error("Please fill in the blanks error!", {
                autoClose: 2000,
            });
        }
        console.error("Error submitting form:", error);
    }
};

watch(claimant, function () {
    monitorForm.claimant = claimant.value.id;
    monitorForm.age = claimant.value.age;
    monitorForm.gender = claimant.value.gender;
    monitorForm.contact_no = claimant.value.contact_no;
    monitorForm.barangay = claimant.value.barangay;
    monitorForm.municipality = claimant.value.municipality;
    monitorForm.assistance_type = claimant.value.category;
    monitorForm.date_intake = claimant.value.date_intake;
});

onMounted(fetchMonitoringRecords);
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
                        <h5 class="fw-bold">Create Record</h5>
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
                <form class="row g-3 mt-3" @submit.prevent="submitForm">
                    <div class="col-md-6">
                        <label for="claimant"
                            >Claimant<span class="text-danger">*</span></label
                        >
                        <v-select
                            class="fw-bold"
                            name="claimant"
                            id="claimant"
                            v-model="claimant"
                            :options="filteredMonitors"
                            :reduce="(data) => data"
                            label="fullname"
                            :class="{
                                'form-control is-invalid': errors.claimant,
                            }"
                            placeholder="Select"
                        >
                            <v-option value="">Select</v-option>
                        </v-select>
                        <small v-if="errors.claimant" class="text-danger">{{
                            errors.claimant
                        }}</small>
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
                            v-model="monitorForm.beneficiary"
                            :class="{ 'is-invalid': errors.beneficiary }"
                            placeholder="Enter a name.."
                        />
                        <small v-if="errors.beneficiary" class="text-danger">{{
                            errors.beneficiary
                        }}</small>
                    </div>
                    <div class="col-md-2">
                        <label for="age"
                            >Age<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control fw-bold"
                            id="age"
                            name="age"
                            v-model="monitorForm.age"
                            disabled
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="gender"
                            >Gender<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control fw-bold"
                            name="gender"
                            id="gender"
                            v-model="monitorForm.gender"
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
                            v-model="monitorForm.contact_no"
                            :class="{ 'is-invalid': errors.contact_no }"
                            placeholder="Enter a phone or mobile number.."
                        />
                        <small v-if="errors.contact_no" class="text-danger">{{
                            errors.contact_no
                        }}</small>
                    </div>
                    <div class="col-md-5">
                        <label for="sector"
                            >Sector<span class="text-danger">*</span></label
                        >
                        <v-select
                            class="fw-bold"
                            name="sector"
                            id="sector"
                            :options="sectors.data"
                            :reduce="(data) => data.id"
                            label="name"
                            v-model="monitorForm.sector"
                            :class="{
                                'form-control is-invalid': errors.sector,
                            }"
                            placeholder="Select"
                        >
                        </v-select>
                        <small v-if="errors.sector" class="text-danger">{{
                            errors.sector
                        }}</small>
                    </div>

                    <div class="col-md-4">
                        <label for="municipal"
                            >Municipality<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control fw-bold"
                            name="municipal"
                            id="municipal"
                            v-model="monitorForm.municipality"
                            disabled
                        />
                    </div>

                    <div class="col-md-4">
                        <label for="barangay"
                            >Barangay<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control fw-bold"
                            name="barangay"
                            id="barangay"
                            v-model="monitorForm.barangay"
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
                            v-model="monitorForm.client_type"
                            :class="{ 'is-invalid': errors.client_type }"
                        >
                            <option value="" disabled>Select</option>
                            <option value="walk-in">Walk-in</option>
                            <option value="referred">Referred</option>
                            <option value="reach-out">Reach-out</option>
                        </select>
                        <small v-if="errors.client_type" class="text-danger">{{
                            errors.client_type
                        }}</small>
                    </div>
                    <div class="col-md-4">
                        <label for="assistanceType"
                            >Type of Assistance<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control fw-bold"
                            name="assistanceType"
                            id="assistanceType"
                            v-model="monitorForm.assistance_type"
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
                            v-model="monitorForm.amount"
                            :class="{ 'is-invalid': errors.amount }"
                        />
                        <small v-if="errors.amount" class="text-danger">{{
                            errors.amount
                        }}</small>
                    </div>
                    <div class="col-md-3">
                        <label for="charges"
                            >Charges<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="charges"
                            id="charges"
                            :options="officeCharge.data"
                            v-model="monitorForm.charges"
                            :reduce="(data) => data.description"
                            label="description"
                            :class="{
                                'form-control is-invalid': errors.charges,
                            }"
                            placeholder="Select"
                        ></v-select>

                        <small v-if="errors.charges" class="text-danger">{{
                            errors.charges
                        }}</small>
                    </div>
                    <div class="col-md-3">
                        <label for="intakeDate"
                            >Date of Intake<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control fw-bold"
                            id="intakeDate"
                            name="intakeDate"
                            v-model="monitorForm.date_intake"
                            disabled
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="staff"
                            >Staff Administered<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <v-select
                            name="staff"
                            id="staff"
                            :options="admins.data"
                            v-model="monitorForm.staff_admin"
                            :reduce="(data) => data.fullname"
                            label="fullname"
                            :class="{
                                'form-control is-invalid': errors.staff_admin,
                            }"
                            placeholder="Select"
                        >
                        </v-select>
                        <small v-if="errors.staff_admin" class="text-danger">{{
                            errors.staff_admin
                        }}</small>
                    </div>
                    <div class="col-md-4">
                        <label for="liaison"
                            >Liaison<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="liaison"
                            id="liaison"
                            :options="users.data"
                            v-model="monitorForm.liaison"
                            :reduce="(data) => data.id"
                            label="fullname"
                            :class="{
                                'form-control is-invalid': errors.liaison,
                            }"
                            placeholder="Select"
                        >
                        </v-select>
                        <small v-if="errors.liaison" class="text-danger">{{
                            errors.liaison
                        }}</small>
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
                            v-model="monitorForm.status_date"
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
                            v-model="monitorForm.remarks"
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
                            v-model="monitorForm.status"
                            :class="{ 'is-invalid': errors.status }"
                        >
                            <option value="" disabled>Select</option>
                            <option value="PSWDO">PSWDO</option>
                            <option value="PGO">PGO</option>
                            <option value="PBO">PBO</option>
                            <option value="PACCO">PACCO</option>
                            <option value="PTO">PTO</option>
                            <option value="CLAIMED">CLAIMED</option>
                        </select>
                        <small v-if="errors.status" class="text-danger">{{
                            errors.status
                        }}</small>
                    </div>
                    <div class="mt-4">
                        <button
                            type="submit"
                            class="btn btn-md btn-success float-end"
                        >
                            <i class="bi bi-save"></i>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
