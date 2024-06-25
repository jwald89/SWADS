<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent, defineProps, onMounted } from "vue";
import axios from "axios";

const props = defineProps({
    intakes: {
        type: Object,
    },
});

const getData = async () => {
    try {
        const response = await axios.get("/intake/show/{{ $intake->id }}");
        props.value = response.data.data;
        console.log("Data fetched successfully.");
    } catch (error) {
        console.error("Error submitting form:", error);
    }
};

onMounted(() => {
    getData();
});

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
                        <div class="col border p-2">4Ps</div>
                        <div class="col border fw-bold p-2">Category</div>
                        <div class="col border p-2">
                            Financial/ Special Case
                        </div>
                        <div class="col border fw-bold p-2">Date Intake</div>
                        <div class="col border p-2">June 25, 2024</div>
                    </div>
                    <div class="row row-cols-8">
                        <div class="col border fw-bold p-2">Lastname</div>
                        <div class="col border p-2">Doe</div>
                        <div class="col border fw-bold p-2">Firstname</div>
                        <div class="col border p-2">John</div>
                        <div class="col border fw-bold p-2">Middlename</div>
                        <div class="col border p-2">Jane</div>
                        <div class="col border fw-bold p-2">Nickname</div>
                        <div class="col border p-2">John Paul</div>
                    </div>
                    <div class="row row-cols-8">
                        <div class="col border fw-bold p-2">Age</div>
                        <div class="col border p-2">35</div>
                        <div class="col border fw-bold p-2">Birthdate</div>
                        <div class="col border p-2">July 1, 1989</div>
                        <div class="col border fw-bold p-2">Sex</div>
                        <div class="col border p-2">Male</div>
                        <div class="col border fw-bold p-2">Civil Status</div>
                        <div class="col border p-2">Single</div>
                    </div>
                    <div class="row row-cols-8">
                        <div class="col border fw-bold p-2">Purok</div>
                        <div class="col border p-2">Marigold</div>
                        <div class="col border fw-bold p-2">Street</div>
                        <div class="col border p-2">Serra</div>
                        <div class="col border fw-bold p-2">Barangay</div>
                        <div class="col border p-2">Bongtud</div>
                        <div class="col border fw-bold p-2">Municipal</div>
                        <div class="col border p-2">Tandag City</div>
                    </div>
                    <div class="row row-cols-6">
                        <div class="col border fw-bold p-2">Job</div>
                        <div class="col border p-2">Junior Web Developer</div>
                        <div class="col border fw-bold p-2">Contact No.</div>
                        <div class="col border p-2">09122010924</div>
                        <div class="col border fw-bold p-2">Income</div>
                        <div class="col border p-2">20,000</div>
                    </div>
                    <div class="row row-cols-12 mt-3">
                        <div
                            class="col border fw-bold p-2 text-center text-uppercase"
                        >
                            Family Composition
                        </div>
                    </div>
                    <div class="row row-cols-6">
                        <div class="col-3 border fw-bold p-2">Fullname</div>
                        <div class="col-9 border p-2">Ocso, Reynand Verano</div>
                    </div>
                    <div class="row row-cols-4">
                        <div class="col border fw-bold p-2">Age</div>
                        <div class="col border p-2">24</div>
                        <div class="col border fw-bold p-2">Relationship</div>
                        <div class="col border p-2">Son</div>
                    </div>
                    <div class="row row-cols-4">
                        <div class="col border fw-bold p-2">
                            Education Attainment
                        </div>
                        <div class="col border p-2">High School Level</div>
                        <div class="col border fw-bold p-2">Remark</div>
                        <div class="col border p-2">Patient</div>
                    </div>
                    <div class="row row-cols-12 mt-3">
                        <div
                            class="col border fw-bold p-2 text-center text-uppercase"
                        >
                            Circumstances of Referral
                        </div>
                    </div>
                    <div class="row row-cols-12">
                        <div
                            class="col border p-3"
                            style="text-indent: 2em; text-align: justify"
                        >
                            The client came to our office seeking for medical
                            assistance. Her daughter has an auditory problem
                            according to the diagnosis of Dr. Irvin A.
                            Bendanillo. Her daughter was advised to undergo ABR
                            and ASSR in Kamatage Hearing and Health Solutions.
                            The work of her common-law partner is construction
                            worker. His income is just enough in the basic needs
                            of the family. They have limited source of income
                            that hinders the medical procedures of her daughter.
                            Moreover, she shared that the income of her
                            common-law partner is seasonal, sometimes her
                            common-law partner works in construction sites and
                            sometimes planting rice in the rice field. The
                            resources of the family were exhausted already due
                            to expensive medicines and high cost living.
                        </div>
                    </div>
                    <div class="row row-cols-12 mt-3">
                        <div
                            class="col border fw-bold p-2 text-center text-uppercase"
                        >
                            Remarks/ Recommendations
                        </div>
                    </div>
                    <div class="row row-cols-12">
                        <div
                            class="col border p-3"
                            style="text-indent: 2em; text-align: justify"
                        >
                            Per information gathered, the PSWDO office will
                            refer the client to DSWD for medical assistance.
                            Furthermore, the client needs cash assistance for
                            food allowance and transportation. The medical
                            condition of her child needs to address immediately
                            to prevent worst condition of the medical condition.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
