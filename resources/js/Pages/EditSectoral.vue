<script setup>
import { defineComponent, watchEffect, reactive, computed, watch } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import vSelect from "vue-select";
import { toast } from "vue3-toastify";

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
    disabilities: {
        type: Object,
        required: true,
    },
    indigents: {
        type: Object,
        required: true,
    },
});

const barangayOptions = computed(() => {
    if (!props.sectoral.municipality) return [];

    const list = Array.isArray(props.barangays)
        ? props.barangays
        : props.barangays?.data ?? [];

    return list.filter(
        (b) => Number(b.municipality_id) === Number(props.sectoral.municipality)
    );
});

watch(() => props.sectoral);

const errors = reactive({});

const submitForm = async () => {
    try {
        const response = await axios.put(
            `/sectoral-data/update/${props.sectoral.id}`,
            props.sectoral
        );

        toast.success("Record successfully updated.", {
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

watchEffect(() => {
    props.sectoral.sector = parseInt(props.sectoral.sector);
    props.sectoral.municipality = parseInt(props.sectoral.municipality);
    props.sectoral.barangay = parseInt(props.sectoral.barangay);

    if (props.sectoral?.ethnicity) {
        props.sectoral.ethnicity = parseInt(props.sectoral.ethnicity);
    }
    if (props.sectoral?.physical_disability) {
        props.sectoral.physical_disability = parseInt(
            props.sectoral.physical_disability
        );
    }
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
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">
                            Edit Record
                            <small class="font-monospace"
                                >(Sectoral Data Form)</small
                            >
                        </h5>
                    </div>
                    <div class="col-lg-6 text-end">
                        <Link
                            class="btn btn-sm btn-light"
                            :href="`/sectoral-data`"
                        >
                            <i class="bi bi-backspace"></i>
                            Back
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form @submit.prevent="submitForm">
                    <diva>
                        <!-- Start of 1st card -->
                        <h6>
                            <i class="bi bi-person-lines-fill"></i> Personal
                            Details
                        </h6>
                        <div class="card">
                            <div class="card-body p-3">
                                <!-- 1st row -->
                                <div
                                    class="d-flex flex-column flex-md-row justify-content-between mt-2"
                                >
                                    <div class="col-12 col-md-4 mb-2">
                                        <label for="sector"
                                            >Sector<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <v-select
                                            class="fw-bold"
                                            name="sector"
                                            :options="sectors.data"
                                            :reduce="(data) => data.id"
                                            id="sector"
                                            label="name"
                                            v-model="sectoral.sector"
                                        >
                                        </v-select>
                                        <small
                                            v-if="errors.sector"
                                            class="text-danger"
                                        >
                                            {{ errors.sector }}
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-3 mb-4">
                                        <label for="dateEncoded"
                                            >Date<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="date"
                                            class="form-control fw-bold"
                                            id="date_encoded"
                                            name="date_encoded"
                                            v-model="sectoral.date_encoded"
                                        />
                                        <small
                                            v-if="errors.date_encoded"
                                            class="text-danger"
                                        >
                                            {{ errors.date_encoded }}
                                        </small>
                                    </div>
                                </div>
                                <!-- end 1st row -->

                                <!-- 2nd row -->
                                <div class="row">
                                    <div class="col-12 col-md-4 mb-2">
                                        <label for="firstname"
                                            >First name<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            name="first_name"
                                            id="first_name"
                                            v-model="sectoral.first_name"
                                        />
                                        <small
                                            v-if="errors.first_name"
                                            class="text-danger"
                                        >
                                            {{ errors.first_name }}
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-4 mb-2">
                                        <label for="middlename"
                                            >Middle name<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            name="middle_name"
                                            id="middle_name"
                                            v-model="sectoral.middle_name"
                                        />
                                        <small
                                            v-if="errors.middle_name"
                                            class="text-danger"
                                        >
                                            {{ errors.middle_name }}
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-4 mb-2">
                                        <label for="lastname"
                                            >Last name<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="last_name"
                                            name="last_name"
                                            v-model="sectoral.last_name"
                                        />
                                        <small
                                            v-if="errors.last_name"
                                            class="text-danger"
                                        >
                                            {{ errors.last_name }}
                                        </small>
                                    </div>
                                </div>
                                <!-- end 2nd row -->

                                <!-- 3rd row -->
                                <div class="row mt-3">
                                    <div class="col-12 col-md-2 mb-2">
                                        <label for="age"
                                            >Age<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            name="age"
                                            id="age"
                                            v-model="sectoral.age"
                                        />
                                        <small
                                            v-if="errors.age"
                                            class="text-danger"
                                        >
                                            {{ errors.age }}
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-2 mb-2">
                                        <label for="gender"
                                            >Gender<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <select
                                            class="form-select fw-bold"
                                            name="sex"
                                            id="sex"
                                            v-model="sectoral.sex"
                                        >
                                            <option value="male">Male</option>
                                            <option value="female">
                                                Female
                                            </option>
                                        </select>
                                        <small
                                            v-if="errors.sex"
                                            class="text-danger"
                                        >
                                            {{ errors.sex }}
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-2 mb-2">
                                        <label for="birthdate"
                                            >Birthdate<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="date"
                                            class="form-control fw-bold"
                                            id="birthdate"
                                            name="birthdate"
                                            v-model="sectoral.birthdate"
                                        />
                                        <small
                                            v-if="errors.birthdate"
                                            class="text-danger"
                                        >
                                            {{ errors.birthdate }}
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="placeBirth"
                                            >Place of Birth<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            name="place_birth"
                                            id="place_birth"
                                            v-model="sectoral.place_birth"
                                        />
                                        <small
                                            v-if="errors.place_birth"
                                            class="text-danger"
                                        >
                                            {{ errors.place_birth }}
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="civilStatus"
                                            >Civil Status<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <select
                                            class="form-select fw-bold"
                                            id="civil_status"
                                            name="civil_status"
                                            v-model="sectoral.civil_status"
                                        >
                                            <option value="single">
                                                Single
                                            </option>
                                            <option value="married">
                                                Married
                                            </option>
                                            <option value="widowed">
                                                Widowed
                                            </option>
                                            <option value="divorced">
                                                Divorced
                                            </option>
                                            <option value="separated">
                                                Separated
                                            </option>
                                        </select>
                                        <small
                                            v-if="errors.civil_status"
                                            class="text-danger"
                                        >
                                            {{ errors.civil_status }}
                                        </small>
                                    </div>
                                </div>
                                <!-- end 3rd row-->

                                <!-- 4th row -->
                                <div class="row mt-3">
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="purok">Purok</label>
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            name="purok"
                                            id="purok"
                                            v-model="sectoral.purok"
                                        />
                                        <small
                                            v-if="errors.purok"
                                            class="text-danger"
                                            >{{ errors.purok }}</small
                                        >
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="municipal"
                                            >Municipality<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <v-select
                                            class="fw-bold"
                                            name="municipality"
                                            :options="municipality.data"
                                            :reduce="(data) => data.id"
                                            id="municipality"
                                            label="municipality"
                                            v-model="sectoral.municipality"
                                        >
                                        </v-select>
                                        <small
                                            v-if="errors.municipality"
                                            class="text-danger"
                                            >{{ errors.municipality }}</small
                                        >
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="barangay"
                                            >Barangay<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <v-select
                                            class="fw-bold"
                                            name="barangay"
                                            :options="barangayOptions"
                                            :reduce="(data) => data.id"
                                            id="barangay"
                                            label="barangay"
                                            v-model="sectoral.barangay"
                                        >
                                        </v-select>
                                        <small
                                            v-if="errors.barangay"
                                            class="text-danger"
                                            >{{ errors.barangay }}</small
                                        >
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <label for="contactNo"
                                            >Contact No.<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="contact_no"
                                            name="contact_no"
                                            v-model="sectoral.contact_no"
                                        />
                                    </div>
                                </div>
                                <!-- end 4th row -->
                            </div>
                        </div>

                        <!-- 2nd card -->
                        <h6>
                            <i class="bi bi-file-text-fill"></i> Other Details
                        </h6>
                        <div class="card">
                            <div class="card-body p-4">
                                <!-- 1st row -->
                                <div class="row">
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="nationality"
                                            >Nationality<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            class="form-control fw-bold"
                                            name="nationality"
                                            id="nationality"
                                            v-model="sectoral.nationality"
                                        />
                                        <small
                                            v-if="errors.nationality"
                                            class="text-danger"
                                        >
                                            {{ errors.nationality }}
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="religion"
                                            >Religion<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="religion"
                                            name="religion"
                                            v-model="sectoral.religion"
                                        />
                                        <small
                                            v-if="errors.religion"
                                            class="text-danger"
                                        >
                                            {{ errors.religion }}
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="ethnicity">Ethnicity</label>
                                        <v-select
                                            class="fw-bold"
                                            name="ethnicity"
                                            :options="indigents.data"
                                            :reduce="(data) => data.id"
                                            id="ethnicity"
                                            label="name"
                                            v-model="sectoral.ethnicity"
                                            placeholder="Select"
                                        >
                                        </v-select>
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="physical">Disability</label>
                                        <v-select
                                            class="fw-bold"
                                            name="physical_disability"
                                            :options="disabilities.data"
                                            :reduce="(data) => data.id"
                                            id="physical_disability"
                                            label="description"
                                            v-model="
                                                sectoral.physical_disability
                                            "
                                            placeholder="Select"
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <!-- end 1st row -->
                                <div class="row mt-3">
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="fbAcct"
                                            >Facebook Account</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="fb_acct"
                                            name="fb_acct"
                                            v-model="sectoral.fb_accnt"
                                        />
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="schoolLastAttend"
                                            >School Last Attended</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="school_last_attend"
                                            name="school_last_attend"
                                            v-model="
                                                sectoral.school_last_attend
                                            "
                                        />
                                    </div>

                                    <div class="col-12 col-md-2 mb-2">
                                        <label for="monthYear"
                                            >Month and Year</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="month_year"
                                            name="month_year"
                                            v-model="sectoral.month_year"
                                        />
                                    </div>

                                    <div class="col-12 col-md-4 mb-2">
                                        <label for="skills">Skills</label>
                                        <input
                                            class="form-control fw-bold"
                                            name="skills"
                                            id="skills"
                                            v-model="sectoral.skills"
                                        />
                                    </div>
                                </div>
                                <!-- 2nd row -->

                                <!-- 3rd row -->
                                <div class="row mt-3">
                                    <div class="col-12 col-md-4 mb-2">
                                        <label for="interest"
                                            >Interest/Hobbies</label
                                        >
                                        <input
                                            class="form-control fw-bold"
                                            name="interest_hobby"
                                            id="interest_hobby"
                                            v-model="sectoral.interest_hobby"
                                        />
                                    </div>

                                    <div class="col-12 col-md-5 mb-2">
                                        <label for="workExp"
                                            >Work Experience</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="work_exp"
                                            name="work_exp"
                                            v-model="sectoral.work_exp"
                                        />
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="orgMembers"
                                            >Members of Organizations</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="org_membership"
                                            name="org_membership"
                                            v-model="sectoral.org_membership"
                                        />
                                    </div>
                                </div>
                                <!-- end 3rd row -->

                                <!-- 4th row -->
                                <div class="row mt-3">
                                    <div class="col-12 col-md-2 mb-2">
                                        <label for="famMembers"
                                            >Number of Family Members<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="fam_members"
                                            name="fam_members"
                                            v-model="sectoral.fam_members"
                                        />
                                        <small
                                            v-if="errors.fam_members"
                                            class="text-danger"
                                        >
                                            {{ errors.fam_members }}
                                        </small>
                                    </div>

                                    <div class="col-12 col-md-2 mb-2">
                                        <label for="isyOsy"
                                            >ISY/OSY<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <select
                                            type="text"
                                            class="form-control fw-bold"
                                            id="ISY_OSY"
                                            name="ISY_OSY"
                                            v-model="sectoral.ISY_OSY"
                                        >
                                            <option value="isy">ISY</option>
                                            <option value="osy">OSY</option>
                                        </select>
                                        <small
                                            v-if="errors.ISY_OSY"
                                            class="text-danger"
                                        >
                                            {{ errors.ISY_OSY }}
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-4 mb-2">
                                        <label for="position">Position</label>
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="position"
                                            name="position"
                                            v-model="sectoral.position"
                                        />
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="statusTrans"
                                            >Status<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <select
                                            type="text"
                                            class="form-control fw-bold"
                                            id="status"
                                            name="status"
                                            v-model="sectoral.status"
                                        >
                                            <option value="active">
                                                Active
                                            </option>
                                            <option value="inactive">
                                                Inactive
                                            </option>
                                        </select>
                                        <small
                                            v-if="errors.status"
                                            class="text-danger"
                                        >
                                            {{ errors.status }}
                                        </small>
                                    </div>
                                </div>
                                <!-- end 4th row -->
                            </div>
                            <button
                                type="submit"
                                class="btn btn-md btn-success float-end"
                            >
                                <i class="bi bi-save"></i>
                                Update
                            </button>
                        </div>
                        <!-- end of 2nd card -->
                    </diva>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
