<script setup>
import { defineComponent, reactive, provide, ref, onMounted } from "vue";
import axios from "axios";
import LayoutApp from "../Shared/Layout.vue";
import IntakeCreateP1 from "../Pages/IntakeCreateP1.vue";
import IntakeCreateP2 from "../Pages/IntakeCreateP2.vue";
import IntakeCreateP3 from "../Pages/IntakeCreateP3.vue";
import IntakeCreateP4 from "../Pages/IntakeCreateP4.vue";
import { Link, usePage, router } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

const tabs = ref([
    {
        saved: false,
    },
    {
        saved: false,
    },
    {
        saved: false,
    },
    {
        saved: false,
    },
]);

// initialize the data from the Personal Information model
const personalForm = reactive({
    classification: "",
    ips: "",
    category: "",
    sector_type: "",
    ofis_charge: "",
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
    case: "",
    age: "",
    birthdate: "",
    sex: "",
    civil_stats: "",
    educ_attainment: "",
    job: "",
    contact_no: "",
    income: "",
});

// initialize error in form submission
const errors = reactive({});
const modalError = ref("");
const currentIndex = ref(0);

// create a store method for Personal Information form
const submitPersonalDetails = async () => {
    // Clear previous errors
    const fields = [
        "classification",
        "category",
        "sector_type",
        "ofis_charge",
        "ips",
        "date_intake",
        "last_name",
        "first_name",
        "middle_name",
        "nick_name",
        "barangay",
        "municipality",
        "age",
        "birthdate",
        "sex",
        "civil_stats",
        "job",
        "income",
    ];

    fields.forEach((field) => {
        if (personalForm[field]) {
            errors[field] = "";
        }
    });

    try {
        const response = await axios.post(
            "/intake/create-post/p1",
            personalForm
        );
        console.log("New record ID:", response.data.id);
        nextTab();
        toast.success("Successfully added.", {
            autoClose: 1000,
        });
        localStorage.setItem("applicant_id", response.data.id);
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
                modalError.value = errorMsg; // Use .value for ref
                const errorModal = new bootstrap.Modal(
                    document.getElementById("errorModal")
                );
                errorModal.show();
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
provide("tabs", tabs.value);

const nextTab = () => {
    tabs.value[currentIndex.value].saved = true;
    currentIndex.value++;
};

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

/**
 * create a store method for Family Compositions form where the values are null except the applicant_id
 */
const submitFamCompositions = async () => {
    try {
        const applicantId = localStorage.getItem("applicant_id");
        const famForm = {
            applicant_id: JSON.parse(applicantId),
            lastname: null,
            firstname: null,
            middlename: null,
            age: null,
            relationship: null,
            educ_attainment: null,
            remarks: null,
        };

        const response = await axios.post(
            "/intake/create-post/null/p2",
            famForm
        );

        nextTab();
    } catch (error) {
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
        toast.success("Successfully added.", {
            autoClose: 1000,
        });
        nextTab();
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

        toast.success("Successfully added.", {
            autoClose: 5000,
        });

        router.visit("/intake", {
            preserveScroll: true,
        });
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
    assistances: Object,
    sectorType: Object,
    municipality: Object,
    barangays: Object,
    indigents: Object,
    officeCharge: Object,
    classType: Object,
});

defineComponent({
    IntakeCreateP1,
    IntakeCreateP2,
    IntakeCreateP3,
    IntakeCreateP4,
});

// discard process then delete records on database table
const removeRecords = () => {
    const applicant = localStorage.getItem("applicant_id");

    alertify.confirm(
        "Are you sure you want to cancel this record?",
        function () {
            axios
                .post(`/api/remove-records`, {
                    id: applicant,
                    _method: "DELETE",
                })
                .then((response) => {
                    if (response.status === 200) {
                        localStorage.clear();
                        location.reload();
                    }
                })
                .catch((err) => {
                    alertify.error(
                        "Something went wrong, please contact the developer!"
                    );
                });
        },
        function () {
            alertify.message("Cancelled");
        }
    );
};

onMounted(() => {});
</script>

<template>
    <LayoutApp>
        <div
            class="modal fade"
            id="errorModal"
            tabindex="-1"
            aria-labelledby="errorModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h3 class="modal-title text-light" id="errorModalLabel">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Oops
                        </h3>
                        <button
                            type="button"
                            class="btn-close bg-light"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body fw-bold">
                        <h2>
                            {{ modalError }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Create Intake</h5>
                    </div>
                    <div class="col-lg-6 text-end">
                        <Link
                            class="btn btn-sm btn-light"
                            v-if="!personalForm.last_name"
                            :href="`/intake`"
                        >
                            <i class="bi bi-backspace"></i>
                            Back
                        </Link>

                        <button
                            class="btn btn-danger float-end"
                            @click="removeRecords()"
                            v-else
                        >
                            Discard
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body mt-4">
                <ul
                    class="nav nav-tabs nav-tabs-bordered d-flex"
                    id="borderedTabJustified"
                    role="tablist"
                >
                    <li
                        class="nav-item flex-fill col-12 col-md-3"
                        role="presentation"
                    >
                        <button
                            class="nav-link w-100"
                            :class="{
                                active: currentIndex == 0,
                            }"
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
                    <li
                        class="nav-item flex-fill col-12 col-md-3"
                        role="presentation"
                    >
                        <button
                            class="nav-link w-100"
                            id="profile-tab"
                            :class="{
                                active: currentIndex == 1,
                            }"
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
                    <li
                        class="nav-item flex-fill col-12 col-md-3"
                        role="presentation"
                    >
                        <button
                            class="nav-link w-100"
                            id="contact-tab"
                            :class="{
                                active: currentIndex == 2,
                            }"
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
                    <li
                        class="nav-item flex-fill col-12 col-md-3"
                        role="presentation"
                    >
                        <button
                            class="nav-link w-100"
                            id="contact-tab"
                            :class="{
                                active: currentIndex == 3,
                            }"
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
                        :index="currentIndex"
                        :assistances="assistances"
                        :sectorType="sectorType"
                        :indigents="indigents"
                        :officeCharge="officeCharge"
                        :classType="classType"
                        :civilStatus="civilStatus"
                        :municipality="municipality"
                        :barangays="barangays"
                        :gender="gender"
                    />
                    <IntakeCreateP2
                        @incrementIndex="nextTab"
                        :index="currentIndex"
                    />
                    <IntakeCreateP3 :index="currentIndex" />
                    <IntakeCreateP4 :index="currentIndex" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
