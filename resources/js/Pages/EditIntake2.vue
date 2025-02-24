<script setup>
import { inject } from "vue";
const intakes = inject("intakeData");
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
            <div
                class="card mb-2"
                v-for="(famCompose, index) in intakes.fam_compose"
                :key="famCompose.index"
            >
                <card-header class="bg-primary px-2 py-1 text-light">
                    Family Member No.
                    <span class="badge text-bg-light">{{ index + 1 }}</span>
                </card-header>
                <div class="card-body mt-2">
                    <form class="row g-3">
                        <div class="col-md-4">
                            <label for="lastName"
                                >Last name<span class="text-danger"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                class="form-control fw-bold"
                                id="lastName"
                                name="lastName"
                                placeholder="Family name"
                                v-model="famCompose.lastname"
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
                                class="form-control fw-bold"
                                id="firstName"
                                name="firstName"
                                placeholder="Given name"
                                v-model="famCompose.firstname"
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
                                class="form-control fw-bold"
                                id="middleName"
                                name="middleName"
                                placeholder="Middle name"
                                v-model="famCompose.middlename"
                            />
                        </div>
                        <div class="col-md-5">
                            <label for="age"
                                >Age<span class="text-danger">*</span></label
                            >
                            <input
                                type="text"
                                class="form-control fw-bold"
                                id="age"
                                name="age"
                                placeholder="age"
                                v-model="famCompose.age"
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
                                class="form-control fw-bold"
                                id="relationship"
                                name="relationship"
                                v-model="famCompose.relationship"
                            />
                        </div>
                        <div class="col-12">
                            <label for="educationalBg"
                                >Educational Attainment</label
                            >
                            <input
                                type="text"
                                class="form-control fw-bold"
                                id="educationalBg"
                                name="educationalBg"
                                v-model="famCompose.educ_attainment"
                            />
                        </div>
                        <div class="col-md-12">
                            <label for="remarks">Remarks</label>
                            <input
                                type="text"
                                class="form-control fw-bold"
                                id="remarks"
                                name="remarks"
                                v-model="famCompose.remarks"
                            />
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-4">
                <button
                    type="submit"
                    class="btn btn-success float-end"
                    @click="submitForm"
                >
                    <i class="bi bi-save"></i>
                    Update
                </button>
            </div>
        </div>
    </div>
</template>
