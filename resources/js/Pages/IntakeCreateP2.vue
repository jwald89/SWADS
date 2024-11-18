<script setup>
import { inject, ref, onMounted } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";

// Inject the existing states and methods from the parent component
const errors = inject("formErrors");
const form = inject("familyComposition");
const submitForm = inject("submitFormP2"); // Existing form submission method for validation

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
};

// Save the form data to local storage
const saveToLocalStorage = async () => {
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
    const newEntry = { ...form };
    familyList.value.push(newEntry);
    localStorage.setItem(
        "familyCompositions",
        JSON.stringify(familyList.value)
    );
    toast.success("Data saved to local storage!", { autoClose: 2000 });

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
            console.log("SUCCESSFULLY ADDED! ", familyCompositions);
        } else {
            toast.error(
                "No family data found. Please save at least one entry.",
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
            middlename: item.middlename || form.middlename,
            age: item.age || form.age,
            relationship: item.relationship || form.relationship,
            educ_attainment: item.educ_attainment || form.educ_attainment,
            remarks: item.remarks || form.remarks,
        }));

        // Check the final data to be submitted
        console.log("Data to submit:", familyCompositions);

        // Submit the data to the backend
        const response = await axios.post(
            "/intake/create-post/p2",
            familyCompositions
        );

        // Clear localStorage after successful submission
        localStorage.removeItem("familyCompositions");

        // Update UI and notify the user
        familyList.value = []; // Clear the family list
        toast.success("Successfully submitted to the database!", {
            autoClose: 2000,
        });

        console.log("Data successfully stored in the database:", response.data);
    } catch (error) {
        toast.error("Failed to submit data. Please try again.", {
            autoClose: 2000,
        });
        console.error("Error submitting to the database:", error);
    }
};

// Load saved data when component is mounted
onMounted(() => {
    loadSavedFamilyData();
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
                                class="btn btn-success float-start"
                            >
                                <i class="bi bi-person-plus"></i>
                                Add Person
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Final submission button -->
                <div class="card-footer bg-light">
                    <button
                        @click="finalSubmit"
                        class="btn btn-primary float-end"
                    >
                        <i class="bi bi-save"></i>
                        Save
                    </button>
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
                            @click="editFamilyMember(index)"
                        >
                            Modify
                        </button>
                        <button
                            class="btn btn-danger btn-sm mt-2"
                            @click="deleteFamilyMember(index)"
                        >
                            Remove
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
