<script setup>
import { inject } from "vue";

const errors = inject("formErrors");
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
                                :class="{ 'is-invalid': errors.lastname }"
                            />
                            <small v-if="errors.lastname" class="text-danger">{{
                                errors.lastname
                            }}</small>
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
                                :class="{ 'is-invalid': errors.firstname }"
                            />
                            <small
                                v-if="errors.firstname"
                                class="text-danger"
                                >{{ errors.firstname }}</small
                            >
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
                                :class="{ 'is-invalid': errors.middlename }"
                            />
                            <small
                                v-if="errors.middlename"
                                class="text-danger"
                                >{{ errors.middlename }}</small
                            >
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
                                :class="{ 'is-invalid': errors.age }"
                            />
                            <small v-if="errors.age" class="text-danger">{{
                                errors.age
                            }}</small>
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
                                :class="{ 'is-invalid': errors.relationship }"
                            />
                            <small
                                v-if="errors.relationship"
                                class="text-danger"
                                >{{ errors.relationship }}</small
                            >
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
                                :class="{
                                    'is-invalid': errors.educ_attainment,
                                }"
                            />
                            <small
                                v-if="errors.educ_attainment"
                                class="text-danger"
                                >{{ errors.educ_attainment }}</small
                            >
                        </div>
                        <div class="col-md-12">
                            <label for="remarks">Remarks</label>
                            <input
                                type="text"
                                class="form-control"
                                id="remarks"
                                name="remarks"
                                v-model="form.remarks"
                                :class="{ 'is-invalid': errors.remarks }"
                            />
                            <small v-if="errors.remarks" class="text-danger">{{
                                errors.remarks
                            }}</small>
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
