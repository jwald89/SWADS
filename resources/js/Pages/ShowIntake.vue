<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent, defineProps, onMounted, watchEffect, ref } from "vue";
import axios from "axios";

const props = defineProps({
    intakes: {
        type: Object,
    },
});

const intakes = ref(props.intakes);

defineComponent({
    LayoutApp,
});
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="row row-cols-12">
                        <div
                            class="col border fw-bold p-2 text-center text-uppercase"
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
                            {{ intakes.category }}
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
                            class="col border fw-bold p-2 text-center text-uppercase"
                        >
                            Family Composition
                        </div>

                        <div
                            class="mb-2"
                            v-for="famCompose in intakes.fam_compose"
                            :key="famCompose.id"
                        >
                            <div class="row row-cols-6">
                                <div class="col-3 border fw-bold p-2">
                                    Fullname
                                </div>
                                <div class="col-9 border p-2">
                                    {{
                                        famCompose.lastname +
                                        ", " +
                                        famCompose.firstname +
                                        " " +
                                        famCompose.middlename
                                    }}
                                </div>
                            </div>
                            <div class="row row-cols-4">
                                <div class="col border fw-bold p-2">Age</div>
                                <div class="col border p-2">
                                    {{ famCompose.age }}
                                </div>
                                <div class="col border fw-bold p-2">
                                    Relationship
                                </div>
                                <div class="col border p-2">
                                    {{ famCompose.relationship }}
                                </div>
                            </div>
                            <div class="row row-cols-4">
                                <div class="col border fw-bold p-2">
                                    Education Attainment
                                </div>
                                <div class="col border p-2">
                                    {{ famCompose.educ_attainment }}
                                </div>
                                <div class="col border fw-bold p-2">Remark</div>
                                <div class="col border p-2">
                                    {{ famCompose.remarks }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-12 mt-3">
                        <div
                            class="col border fw-bold p-2 text-center text-uppercase"
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
                            class="col border fw-bold p-2 text-center text-uppercase"
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
