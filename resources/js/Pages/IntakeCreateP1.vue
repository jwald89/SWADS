<script setup>
import { defineComponent, inject } from "vue";
import vSelect from "vue-select";

const form = inject("personalData");
const submitForm = inject("submitFormP1");

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
    errors: Object,
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
                                >
                                    <option value="" default></option>
                                    <option value="non-poor 4Ps">
                                        Non-poor 4Ps
                                    </option>
                                    <option value="4Ps">4Ps</option>
                                </select>
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
                                    v-model="form.date_intake"
                                />
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
                                                    v-model="form.first_name"
                                                    placeholder="Given name"
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
                                                    v-model="form.middle_name"
                                                    placeholder="Middle name"
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
                                                    id="municipal"
                                                    :options="municipality.data"
                                                    v-model="form.municipality"
                                                    :reduce="
                                                        (data) =>
                                                            data.municipality
                                                    "
                                                    label="municipality"
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
                                        v-model="form.age"
                                        placeholder="Age"
                                    />
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
                                        v-model="form.birthdate"
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
                                        id="gender"
                                        name="gender"
                                        v-model="form.sex"
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
                                        v-model="form.civil_stats"
                                    >
                                        <option
                                            v-for="civil in civilStatus"
                                            :key="civil"
                                        >
                                            {{ civil }}
                                        </option>
                                    </select>
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
                                        v-model="form.job"
                                        placeholder="Job"
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
                                        v-model="form.contact_no"
                                        placeholder="Mobile number or Tel number"
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
                                        v-model="form.income"
                                        placeholder="Amount"
                                    />
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
