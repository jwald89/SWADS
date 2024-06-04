<script setup>
import { defineComponent, ref, watch } from "vue";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";
import axios from "axios";
import { Link } from "@inertiajs/vue3";
import vSelect from "vue-select";

const props = defineProps({
    dataMonitors: {
        type: Object,
        required: true,
    },
    sectors: {
        type: Object,
        required: true,
    },
});

const claimant = ref();

watch(claimant, function () {
    console.log(claimant.value);
});

defineComponent({
    Link,
    Navbar,
    Sidebar,
    vSelect,
});
</script>

<template>
    <Navbar />
    <Sidebar />
    <main class="main" id="main">
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
                {{ claimant }}
                <form class="row g-3 mt-3" action="">
                    <div class="col-md-6">
                        <label for="claimant"
                            >Claimant<span class="text-danger">*</span></label
                        >
                        <v-select
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
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="age"
                            >Age<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="age"
                            name="age"
                            disabled
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="gender"
                            >Gender<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="gender"
                            id="gender"
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
                            disabled
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="sector"
                            >Sector<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="sector"
                            id="sector"
                            :options="sectors.data"
                            label="name"
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
                            class="form-control"
                            name="municipal"
                            id="municipal"
                            disabled
                        />
                    </div>

                    <div class="col-md-4">
                        <label for="barangay"
                            >Barangay<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="barangay"
                            id="barangay"
                            disabled
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="clientType"
                            >Type of Client<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="clientType"
                            id="clientType"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="assistanceType"
                            >Type of Assistance<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="assistanceType"
                            id="assistanceType"
                            disabled
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
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="charges"
                            >Charges<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="charges"
                            name="charges"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="intakeDate"
                            >Date of Intake<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="date"
                            class="form-control"
                            id="intakeDate"
                            name="intakeDate"
                            disabled
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="staff"
                            >Staff Administered<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <select class="form-select" name="staff" id="staff">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="liaison"
                            >Liaison<span class="text-danger">*</span></label
                        >
                        <select class="form-select" name="liaison" id="staff">
                            <option value=""></option>
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
                        />
                    </div>
                    <div class="mt-4">
                        <button
                            type="button"
                            class="btn btn-md btn-success float-end"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</template>
