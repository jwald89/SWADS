<script setup>
import LayoutApp from "../Shared/Layout.vue";
import {
    defineComponent,
    ref,
    watch,
    reactive,
    onMounted,
    computed,
} from "vue";
import axios from "axios";
import { Link } from "@inertiajs/vue3";
import vSelect from "vue-select";
import { toast } from "vue3-toastify";

const props = defineProps({
    dataMonitors: {
        type: Object,
        required: true,
    },
});

const fullName = computed(() => {
    return `${props.dataMonitors.user.first_name} ${props.dataMonitors.user.last_name}`;
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
                            >Back</Link
                        >
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label for="claimant">Claimant</label>
                        <input
                            class="form-control"
                            name="claimant"
                            id="claimant"
                            v-model="dataMonitors.claimant"
                            readonly
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
                            readonly
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
                            readonly
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
                            readonly
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
                            readonly
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
                            v-model="dataMonitors.assistance_type"
                            readonly
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
                        <select
                            type="text"
                            class="form-control"
                            id="charges"
                            name="charges"
                            v-model="dataMonitors.charges"
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
                        <label for="intakeDate">Date of Intake</label>
                        <input
                            type="text"
                            class="form-control"
                            id="intakeDate"
                            name="intakeDate"
                            v-model="dataMonitors.date_intake"
                            readonly
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
                            v-model="dataMonitors.staff_admin"
                            label="fullname"
                        >
                        </v-select>
                    </div>
                    <div class="col-md-4">
                        <label for="liaison"
                            >Liaison<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="liaison"
                            id="liaison"
                            v-model="fullName"
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
                        <v-select
                            name="offices"
                            id="offices"
                            v-model="dataMonitors.status"
                            label="acronym"
                        >
                        </v-select>
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
    </LayoutApp>
</template>
