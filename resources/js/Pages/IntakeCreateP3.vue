<script setup>
import { inject } from "vue";

const form = inject("referralForm");
const submitForm = inject("submitFormP3");
</script>

<template>
    <div
        class="tab-pane fade"
        id="circumstances-referral"
        role="tabpanel"
        aria-labelledby="contact-tab"
    >
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body mt-4">
                    <form @submit.prevent="submitForm" class="row g-3">
                        <label for="referral">Textarea:</label>
                        <textarea
                            class="form-control"
                            rows="5"
                            id="referral"
                            name="referral"
                            v-model="form.content"
                        >
                Circumstances/ Referral</textarea
                        >
                        <div class="mt-4">
                            <button
                                type="submit"
                                class="btn btn-primary float-end"
                            >
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
