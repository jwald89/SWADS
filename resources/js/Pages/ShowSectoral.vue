<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    sectoral: {
        type: Object,
    },
    createdBy: {
        type: String,
    },
    modifiedBy: {
        type: String,
    },
});

const formatDate = (dateString) => {
    const options = { year: "numeric", month: "short", day: "numeric" };
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", options).replace(".", ",");
};

const formatName = (fName) => {
    return fName
        .split(" ")
        .map(
            (word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        )
        .join(" ");
};
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-content-between">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Details</h5>
                    </div>
                    <div class="col-lg-6 text-end">
                        <Link
                            class="btn btn-sm btn-light"
                            :href="`/sectoral-data`"
                        >
                            <i class="bi bi-backspace"></i>
                            Back
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="row col-12 col-md-6">
                        <div class="mt-3 mb-4">
                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    First name:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{ formatName(sectoral.first_name) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Middle name:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.middle_name === null
                                            ? ""
                                            : formatName(sectoral.middle_name)
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Last name:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{ formatName(sectoral.last_name) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Age:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{ sectoral.age }} years old
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Sex:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{ formatName(sectoral.sex) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Birthdate:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.birthdate === null
                                            ? ""
                                            : formatDate(sectoral.birthdate)
                                    }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Place of birth:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.place_birth === null
                                            ? ""
                                            : formatName(sectoral.place_birth)
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Purok:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.purok === null
                                            ? "N/A"
                                            : formatName(sectoral.purok)
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Barangay:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{ sectoral.barangay.barangay }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Municipality:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{ sectoral.municipality.municipality }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Civil status:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.civil_status === null
                                            ? ""
                                            : formatName(sectoral.civil_status)
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Contact number:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.contact_no === null
                                            ? "N/A"
                                            : sectoral.contact_no
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Nationality:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.nationality === null
                                            ? "N/A"
                                            : formatName(sectoral.nationality)
                                    }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Religion:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.religion === null
                                            ? "N/A"
                                            : formatName(sectoral.religion)
                                    }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Created By:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{ props.createdBy }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Modified By:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{ props.modifiedBy }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Modified Date:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.modified_date === null
                                            ? ""
                                            : formatDate(sectoral.modified_date)
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-12 col-md-6">
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Date encoded:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.date_encoded === null
                                            ? ""
                                            : formatDate(sectoral.date_encoded)
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Sector type:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{ sectoral.sector.name }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Ethnicity:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.ethnicity === null
                                            ? "N/A"
                                            : formatName(
                                                  sectoral.indigent_type.name
                                              )
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Disability:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.physical_disability === null
                                            ? "N/A"
                                            : formatName(
                                                  sectoral.disability_type
                                                      .description
                                              )
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Facebook account:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.fb_accnt === null
                                            ? "N/A"
                                            : formatName(sectoral.fb_accnt)
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    School last attended:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.school_last_attend === null
                                            ? "N/A"
                                            : formatName(
                                                  sectoral.school_last_attend
                                              )
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Month and Year:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.month_year === null
                                            ? "N/A"
                                            : sectoral.month_year
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Skills:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.skills === null
                                            ? "N/A"
                                            : formatName(sectoral.skills)
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Interest and hobby:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.interest_hobby === null
                                            ? "N/A"
                                            : formatName(
                                                  sectoral.interest_hobby
                                              )
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Work experience:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.work_exp === null
                                            ? "N/A"
                                            : formatName(sectoral.work_exp)
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Organizational membership:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.org_membership === null
                                            ? "N/A"
                                            : formatName(
                                                  sectoral.org_membership
                                              )
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Family Members:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.fam_members === null
                                            ? "N/A"
                                            : sectoral.fam_members
                                    }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    ISY/OSY:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{ sectoral.ISY_OSY.toUpperCase() }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Position:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.position === null
                                            ? "N/A"
                                            : formatName(sectoral.position)
                                    }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-5 label fw-bold">
                                    Status:
                                </div>
                                <div class="col-6 col-md-7">
                                    {{
                                        sectoral.status === null
                                            ? ""
                                            : formatName(sectoral.status)
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
