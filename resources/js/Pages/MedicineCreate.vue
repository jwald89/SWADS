<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent, ref, reactive, computed, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import vSelect from "vue-select";
import { toast } from "vue3-toastify";
import axios from "axios";

const props = defineProps({
    municipalities: {
        type: Object,
        required: true,
    },
    barangays: {
        type: Object,
        required: true,
    },
    famRelationships: {
        type: Object,
        required: true,
    },
    errors: Object,
});

const errors = reactive({});

const form = reactive({
    first_name: "",
    middle_name: "",
    last_name: "",
    suffix: "",
    brgy: "",
    municipality: "",
    date_started: "",
    date_ended: "",
    pharmacy: "",
    amount: "",
    beneficiary: "",
    relationship: "",
    kinds_of_med: "",
    problem_present: "",
    assistance_need: "",
});

const barangayOptions = computed(() => {
    if (!form.municipality) return [];

    const list = Array.isArray(props.barangays)
        ? props.barangays
        : props.barangays?.data ?? [];

    return list.filter(
        (b) => Number(b.municipality_id) === Number(form.municipality)
    );
});

watch(
    () => form.municipality,
    () => {
        form.brgy = null;
    }
);

const resetForm = () => {
    form.first_name = "";
    form.middle_name = "";
    form.last_name = "";
    form.suffix = "";
    form.brgy = "";
    form.municipality = "";
    form.date_started = "";
    form.date_ended = "";
    form.pharmacy = "";
    form.amount = "";
    form.beneficiary = "";
    form.relationship = "";
    form.kinds_of_med = "";
    form.problem_present = "";
    form.assistance_need = "";
};

const submitForm = async () => {
    // Clear previous errors
    const fields = [
        "first_name",
        "middle_name",
        "last_name",
        "suffix",
        "brgy",
        "municipality",
        "date_started",
        "date_ended",
        "pharmacy",
        "amount",
        "beneficiary",
        "relationship",
        "kinds_of_med",
        "problem_present",
        "assistance_need",
    ];

    fields.forEach((field) => {
        if (form[field]) {
            errors[field] = "";
        }
    });

    // isSubmitting.value = true;

    try {
        const response = await axios.post("/medicine/post", form);

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
    }
    //  finally {
    //     isSubmitting.value = false;
    // }
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
                        <h5 class="fw-bold">Medicine Form</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            :href="`/medicine`"
                        >
                            <i class="bi bi-backspace"></i>
                            Back
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form @submit.prevent="submitForm">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>
                                <i class="bi bi-person-fill"></i> Person's Name
                            </h6>
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="row mb-2">
                                        <label
                                            for="lastname"
                                            class="col-sm-3 col-form-label"
                                            >Last name<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control fw-bold"
                                                name="lastname"
                                                id="lastname"
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
                                                >{{ errors.last_name }}</small
                                            >
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label
                                            for="firstname"
                                            class="col-sm-3 col-form-label"
                                            >First name<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control fw-bold"
                                                name="firstname"
                                                id="firstname"
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
                                                >{{ errors.first_name }}</small
                                            >
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label
                                            for="middlename"
                                            class="col-sm-3 col-form-label"
                                            >Middle name
                                            <small>(Optional)</small>
                                        </label>
                                        <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control fw-bold"
                                                name="middlename"
                                                id="middlename"
                                                v-model="form.middle_name"
                                                placeholder="Middle name"
                                            />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label
                                            for="suffix"
                                            class="col-sm-3 col-form-label"
                                            >Suffix
                                            <small> (Optional)</small>
                                        </label>
                                        <div class="col-sm-9">
                                            <select
                                                class="form-control fw-bold"
                                                id="suffix"
                                                name="suffix"
                                                v-model="form.suffix"
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
                                                <option value="II">II</option>
                                                <option value="III">III</option>
                                                <option value="IV">IV</option>
                                            </select>
                                        </div>
                                    </div>
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
                                                for="municipal"
                                                class="col-sm-3 col-form-label"
                                                >Municipality<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <div class="col-sm-9">
                                                <v-select
                                                    class="fw-bold"
                                                    name="municipal"
                                                    id="municipal"
                                                    :options="
                                                        municipalities.data
                                                    "
                                                    :reduce="(data) => data.id"
                                                    v-model="form.municipality"
                                                    label="municipality"
                                                    placeholder="Select"
                                                    :class="{
                                                        'is-invalid form-control':
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
                                        <div class="row mb-4">
                                            <label
                                                for="barangay"
                                                class="col-sm-3 col-form-label"
                                                >Barangay<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <div class="col-sm-9">
                                                <v-select
                                                    class="fw-bold"
                                                    name="barangay"
                                                    id="barangay"
                                                    :options="barangayOptions"
                                                    :reduce="(data) => data.id"
                                                    v-model="form.brgy"
                                                    label="barangay"
                                                    placeholder="Select"
                                                    :class="{
                                                        'is-invalid form-control':
                                                            errors.brgy,
                                                    }"
                                                    :disabled="
                                                        !form.municipality
                                                    "
                                                >
                                                </v-select>
                                                <small
                                                    v-if="errors.brgy"
                                                    class="text-danger"
                                                    >{{ errors.brgy }}</small
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
                            <div
                                class="d-flex justify-content-between mb-3 mt-3"
                            >
                                <div class="col-md-5">
                                    <label for="dateStarted"
                                        >Date Started<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="dateStarted"
                                        v-model="form.date_started"
                                        :class="{
                                            'is-invalid': errors.date_started,
                                        }"
                                    />
                                    <small
                                        v-if="errors.date_started"
                                        class="text-danger"
                                        >{{ errors.date_started }}</small
                                    >
                                </div>
                                <div class="col-md-5">
                                    <label for="dateEnded"
                                        >Date Ended<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="dateEnded"
                                        v-model="form.date_ended"
                                        :class="{
                                            'is-invalid': errors.date_ended,
                                        }"
                                    />
                                    <small
                                        v-if="errors.date_ended"
                                        class="text-danger"
                                        >{{ errors.date_ended }}</small
                                    >
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div class="col-md-5">
                                    <label for="pharmacy"
                                        >Pharmacy<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
                                        id="pharmacy"
                                        v-model="form.pharmacy"
                                        placeholder="Enter pharmacy.."
                                        :class="{
                                            'is-invalid': errors.pharmacy,
                                        }"
                                    />
                                    <small
                                        v-if="errors.pharmacy"
                                        class="text-danger"
                                        >{{ errors.pharmacy }}</small
                                    >
                                </div>
                                <div class="col-md-5">
                                    <label for="amount"
                                        >Amount<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
                                        id="amount"
                                        v-model="form.amount"
                                        placeholder="Enter amount.."
                                        :class="{
                                            'is-invalid': errors.amount,
                                        }"
                                    />
                                    <small
                                        v-if="errors.amount"
                                        class="text-danger"
                                        >{{ errors.amount }}</small
                                    >
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <div class="col-md-5">
                                    <label for="beneficiary">Beneficiary</label>
                                    <input
                                        type="text"
                                        class="form-control fw-bold"
                                        id="beneficiary"
                                        v-model="form.beneficiary"
                                        placeholder="Enter beneficiary.."
                                    />
                                </div>
                                <div class="col-md-5">
                                    <label for="relationship"
                                        >Relationship</label
                                    >
                                    <v-select
                                        class="fw-bold"
                                        name="relationship"
                                        id="relationship"
                                        :options="famRelationships.data"
                                        :reduce="(data) => data.id"
                                        v-model="form.relationship"
                                        label="name"
                                        placeholder="Select"
                                    >
                                    </v-select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="problemPresented"
                                    >Problem Presented<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <textarea
                                    class="form-control fw-bold"
                                    id="problemPresented"
                                    v-model="form.problem_present"
                                    placeholder="Enter problem presented.."
                                    rows="3"
                                    :class="{
                                        'is-invalid': errors.problem_present,
                                    }"
                                ></textarea>
                                <small
                                    v-if="errors.problem_present"
                                    class="text-danger"
                                    >{{ errors.problem_present }}</small
                                >
                            </div>
                            <div class="mb-3">
                                <label for="assistanceNeeded"
                                    >Assistance Needed<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <textarea
                                    class="form-control fw-bold"
                                    id="assistanceNeeded"
                                    v-model="form.assistance_need"
                                    placeholder="Enter assistance needed.."
                                    rows="3"
                                    :class="{
                                        'is-invalid': errors.assistance_need,
                                    }"
                                ></textarea>
                                <small
                                    v-if="errors.assistance_need"
                                    class="text-danger"
                                    >{{ errors.assistance_need }}</small
                                >
                            </div>
                            <div class="mb-2">
                                <label for=""
                                    >Kinds of Medicine<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control fw-bold"
                                    v-model="form.kinds_of_med"
                                    placeholder="Enter kinds of medicine.."
                                    :class="{
                                        'is-invalid': errors.kinds_of_med,
                                    }"
                                />
                                <small
                                    v-if="errors.kinds_of_med"
                                    class="text-danger"
                                    >{{ errors.kinds_of_med }}</small
                                >
                            </div>
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="btn btn-success mt-0 float-end"
                    >
                        <i class="bi bi-save"></i> Save
                    </button>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
