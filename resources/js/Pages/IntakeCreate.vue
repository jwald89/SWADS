<script setup>
import { defineComponent, reactive, provide } from "vue";
import axios from "axios";
import LayoutApp from "../Shared/Layout.vue";
import IntakeCreateP1 from "../Pages/IntakeCreateP1.vue";
import IntakeCreateP2 from "../Pages/IntakeCreateP2.vue";
import IntakeCreateP3 from "../Pages/IntakeCreateP3.vue";
import IntakeCreateP4 from "../Pages/IntakeCreateP4.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

// initialize the data from the Personal Information model
const personalForm = reactive({
    classification: "",
    category: "",
    date_intake: "",
    last_name: "",
    first_name: "",
    middle_name: "",
    extn_name: "",
    nick_name: "",
    purok: "",
    street: "",
    barangay: "",
    municipality: "",
    age: "",
    birthdate: "",
    sex: "",
    civil_stats: "",
    job: "",
    contact_no: "",
    income: "",
});

// initialize error in form submission
const errors = reactive({});

// create a store method for Personal Information form
const submitPersonalDetails = async () => {
    if (personalForm.classification) {
        errors.classification = "";
    }
    if (personalForm.category) {
        errors.category = "";
    }
    if (personalForm.date_intake) {
        errors.date_intake = "";
    }
    if (personalForm.last_name) {
        errors.last_name = "";
    }
    if (personalForm.first_name) {
        errors.first_name = "";
    }
    if (personalForm.middle_name) {
        errors.middle_name = "";
    }
    if (personalForm.nick_name) {
        errors.nick_name = "";
    }
    if (personalForm.barangay) {
        errors.barangay = "";
    }
    if (personalForm.municipality) {
        errors.municipality = "";
    }
    if (personalForm.age) {
        errors.age = "";
    }
    if (personalForm.birthdate) {
        errors.birthdate = "";
    }
    if (personalForm.sex) {
        errors.sex = "";
    }
    if (personalForm.civil_stats) {
        errors.civil_stats = "";
    }

    try {
        const response = await axios.post(
            "/intake/create-post/p1",
            personalForm
        );
        console.log("New record ID:", response.data.id);
        toast.success("Successfully updated.", {
            autoClose: 1000,
        });
        localStorage.setItem("applicant_id", response.data.id);
        console.log("working..");
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0]; // Capture the first error message for each field
                }
            }

            const errorMsg = error.response.data.error;
            if (errorMsg) {
                toast.error(errorMsg, {
                    autoClose: 10000,
                });
            } else {
                toast.error("Please fill in the blanks error!", {
                    autoClose: 2000,
                });
            }
        }

        console.error("Error submitting form:", error);
    }
};

// inherit the code to the child file
provide("personalData", personalForm);
provide("submitFormP1", submitPersonalDetails);

// initialize the data from the Family Compositions model
const familyForm = reactive({
    applicant_id: "",
    lastname: "",
    firstname: "",
    middlename: "",
    age: "",
    relationship: "",
    educ_attainment: "",
    remarks: "",
});

// create a store method for Family Compositions form
const submitFamCompositions = async () => {
    if (familyForm.lastname) {
        errors.lastname = "";
    }
    if (familyForm.firstname) {
        errors.firstname = "";
    }
    if (familyForm.middlename) {
        errors.middlename = "";
    }
    if (familyForm.age) {
        errors.age = "";
    }
    if (familyForm.relationship) {
        errors.relationship = "";
    }
    if (familyForm.educ_attainment) {
        errors.educ_attainment = "";
    }
    if (familyForm.remarks) {
        errors.remarks = "";
    }

    try {
        const applicantId = localStorage.getItem("applicant_id");
        familyForm.applicant_id = applicantId;

        const response = await axios.post("/intake/create-post/p2", familyForm);
        toast.success("Successfully updated.", {
            autoClose: 2000,
        });

        localStorage.setItem("id", response.data.id);
        localStorage.setItem("lastname", familyForm.lastname);
        localStorage.setItem("firstname", familyForm.firstname);
        localStorage.setItem("middlename", familyForm.middlename);
        localStorage.setItem("age", familyForm.age);
        localStorage.setItem("relationship", familyForm.relationship);
        localStorage.setItem("educ_attainment", familyForm.educ_attainment);
        localStorage.setItem("remarks", familyForm.remarks);

        console.log("working..");
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0];
                }
            }
            toast.error("Please fill in the blanks error!", {
                autoClose: 2000,
            });
        }
        console.error("Error submitting form:", error);
    }
};

// inherit the code to the child file
provide("familyComposition", familyForm);
provide("submitFormP2", submitFamCompositions);

// initialize the data from the Referral model
const refForm = reactive({
    applicant_id: "",
    content: "",
});

// create a store method for Referral form
const submitRef = async () => {
    if (refForm.content) {
        errors.content = "";
    }

    try {
        const applicantId = localStorage.getItem("applicant_id");
        refForm.applicant_id = applicantId;

        const response = await axios.post("/intake/create-post/p3", refForm);
        toast.success("Successfully updated.", {
            autoClose: 200,
        });
        console.log("working..");
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0]; // Capture the first error message for each field
                }
            }
            toast.error("Please fill in the blanks error!", {
                autoClose: 2000,
            });
        }
        console.error("Error submitting form:", error);
    }
};

// inherit the code to the child file
provide("referralForm", refForm);
provide("submitFormP3", submitRef);

// initialize the data from the Remark model
const remForm = reactive({
    applicant_id: "",
    content: "",
});

// create a store method for Remark form
const submitRem = async () => {
    if (remForm.content) {
        errors.content = "";
    }

    try {
        const applicantId = localStorage.getItem("applicant_id");
        remForm.applicant_id = applicantId;

        await axios.post("/intake/create-post/p4", remForm);
        toast.success("Successfully updated.", {
            autoClose: 200,
        });
        localStorage.clear();
        console.log("working..");
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0]; // Capture the first error message for each field
                }
            }
            toast.error("Please fill in the blanks error!", {
                autoClose: 2000,
            });
        }
        console.log("Error submitting form: ", error);
    }
};

// inherit the code to the child file
provide("remarkForm", remForm);
provide("submitFormP4", submitRem);
provide("formErrors", errors);

// initialize to inherit the data to the child file
const civilStatus = usePage().props.civilStatus;
const gender = usePage().props.gender;

const props = defineProps({
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
});

defineComponent({
    LayoutApp,
    IntakeCreateP1,
    IntakeCreateP2,
    IntakeCreateP3,
    IntakeCreateP4,
});
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-space-around">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Create Intake</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            href="/intake"
                            >Back</Link
                        >
                    </div>
                </div>
            </div>
            <div class="card-body mt-4">
                <ul
                    class="nav nav-tabs nav-tabs-bordered d-flex"
                    id="borderedTabJustified"
                    role="tablist"
                >
                    <li class="nav-item flex-fill" role="presentation">
                        <button
                            class="nav-link w-100 active"
                            id="home-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#identifying-data"
                            type="button"
                            role="tab"
                            aria-controls="home"
                            aria-selected="true"
                        >
                            I. IDENTIFYING DATA
                        </button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button
                            class="nav-link w-100"
                            id="profile-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#family-composition"
                            type="button"
                            role="tab"
                            aria-controls="profile"
                            aria-selected="false"
                        >
                            II. FAMILY COMPOSITION
                        </button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button
                            class="nav-link w-100"
                            id="contact-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#circumstances-referral"
                            type="button"
                            role="tab"
                            aria-controls="contact"
                            aria-selected="false"
                        >
                            III. CIRCUMSTANCES & REFERRAL
                        </button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button
                            class="nav-link w-100"
                            id="contact-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#remarks-recommendation"
                            type="button"
                            role="tab"
                            aria-controls="contact"
                            aria-selected="false"
                        >
                            IV. REMARKS/ RECOMMENDATIONS
                        </button>
                    </li>
                </ul>
                <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                    <IntakeCreateP1
                        :assistances="assistances"
                        :civilStatus="civilStatus"
                        :municipality="municipality"
                        :barangays="barangays"
                        :gender="gender"
                    />
                    <IntakeCreateP2 />
                    <IntakeCreateP3 />
                    <IntakeCreateP4 />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
