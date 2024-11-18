<script setup>
import { inject } from "vue";

const errors = inject("formErrors");
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
                            :class="{ 'is-invalid': errors.content }"
                        >
                Circumstances/ Referral</textarea
                        >
                        <small v-if="errors.content" class="text-danger">{{
                            errors.content
                        }}</small>
                        <div class="mt-4">
                            <button
                                type="submit"
                                class="btn btn-primary float-end"
                            >
                                <i class="bi bi-save"></i>
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
