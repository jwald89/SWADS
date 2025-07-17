<script setup>
import { inject, watchEffect } from "vue";

const intakes = inject("intakeData");
const submitFormP4 = inject("submitFormP4");

const formatMoney = (value) => {
    if (isNaN(value) || value === null) return "₱0.00";

    const number = parseFloat(value);
    const formatted = number.toFixed(2);
    const parts = formatted.split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return `${parts.join(".")}`;
};

// Watch effect to initialize cash assistance
watchEffect(() => {
    intakes.remark.forEach((remarks) => {
        if (remarks && typeof remarks.cash_assistance !== "undefined") {
            remarks.cash_assistance = remarks.cash_assistance || 0;
        }
    });
});

// Handle input changes
const handleInput = (event, remarks) => {
    const rawValue = event.target.value.replace(/₱/g, "").replace(/,/g, "");
    remarks.cash_assistance = parseFloat(rawValue) || 0;
};
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
                        ></textarea>

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
                                    :value="
                                        formatMoney(remarks.cash_assistance)
                                    "
                                    @input="
                                        (event) => handleInput(event, remarks)
                                    "
                                    placeholder="0.00"
                                />
                            </div>
                        </div>

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
