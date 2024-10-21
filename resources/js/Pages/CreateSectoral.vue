<script setup>
import { defineComponent, ref, watch, reactive, onMounted } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import axios from "axios";
import { Link } from "@inertiajs/vue3";
import vSelect from "vue-select";
import { toast } from "vue3-toastify";

defineProps({
    assistances: {
        type: Object,
        required: true,
    },
    municipality: {
        type: Object,
        required: true,
    },
    barangays: {
        type: Object,
        required: true,
    },
    civilStatus: {
        type: Object,
        required: true,
    },
    gender: {
        type: Object,
        required: true,
    },
    errors: Object,
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
                        <h5 class="fw-bold">Create Sectoral Data</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            href="/sectoral-data"
                            >Back</Link
                        >
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label for="firstname"
                            >Firstname<span class="text-danger">*</span></label
                        >
                        <input
                            class="form-control"
                            name="firstname"
                            id="firstname"
                            label="firstname"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="beneficiary"
                            >Middlename<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="middlename"
                            id="middlename"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="age"
                            >Lastname<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="lastname"
                            name="lastname"
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="gender"
                            >Age<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="age"
                            id="age"
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
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="contactNo"
                            >Nationality<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            class="form-control"
                            name="nationality"
                            id="nationality"
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="sector"
                            >Religion<span class="text-danger">*</span></label
                        >
                        <v-select class="" name="religion" id="religion">
                        </v-select>
                    </div>
                    <div class="col-md-3">
                        <label for="sector"
                            >Ethnicity<span class="text-danger">*</span></label
                        >
                        <v-select class="" name="ethnicity" id="ethnicity">
                        </v-select>
                    </div>

                    <div class="col-md-3">
                        <label for="purok"
                            >Purok<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="purok"
                            id="purok"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="barangay"
                            >Barangay<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="barangay"
                            id="barangay"
                            label="barangay"
                        >
                        </v-select>
                    </div>
                    <div class="col-md-3">
                        <label for="municipal"
                            >Municipality<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <v-select
                            name="municipal"
                            id="municipal"
                            label="municipal"
                        >
                        </v-select>
                    </div>
                    <div class="col-md-3">
                        <label for="dateStatus"
                            >Birthdate<span class="text-danger">*</span></label
                        >
                        <input
                            type="date"
                            class="form-control"
                            id="birthdate"
                            name="birthdate"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="municipal"
                            >Place of Birth<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="placeBirth"
                            id="placeBirth"
                        />
                    </div>

                    <div class="col-md-3">
                        <label for="civilStatus"
                            >Civil Status<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <select
                            class="form-select"
                            id="civil_status"
                            name="civil_status"
                        >
                            <option v-for="civil in civilStatus" :key="civil">
                                {{ civil }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="physical"
                            >Physical Disability<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="physical"
                            name="physical"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="charges"
                            >Contact No.<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="contactNo"
                            name="contactNo"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="fbAcct"
                            >Facebook Account<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="fbAcct"
                            name="fbAcct"
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="schoolLastAttend"
                            >School Last Attended<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="schoolLastAttend"
                            name="schoolLastAttend"
                        />
                    </div>

                    <div class="col-md-3">
                        <label for="month"
                            >Month and Year<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="date"
                            class="form-control"
                            id="month"
                            name="month"
                        />
                    </div>

                    <div class="col-md-4">
                        <label for="skills"
                            >Skills<span class="text-danger">*</span></label
                        >
                        <v-select name="skills" id="skills"> </v-select>
                    </div>
                    <div class="col-md-4">
                        <label for="interest"
                            >Interest/Hobbies<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <v-select name="interest" id="interest"> </v-select>
                    </div>

                    <div class="col-md-4">
                        <label for="workExp"
                            >Work Experience<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="workExp"
                            name="workExp"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="orgMembers"
                            >Members of Organizations<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="orgMembers"
                            name="orgMembers"
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="famMembers"
                            >Number of Family Members<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="famMembers"
                            name="famMembers"
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="isyOsy"
                            >ISY/OSY<span class="text-danger">*</span></label
                        >
                        <select
                            type="text"
                            class="form-control"
                            id="isyOsy"
                            name="isyOsy"
                        >
                            <option value="N/A">--- Select ---</option>
                            <option value="isy">ISY</option>
                            <option value="osy">OSY</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="position"
                            >Position<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="position"
                            name="position"
                        />
                    </div>
                    <div class="col-md-3">
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
