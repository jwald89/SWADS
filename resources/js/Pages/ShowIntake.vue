<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent, defineProps, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    intakes: {
        type: Object,
    },
});

const intakes = ref(props.intakes);

defineComponent({
    Link,
    LayoutApp,
});
</script>

<template>
    <LayoutApp>
        <div class="clearfix mb-2">
            <div class="float-end">
                <Link :href="`/intake`" class="btn btn-md btn-outline-dark">
                    <i class="bi bi-backspace"></i>
                    Back
                </Link>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="row row-cols-12">
                        <div
                            class="col border fw-bold p-2 text-center text-uppercase text-white"
                            style="background-color: #581b98"
                        >
                            Identifying Data
                        </div>
                    </div>
                    <div class="row row-cols-6">
                        <div class="col border fw-bold p-2">Classification</div>
                        <div class="col border p-2">
                            {{ intakes.classification }}
                        </div>
                        <div class="col border fw-bold p-2">Category</div>
                        <div class="col border p-2">
                            {{ intakes.assistance.name }}
                        </div>
                        <div class="col border fw-bold p-2">Date Intake</div>
                        <div class="col border p-2">
                            {{ intakes.date_intake }}
                        </div>
                    </div>
                    <div class="row row-cols-8">
                        <div class="col border fw-bold p-2">Lastname</div>
                        <div class="col border p-2">
                            {{ intakes.last_name }}
                        </div>
                        <div class="col border fw-bold p-2">Firstname</div>
                        <div class="col border p-2">
                            {{ intakes.first_name }}
                        </div>
                        <div class="col border fw-bold p-2">Middlename</div>
                        <div class="col border p-2">
                            {{ intakes.middle_name }}
                        </div>
                        <div class="col border fw-bold p-2">Nickname</div>
                        <div class="col border p-2">
                            {{ intakes.nick_name }}
                        </div>
                    </div>
                    <div class="row row-cols-8">
                        <div class="col border fw-bold p-2">Age</div>
                        <div class="col border p-2">{{ intakes.age }}</div>
                        <div class="col border fw-bold p-2">Birthdate</div>
                        <div class="col border p-2">
                            {{ intakes.birthdate }}
                        </div>
                        <div class="col border fw-bold p-2">Sex</div>
                        <div class="col border p-2">{{ intakes.sex }}</div>
                        <div class="col border fw-bold p-2">Civil Status</div>
                        <div class="col border p-2">
                            {{ intakes.civil_stats }}
                        </div>
                    </div>
                    <div class="row row-cols-8">
                        <div class="col border fw-bold p-2">Purok</div>
                        <div class="col border p-2">{{ intakes.purok }}</div>
                        <div class="col border fw-bold p-2">Street</div>
                        <div class="col border p-2">{{ intakes.street }}</div>
                        <div class="col border fw-bold p-2">Barangay</div>
                        <div class="col border p-2">{{ intakes.barangay }}</div>
                        <div class="col border fw-bold p-2">Municipal</div>
                        <div class="col border p-2">
                            {{ intakes.municipality }}
                        </div>
                    </div>
                    <div class="row row-cols-6">
                        <div class="col border fw-bold p-2">Job</div>
                        <div class="col border p-2">{{ intakes.job }}</div>
                        <div class="col border fw-bold p-2">Contact No.</div>
                        <div class="col border p-2">
                            {{ intakes.contact_no }}
                        </div>
                        <div class="col border fw-bold p-2">Income</div>
                        <div class="col border p-2">{{ intakes.income }}</div>
                    </div>
                    <div class="row row-cols-12 mt-3">
                        <div
                            class="col border fw-bold p-2 text-center text-uppercase text-white"
                            style="background-color: #581b98"
                        >
                            Family Composition
                        </div>

                        <div class="table-response px-1">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Relationship</th>
                                        <th>Educational Attainment</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody
                                    v-for="famCompose in intakes.fam_compose"
                                    :key="famCompose.id"
                                >
                                    <tr>
                                        <td>
                                            {{
                                                famCompose.lastname +
                                                ", " +
                                                famCompose.firstname +
                                                " " +
                                                famCompose.middlename
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{ famCompose.age }} years old
                                        </td>
                                        <td class="text-center">
                                            {{ famCompose.relationship }}
                                        </td>
                                        <td class="text-center">
                                            {{ famCompose.educ_attainment }}
                                        </td>
                                        <td class="text-center">
                                            {{ famCompose.remarks }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row row-cols-12 mt-3">
                        <div
                            class="col border fw-bold p-2 text-center text-uppercase text-white"
                            style="background-color: #581b98"
                        >
                            Circumstances of Referral
                        </div>
                    </div>
                    <div
                        class="row row-cols-12"
                        v-for="referral in intakes.referral"
                        :key="referral"
                    >
                        <div
                            class="col border p-3"
                            style="text-indent: 2em; text-align: justify"
                        >
                            {{ referral.content }}
                        </div>
                    </div>
                    <div class="row row-cols-12 mt-3">
                        <div
                            class="col border fw-bold p-2 text-center text-uppercase text-white"
                            style="background-color: #581b98"
                        >
                            Remarks/ Recommendations
                        </div>
                    </div>
                    <div
                        class="row row-cols-12"
                        v-for="remark in intakes.remark"
                        :key="remark.id"
                    >
                        <div
                            class="col border p-3"
                            style="text-indent: 2em; text-align: justify"
                        >
                            {{ remark.content }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
