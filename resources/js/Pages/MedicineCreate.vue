<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import vSelect from "vue-select";

const form = ref({
    firstname: "",
    middlename: "",
    lastname: "",
    barangay: "",
    municipality: "",
    province: "",
    dateStarted: "",
    dateEnded: "",
    pharmacy: "",
    amount: "",
    assistanceType: "",
    beneficiary: "",
    relationship: "",
    problemPresented: "",
    assistanceNeeded: "",
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
                <form>
                    <div class="row">
                        <div class="col-md-7">
                            <h6>
                                <i class="bi bi-person-fill"></i> Person's Name
                            </h6>
                            <div class="card">
                                <div class="card-body p-4">
                                    <form>
                                        <div class="row mb-2">
                                            <label
                                                for="lastname"
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
                                                    name="lastname"
                                                    id="lastname"
                                                    v-model="form.lastname"
                                                    placeholder="Family name"
                                                />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label
                                                for="firstname"
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
                                                    name="firstname"
                                                    id="firstname"
                                                    v-model="form.firstname"
                                                    placeholder="Given name"
                                                />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label
                                                for="middlename"
                                                class="col-sm-2 col-form-label"
                                                >Middle name
                                                <small>(Optional)</small>
                                            </label>
                                            <div class="col-sm-10">
                                                <input
                                                    type="text"
                                                    class="form-control fw-bold"
                                                    name="middlename"
                                                    id="middlename"
                                                    placeholder="Middle name"
                                                />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label
                                                for="suffix"
                                                class="col-sm-2 col-form-label"
                                                >Suffix
                                                <small> (Optional)</small>
                                            </label>
                                            <div class="col-sm-10">
                                                <select
                                                    class="form-control fw-bold"
                                                    id="suffix"
                                                    name="suffix"
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
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <h6><i class="bi bi-house-fill"></i> Address</h6>
                            <div class="card">
                                <div class="card-body p-4">
                                    <form>
                                        <div class="row mb-2">
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
                                                    v-model="form.barangay"
                                                    label="barangay"
                                                    placeholder="Select"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
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
                                                    label="municipality"
                                                    placeholder="Select"
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
                            <div class="row mb-3 mt-3">
                                <div class="col-md-6">
                                    <label for="dateStarted"
                                        >Date Started<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="dateStarted"
                                        v-model="form.dateStarted"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label for="dateEnded"
                                        >Date Ended<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="dateEnded"
                                        v-model="form.dateEnded"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="pharmacy"
                                        >Pharmacy<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="pharmacy"
                                        v-model="form.pharmacy"
                                        placeholder="Enter pharmacy"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label for="amount"
                                        >Amount<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="amount"
                                        v-model="form.amount"
                                        placeholder="Enter amount"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="beneficiary">Beneficiary</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="beneficiary"
                                        v-model="form.beneficiary"
                                        placeholder="Enter beneficiary"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label for="relationship"
                                        >Relationship</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="relationship"
                                        v-model="form.relationship"
                                        placeholder="Enter relationship"
                                    />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="problemPresented"
                                    >Problem Presented<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <textarea
                                    class="form-control"
                                    id="problemPresented"
                                    v-model="form.problemPresented"
                                    placeholder="Enter problem presented"
                                    rows="3"
                                ></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="assistanceNeeded"
                                    >Assistance Needed<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <textarea
                                    class="form-control"
                                    id="assistanceNeeded"
                                    v-model="form.assistanceNeeded"
                                    placeholder="Enter assistance needed"
                                    rows="3"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success float-end">
                        <i class="bi bi-save"></i> Save
                    </button>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
