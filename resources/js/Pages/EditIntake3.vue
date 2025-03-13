<script setup>
import { inject } from "vue";
const intakes = inject("intakeData");
const submitForms = inject("submitFormP3");
const errors = inject("formErrors");
</script>

<template>
    <div
        class="tab-pane fade"
        id="circumstances-referral"
        role="tabpanel"
        aria-labelledby="contact-tab"
    >
        <div class="col-lg-12">
            <div
                class="card"
                v-for="referrals in intakes.referral"
                :key="referrals.id"
            >
                <div class="card-body mt-4">
                    <form class="row g-3" @submit.prevent="submitForms">
                        <textarea
                            class="form-control fw-bold"
                            rows="5"
                            id="referral"
                            name="referral"
                            v-model="referrals.content"
                            placeholder="Enter a referrral.."
                        >
                        </textarea>
                        <div class="mt-4">
                            <button
                                type="submit"
                                class="btn btn-success float-end"
                            >
                                <i class="bi bi-save"></i>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
