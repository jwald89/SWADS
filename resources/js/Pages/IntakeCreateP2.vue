<script setup>
import { inject } from "vue";

const form = inject("familyComposition");
const submitForm = inject("submitFormP2");
</script>

<template>
    <div
        class="tab-pane fade"
        id="family-composition"
        role="tabpanel"
        aria-labelledby="profile-tab"
    >
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body mt-4">
                    <form class="row g-3" @submit.prevent="submitForm">
                        <div class="col-md-4">
                            <label for="lastName"
                                >Last name<span class="text-danger"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="lastName"
                                name="lastName"
                                placeholder="Family name"
                                v-model="form.lastname"
                            />
                        </div>
                        <div class="col-md-4">
                            <label for="firstName"
                                >First name<span class="text-danger"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="firstName"
                                name="firstName"
                                placeholder="Given name"
                                v-model="form.firstname"
                            />
                        </div>
                        <div class="col-md-4">
                            <label for="middleName"
                                >Middle name<span class="text-danger"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="middleName"
                                name="middleName"
                                placeholder="Middle name"
                                v-model="form.middlename"
                            />
                        </div>
                        <div class="col-md-5">
                            <label for="age"
                                >Age<span class="text-danger">*</span></label
                            >
                            <input
                                type="number"
                                class="form-control"
                                id="age"
                                name="age"
                                placeholder="age"
                                v-model="form.age"
                            />
                        </div>
                        <div class="col-md-7">
                            <label for="relationship"
                                >Relationship<span class="text-danger"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="relationship"
                                name="relationship"
                                v-model="form.relationship"
                            />
                        </div>
                        <div class="col-12">
                            <label for="educationalBg"
                                >Educational Attainment</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="educationalBg"
                                name="educationalBg"
                                v-model="form.educ_attainment"
                            />
                        </div>
                        <div class="col-md-12">
                            <label for="remarks">Remarks</label>
                            <input
                                type="text"
                                class="form-control"
                                id="remarks"
                                name="remarks"
                                v-model="form.remarks"
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
