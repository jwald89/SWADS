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
    errors: Object,
});

const sectoralForm = reactive({
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
});

const submitForm = async () => {
    try {
        const response = await axios.post(
            "/sectoral-data/create-post",
            sectoralForm
        );

        toast.success("Successfully updated.", {
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
            toast.error("Please fill in the blanks error!", {
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
                            href="/sectoral-data"
                            >Back</Link
                        >
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="row g-3 mt-3" @submit.prevent="submitForm">
                    <div class="col-md-4">
                        <label for="firstname"
                            >Firstname<span class="text-danger">*</span></label
                        >
                        <input
                            class="form-control"
                            name="first_name"
                            id="first_name"
                            v-model="sectoralForm.first_name"
                        />
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
                        />
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
                        />
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
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="gender"
                            >Gender<span class="text-danger">*</span></label
                        >
                        <select
                            class="form-select"
                            name="sex"
                            id="sex"
                            v-model="sectoralForm.sex"
                        >
                            <option v-for="sex in gender" :key="sex">
                                {{ sex }}
                            </option>
                        </select>
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
                        />
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
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="ethnicity"
                            >Ethnicity<span class="text-danger">*</span></label
                        >
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
                            v-model="sectoralForm.barangay"
                            :options="barangays.data"
                            :reduce="(data) => data.barangay"
                            :class="{
                                'form-control is-invalid': errors.barangay,
                            }"
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
                            name="municipality"
                            id="municipality"
                            label="municipality"
                            v-model="sectoralForm.municipality"
                            :options="municipality.data"
                            :reduce="(data) => data.municipality"
                            :class="{
                                'form-control is-invalid': errors.municipality,
                            }"
                        >
                        </v-select>
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
                        />
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
                            v-model="sectoralForm.civil_status"
                        >
                            <option v-for="civil in civilStatus" :key="civil">
                                {{ civil }}
                            </option>
                        </select>
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
                            id="fb_acct"
                            name="fb_acct"
                            v-model="sectoralForm.fb_acct"
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
                            id="school_last_attend"
                            name="school_last_attend"
                            v-model="sectoralForm.school_last_attended"
                        />
                    </div>

                    <div class="col-md-3">
                        <label for="monthYear"
                            >Month and Year<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="month_year"
                            name="month_year"
                            v-model="sectoralForm.month_year"
                        />
                    </div>

                    <div class="col-md-4">
                        <label for="skills"
                            >Skills<span class="text-danger">*</span></label
                        >
                        <input
                            class="form-control"
                            name="skills"
                            id="skills"
                            v-model="sectoralForm.skills"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="interest"
                            >Interest/Hobbies<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            class="form-control"
                            name="interest_hobby"
                            id="interest_hobby"
                            v-model="sectoralForm.interest_hobby"
                        />
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
                            id="work_exp"
                            name="work_exp"
                            v-model="sectoralForm.work_exp"
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
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="isyOsy"
                            >ISY/OSY<span class="text-danger">*</span></label
                        >
                        <select
                            type="text"
                            class="form-control"
                            id="ISY_OSY"
                            name="ISY_OSY"
                            v-model="sectoralForm.ISY_OSY"
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
                            v-model="sectoralForm.position"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="status"
                            >Status<span class="text-danger">*</span></label
                        >
                        <select
                            type="text"
                            class="form-control"
                            id="status"
                            name="status"
                            v-model="sectoralForm.status"
                        >
                            <option value="N/A">--- Select ---</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
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
