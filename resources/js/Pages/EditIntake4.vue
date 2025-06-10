<script setup>
import { inject } from "vue";

const intakes = inject("intakeData");
const submitFormP4 = inject("submitFormP4");

const unformat = (val) => {
    const numeric = parseFloat(val.replace(/,/g, ""));
    return isNaN(numeric) ? 0 : numeric;
};

const moneyFormat = (amount) => {
    return new Intl.NumberFormat("en-US", {
        style: "decimal",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(amount);
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
                                        moneyFormat(remarks.cash_assistance)
                                    "
                                    @input="
                                        remarks.cash_assistance = unformat(
                                            $event.target.value
                                        )
                                    "
                                    @blur="
                                        $event.target.value = moneyFormat(
                                            remarks.cash_assistance
                                        )
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
