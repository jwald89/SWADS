<script setup>
import { defineComponent } from "vue";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";
import IntakeCreateP1 from "../Pages/IntakeCreateP1.vue";
import IntakeCreateP2 from "../Pages/IntakeCreateP2.vue";
import IntakeCreateP3 from "../Pages/IntakeCreateP3.vue";
import IntakeCreateP4 from "../Pages/IntakeCreateP4.vue";
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const civilStatus = usePage().props.civilStatus;

const props = defineProps({
    assistances: {
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
            <div class="card-header bg-dark text-white">
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
                    />
                    <IntakeCreateP2 />
                    <IntakeCreateP3 />
                    <IntakeCreateP4 />
                </div>
                <div class="mt-4 float-end">
                    <button type="button" class="btn btn-md btn-success">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>
