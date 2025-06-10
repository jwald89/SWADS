<script setup>
import { inject } from "vue";

const tabs = inject("tabs");
const props = defineProps({
    index: Number,
});

const errors = inject("formErrors");
const form = inject("remarkForm");
const submitForm = inject("submitFormP4");

const tabIndex = 3;
</script>

<template>
    <div
        class="tab-pane fade"
        id="remarks-recommendation"
        :class="{ show: index == tabIndex, active: index == tabIndex }"
        role="tabpanel"
        aria-labelledby="contact-tab"
    >
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body mt-4">
                    <form class="row g-3" @submit.prevent="submitForm">
                        <textarea
                            class="form-control fw-bold"
                            rows="5"
                            id="recommendation"
                            name="recommendation"
                            v-model="form.content"
                            :class="{ 'is-invalid': errors.content }"
                            placeholder="Enter a remark.."
                        >
                        </textarea>
                        <small v-if="errors.content" class="text-danger">{{
                            errors.content
                        }}</small>

                        <div class="col-md-3">
                            <label for="cash_assistance"
                                >Amount of Financial Assistance</label
                            >
                            <span class="text-danger">*</span>
                            <div class="input-group">
                                <span
                                    class="input-group-text fw-bold fs-2 text-secondary"
                                    >₱</span
                                >
                                <input
                                    type="text"
                                    class="form-control fw-bold fs-2"
                                    id="cash_assistance"
                                    name="cash_assistance"
                                    v-model="form.cash_assistance"
                                    placeholder="0.00"
                                    :class="{
                                        'is-invalid': errors.cash_assistance,
                                    }"
                                />
                            </div>
                            <small
                                v-if="errors.cash_assistance"
                                class="text-danger"
                                >{{ errors.cash_assistance }}</small
                            >
                        </div>
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
