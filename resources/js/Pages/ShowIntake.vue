<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent, defineProps, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    intakes: {
        type: Object,
    },
    createdBy: String,
    modifiedBy: String,
});

const intakes = ref(props.intakes);

const formatName = (fName) => {
    if (fName == null) {
        return ""; // Return an empty string or handle null case as needed
    }

    return fName
        .split(" ")
        .map(
            (word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        )
        .join(" ");
};

defineComponent({
    Link,
    LayoutApp,
});
</script>

<template>
    <LayoutApp>
        <div class="clearfix mb-2">
            <div class="float-end">
                <Link :href="`/intake`" class="btn btn-sm btn-primary">
                    <i class="bi bi-backspace"></i>
                    Back
                </Link>
            </div>
        </div>

        <!-- Identifying Data Card -->
        <div class="card col-lg-12">
            <h6
                class="card-header text-light text-center fw-bold"
                style="background-color: #581b98"
            >
                IDENTIFYING DATA
            </h6>
            <div class="card-body">
                <div class="row col-lg-12 mt-2">
                    <!-- First Row Card -->
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Case No:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.case_no }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Classification:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.classific.name }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Ethnicity:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{
                                    intakes.indigent === null
                                        ? "N/A"
                                        : intakes.indigent.name
                                }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Assistance type:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.assistance.name }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Sector type:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.sector_name.name }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Office Charge:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.charging_office.description }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Date Intake:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.date_intake }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Case:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.case }}
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-lg-4 col-md-2 label fw-bold">
                                    First name:
                                </div>
                                <div class="col-lg-8 col-md-10">
                                    {{ formatName(intakes.first_name) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-2 label fw-bold">
                                    Middle name:
                                </div>
                                <div class="col-lg-8 col-md-10">
                                    {{ formatName(intakes.middle_name) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-2 label fw-bold">
                                    Last name:
                                </div>
                                <div class="col-lg-8 col-md-10">
                                    {{
                                        formatName(intakes.last_name) +
                                        (intakes.extn_name
                                            ? ", " + intakes.extn_name
                                            : "")
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-2 label fw-bold">
                                    Nickname:
                                </div>
                                <div class="col-lg-8 col-md-10">
                                    {{ formatName(intakes.nick_name) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of First Row Card -->

                    <!-- Second Row Card -->
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Purok:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ formatName(intakes.purok) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Street:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ formatName(intakes.street) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Barangay:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.brgy.barangay }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Municipality:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.municipal.municipality }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Birthdate:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.birthdate }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Age:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{
                                    intakes.age
                                        ? intakes.age + " years old"
                                        : ""
                                }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Sex:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ formatName(intakes.sex) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Civil Status:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ formatName(intakes.civil_stats) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Educational Attainment:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{
                                    intakes.educ_attainment === null
                                        ? ""
                                        : formatName(intakes.educ_attainment)
                                }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Occupation:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{
                                    intakes.job === null
                                        ? "NA"
                                        : formatName(intakes.job)
                                }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Contact No:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.contact_no }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-2 label fw-bold">
                                Income:
                            </div>
                            <div class="col-lg-8 col-md-10">
                                {{ intakes.income }}
                            </div>
                        </div>
                    </div>
                    <!-- End of Second Row Card -->
                </div>
            </div>
        </div>
        <!-- End Identifying Data Card -->

        <!-- Family Composition Card -->
        <div class="card col-lg-12">
            <h6
                class="card-header text-light text-center fw-bold"
                style="background-color: #581b98"
            >
                FAMILY COMPOSITION
            </h6>
            <div class="card-body">
                <div class="row mt-2">
                    <div
                        class="col-lg-12"
                        v-for="famCompose in intakes.fam_compose"
                        :key="famCompose.id"
                    >
                        <div class="d-flex justify-content-content col-lg-12">
                            <div class="d-flex col-lg-4">
                                <div class="label fw-bold">First name:</div>
                                <div class="ms-3">
                                    {{ formatName(famCompose.firstname) }}
                                </div>
                            </div>

                            <div class="d-flex col-lg-4">
                                <div class="label fw-bold">Middle name:</div>
                                <div class="ms-3">
                                    {{ formatName(famCompose.middlename) }}
                                </div>
                            </div>

                            <div class="d-flex col-lg-4">
                                <div class="label fw-bold">Last name:</div>
                                <div class="ms-3">
                                    {{ formatName(famCompose.lastname) }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex col-lg-12 mt-1">
                            <div class="d-flex col-lg-4">
                                <div class="label fw-bold">Age:</div>
                                <div class="ms-2">
                                    {{
                                        famCompose.age
                                            ? famCompose.age + " years old"
                                            : ""
                                    }}
                                </div>
                            </div>

                            <div class="d-flex col-lg-8 mt-1">
                                <div class="label fw-bold">Relationship:</div>
                                <div class="ms-3">
                                    {{ famCompose.fam_relation.name }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="label fw-bold">
                                Educational Attainment :
                            </div>
                            <div class="ms-3">
                                {{ famCompose.educ_attainment }}
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="label fw-bold">Remarks:</div>
                            <div class="ms-3">
                                {{ famCompose.remarks }}
                            </div>
                        </div>
                        <hr v-if="intakes.fam_compose.length > 1" />
                    </div>
                </div>
            </div>
        </div>
        <!-- End Family Composition Card -->

        <div class="row col-lg-12">
            <!-- Circumstances/Referral Card -->
            <div class="card col-lg-6">
                <h6
                    class="card-header text-light text-center fw-bold"
                    style="background-color: #581b98"
                >
                    CIRCUMSTANCES & REFERRAL
                </h6>
                <div class="card-body p-3">
                    <div
                        v-for="referral in intakes.referral"
                        :key="referral.id"
                    >
                        {{ referral.content }}
                    </div>
                </div>
            </div>
            <!-- End Circumstances/Referral Card -->

            <!-- Remark Card -->
            <div class="card col-lg-6">
                <h6
                    class="card-header text-light text-center fw-bold"
                    style="background-color: #581b98"
                >
                    REMARKS
                </h6>
                <div class="card-body p-3">
                    <div
                        v-for="remark in intakes.remark"
                        :key="remark.id"
                        class="mt-2"
                    >
                        {{ remark.content }}
                    </div>
                </div>
            </div>
            <!-- End Remark Card -->
        </div>
    </LayoutApp>
</template>
