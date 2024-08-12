<script setup>
import { defineComponent, ref, watch, reactive } from "vue";
import LayoutApp from "../Shared/Layout.vue";
// import Navbar from "@/components/Navbar.vue";
// import Sidebar from "@/components/Sidebar.vue";
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
    admins: {
        type: Object,
        required: true,
    },
});

const claimant = ref();
const age = ref();
const gender = ref();
const contactNo = ref();
const barangay = ref();
const municipality = ref();
const assistance_type = ref();
const dateIntake = ref();

const monitorForm = reactive({
    beneficiary: "",
    sector: "",
    client_type: "",
    amount: "",
    charges: "",
    staff_admin: "",
    liaison: "",
    status_date: "",
    remarks: "",
    status: "",
    claimant: "",
    age: "",
    gender: "",
    contact_no: "",
    barangay: "",
    municipality: "",
    assistance_type: "",
    date_intake: "",
});

const submitForm = async () => {
    try {
        const response = await axios.post(
            "/monitoring/create-post",
            monitorForm
        );

        toast.success("Successfully updated.", {
            autoClose: 1000,
        });

        console.log("working..");
    } catch (error) {
        toast.error("Please fill in the blanks!", {
            autoClose: 2000,
        });
        console.error("Error submitting form:", error);
    }
};

watch(claimant, function () {
    monitorForm.claimant = claimant.value.fullname;
    monitorForm.age = claimant.value.age;
    monitorForm.gender = claimant.value.gender;
    monitorForm.contact_no = claimant.value.contact_no;
    monitorForm.barangay = claimant.value.barangay;
    monitorForm.municipality = claimant.value.municipality;
    monitorForm.assistance_type = claimant.value.category;
    monitorForm.date_intake = claimant.value.date_intake;
});

defineComponent({
    Link,
    LayoutApp,
    // Navbar,
    // Sidebar,
    vSelect,
});
</script>

<template>
    <!-- <Navbar />
    <Sidebar />
    <main class="main" id="main"> -->
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
                            href="/monitoring"
                            >Back</Link
                        >
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
                            :options="dataMonitors.data"
                            :reduce="(data) => data"
                            label="fullname"
                        >
                        </v-select>
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
                        />
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
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="contactNo"
                            >Contact No.<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            class="form-control fw-bold"
                            name="contactNo"
                            id="contactNo"
                            v-model="monitorForm.contact_no"
                        />
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
                            :reduce="(data) => data.name"
                            label="name"
                            v-model="monitorForm.sector"
                        >
                        </v-select>
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
                        >
                            <option value="walk-in">Walk-in</option>
                            <option value="referred">Referred</option>
                            <option value="reach-out">Reach-out</option>
                        </select>
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
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="amount"
                            >Amount<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="amount"
                            name="amount"
                            v-model="monitorForm.amount"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="charges"
                            >Charges<span class="text-danger">*</span></label
                        >
                        <select
                            type="text"
                            class="form-control"
                            id="charges"
                            name="charges"
                            v-model="monitorForm.charges"
                        >
                            <option value="PGO">PGO</option>
                            <option value="PVGO">PVGO</option>
                            <option value="SB">SB</option>
                            <option value="SP">SP</option>
                            <option value="CWS">CWS</option>
                            <option value="PSWDO">PSWDO</option>
                            <option value="PSWDO (Distaster)">
                                PSWDO (Disaster)
                            </option>
                            <option value="PSWDO (Senior Citizen)">
                                PSWDO (Senior Citizen)
                            </option>
                            <option value="PSWDO (PWD)">PSWDO (PWD)</option>
                            <option value="PSWDO (Children)">
                                PSWDO (Children)
                            </option>
                            <option value="PSWDO (GAD)">PSWDO (GAD)</option>
                            <option value="PSWDO (E-CLIP)">
                                PSWDO (E-CLIP)
                            </option>
                            <option value="PSWDO (Mentally ill)">
                                PSWDO (Mentally ill)
                            </option>
                        </select>
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
                        >
                        </v-select>
                    </div>
                    <div class="col-md-4">
                        <label for="liaison"
                            >Liaison<span class="text-danger">*</span></label
                        >
                        <select
                            class="form-select"
                            name="liaison"
                            id="staff"
                            v-model="monitorForm.liaison"
                        >
                            <option value="Shiela Ann G. Laurente">
                                Shiela Ann G. Laurente
                            </option>
                            <option value="Haide Pangilinan">
                                Haide Pangilinan
                            </option>
                            <option value="Mary Jane Umali">
                                Mary Jane Umali
                            </option>
                            <option value="C/O PGO">C/O PGO</option>
                            <option value="C/O PVGO">C/O PVGO</option>
                        </select>
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
                        <input
                            type="text"
                            class="form-control"
                            id="status"
                            name="status"
                            v-model="monitorForm.status"
                        />
                    </div>
                    <div class="mt-4">
                        <button
                            type="submit"
                            class="btn btn-md btn-success float-end"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- </main> -->
    </LayoutApp>
</template>
