<script setup>
import { inject } from "vue";

const props = defineProps({
    index: Number,
});
const tabIndex = 2;
const errors = inject("formErrors");
const form = inject("referralForm");
const submitForm = inject("submitFormP3");
const tabs = inject("tabs");
</script>

<template>
    <div
        class="tab-pane fade"
        id="circumstances-referral"
        :class="{ show: index == tabIndex, active: index == tabIndex }"
        role="tabpanel"
        aria-labelledby="contact-tab"
    >
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body mt-4">
                    <form @submit.prevent="submitForm" class="row g-3">
                        <textarea
                            class="form-control fw-bold"
                            rows="5"
                            id="referral"
                            name="referral"
                            v-model="form.content"
                            :class="{ 'is-invalid': errors.content }"
                            placeholder="Enter a referrral.."
                        >
                Circumstances/ Referral</textarea
                        >
                        <small v-if="errors.content" class="text-danger">{{
                            errors.content
                        }}</small>
                        <div class="mt-4">
                            <button
                                v-if="!tabs[tabIndex].saved"
                                type="submit"
                                class="btn btn-success float-end"
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
