<script setup>
import { defineComponent, reactive, provide } from "vue";
import axios from "axios";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";
import IntakeCreateP1 from "../Pages/IntakeCreateP1.vue";
import IntakeCreateP2 from "../Pages/IntakeCreateP2.vue";
import IntakeCreateP3 from "../Pages/IntakeCreateP3.vue";
import IntakeCreateP4 from "../Pages/IntakeCreateP4.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

// initialize the data from the Personal Information model
const personalForm = reactive({
    id: "",
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

// create a store method for Personal Information form
const submitPersonalDetails = async () => {
    try {
        const response = await axios.post(
            "/intake/create-post/p1",
            personalForm
        );
        toast.success("Successfully updated.", {
            autoClose: 1000,
        });
        console.log("working..");
    } catch (error) {
        toast.error("Please fill in the blanks!", {
            autoClose: 2000,
        });
        console.error("Error submitting form:", error);
    }
};

// inherit the code to the child file
provide("personalData", personalForm);
provide("submitFormP1", submitPersonalDetails);

// initialize the data from the Family Compositions model
const familyForm = reactive({
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
    try {
        const response = await axios.post("/intake/create-post/p2", familyForm);
        toast.success("Successfully updated.", {
            autoClose: 2000,
        });
        console.log("working..");
    } catch (error) {
        toast.error("Please fill in the blanks!", {
            autoClose: 2000,
        });
        console.error("Error submitting form:", error);
    }
};

// inherit the code to the child file
provide("familyComposition", familyForm);
provide("submitFormP2", submitFamCompositions);

// initialize the data from the Referral model
const refForm = reactive({
    content: "",
});

// create a store method for Referral form
const submitRef = async () => {
    try {
        const response = await axios.post("/intake/create-post/p3", refForm);
        toast.success("Successfully updated.", {
            autoClose: 200,
        });
        console.log("working..");
    } catch (err) {
        toast.error("Please fill in the blank!", {
            autoColse: 2000,
        });
        console.log("Error submittinng form: ", err);
    }
};

// inherit the code to the child file
provide("referralForm", refForm);
provide("submitFormP3", submitRef);

// initialize the data from the Remark model
const remForm = reactive({
    content: "",
});

// create a store method for Remark form
const submitRem = async () => {
    try {
        await axios.post("/intake/create-post/p4", remForm);
        toast.success("Successfully updated.", {
            autoClose: 200,
        });
        console.log("working..");
    } catch (err) {
        toast.error("Please fill in the blank!", {
            autoClose: 200,
        });
        console.log("Error submittingn form: ", err);
    }
};

// inherit the code to the child file
provide("remarkForm", remForm);
provide("submitFormP4", submitRem);

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
    Link,
    Navbar,
    Sidebar,
    IntakeCreateP1,
    IntakeCreateP2,
    IntakeCreateP3,
    IntakeCreateP4,
});
</script>

<template>
    <Navbar />
    <Sidebar />
    <main class="main" id="main">
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
                    <IntakeCreateP2 :personal_id="personal_id" />
                    <IntakeCreateP3 />
                    <IntakeCreateP4 />
                </div>
            </div>
        </div>
    </main>
</template>
