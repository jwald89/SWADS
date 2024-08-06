<script setup>
import { inject } from "vue";

const intakes = inject("intakeData");
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
                    <form
                        class="row g-3"
                        v-for="referrals in intakes.referral"
                        :key="referrals.id"
                    >
                        <label for="referral">Textarea:</label>
                        <textarea
                            class="form-control"
                            rows="5"
                            id="referral"
                            name="referral"
                            v-model="referrals.content"
                        >
                        </textarea>
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
