<script setup>
import {
    defineComponent,
    inject,
    ref,
    computed,
    watchEffect,
    watch,
} from "vue";
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

/* ---------- Barangay options scoped to the selected municipality -------- */
const barangayOptions = computed(() => {
    if (!form.municipality) return [];

    // props.barangays can be either an array or { data: [...] }
    const list = Array.isArray(props.barangays)
        ? props.barangays
        : props.barangays?.data ?? [];

    return list.filter(
        (b) => Number(b.municipality_id) === Number(form.municipality)
    );
});

/*  Reset the chosen barangay every time the municipality changes  */
watch(
    () => form.municipality,
    () => {
        form.barangay = null;
    }
);

// Initialize refs
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
        // Update form age and local age ref
        form.age = calculatedAge;
        age.value = calculatedAge;
    } else {
        age.value = null;
        form.age = null;
    }
};

watchEffect(() => {
    birthdate.value = form.birthdate; // Sync birthdate with form
    calculateAge(); // Calculate age whenever birthdate changes
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
                    <h6 class="mt-2">
                        <i class="bi bi-filter-circle-fill"></i> Filter Section
                    </h6>
                    <div class="card">
                        <div class="card-body row g-2 mt-3">
                            <div class="col-md-3">
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
                                    class="fw-bold"
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
                                    class="fw-bold"
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
                                    class="fw-bold"
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
                                    class="form-control fw-bold"
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
                            <div class="col-md-3">
                                <label for="ips"
                                    >Ethnicity
                                    <small class="font-monospace"
                                        >(IPs Affiliates)</small
                                    ></label
                                >
                                <v-select
                                    class="fw-bold"
                                    name="ips"
                                    id="ips"
                                    :options="indigents.data"
                                    v-model="form.ips"
                                    :reduce="(data) => data.id"
                                    label="name"
                                    placeholder="Select"
                                ></v-select>
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
                                                    v-model="form.middle_name"
                                                    placeholder="Middle name"
                                                />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
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
                                                    v-model="form.extn_name"
                                                >
                                                    <option value="" disabled>
                                                        Select
                                                    </option>
                                                    <option value="Jr.">
                                                        Junior (Jr.)
                                                    </option>
                                                    <option value="Sr.">
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
                                            <div class="col-md-6">
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
                                                    v-model="form.purok"
                                                    placeholder="Purok"
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
                                                    v-model="form.street"
                                                    placeholder="Sample St.,"
                                                />
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
                                                    id="barangay"
                                                    :options="barangayOptions"
                                                    v-model="form.barangay"
                                                    :reduce="(data) => data.id"
                                                    label="barangay"
                                                    :class="{
                                                        'form-control is-invalid':
                                                            errors.barangay,
                                                    }"
                                                    placeholder="Select"
                                                    :disabled="
                                                        !form.municipality
                                                    "
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
                                    <label for="case"
                                        >Case <small>(Optional)</small></label
                                    >
                                    <textarea
                                        class="form-control fw-bold"
                                        rows="2"
                                        id="case"
                                        name="case"
                                        v-model="form.case"
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
                                        v-model="form.birthdate"
                                        @change="calculateAge"
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
                                        v-model="form.age"
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
                                    <label for="gender"
                                        >Gender<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        class="form-control fw-bold"
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
                                    <label for="civilStatus"
                                        >Civil Status<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        class="form-control fw-bold"
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
                                            {{
                                                civil
                                                    .split(" ")
                                                    .map(
                                                        (word) =>
                                                            word
                                                                .charAt(0)
                                                                .toUpperCase() +
                                                            word
                                                                .slice(1)
                                                                .toLowerCase()
                                                    )
                                                    .join(" ")
                                            }}
                                        </option>
                                    </select>
                                    <small
                                        v-if="errors.civil_stats"
                                        class="text-danger"
                                        >{{ errors.civil_stats }}</small
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label for="educ_attainment"
                                        >Educational Attainment</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
                                        id="educ_attainment"
                                        name="educ_attainment"
                                        v-model="form.educ_attainment"
                                    />
                                </div>

                                <div class="col-md-6">
                                    <label for="occupation">Occupation</label>
                                    <span class="text-danger">*</span>
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
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
                                    <label for="contactNo">Contact No.</label>
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
                                        id="contactNo"
                                        name="contact_no"
                                        v-model="form.contact_no"
                                        placeholder="Enter a phone or mobile number.."
                                    />
                                </div>

                                <div class="col-md-2">
                                    <label for="income">Income</label>
                                    <span class="text-danger">*</span>
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
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
