<script setup>
import { inject } from "vue";
const intakes = inject("intakeData");
const submitFormP4 = inject("submitFormP4");
</script>

<template>
    <div
        class="tab-pane fade"
        id="remarks-recommendation"
        role="tabpanel"
        aria-labelledby="contact-tab"
    >
        <div class="col-lg-12">
            <div
                class="card"
                v-for="remarks in intakes.remark"
                :key="remarks.id"
            >
                <div class="card-body mt-4">
                    <form class="row g-3" @submit.prevent="submitFormP4">
                        <textarea
                            class="form-control fw-bold"
                            rows="5"
                            id="recommendation"
                            name="recommendation"
                            v-model="remarks.content"
                            placeholder="Enter a remark.."
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
