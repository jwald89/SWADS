<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { reactive } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import { Link } from "@inertiajs/vue3";

const errors = reactive({});

const data = reactive({
    municipality: "",
});

const submitData = async () => {
    try {
        const response = await axios.post("/municipality/post", data);
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
                        <h5 class="fw-bold">Create Municipality</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            href="/municipality"
                        >
                            Back
                        </Link>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <form @submit.prevent="submitData">
                    <div class="form-group mt-4 mb-4">
                        <label for=""
                            >Municipality<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control form-control-md"
                            name="name"
                            id="name"
                            v-model="data.municipality"
                            :class="{ 'is-invalid': errors.municipality }"
                        />
                        <small v-if="errors.municipality" class="text-danger">{{
                            errors.municipality
                        }}</small>
                    </div>
                    <div class="float-end">
                        <button type="submit" class="btn btn-md btn-success">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
