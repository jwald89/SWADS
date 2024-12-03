<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import { defineComponent, reactive } from "vue";
import vSelect from "vue-select";
import axios from "axios";
import { toast } from "vue3-toastify";
import { Link } from "@inertiajs/vue3";

defineProps({
    barangays: {
        type: Object,
    },
    municipality: {
        type: Object,
    },
});

const errors = reactive({});

const brgyData = reactive({
    municipality_id: "",
    barangay: "",
});

const submitData = async () => {
    try {
        const response = await axios.post("/barangay/post", brgyData);
        toast.success("Successfully created!", {
            autoClose: 1000,
        });
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0];
                }
            }
            toast.error("Please fill in the blanks error!", {
                autoClose: 2000,
            });
            console.error("Error submitting form:", error);
        }
    }
};

defineComponent({
    vSelect,
});
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <div class="d-flex justify-space-around">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Create Barangay</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            :href="`/barangay`"
                        >
                            <i class="bi bi-backspace"></i>
                            Back
                        </Link>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <form @submit.prevent="submitData">
                    <div class="form-group mt-4">
                        <label for="">Municipality</label>
                        <span class="text-danger">*</span>
                        <small class="ms-2"
                            >(Please select your municipality)</small
                        >
                        <v-select
                            label="municipality"
                            name="municipality_id"
                            id="municipality_id"
                            :options="municipality.data"
                            :reduce="(data) => data.id"
                            v-model="brgyData.municipality_id"
                            :class="{
                                'form-control is-invalid':
                                    errors.municipality_id,
                            }"
                        >
                        </v-select>
                        <small
                            v-if="errors.municipality_id"
                            class="text-danger"
                            >{{ errors.municipality_id }}</small
                        >
                    </div>
                    <div class="form-group mt-4 mb-4">
                        <label for="">Barangay</label>
                        <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control form-control-md"
                            name="barangay"
                            id="barangay"
                            v-model="brgyData.barangay"
                            :class="{ 'is-invalid': errors.barangay }"
                        />
                        <small v-if="errors.barangay" class="text-danger">{{
                            errors.barangay
                        }}</small>
                    </div>
                    <div class="float-end">
                        <button type="submit" class="btn btn-md btn-success">
                            <i class="bi bi-save"></i>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
