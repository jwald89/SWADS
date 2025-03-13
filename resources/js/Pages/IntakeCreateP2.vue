<script setup>
import { inject, ref, onMounted, defineComponent } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import vSelect from "vue-select";

const props = defineProps({
    index: Number,
    famRelation: Object,
});
// Inject the existing states and methods from the parent component
const errors = inject("formErrors");
const form = inject("familyComposition");
const submitForm = inject("submitFormP2");
const tabs = inject("tabs");
const selectedMember = ref(0);
const tabIndex = 1;

const emit = defineEmits(["incrementIndex"]);

// Ref to hold the list of family compositions from localStorage
const familyList = ref([]);

// Load saved data from local storage
const loadSavedFamilyData = () => {
    const savedData = localStorage.getItem("familyCompositions");
    if (savedData) {
        familyList.value = JSON.parse(savedData);
    }
};

const resetForm = () => {
    // Clear all the fields by setting them to their initial empty values
    form.lastname = "";
    form.firstname = "";
    form.middlename = "";
    form.age = "";
    form.relationship = "";
    form.educ_attainment = "";
    form.remarks = "";
    form.isEditMode = false;
};

// Save the form data to local storage
const saveToLocalStorage = async () => {
    const applicantId = localStorage.getItem("applicant_id");
    // Check if any required field in the form is empty
    const requiredFields = [
        "lastname",
        "firstname",
        "middlename",
        "age",
        "relationship",
        "educ_attainment",
        "remarks",
    ];
    let hasEmptyField = false;

    // Iterate over required fields and check if any field is empty
    requiredFields.forEach((field) => {
        if (!form[field]) {
            errors[field] = `${field} is required.`; // Set the error message for empty fields
            hasEmptyField = true; // Mark that there's at least one empty field
        } else {
            errors[field] = ""; // Clear the error if the field is not empty
        }
    });

    // If there is any empty field, stop execution and display an error toast
    if (hasEmptyField) {
        toast.error("Please fill out all required fields before saving.", {
            autoClose: 2000,
        });
        return;
    }

    // Check if there are any other form errors (if already validated)
    if (Object.values(errors).some((error) => error)) {
        toast.error("Please correct the form errors before saving.", {
            autoClose: 2000,
        });
        return;
    }

    // If validation passes, save the data to local storage
    const newEntry = { ...form, applicant_id: applicantId };

    familyList.value.push(newEntry);
    localStorage.setItem(
        "familyCompositions",
        JSON.stringify(familyList.value)
    );
    toast.success("You have successfully saved a person's data.", {
        autoClose: 2000,
    });

    // Clear the form after saving
    resetForm();
};

// Final submission to the database
const finalSubmit = async () => {
    try {
        const applicantId = localStorage.getItem("applicant_id");

        // Ensure that the applicantId exists before submission
        if (!applicantId) {
            toast.error(
                "Applicant ID not found. Please check the application process.",
                { autoClose: 2000 }
            );
            return;
        }

        // Retrieve family compositions from local storage
        const familyCompositionsFromStorage =
            localStorage.getItem("familyCompositions");

        let familyCompositions = [];

        // Check if data exists in local storage and parse it
        if (familyCompositionsFromStorage) {
            familyCompositions = JSON.parse(familyCompositionsFromStorage);
        } else {
            toast.error(
                "No family data found. Please fill in the fields then click 'Add Person' button, if not required click 'Skip' button.",
                { autoClose: 8000 }
            );
            return;
        }

        // Ensure each item has all required fields and map the data
        familyCompositions = familyCompositions.map((item) => ({
            ...item,
            applicant_id: applicantId,
            lastname: item.lastname || form.lastname,
            firstname: item.firstname || form.firstname,
            age: item.age || form.age,
            relationship: item.relationship || form.relationship,
            educ_attainment: item.educ_attainment || form.educ_attainment,
            remarks: item.remarks || form.remarks,
        }));

        // Submit the data to the backend
        const response = await axios.post(
            "/intake/create-post/p2",
            familyCompositions
        );

        // Clear localStorage after successful submission
        localStorage.removeItem("familyCompositions");

        // Clear the family list
        familyList.value = [];
        toast.success("You have successfully created a record!", {
            autoClose: 2000,
        });
        emit("incrementIndex", props.index);
    } catch (error) {
        toast.error("Failed to submit data. Please try again.", {
            autoClose: 2000,
        });
        console.error("Error submitting to the database:", error);
    }
};

const handleModifyFamilyMember = (member) => {
    selectedMember.value = member;
    form.lastname = familyList.value[member].lastname;
    form.firstname = familyList.value[member].firstname;
    form.middlename = familyList.value[member].middlename;
    form.age = familyList.value[member].age;
    form.relationship = familyList.value[member].relationship;
    form.educ_attainment = familyList.value[member].educ_attainment;
    form.remarks = familyList.value[member].remarks;
    form.isEditMode = true;
};

const handleRemoveFamilyMember = (member) => {
    familyList.value.splice(member, 1);
    localStorage.setItem(
        "familyCompositions",
        JSON.stringify(familyList.value)
    );
};

const handleUpdateFamilyMember = () => {
    familyList.value[selectedMember.value].lastname = form.lastname;
    familyList.value[selectedMember.value].firstname = form.firstname;
    familyList.value[selectedMember.value].middlename = form.middlename;
    familyList.value[selectedMember.value].age = form.age;
    familyList.value[selectedMember.value].relationship = form.relationship;
    familyList.value[selectedMember.value].educ_attainment =
        form.educ_attainment;
    familyList.value[selectedMember.value].remarks = form.remarks;
    form.isEditMode = false;

    localStorage.setItem(
        "familyCompositions",
        JSON.stringify(familyList.value)
    );

    toast.success("Successfully updated a person's record!", {
        autoClose: 2000,
    });

    resetForm();
};

// Load saved data when component is mounted
onMounted(() => {
    loadSavedFamilyData();
});

defineComponent({
    vSelect,
});
</script>

<template>
    <div
        class="tab-pane fade"
        id="family-composition"
        role="tabpanel"
        :class="{
            show: index == tabIndex,
            active: index == tabIndex,
        }"
        aria-labelledby="profile-tab"
    >
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body mt-4">
                    <form class="row g-3" @submit.prevent="saveToLocalStorage">
                        <!-- Form fields for family composition -->
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
                                class="form-control fw-bold"
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
                                class="form-control fw-bold"
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
                                type="text"
                                class="form-control fw-bold"
                                id="age"
                                name="age"
                                placeholder="Age"
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
                            <v-select
                                class="fw-bold"
                                name="relationship"
                                id="relationship"
                                :options="famRelation.data"
                                v-model="form.relationship"
                                :reduce="(data) => data.id"
                                label="name"
                                :class="{
                                    'form-control is-invalid':
                                        errors.relationship,
                                }"
                                placeholder="Select"
                            >
                            </v-select>
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
                                class="form-control fw-bold"
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
                                class="form-control fw-bold"
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
                                class="btn btn-primary float-start"
                            >
                                <i class="bi bi-person-plus"></i>
                                Add Person
                            </button>
                            <button
                                v-if="form.isEditMode"
                                @click="handleUpdateFamilyMember()"
                                type="button"
                                class="btn btn-success ms-2"
                            >
                                <i class="bi bi-person-plus"></i>
                                Update Person
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Final submission button -->
                <div class="card-footer bg-light">
                    <div class="row">
                        <div class="col-lg-12">
                            <button
                                @click="finalSubmit"
                                v-if="!tabs[tabIndex].saved"
                                class="btn btn-success float-end"
                            >
                                <i class="bi bi-save"></i>
                                Save
                            </button>
                            <button
                                @click="submitForm"
                                v-if="!tabs[tabIndex].saved"
                                class="btn btn-warning float-end me-3 fw-bold"
                            >
                                <i class="bi bi-skip-forward"></i>
                                Skip
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic display of family compositions below the form -->
            <div class="mt-0">
                <h5>Persons Lists</h5>
            </div>
            <div v-for="(item, index) in familyList" :key="index" class="card">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Lastname: </strong> {{ item.lastname }}
                        <br />
                        <strong>Firstname: </strong>{{ item.firstname }}
                        <br />
                        <strong>Middlename: </strong>{{ item.middlename }}
                        <br />
                        <strong>Age:</strong> {{ item.age }}<br />
                        <strong>Relationship:</strong> {{ item.relationship
                        }}<br />
                        <strong>Educational Attainment:</strong>
                        {{ item.educ_attainment }}<br />
                        <strong>Remarks:</strong> {{ item.remarks }}
                        <br />
                        <button
                            class="btn btn-primary btn-sm mt-2 me-1"
                            @click="handleModifyFamilyMember(index)"
                        >
                            Modify
                        </button>
                        <button
                            class="btn btn-danger btn-sm mt-2"
                            @click="handleRemoveFamilyMember(index)"
                        >
                            Remove
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
