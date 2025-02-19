<script setup>
import { defineComponent, watchEffect } from "vue";
import LayoutApp from "/resources/js/Shared//Layout.vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { toast } from "vue3-toastify";
import vSelect from "vue-select";

// Props from Inertia
const props = defineProps({
    sectoral: {
        type: Object,
        required: true,
    },
    sectors: {
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
});

const submitData = async () => {
    try {
        const response = await axios.put(
            `/municipal/sectoral/update/${props.sectoral.id}`,
            props.sectoral
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

watchEffect(() => {
    props.sectoral.sector = parseInt(props.sectoral.sector);
    props.sectoral.municipality = parseInt(props.sectoral.municipality);
    props.sectoral.barangay = parseInt(props.sectoral.barangay);
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
                        <h5 class="fw-bold">Edit Sectoral Data</h5>
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
                <form @submit.prevent="submitData" class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label for="sector"
                            >Sector<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="sector"
                            :options="sectors.data"
                            :reduce="(data) => data.id"
                            id="sector"
                            label="name"
                            v-model="sectoral.sector"
                        >
                        </v-select>
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
                            v-model="sectoral.date_encoded"
                        />
                    </div>

                    <div class="col-md-4">
                        <label for="firstname"
                            >Firstname<span class="text-danger">*</span></label
                        >
                        <input
                            class="form-control"
                            name="first_name"
                            id="first_name"
                            v-model="sectoral.first_name"
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
                            v-model="sectoral.middle_name"
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
                            v-model="sectoral.last_name"
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
                            v-model="sectoral.age"
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
                            v-model="sectoral.sex"
                        >
                            <option>
                                {{ sectoral.sex }}
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
                            v-model="sectoral.nationality"
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
                            v-model="sectoral.religion"
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
                            v-model="sectoral.ethnicity"
                        />
                    </div>

                    <div class="col-md-3">
                        <label for="purok">Purok</label>
                        <input
                            type="text"
                            class="form-control"
                            name="purok"
                            id="purok"
                            v-model="sectoral.purok"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="barangay"
                            >Barangay<span class="text-danger">*</span></label
                        >
                        <v-select
                            name="barangay"
                            :options="barangays.data"
                            :reduce="(data) => data.id"
                            id="barangay"
                            label="barangay"
                            v-model="sectoral.barangay"
                        >
                        </v-select>
                    </div>
                    <div class="col-md-3">
                        <label for="municipality"
                            >Municipality<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <v-select
                            name="municipality"
                            :options="municipality.data"
                            :reduce="(data) => parseInt(data.id)"
                            id="municipality"
                            label="municipality"
                            v-model="sectoral.municipality"
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
                            v-model="sectoral.birthdate"
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
                            v-model="sectoral.place_birth"
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
                            v-model="sectoral.civil_status"
                        >
                            <option>
                                {{ sectoral.civil_status }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="physical">Disability</label>
                        <input
                            type="text"
                            class="form-control"
                            id="physical_disability"
                            name="physical_disability"
                            v-model="sectoral.physical_disability"
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
                            v-model="sectoral.contact_no"
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
                            v-model="sectoral.fb_acct"
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
                            v-model="sectoral.school_last_attended"
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
                            v-model="sectoral.month_year"
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
                            v-model="sectoral.skills"
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
                            v-model="sectoral.interest_hobby"
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
                            v-model="sectoral.work_exp"
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
                            v-model="sectoral.org_membership"
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
                            v-model="sectoral.fam_members"
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
                            v-model="sectoral.ISY_OSY"
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
                            v-model="sectoral.position"
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
                            v-model="sectoral.status"
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
