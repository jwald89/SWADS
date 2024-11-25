<script setup>
import { defineComponent, reactive } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import axios from "axios";
import { Link } from "@inertiajs/vue3";
import vSelect from "vue-select";
import { toast } from "vue3-toastify";

defineProps({
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
    sectors: {
        type: Object,
        required: true,
    },
    errors: Object,
});

const errors = reactive({});

const sectoralForm = reactive({
    sector: "",
    date_encoded: "",
    first_name: "",
    middle_name: "",
    last_name: "",
    age: "",
    sex: "",
    nationality: "",
    religion: "",
    barangay: "",
    municipality: "",
    birthdate: "",
    place_birth: "",
    civil_status: "",
    status: "",
    ISY_OSY: "",
});

const submitForm = async () => {
    if (sectoralForm.sector) {
        errors.sector = "";
    }
    if (sectoralForm.date_encoded) {
        errors.date_encoded = "";
    }
    if (sectoralForm.first_name) {
        errors.first_name = "";
    }
    if (sectoralForm.middle_name) {
        errors.middle_name = "";
    }
    if (sectoralForm.last_name) {
        errors.last_name = "";
    }
    if (sectoralForm.age) {
        errors.age = "";
    }
    if (sectoralForm.sex) {
        errors.sex = "";
    }
    if (sectoralForm.nationality) {
        errors.nationality = "";
    }
    if (sectoralForm.religion) {
        errors.religion = "";
    }
    if (sectoralForm.purok) {
        errors.purok = "";
    }
    if (sectoralForm.barangay) {
        errors.barangay = "";
    }
    if (sectoralForm.municipality) {
        errors.municipality = "";
    }
    if (sectoralForm.birthdate) {
        errors.birthdate = "";
    }
    if (sectoralForm.place_birth) {
        errors.place_birth = "";
    }
    if (sectoralForm.civil_status) {
        errors.civil_status = "";
    }
    if (sectoralForm.fam_members) {
        errors.fam_members = "";
    }

    try {
        const response = await axios.post(
            "/sectoral-data/create-post",
            sectoralForm
        );

        toast.success("Successfully created.", {
            autoClose: 1000,
        });

        console.log("working..");
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0];
                }
            }
            toast.error("Please check the error in fields!", {
                autoClose: 2000,
            });
        }
        console.error("Error submitting form:", error);
    }
};

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
                            :href="`/sectoral-data`"
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
                        <label for="sector"
                            >Sector<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="sector"
                            id="sector"
                            :options="sectors.data"
                            :reduce="(data) => data.id"
                            label="name"
                            v-model="sectoralForm.sector"
                            :class="{
                                'form-control is-invalid': errors.sector,
                            }"
                            placeholder="Select"
                        >
                        </v-select>
                        <small v-if="errors.sector" class="text-danger">
                            {{ errors.sector }}
                        </small>
                    </div>
                    <div class="col-md-6">
                        <label for="dateEncoded"
                            >Date<span class="text-danger">*</span></label
                        >
                        <input
                            type="date"
                            class="form-control"
                            id="date_encoded"
                            name="date_encoded"
                            v-model="sectoralForm.date_encoded"
                            :class="{ 'is-invalid': errors.date_encoded }"
                        />
                        <small v-if="errors.date_encoded" class="text-danger">
                            {{ errors.date_encoded }}
                        </small>
                    </div>

                    <div class="col-md-4">
                        <label for="firstname"
                            >Firstname<span class="text-danger">*</span></label
                        >
                        <input
                            class="form-control"
                            name="first_name"
                            id="first_name"
                            v-model="sectoralForm.first_name"
                            :class="{ 'is-invalid': errors.first_name }"
                            placeholder="Given name"
                        />
                        <small v-if="errors.first_name" class="text-danger">
                            {{ errors.first_name }}
                        </small>
                    </div>
                    <div class="col-md-4">
                        <label for="middlename"
                            >Middlename<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="middle_name"
                            id="middle_name"
                            v-model="sectoralForm.middle_name"
                            :class="{ 'is-invalid': errors.middle_name }"
                            placeholder="Middle name"
                        />
                        <small v-if="errors.middle_name" class="text-danger">
                            {{ errors.middle_name }}
                        </small>
                    </div>
                    <div class="col-md-4">
                        <label for="lastname"
                            >Lastname<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="last_name"
                            name="last_name"
                            v-model="sectoralForm.last_name"
                            :class="{ 'is-invalid': errors.last_name }"
                            placeholder="Family name"
                        />
                        <small v-if="errors.last_name" class="text-danger">
                            {{ errors.last_name }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        <label for="age"
                            >Age<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="age"
                            id="age"
                            v-model="sectoralForm.age"
                            :class="{ 'is-invalid': errors.age }"
                        />
                        <small v-if="errors.age" class="text-danger">
                            {{ errors.age }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        <label for="gender"
                            >Gender<span class="text-danger">*</span></label
                        >
                        <select
                            class="form-select opacity-75"
                            name="sex"
                            id="sex"
                            v-model="sectoralForm.sex"
                            :class="{ 'is-invalid': errors.sex }"
                        >
                            <option value="" disabled>Select</option>
                            <option v-for="sex in gender" :key="sex">
                                {{ sex }}
                            </option>
                        </select>
                        <small v-if="errors.sex" class="text-danger">
                            {{ errors.sex }}
                        </small>
                    </div>
                    <div class="col-md-3">
                        <label for="nationality"
                            >Nationality<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            class="form-control"
                            name="nationality"
                            id="nationality"
                            v-model="sectoralForm.nationality"
                            :class="{ 'is-invalid': errors.nationality }"
                            placeholder="Nationality"
                        />
                        <small v-if="errors.nationality" class="text-danger">
                            {{ errors.nationality }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        <label for="religion"
                            >Religion<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="religion"
                            name="religion"
                            v-model="sectoralForm.religion"
                            :class="{ 'is-invalid': errors.religion }"
                            placeholder="Religion"
                        />
                        <small v-if="errors.religion" class="text-danger">
                            {{ errors.religion }}
                        </small>
                    </div>
                    <div class="col-md-3">
                        <label for="ethnicity">Ethnicity</label>
                        <input
                            type="text"
                            class="form-control"
                            id="ethnicity"
                            name="ethnicity"
                            v-model="sectoralForm.ethnicity"
                        />
                    </div>

                    <div class="col-md-3">
                        <label for="purok">Purok</label>
                        <input
                            type="text"
                            class="form-control"
                            name="purok"
                            id="purok"
                            v-model="sectoralForm.purok"
                            :class="{ 'is-invalid': errors.purok }"
                        />
                        <small v-if="errors.purok" class="text-danger">{{
                            errors.purok
                        }}</small>
                    </div>
                    <div class="col-md-3">
                        <label for="barangay"
                            >Barangay<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="barangay"
                            id="barangay"
                            label="barangay"
                            v-model="sectoralForm.barangay"
                            :options="barangays.data"
                            :reduce="(data) => data.id"
                            :class="{
                                'form-control is-invalid': errors.barangay,
                            }"
                            placeholder="Select"
                        >
                        </v-select>
                        <small v-if="errors.barangay" class="text-danger">{{
                            errors.barangay
                        }}</small>
                    </div>
                    <div class="col-md-3">
                        <label for="municipal"
                            >Municipality<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <v-select
                            name="municipality"
                            id="municipality"
                            label="municipality"
                            v-model="sectoralForm.municipality"
                            :options="municipality.data"
                            :reduce="(data) => data.id"
                            :class="{
                                'form-control is-invalid': errors.municipality,
                            }"
                            placeholder="Select"
                        >
                        </v-select>
                        <small v-if="errors.municipality" class="text-danger">{{
                            errors.municipality
                        }}</small>
                    </div>
                    <div class="col-md-3">
                        <label for="birthdate"
                            >Birthdate<span class="text-danger">*</span></label
                        >
                        <input
                            type="date"
                            class="form-control"
                            id="birthdate"
                            name="birthdate"
                            v-model="sectoralForm.birthdate"
                            :class="{ 'is-invalid': errors.birthdate }"
                        />
                        <small v-if="errors.birthdate" class="text-danger">
                            {{ errors.birthdate }}
                        </small>
                    </div>
                    <div class="col-md-3">
                        <label for="placeBirth"
                            >Place of Birth<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="place_birth"
                            id="place_birth"
                            v-model="sectoralForm.place_birth"
                            :class="{ 'is-invalid': errors.place_birth }"
                        />
                        <small v-if="errors.place_birth" class="text-danger">
                            {{ errors.place_birth }}
                        </small>
                    </div>

                    <div class="col-md-3">
                        <label for="civilStatus"
                            >Civil Status<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <select
                            class="form-select opacity-75"
                            id="civil_status"
                            name="civil_status"
                            v-model="sectoralForm.civil_status"
                            :class="{ 'is-invalid': errors.civil_status }"
                        >
                            <option value="" disabled>Select</option>
                            <option v-for="civil in civilStatus" :key="civil">
                                {{ civil }}
                            </option>
                        </select>
                        <small v-if="errors.civil_status" class="text-danger">
                            {{ errors.civil_status }}
                        </small>
                    </div>
                    <div class="col-md-3">
                        <label for="physical">Physical Disability</label>
                        <input
                            type="text"
                            class="form-control"
                            id="physical_disability"
                            name="physical_disability"
                            v-model="sectoralForm.physical_disability"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="contactNo"
                            >Contact No.<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="contact_no"
                            name="contact_no"
                            v-model="sectoralForm.contact_no"
                            placeholder="Phone or Mobile Number"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="fbAcct">Facebook Account</label>
                        <input
                            type="text"
                            class="form-control"
                            id="fb_acct"
                            name="fb_acct"
                            v-model="sectoralForm.fb_acct"
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="schoolLastAttend"
                            >School Last Attended</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="school_last_attend"
                            name="school_last_attend"
                            v-model="sectoralForm.school_last_attended"
                        />
                    </div>

                    <div class="col-md-3">
                        <label for="monthYear">Month and Year</label>
                        <input
                            type="text"
                            class="form-control"
                            id="month_year"
                            name="month_year"
                            v-model="sectoralForm.month_year"
                        />
                    </div>

                    <div class="col-md-4">
                        <label for="skills">Skills</label>
                        <input
                            class="form-control"
                            name="skills"
                            id="skills"
                            v-model="sectoralForm.skills"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="interest">Interest/Hobbies</label>
                        <input
                            class="form-control"
                            name="interest_hobby"
                            id="interest_hobby"
                            v-model="sectoralForm.interest_hobby"
                        />
                    </div>

                    <div class="col-md-4">
                        <label for="workExp">Work Experience</label>
                        <input
                            type="text"
                            class="form-control"
                            id="work_exp"
                            name="work_exp"
                            v-model="sectoralForm.work_exp"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="orgMembers">Members of Organizations</label>
                        <input
                            type="text"
                            class="form-control"
                            id="org_membership"
                            name="org_membership"
                            v-model="sectoralForm.org_membership"
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
                            id="fam_members"
                            name="fam_members"
                            v-model="sectoralForm.fam_members"
                            :class="{ 'is-invalid': errors.fam_members }"
                        />
                        <small v-if="errors.fam_members" class="text-danger">
                            {{ errors.fam_members }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        <label for="isyOsy"
                            >ISY/OSY<span class="text-danger">*</span></label
                        >
                        <select
                            class="form-select opacity-75"
                            id="ISY_OSY"
                            name="ISY_OSY"
                            v-model="sectoralForm.ISY_OSY"
                        >
                            <option value="" disabled>Select</option>
                            <option value="isy">ISY</option>
                            <option value="osy">OSY</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="position">Position</label>
                        <input
                            type="text"
                            class="form-control"
                            id="position"
                            name="position"
                            v-model="sectoralForm.position"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="statusTrans"
                            >Status<span class="text-danger">*</span></label
                        >
                        <select
                            class="form-select opacity-75"
                            name="status"
                            id="status"
                            v-model="sectoralForm.status"
                            :class="{ 'is-invalid': errors.status }"
                        >
                            <option value="" disabled>Select</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
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
