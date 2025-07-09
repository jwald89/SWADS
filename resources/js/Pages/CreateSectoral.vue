<script setup>
import { defineComponent, reactive, ref, computed, watch } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import axios from "axios";
import { Link } from "@inertiajs/vue3";
import vSelect from "vue-select";
import { toast } from "vue3-toastify";

const props = defineProps({
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
    indigents: {
        type: Object,
        required: true,
    },
    disabilities: {
        type: Object,
        required: true,
    },
    errors: Object,
});

const errors = reactive({});
const isSubmitting = ref(false);

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
    purok: "",
    barangay: "",
    municipality: "",
    birthdate: "",
    place_birth: "",
    civil_status: "",
    status: "",
    ISY_OSY: "",
    ethnicity: "",
    physical_disability: "",
    contact_no: "",
    fb_acct: "",
    school_last_attended: "",
    month_year: "",
    skills: "",
    interest_hobby: "",
    work_exp: "",
    org_membership: "",
    fam_members: "",
    position: "",
});

const barangayOptions = computed(() => {
    if (!sectoralForm.municipality) return [];

    const list = Array.isArray(props.barangays)
        ? props.barangays
        : props.barangays?.data ?? [];

    return list.filter(
        (b) => Number(b.municipality_id) === Number(sectoralForm.municipality)
    );
});

watch(
    () => sectoralForm.municipality,
    () => {
        sectoralForm.barangay = null;
    }
);

const resetForm = () => {
    sectoralForm.sector = "";
    sectoralForm.date_encoded = "";
    sectoralForm.first_name = "";
    sectoralForm.middle_name = "";
    sectoralForm.last_name = "";
    sectoralForm.age = "";
    sectoralForm.sex = "";
    sectoralForm.nationality = "";
    sectoralForm.religion = "";
    sectoralForm.purok = "";
    sectoralForm.barangay = "";
    sectoralForm.municipality = "";
    sectoralForm.birthdate = "";
    sectoralForm.place_birth = "";
    sectoralForm.civil_status = "";
    sectoralForm.status = "";
    sectoralForm.ISY_OSY = "";
    sectoralForm.ethnicity = "";
    sectoralForm.physical_disability = "";
    sectoralForm.contact_no = "";
    sectoralForm.fb_acct = "";
    sectoralForm.school_last_attended = "";
    sectoralForm.month_year = "";
    sectoralForm.skills = "";
    sectoralForm.interest_hobby = "";
    sectoralForm.work_exp = "";
    sectoralForm.org_membership = "";
    sectoralForm.fam_members = "";
    sectoralForm.position = "";
};

const submitForm = async () => {
    // Clear previous errors
    const fields = [
        "sector",
        "date_encoded",
        "first_name",
        "last_name",
        "age",
        "sex",
        "nationality",
        "religion",
        "barangay",
        "municipality",
        "birthdate",
        "place_birth",
        "civil_status",
        "fam_members",
    ];

    fields.forEach((field) => {
        if (sectoralForm[field]) {
            errors[field] = "";
        }
    });

    isSubmitting.value = true;

    try {
        const response = await axios.post(
            "/sectoral-data/create-post",
            sectoralForm
        );

        toast.success("Successfully created.", {
            autoClose: 1000,
        });

        console.log("working..");
        resetForm();
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
        } else if (error.response && error.response.status === 409) {
            toast.error("The record already exists!", {
                autoClose: 2000,
            });
        }
        console.error("Error submitting form:", error);
    } finally {
        isSubmitting.value = false;
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
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Sectoral Data Form</h5>
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

            <div class="card-body p-4">
                <form @submit.prevent="submitForm">
                    <div>
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
                                            id="sector"
                                            :options="sectors.data"
                                            :reduce="(data) => data.id"
                                            label="name"
                                            v-model="sectoralForm.sector"
                                            :class="{
                                                'form-control is-invalid':
                                                    errors.sector,
                                            }"
                                            placeholder="Select"
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
                                            v-model="sectoralForm.date_encoded"
                                            :class="{
                                                'is-invalid':
                                                    errors.date_encoded,
                                            }"
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
                                            class="form-control fw-bold"
                                            name="first_name"
                                            id="first_name"
                                            v-model="sectoralForm.first_name"
                                            :class="{
                                                'is-invalid': errors.first_name,
                                            }"
                                            placeholder="Given name"
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
                                            >Middle name
                                            <span>(Optional)</span></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control fw-bold"
                                            name="middle_name"
                                            id="middle_name"
                                            v-model="sectoralForm.middle_name"
                                            placeholder="Middle name"
                                        />
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
                                            v-model="sectoralForm.last_name"
                                            :class="{
                                                'is-invalid': errors.last_name,
                                            }"
                                            placeholder="Family name"
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
                                            v-model="sectoralForm.age"
                                            :class="{
                                                'is-invalid': errors.age,
                                            }"
                                            placeholder="Age"
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
                                            v-model="sectoralForm.sex"
                                            :class="{
                                                'is-invalid': errors.sex,
                                            }"
                                        >
                                            <option value="" disabled>
                                                Select
                                            </option>
                                            <option
                                                v-for="sex in gender"
                                                :key="sex"
                                            >
                                                {{ sex }}
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
                                            v-model="sectoralForm.birthdate"
                                            :class="{
                                                'is-invalid': errors.birthdate,
                                            }"
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
                                            v-model="sectoralForm.place_birth"
                                            :class="{
                                                'is-invalid':
                                                    errors.place_birth,
                                            }"
                                            placeholder="City or Municipality"
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
                                            v-model="sectoralForm.civil_status"
                                            :class="{
                                                'is-invalid':
                                                    errors.civil_status,
                                            }"
                                        >
                                            <option value="" disabled>
                                                Select
                                            </option>
                                            <option
                                                v-for="civil in civilStatus"
                                                :key="civil"
                                            >
                                                {{ civil }}
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
                                            v-model="sectoralForm.purok"
                                            :class="{
                                                'is-invalid': errors.purok,
                                            }"
                                            placeholder="Purok"
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
                                            id="municipality"
                                            :options="municipality.data"
                                            :reduce="(data) => data.id"
                                            v-model="sectoralForm.municipality"
                                            label="municipality"
                                            :class="{
                                                'form-control is-invalid':
                                                    errors.municipality,
                                            }"
                                            placeholder="Select"
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
                                            id="barangay"
                                            label="barangay"
                                            :options="barangayOptions"
                                            v-model="sectoralForm.barangay"
                                            :reduce="(data) => data.id"
                                            :class="{
                                                'form-control is-invalid':
                                                    errors.barangay,
                                            }"
                                            placeholder="Select"
                                            :disabled="
                                                !sectoralForm.municipality
                                            "
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
                                            v-model="sectoralForm.contact_no"
                                            placeholder="Phone or Mobile Number"
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
                                            v-model="sectoralForm.nationality"
                                            :class="{
                                                'is-invalid':
                                                    errors.nationality,
                                            }"
                                            placeholder="Nationality"
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
                                            v-model="sectoralForm.religion"
                                            :class="{
                                                'is-invalid': errors.religion,
                                            }"
                                            placeholder="Religion"
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
                                            id="ethnicity"
                                            :options="indigents.data"
                                            :reduce="(data) => data.id"
                                            label="name"
                                            v-model="sectoralForm.ethnicity"
                                            placeholder="Select"
                                        >
                                        </v-select>
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="physical">Disability</label>
                                        <!-- <input
                                            type="text"
                                            class="form-control fw-bold"
                                            id="physical_disability"
                                            name="physical_disability"
                                            v-model="
                                                sectoralForm.physical_disability
                                            "
                                        /> -->
                                        <v-select
                                            class="fw-bold"
                                            name="physical_disability"
                                            id="physical_disability"
                                            :options="disabilities.data"
                                            :reduce="(data) => data.id"
                                            label="description"
                                            v-model="
                                                sectoralForm.physical_disability
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
                                            v-model="sectoralForm.fb_acct"
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
                                                sectoralForm.school_last_attended
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
                                            v-model="sectoralForm.month_year"
                                        />
                                    </div>

                                    <div class="col-12 col-md-4 mb-2">
                                        <label for="skills">Skills</label>
                                        <input
                                            class="form-control fw-bold"
                                            name="skills"
                                            id="skills"
                                            v-model="sectoralForm.skills"
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
                                            v-model="
                                                sectoralForm.interest_hobby
                                            "
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
                                            v-model="sectoralForm.work_exp"
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
                                            v-model="
                                                sectoralForm.org_membership
                                            "
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
                                            v-model="sectoralForm.fam_members"
                                            :class="{
                                                'is-invalid':
                                                    errors.fam_members,
                                            }"
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
                                            class="form-select fw-bold"
                                            id="ISY_OSY"
                                            name="ISY_OSY"
                                            v-model="sectoralForm.ISY_OSY"
                                            :class="{
                                                'is-invalid': errors.ISY_OSY,
                                            }"
                                        >
                                            <option value="" disabled>
                                                Select
                                            </option>
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
                                            v-model="sectoralForm.position"
                                        />
                                    </div>
                                    <div class="col-12 col-md-3 mb-2">
                                        <label for="statusTrans"
                                            >Status<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <select
                                            class="form-select fw-bold"
                                            name="status"
                                            id="status"
                                            v-model="sectoralForm.status"
                                            :class="{
                                                'is-invalid': errors.status,
                                            }"
                                        >
                                            <option value="" disabled>
                                                Select
                                            </option>
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
                            <!-- end of 2nd card -->
                            <button
                                type="submit"
                                class="btn btn-md btn-success float-end"
                            >
                                <i class="bi bi-save"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
