<script setup>
import { defineComponent, inject, ref, computed } from "vue";
import vSelect from "vue-select";

const form = inject("personalData");
const submitForm = inject("submitFormP1");
const errors = inject("formErrors");
const tabs = inject("tabs");
const tabIndex = 0;

const props = defineProps({
    assistances: Object,
    sectorType: Object,
    municipality: Object,
    barangays: Object,
    indigents: Object,
    civilStatus: Object,
    gender: Object,
    officeCharge: Object,
    classType: Object,
    errors: Object,
    index: Number,
});

const birthdate = ref(form.birthdate);
const age = ref(form.age);

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
        form.age = calculatedAge;
        form.birthdate = birthdate.value;
        age.value = calculatedAge;
    } else {
        age.value = null; // Reset age if no date is selected
    }
};

// Computed property to determine visibility of the IPs field
const showIpsField = computed(() => {
    return form.classification === 3;
});

defineComponent({
    vSelect,
});
</script>

<template>
    <div
        class="tab-pane fade"
        id="identifying-data"
        :class="{ show: index == tabIndex, active: index == tabIndex }"
        role="tabpanel"
        aria-labelledby="home-tab"
    >
        <form @submit.prevent="submitForm">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="mt-2">Filter Section</h6>
                    <div class="card">
                        <div class="card-body row g-2 mt-3">
                            <div class="col-md-3">
                                <label for="classification"
                                    >Classification<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <v-select
                                    name="classification"
                                    id="classification"
                                    :options="classType.data"
                                    v-model="form.classification"
                                    :reduce="(data) => data.id"
                                    label="name"
                                    :class="{
                                        'form-control is-invalid':
                                            errors.classification,
                                    }"
                                    placeholder="Select"
                                >
                                </v-select>
                                <small
                                    v-if="errors.classification"
                                    class="text-danger"
                                    >{{ errors.classification }}</small
                                >
                            </div>
                            <div class="col-md-3">
                                <label for="category"
                                    >Assistance Type
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    name="category"
                                    id="category"
                                    :options="assistances.data"
                                    v-model="form.category"
                                    :reduce="(data) => data.id"
                                    label="name"
                                    :class="{
                                        'form-control is-invalid':
                                            errors.category,
                                    }"
                                    placeholder="Select"
                                >
                                </v-select>
                                <small
                                    v-if="errors.category"
                                    class="text-danger"
                                    >{{ errors.category }}</small
                                >
                            </div>
                            <div class="col-md-2">
                                <label for="sector_type"
                                    >Sector
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    name="sector_type"
                                    id="sector_type"
                                    :options="sectorType.data"
                                    v-model="form.sector_type"
                                    :reduce="(data) => data.id"
                                    label="name"
                                    :class="{
                                        'form-control is-invalid':
                                            errors.sector_type,
                                    }"
                                    placeholder="Select"
                                >
                                </v-select>
                                <small
                                    v-if="errors.sector_type"
                                    class="text-danger"
                                    >{{ errors.sector_type }}</small
                                >
                            </div>

                            <div class="col-md-2">
                                <label for="ofis_charge"
                                    >Office Charge
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    name="ofis_charge"
                                    id="ofis_charge"
                                    :options="officeCharge.data"
                                    v-model="form.ofis_charge"
                                    :reduce="(data) => data.id"
                                    label="description"
                                    :class="{
                                        'form-control is-invalid':
                                            errors.ofis_charge,
                                    }"
                                    placeholder="Select"
                                >
                                </v-select>
                                <small
                                    v-if="errors.ofis_charge"
                                    class="text-danger"
                                    >{{ errors.ofis_charge }}</small
                                >
                            </div>

                            <div class="col-md-2">
                                <label for="dateIntake"
                                    >Date<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="date"
                                    class="form-control"
                                    name="date_intake"
                                    id="dateIntake"
                                    v-model="form.date_intake"
                                    :class="{
                                        'is-invalid': errors.date_intake,
                                    }"
                                />
                                <small
                                    v-if="errors.date_intake"
                                    class="text-danger"
                                    >{{ errors.date_intake }}</small
                                >
                            </div>
                            <div class="col-md-3" v-if="showIpsField">
                                <label for="ips"
                                    >IPs Affiliates
                                    <span class="text-danger">*</span></label
                                >

                                <v-select
                                    name="ips"
                                    id="ips"
                                    :options="indigents.data"
                                    v-model="form.ips"
                                    :reduce="(data) => data.id"
                                    label="name"
                                    :class="{
                                        'form-control is-invalid': errors.ips,
                                    }"
                                    placeholder="Select"
                                ></v-select>
                                <small v-if="errors.ips" class="text-danger">{{
                                    errors.ips
                                }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Person's Name</h6>
                            <div class="card">
                                <div class="card-body p-4">
                                    <form>
                                        <div class="row mb-3">
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
                                                    class="form-control"
                                                    name="lastName"
                                                    id="lastName"
                                                    v-model="form.last_name"
                                                    placeholder="Family name"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.last_name,
                                                    }"
                                                />
                                                <small
                                                    v-if="errors.last_name"
                                                    class="text-danger"
                                                    >{{
                                                        errors.last_name
                                                    }}</small
                                                >
                                            </div>
                                        </div>
                                        <div class="row mb-3">
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
                                                    class="form-control"
                                                    name="firstName"
                                                    id="firstName"
                                                    v-model="form.first_name"
                                                    placeholder="Given name"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.first_name,
                                                    }"
                                                />
                                                <small
                                                    v-if="errors.first_name"
                                                    class="text-danger"
                                                    >{{
                                                        errors.first_name
                                                    }}</small
                                                >
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label
                                                for="middleName"
                                                class="col-sm-2 col-form-label"
                                                >Middle name<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <div class="col-sm-10">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="middleName"
                                                    id="middleName"
                                                    v-model="form.middle_name"
                                                    placeholder="Middle name"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.middle_name,
                                                    }"
                                                />
                                                <small
                                                    v-if="errors.middle_name"
                                                    class="text-danger"
                                                    >{{
                                                        errors.middle_name
                                                    }}</small
                                                >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="extension"
                                                    >Extension</label
                                                >
                                                <small>
                                                    (Jr. Sr. I II III
                                                    etc.)</small
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="extension"
                                                    id="extension"
                                                    v-model="form.extn_name"
                                                    placeholder="Suffix"
                                                />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nickName"
                                                    >Nick name<span
                                                        class="text-danger"
                                                        >*</span
                                                    ></label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="nickName"
                                                    id="nickName"
                                                    v-model="form.nick_name"
                                                    placeholder="Nickname"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.nick_name,
                                                    }"
                                                />
                                                <small
                                                    v-if="errors.nick_name"
                                                    class="text-danger"
                                                    >{{
                                                        errors.nick_name
                                                    }}</small
                                                >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6>Address</h6>
                            <div class="card">
                                <div class="card-body p-4">
                                    <form>
                                        <div class="row mb-3">
                                            <label
                                                for="purok"
                                                class="col-sm-2 col-form-label"
                                                >Purok</label
                                            >
                                            <div class="col-sm-10">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="purok"
                                                    id="purok"
                                                    v-model="form.purok"
                                                    placeholder="Purok"
                                                />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label
                                                for="street"
                                                class="col-sm-2 col-form-label"
                                                >Street</label
                                            >
                                            <div class="col-sm-10">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="street"
                                                    id="street"
                                                    v-model="form.street"
                                                    placeholder="Sample St.,"
                                                />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
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
                                                    name="barangay"
                                                    id="barangay"
                                                    :options="barangays.data"
                                                    v-model="form.barangay"
                                                    :reduce="(data) => data.id"
                                                    label="barangay"
                                                    :class="{
                                                        'form-control is-invalid':
                                                            errors.barangay,
                                                    }"
                                                    placeholder="Select"
                                                >
                                                </v-select>
                                                <small
                                                    v-if="errors.barangay"
                                                    class="text-danger"
                                                    >{{
                                                        errors.barangay
                                                    }}</small
                                                >
                                            </div>
                                        </div>
                                        <div class="row mb-3">
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
                                                    name="municipal"
                                                    id="municipal"
                                                    :options="municipality.data"
                                                    v-model="form.municipality"
                                                    :reduce="(data) => data.id"
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
                                                    >{{
                                                        errors.municipality
                                                    }}</small
                                                >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6>Others</h6>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 mt-1">
                                <div class="col-md-12">
                                    <label for="case"
                                        >Case <small>(Optional)</small></label
                                    >
                                    <textarea
                                        class="form-control"
                                        rows="2"
                                        id="case"
                                        name="case"
                                        v-model="form.case"
                                        placeholder="What is the case.."
                                    >
                                    </textarea>
                                </div>

                                <div class="col-md-3">
                                    <label for="birthDate" class="form-label"
                                        >Date of Birth<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="date"
                                        class="form-control"
                                        name="birthDate"
                                        id="birthDate"
                                        v-model="birthdate"
                                        @keyup="calculateAge"
                                        :class="{
                                            'is-invalid': errors.birthdate,
                                        }"
                                    />
                                    <small
                                        v-if="errors.birthdate"
                                        class="text-danger"
                                        >{{ errors.birthdate }}</small
                                    >
                                </div>

                                <div class="col-md-3">
                                    <label for="age" class="form-label"
                                        >Age<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="age"
                                        id="age"
                                        v-model="age"
                                        placeholder="Age"
                                        :class="{ 'is-invalid': errors.age }"
                                        readonly
                                    />
                                    <small
                                        v-if="errors.age"
                                        class="text-danger"
                                        >{{ errors.age }}</small
                                    >
                                </div>

                                <div class="col-md-3">
                                    <label for="gender" class="form-label"
                                        >Gender<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        class="form-select"
                                        id="sex"
                                        name="sex"
                                        v-model="form.sex"
                                        :class="{ 'is-invalid': errors.sex }"
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
                                        >{{ errors.sex }}</small
                                    >
                                </div>

                                <div class="col-md-3">
                                    <label for="civilStatus" class="form-label"
                                        >Civil Status<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        class="form-select"
                                        id="civil_stats"
                                        name="civil_stats"
                                        v-model="form.civil_stats"
                                        :class="{
                                            'is-invalid': errors.civil_stats,
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
                                        v-if="errors.civil_stats"
                                        class="text-danger"
                                        >{{ errors.civil_stats }}</small
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label
                                        for="educ_attainment"
                                        class="form-label"
                                        >Educational Attainment</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="educ_attainment"
                                        name="educ_attainment"
                                        v-model="form.educ_attainment"
                                    />
                                </div>

                                <div class="col-md-6">
                                    <label for="occupation" class="form-label"
                                        >Occupation</label
                                    >
                                    <span class="text-danger">*</span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="occupation"
                                        name="occupation"
                                        v-model="form.job"
                                        placeholder="Job"
                                        :class="{ 'is-invalid': errors.job }"
                                    />
                                    <small
                                        v-if="errors.job"
                                        class="text-danger"
                                        >{{ errors.job }}</small
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label for="contactNo" class="form-label"
                                        >Contact No.</label
                                    >
                                    <input
                                        class="form-control"
                                        id="contactNo"
                                        name="contact_no"
                                        v-model="form.contact_no"
                                        placeholder="Enter a phone or mobile number.."
                                    />
                                </div>

                                <div class="col-md-2">
                                    <label for="income" class="form-label"
                                        >Income</label
                                    >
                                    <span class="text-danger">*</span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="income"
                                        name="income"
                                        v-model="form.income"
                                        placeholder="Amount"
                                        :class="{ 'is-invalid': errors.income }"
                                    />
                                    <small
                                        v-if="errors.income"
                                        class="text-danger"
                                        >{{ errors.income }}</small
                                    >
                                </div>

                                <div class="mt-2">
                                    <button
                                        v-if="!tabs[tabIndex].saved"
                                        type="submit"
                                        class="btn btn-success float-end"
                                    >
                                        <i class="bi bi-save"></i>
                                        Save
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
