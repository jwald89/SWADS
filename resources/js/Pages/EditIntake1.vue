<script setup>
import { defineComponent, inject, watchEffect, ref } from "vue";
import vSelect from "vue-select";

const submitForm = inject("submitFormP1");
const intakes = inject("intakeData");

defineProps({
    assistances: Object,
    sectorType: Object,
    indigents: Object,
    officeCharge: Object,
    municipality: Object,
    barangays: Object,
    classType: Object,
});

const birthdate = ref(intakes.birthdate);
const age = ref(intakes.age);

const calculateAge = () => {
    if (birthdate.value) {
        const birthDate = new Date(birthdate.value);
        const currentYear = new Date().getFullYear();
        let calculatedAge = currentYear - birthDate.getFullYear();
        const monthDifference = new Date().getMonth() - birthDate.getMonth();

        // Adjust age if the birth date hasn't occurred yet this year
        if (
            monthDifference < 0 ||
            (monthDifference === 0 && new Date() < birthDate)
        ) {
            calculatedAge--;
        }
        // Update intakes age and local age ref
        intakes.age = calculatedAge;
        age.value = calculatedAge;
    } else {
        age.value = null;
        intakes.age = null; // Clear age in intakes if no birthdate
    }
};

watchEffect(() => {
    intakes.category = parseInt(intakes.category);
    intakes.barangay = parseInt(intakes.barangay);
    intakes.municipality = parseInt(intakes.municipality);
    intakes.sector_type = parseInt(intakes.sector_type);
    intakes.ofis_charge = parseInt(intakes.ofis_charge);
    intakes.classification = parseInt(intakes.classification);

    if (intakes?.ips) {
        intakes.ips = parseInt(intakes.ips);
    }
});

// Watch for changes in birthdate to calculate age
watchEffect(() => {
    birthdate.value = intakes.birthdate;
    calculateAge();
});

defineComponent({
    vSelect,
});
</script>

<template>
    <div
        class="tab-pane fade show active"
        id="identifying-data"
        role="tabpanel"
        aria-labelledby="home-tab"
    >
        <form @submit.prevent="submitForm">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="mt-2">
                        <i class="bi bi-filter-circle-fill"></i> Filter Section
                    </h6>
                    <div class="card">
                        <div class="card-body row g-2 mt-1">
                            <div class="col-md-1">
                                <label for="caseNo">Case No.</label>
                                <input
                                    type="text"
                                    class="form-control fw-bold"
                                    name="caseNo"
                                    id="caseno"
                                    v-model="intakes.case_no"
                                />
                            </div>
                            <div class="col-md-2">
                                <label for="classification"
                                    >Classification<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <v-select
                                    class="fw-bold"
                                    name="classification"
                                    id="classification"
                                    :options="classType.data"
                                    :reduce="(data) => data.id"
                                    v-model="intakes.classification"
                                    label="name"
                                >
                                </v-select>
                            </div>
                            <div class="col-md-3">
                                <label for="category"
                                    >Assistance Type
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    class="fw-bold"
                                    name="category"
                                    id="category"
                                    :options="assistances.data"
                                    :reduce="(data) => data.id"
                                    v-model="intakes.category"
                                    label="name"
                                >
                                </v-select>
                            </div>
                            <div class="col-md-2">
                                <label for="sector_type"
                                    >Sector
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    class="fw-bold"
                                    name="sector_type"
                                    id="sector_type"
                                    :options="sectorType.data"
                                    :reduce="(data) => data.id"
                                    v-model="intakes.sector_type"
                                    label="name"
                                >
                                </v-select>
                            </div>
                            <div class="col-md-2">
                                <label for="ofis_charge"
                                    >Office Charge
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    class="fw-bold"
                                    name="ofis_charge"
                                    id="ofis_charge"
                                    :options="officeCharge.data"
                                    v-model="intakes.ofis_charge"
                                    :reduce="(data) => data.id"
                                    label="description"
                                >
                                </v-select>
                            </div>
                            <div class="col-md-2">
                                <label for="dateIntake"
                                    >Date<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="date"
                                    class="form-control fw-bold"
                                    name="date_intake"
                                    id="dateIntake"
                                    v-model="intakes.date_intake"
                                />
                            </div>

                            <div class="col-md-3">
                                <label for="ips"
                                    >Ethnicity
                                    <span class="font-monospace"
                                        >(IPs Affiliates)</span
                                    ></label
                                >
                                <v-select
                                    class="fw-bold"
                                    name="ips"
                                    id="ips"
                                    :options="indigents.data"
                                    v-model="intakes.ips"
                                    :reduce="(data) => data.id"
                                    label="name"
                                    placeholder="Select"
                                >
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>
                                <i class="bi bi-person-fill"></i> Person's Name
                            </h6>
                            <div class="card">
                                <div class="card-body p-4">
                                    <form>
                                        <div class="row mb-2">
                                            <label
                                                for="lastName"
                                                class="col-sm-2 col-form-label"
                                                >Last name<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <div class="col-sm-10">
                                                <input
                                                    type="text"
                                                    class="form-control fw-bold"
                                                    name="lastName"
                                                    id="lastName"
                                                    placeholder="Family name"
                                                    v-model="intakes.last_name"
                                                />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label
                                                for="firstName"
                                                class="col-sm-2 col-form-label"
                                                >First name<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <div class="col-sm-10">
                                                <input
                                                    type="text"
                                                    class="form-control fw-bold"
                                                    name="firstName"
                                                    id="firstName"
                                                    placeholder="Given name"
                                                    v-model="intakes.first_name"
                                                />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label
                                                for="middleName"
                                                class="col-sm-2 col-form-label"
                                                >Middle name
                                                <small>(Optional)</small>
                                            </label>
                                            <div class="col-sm-10">
                                                <input
                                                    type="text"
                                                    class="form-control fw-bold"
                                                    name="middleName"
                                                    id="middleName"
                                                    placeholder="Middle name"
                                                    v-model="
                                                        intakes.middle_name
                                                    "
                                                />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 mb-2">
                                                <label for="extension"
                                                    >Extension</label
                                                >
                                                <small>
                                                    (Jr. Sr. II III etc.)</small
                                                >
                                                <select
                                                    class="form-control fw-bold"
                                                    id="extension"
                                                    name="extension"
                                                    v-model="intakes.extn_name"
                                                >
                                                    <option value="">NA</option>
                                                    <option value="Jr">
                                                        Junior (Jr.)
                                                    </option>
                                                    <option value="Sr">
                                                        Senior (Sr.)
                                                    </option>
                                                    <option value="II">
                                                        II
                                                    </option>
                                                    <option value="III">
                                                        III
                                                    </option>
                                                    <option value="IV">
                                                        IV
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="nickName"
                                                    >Nick name<span
                                                        class="text-danger"
                                                        >*</span
                                                    ></label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control fw-bold"
                                                    name="nickName"
                                                    id="nickName"
                                                    placeholder="Nickname"
                                                    v-model="intakes.nick_name"
                                                />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6><i class="bi bi-house-fill"></i> Address</h6>
                            <div class="card">
                                <div class="card-body p-4">
                                    <form>
                                        <div class="row mb-2">
                                            <label
                                                for="purok"
                                                class="col-sm-2 col-form-label"
                                                >Purok</label
                                            >
                                            <div class="col-sm-10">
                                                <input
                                                    type="text"
                                                    class="form-control fw-bold"
                                                    name="purok"
                                                    id="purok"
                                                    placeholder="Purok"
                                                    v-model="intakes.purok"
                                                />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label
                                                for="street"
                                                class="col-sm-2 col-form-label"
                                                >Street</label
                                            >
                                            <div class="col-sm-10">
                                                <input
                                                    type="text"
                                                    class="form-control fw-bold"
                                                    name="street"
                                                    id="street"
                                                    placeholder="Sample St.,"
                                                    v-model="intakes.street"
                                                />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label
                                                for="barangay"
                                                class="col-sm-2 col-form-label"
                                                >Barangay<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <div class="col-sm-10">
                                                <v-select
                                                    class="fw-bold"
                                                    name="barangay"
                                                    :options="barangays.data"
                                                    :reduce="(data) => data.id"
                                                    id="barangay"
                                                    label="barangay"
                                                    v-model="intakes.barangay"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label
                                                for="municipal"
                                                class="col-sm-2 col-form-label"
                                                >Municipality<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <div class="col-sm-10">
                                                <v-select
                                                    class="fw-bold"
                                                    name="municipal"
                                                    :options="municipality.data"
                                                    :reduce="(data) => data.id"
                                                    id="municipal"
                                                    label="municipality"
                                                    v-model="
                                                        intakes.municipality
                                                    "
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6><i class="bi bi-file-text-fill"></i> Others</h6>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 mt-1">
                                <div class="col-md-12">
                                    <label for="cases"
                                        >Case <small>(Optional)</small></label
                                    >
                                    <textarea
                                        class="form-control fw-bold"
                                        rows="2"
                                        id="case"
                                        name="case"
                                        v-model="intakes.case"
                                        placeholder="What is the case.."
                                    >
                                    </textarea>
                                </div>

                                <div class="col-md-3">
                                    <label for="birthDate"
                                        >Date of Birth<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="date"
                                        class="form-control fw-bold"
                                        name="birthDate"
                                        id="birthDate"
                                        v-model="intakes.birthdate"
                                        @change="calculateAge"
                                    />
                                </div>

                                <div class="col-md-3">
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
                                        placeholder="Age"
                                        v-model="intakes.age"
                                        readonly
                                    />
                                </div>

                                <div class="col-md-3">
                                    <label for="gender"
                                        >Gender<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        class="form-control fw-bold"
                                        id="sex"
                                        name="sex"
                                        v-model="intakes.sex"
                                    >
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="civilStatus"
                                        >Civil Status<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        class="form-control fw-bold"
                                        id="civil_stats"
                                        name="civil_stats"
                                        v-model="intakes.civil_stats"
                                    >
                                        <option value="single">Single</option>
                                        <option value="married">Married</option>
                                        <option value="widowed">Widowed</option>
                                        <option value="divorced">
                                            Divorced
                                        </option>
                                        <option value="separated">
                                            Separated
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="educ_attainment"
                                        >Educational Attainment</label
                                    >
                                    <span class="text-danger">*</span>
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
                                        id="educ_attainment"
                                        name="educ_attainment"
                                        v-model="intakes.educ_attainment"
                                    />
                                </div>

                                <div class="col-md-6">
                                    <label for="occupation">Occupation</label>
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
                                        id="occupation"
                                        name="occupation"
                                        placeholder="Job"
                                        v-model="intakes.job"
                                    />
                                </div>
                                <div class="col-md-4">
                                    <label for="contactNo"
                                        >Contact No.<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
                                        id="contactNo"
                                        name="contact_no"
                                        placeholder="Enter a phone or mobile number.."
                                        v-model="intakes.contact_no"
                                    />
                                </div>
                                <div class="col-md-2">
                                    <label for="income">Income</label>
                                    <small> (optional)</small>
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
                                        id="income"
                                        name="income"
                                        placeholder="Amount"
                                        v-model="intakes.income"
                                    />
                                </div>

                                <div class="mt-2">
                                    <button
                                        type="submit"
                                        class="btn btn-success float-end"
                                    >
                                        <i class="bi bi-save"></i>
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
