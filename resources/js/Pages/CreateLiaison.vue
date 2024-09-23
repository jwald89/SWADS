<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { defineComponent, reactive } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import { Link } from "@inertiajs/vue3";

const errors = reactive({});

const data = reactive({
    lastname: "",
    firstname: "",
    middlename: "",
});

const submitData = async () => {
    try {
        const response = await axios.post("/liaison/post", data);
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
    LayoutApp,
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
                        <h5 class="fw-bold">Create Liaison</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            href="/liaison"
                        >
                            Back
                        </Link>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <form @submit.prevent="submitData">
                    <div class="form-group mt-4 mb-4">
                        <label for="">Lastname</label>
                        <input
                            type="text"
                            class="form-control form-control-md"
                            name="name"
                            id="name"
                            v-model="data.lastname"
                            :class="{ 'is-invalid': errors.lastname }"
                        />
                        <small v-if="errors.lastname" class="text-danger">{{
                            errors.lastname
                        }}</small>
                    </div>
                    <div class="form-group mt-4 mb-4">
                        <label for="">Firstname</label>
                        <input
                            type="text"
                            class="form-control form-control-md"
                            name="name"
                            id="name"
                            v-model="data.firstname"
                            :class="{ 'is-invalid': errors.firstname }"
                        />
                        <small v-if="errors.firstname" class="text-danger">{{
                            errors.firstname
                        }}</small>
                    </div>
                    <div class="form-group mt-4 mb-4">
                        <label for="">Middlename</label>
                        <input
                            type="text"
                            class="form-control form-control-md"
                            name="name"
                            id="name"
                            v-model="data.middlename"
                            :class="{ 'is-invalid': errors.middlename }"
                        />
                        <small v-if="errors.middlename" class="text-danger">{{
                            errors.middlename
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
