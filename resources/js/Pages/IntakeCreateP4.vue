<script setup>
import { inject } from "vue";

const errors = inject("formErrors");
const form = inject("remarkForm");
const submitForm = inject("submitFormP4");
</script>

<template>
    <div
        class="tab-pane fade"
        id="remarks-recommendation"
        role="tabpanel"
        aria-labelledby="contact-tab"
    >
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body mt-4">
                    <form class="row g-3" @submit.prevent="submitForm">
                        <label for="recommendation">Textarea:</label>
                        <textarea
                            class="form-control"
                            rows="5"
                            id="recommendation"
                            name="recommendation"
                            v-model="form.content"
                            :class="{ 'is-invalid': errors.content }"
                        >
                Remarks/ Recommendation</textarea
                        >
                        <small v-if="errors.content" class="text-danger">{{
                            errors.content
                        }}</small>
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
