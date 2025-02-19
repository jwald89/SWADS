<script setup>
import { defineComponent, inject, watchEffect } from "vue";
import vSelect from "vue-select";

const submitForm = inject("submitFormP1");
const intakes = inject("intakeData");

defineProps({
    assistances: {
        type: String,
    },
    sectorType: {
        type: String,
    },
    indigents: {
        type: String,
    },
    officeCharge: {
        type: String,
    },
    municipality: {
        type: String,
    },
    barangays: {
        type: String,
    },
});

defineComponent({
    vSelect,
});

watchEffect(() => {
    intakes.category = parseInt(intakes.category);
    intakes.barangay = parseInt(intakes.barangay);
    intakes.municipality = parseInt(intakes.municipality);
    intakes.sector_type = parseInt(intakes.sector_type);
    intakes.ips = parseInt(intakes.ips);
    intakes.ofis_charge = parseInt(intakes.ofis_charge);
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
                    <h6 class="mt-2">Filter Section</h6>
                    <div class="card">
                        <div class="card-body row g-3 mt-1">
                            <div class="col-md-3">
                                <label for="classification"
                                    >Classification<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <select
                                    class="form-select"
                                    name="classification"
                                    id="classification"
                                    v-model="intakes.classification"
                                >
                                    <option value="non-4Ps">Non-4Ps</option>
                                    <option value="4Ps">4Ps</option>
                                    <option value="IPs">IPs</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="category"
                                    >Please select type of assistance
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    name="category"
                                    id="category"
                                    :options="assistances.data"
                                    :reduce="(data) => data.id"
                                    v-model="intakes.category"
                                    label="name"
                                >
                                </v-select>
                            </div>
                            <div class="col-md-3">
                                <label for="sector_type"
                                    >Sector
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    name="sector_type"
                                    id="sector_type"
                                    :options="sectorType.data"
                                    :reduce="(data) => data.id"
                                    v-model="intakes.sector_type"
                                    label="name"
                                >
                                </v-select>
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
                                    v-model="intakes.date_intake"
                                />
                            </div>

                            <div class="col-md-3">
                                <label for="ips"
                                    >IPs
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    name="ips"
                                    id="ips"
                                    :options="indigents.data"
                                    v-model="intakes.ips"
                                    :reduce="(data) => data.id"
                                    label="name"
                                >
                                </v-select>
                            </div>
                            <div class="col-md-3">
                                <label for="ofis_charge"
                                    >Office Charge
                                    <span class="text-danger">*</span></label
                                >
                                <v-select
                                    name="ofis_charge"
                                    id="ofis_charge"
                                    :options="officeCharge.data"
                                    v-model="intakes.ofis_charge"
                                    :reduce="(data) => data.id"
                                    label="description"
                                >
                                </v-select>
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
                                                    placeholder="Family name"
                                                    v-model="intakes.last_name"
                                                />
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
                                                    placeholder="Given name"
                                                    v-model="intakes.first_name"
                                                />
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
                                                    placeholder="Middle name"
                                                    v-model="
                                                        intakes.middle_name
                                                    "
                                                />
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
                                                    placeholder="Suffix"
                                                    v-model="intakes.extn_name"
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
                                                    placeholder="Purok"
                                                    v-model="intakes.purok"
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
                                                    placeholder="Sample St.,"
                                                    v-model="intakes.street"
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
                                                    :options="barangays.data"
                                                    :reduce="(data) => data.id"
                                                    id="barangay"
                                                    label="barangay"
                                                    v-model="intakes.barangay"
                                                >
                                                </v-select>
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
                                        v-model="intakes.birthdate"
                                    />
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
                                        placeholder="Age"
                                        v-model="intakes.age"
                                    />
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
                                        v-model="intakes.sex"
                                    >
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
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
                                    <label
                                        for="educ_attainment"
                                        class="form-label"
                                        >Educational Attainment</label
                                    >
                                    <span class="text-danger">*</span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="educ_attainment"
                                        name="educ_attainment"
                                        v-model="intakes.educ_attainment"
                                    />
                                </div>

                                <div class="col-md-6">
                                    <label for="occupation" class="form-label"
                                        >Occupation</label
                                    >
                                    <small> (optional)</small>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="occupation"
                                        name="occupation"
                                        placeholder="Job"
                                        v-model="intakes.job"
                                    />
                                </div>
                                <div class="col-md-4">
                                    <label for="contactNo" class="form-label"
                                        >Contact No.<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        class="form-control"
                                        id="contactNo"
                                        name="contact_no"
                                        placeholder="Mobile number or Tel number"
                                        v-model="intakes.contact_no"
                                    />
                                </div>
                                <div class="col-md-2">
                                    <label for="income" class="form-label"
                                        >Income</label
                                    >
                                    <small> (optional)</small>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="income"
                                        name="income"
                                        placeholder="Amount"
                                        v-model="intakes.income"
                                    />
                                </div>

                                <div class="mt-4">
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
