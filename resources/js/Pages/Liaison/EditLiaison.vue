<script setup>
import LayoutApp from "@/Shared/Layout.vue";
import { computed, defineProps, defineComponent } from "vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import vSelect from "vue-select";
import { toast } from "vue3-toastify";

const props = defineProps({
    monitoring: {
        type: Object,
        required: true,
    },
    offices: {
        type: Object,
        required: true,
    },
});

const submitData = async () => {
    try {
        const response = await axios.put(
            `/liaison/monitoring/update/${props.monitoring.id}`,
            props.monitoring
        );

        console.log("New record ID:", response.data.id);
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

const fullName = computed(() => {
    return `${props.monitoring.user.first_name} ${props.monitoring.user.last_name}`;
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
                        <h5 class="fw-bold">Update Record</h5>
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
                            class="form-control text-white bg-secondary"
                            name="claimant"
                            id="claimant"
                            v-model="monitoring.claimant"
                            readonly
                        />
                    </div>
                    <div class="col-md-6">
                        <label for="beneficiary">Beneficiary</label>
                        <input
                            type="text"
                            class="form-control text-white bg-secondary"
                            name="beneficiary"
                            id="beneficiary"
                            v-model="monitoring.beneficiary"
                            readonly
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="age">Age</label>
                        <input
                            type="text"
                            class="form-control text-white bg-secondary"
                            id="age"
                            name="age"
                            v-model="monitoring.age"
                            readonly
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="gender">Gender</label>
                        <input
                            type="text"
                            class="form-control text-white bg-secondary"
                            name="gender"
                            id="gender"
                            v-model="monitoring.sex"
                            readonly
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="contactNo">Contact No.</label>
                        <input
                            class="form-control text-white bg-secondary"
                            name="contactNo"
                            id="contactNo"
                            v-model="monitoring.contact_no"
                            readonly
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="sector">Sector</label>
                        <input
                            class="form-control text-white bg-secondary"
                            name="sector"
                            id="sector"
                            v-model="monitoring.sector"
                            readonly
                        />
                    </div>

                    <div class="col-md-4">
                        <label for="municipal">Municipality</label>
                        <input
                            type="text"
                            class="form-control text-white bg-secondary"
                            name="municipal"
                            id="municipal"
                            v-model="monitoring.municipality"
                            readonly
                        />
                    </div>

                    <div class="col-md-4">
                        <label for="barangay">Barangay</label>
                        <input
                            type="text"
                            class="form-control text-white bg-secondary"
                            name="barangay"
                            id="barangay"
                            v-model="monitoring.barangay"
                            readonly
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="clientType">Type of Client</label>
                        <input
                            type="text"
                            class="form-control text-white bg-secondary"
                            name="clientType"
                            id="clientType"
                            v-model="monitoring.client_type"
                            readonly
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="assistanceType">Type of Assistance</label>
                        <input
                            type="text"
                            class="form-control text-white bg-secondary"
                            name="assistanceType"
                            id="assistanceType"
                            v-model="monitoring.assistance_type"
                            readonly
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="amount">Amount</label>
                        <input
                            type="text"
                            class="form-control text-white bg-secondary"
                            id="amount"
                            name="amount"
                            v-model="monitoring.amount"
                            readonly
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="charges">Charges</label>
                        <input
                            type="text"
                            class="form-control text-white bg-secondary"
                            id="charges"
                            name="charges"
                            v-model="monitoring.charges"
                            readonly
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="intakeDate">Date of Intake</label>
                        <input
                            type="text"
                            class="form-control text-white bg-secondary"
                            id="intakeDate"
                            name="intakeDate"
                            v-model="monitoring.date_intake"
                            readonly
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="staff">Staff Administered</label>
                        <input
                            name="staff"
                            class="form-control text-white bg-secondary"
                            id="staff"
                            label="fullname"
                            v-model="monitoring.staff_admin"
                            readonly
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="liaison">Liaison</label>
                        <input
                            name="liaison"
                            class="form-control text-white bg-secondary"
                            id="liaison"
                            label="fullname"
                            v-model="fullName"
                            readonly
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="dateStatus">Status Date</label>
                        <input
                            type="date"
                            class="form-control text-white bg-secondary"
                            id="dateStatus"
                            name="dateStatus"
                            v-model="monitoring.status_date"
                            readonly
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
                            v-model="monitoring.remarks"
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
                            v-model="monitoring.status"
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
