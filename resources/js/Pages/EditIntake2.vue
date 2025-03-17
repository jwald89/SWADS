<script setup>
import { inject, defineComponent, watchEffect } from "vue";
const intakes = inject("intakeData");
const submitForm = inject("submitFormP2");
import vSelect from "vue-select";
import axios from "axios";

defineProps({
    relationships: Object,
});

// Initialize fam_relation if it does not exist
watchEffect(() => {
    intakes.fam_compose.forEach((famCompose) => {
        if (famCompose?.relationship) {
            famCompose.relationship = parseInt(famCompose.relationship);
        }
    });
});

const addFamilyMember = () => {
    intakes.fam_compose.push({
        lastname: "",
        firstname: "",
        middlename: "",
        age: "",
        relationship: null,
        educ_attainment: "",
        remarks: "",
    });
};

const deleteFamilyMember = async (index, id) => {
    console.log("ID:", id);
    if (id) {
        try {
            alertify.confirm(
                "Remove Family Member",
                "Are you sure you want to remove this family member?",
                function () {
                    axios.delete(`/api/family-member/${id}`);
                    intakes.fam_compose.splice(index, 1);
                    console.log(`Family member with ID ${id} deleted.`);
                },
                () => {
                    console.log("Family member deletion cancelled.");
                }
            );
        } catch (error) {
            console.error("Error deleting family member:", error);
        }
    } else {
        intakes.fam_compose.splice(index, 1);
    }
};

defineComponent({
    vSelect,
});
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
                    <button
                        type="button"
                        class="btn btn-light btn-sm text-danger fw-bold float-end"
                        @click="deleteFamilyMember(index, famCompose.id)"
                    >
                        <i class="bi bi-trash"></i>
                        Remove
                    </button>
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
                                placeholder="Age"
                                v-model="famCompose.age"
                            />
                        </div>
                        <div class="col-md-7">
                            <label for="relationship"
                                >Relationship<span class="text-danger"
                                    >*</span
                                ></label
                            >
                            <v-select
                                class="fw-bold"
                                name="relationship"
                                id="relationship"
                                :options="relationships.data"
                                v-model="famCompose.relationship"
                                :reduce="(data) => data.id"
                                label="name"
                                placeholder="Select"
                            >
                            </v-select>
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
                    type="button"
                    class="btn btn-primary"
                    @click="addFamilyMember"
                >
                    <i class="bi bi-plus"></i>
                    Add Family Member
                </button>
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
