<script setup>
import { defineComponent, inject, ref } from "vue";
import vSelect from "vue-select";

const form = inject("personalData");
const submitForm = inject("submitFormP1");
const errors = inject("formErrors");

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
                    <div class="card">
                        <div class="card-body row g-3 mt-1">
                            <div class="col-md-4">
                                <label for="classification"
                                    >Classification<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <select
                                    class="form-select"
                                    name="classification"
                                    id="classification"
                                    v-model="form.classification"
                                    :class="{
                                        'is-invalid': errors.classification,
                                    }"
                                >
                                    <option value="" default></option>
                                    <option value="non-poor 4Ps">
                                        Non-poor 4Ps
                                    </option>
                                    <option value="4Ps">4Ps</option>
                                </select>
                                <small
                                    v-if="errors.classification"
                                    class="text-danger"
                                    >{{ errors.classification }}</small
                                >
                            </div>
                            <div class="col-md-5">
                                <label for="category"
                                    >Please select type of assistance
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    name="category"
                                    id="category"
                                    :options="assistances.data"
                                    v-model="form.category"
                                    :reduce="(data) => data.name"
                                    label="name"
                                    :class="{
                                        'form-control is-invalid':
                                            errors.category,
                                    }"
                                >
                                </v-select>
                                <small
                                    v-if="errors.category"
                                    class="text-danger"
                                    >{{ errors.category }}</small
                                >
                            </div>
                            <div class="col-md-3">
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
                                                    :reduce="
                                                        (data) => data.barangay
                                                    "
                                                    label="barangay"
                                                    :class="{
                                                        'form-control is-invalid':
                                                            errors.barangay,
                                                    }"
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
                                                    :reduce="
                                                        (data) =>
                                                            data.municipality
                                                    "
                                                    label="municipality"
                                                    :class="{
                                                        'form-control is-invalid':
                                                            errors.municipality,
                                                    }"
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
                                        type="number"
                                        class="form-control"
                                        name="age"
                                        id="age"
                                        v-model="age"
                                        placeholder="Age"
                                        :class="{ 'is-invalid': errors.age }"
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
                                        <option
                                            v-for="gen in gender"
                                            :key="gen"
                                        >
                                            {{ gen }}
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
                                        placeholder="Mobile number or Tel number"
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

                                <div class="mt-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary float-end"
                                    >
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
