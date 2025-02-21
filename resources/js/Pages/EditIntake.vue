<script setup>
import { reactive, provide } from "vue";
import axios from "axios";
import LayoutApp from "../Shared/Layout.vue";
import EditIntake1 from "../Pages/EditIntake1.vue";
import EditIntake2 from "../Pages/EditIntake2.vue";
import EditIntake3 from "../Pages/EditIntake3.vue";
import EditIntake4 from "../Pages/EditIntake4.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { defineProps } from "vue";

const props = defineProps({
    intakes: Object,
    assistances: Object,
    sectorType: Object,
    indigents: Object,
    officeCharge: Object,
    municipality: Object,
    barangays: Object,
    classType: Object,
});

// initialize to inherit the data to the child file
const civilStatus = usePage().props.civilStatus;
const gender = usePage().props.gender;

// initialize error in form submission
const errors = reactive({});

// START PERSONAL INFORMATION //
const submitPersonalDetails = async () => {
    try {
        const response = await axios.put(
            `/intake/update/${props.intakes.id}`,
            props.intakes
        );

        toast.success("Record successfully updated.", {
            autoClose: 1000,
        });
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0];
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
provide("intakeData", props.intakes);
provide("submitFormP1", submitPersonalDetails);
// END SUBMIT PERSONAL INFORMATION //

// START SUBMIT FAMILY COMPOSITION //
const submitFamilyCompose = async () => {
    try {
        const response = await axios.put(
            `/intake/update/${props.intakes.id}`,
            props.intakes
        );

        toast.success("Record successfully updated.", {
            autoClose: 1000,
        });
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0];
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

provide("submitFormP2", submitFamilyCompose);
// END SUBMIT FAMILY COMPOSITION //

// START SUBMIT REFERRAL //
const submitReferral = async () => {
    try {
        const response = await axios.put(
            `/intake/update/${props.intakes.id}`,
            props.intakes
        );

        toast.success("Record successfully updated.", {
            autoClose: 1000,
        });
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0];
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

provide("submitFormP3", submitReferral);
// END SUBMIT REFERRAL //

// START SUBMIT REMARK //
const submitRemark = async () => {
    try {
        const response = await axios.put(
            `/intake/update/${props.intakes.id}`,
            props.intakes
        );

        toast.success("Record successfully updated.", {
            autoClose: 1000,
        });
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0];
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

provide("submitFormP4", submitRemark);
// END SUBMIT REMARK //
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
                        <h5 class="fw-bold">
                            Edit Record
                            <small class="font-monospace">(Intake Form)</small>
                        </h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            :href="`/intake`"
                        >
                            <i class="bi bi-backspace"></i>
                            Back
                        </Link>
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
                    <EditIntake1
                        :assistances="assistances"
                        :sectorType="sectorType"
                        :indigents="indigents"
                        :classType="classType"
                        :officeCharge="officeCharge"
                        :municipality="municipality"
                        :barangays="barangays"
                    />
                    <EditIntake2 />
                    <EditIntake3 />
                    <EditIntake4 />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
