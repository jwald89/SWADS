<script setup>
import LayoutApp from "../Shared/Layout.vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import vSelect from "vue-select";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    municipality: {
        type: Object,
        required: true,
    },
});

const roleTypes = ["USER", "ADMIN", "LIAISON", "MUNICIPAL"];

const submitUserData = async () => {
    try {
        const response = await axios.put(
            `/user/update/${props.users.id}`,
            props.users
        );
        toast.success("Record successfully updated!", {
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
        }

        console.error("Error submitting form:", error);
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
                        <h5 class="fw-bold">Edit User</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            :href="`/user-registration/index`"
                        >
                            <i class="bi bi-backspace"></i>
                            Back
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body px-5 mt-4">
                <form @submit.prevent="submitUserData">
                    <div class="row mb-3">
                        <label for="lastName" class="col-sm-1 col-form-label"
                            >Last name<span class="text-danger">*</span></label
                        >
                        <div class="col-sm-7">
                            <input
                                type="text"
                                class="form-control"
                                name="last_name"
                                id="last_name"
                                v-model="users.last_name"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lastName" class="col-sm-1 col-form-label"
                            >First name<span class="text-danger">*</span></label
                        >
                        <div class="col-sm-7">
                            <input
                                type="text"
                                class="form-control"
                                name="first_name"
                                id="first_name"
                                v-model="users.first_name"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lastName" class="col-sm-1 col-form-label"
                            >Middle initial<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <div class="col-sm-7">
                            <input
                                type="text"
                                class="form-control"
                                name="middle_name"
                                id="middle_name"
                                v-model="users.middle_init"
                            />
                        </div>
                    </div>
                    <hr width="70%" />
                    <div class="row mb-3 mt-4">
                        <label for="lastName" class="col-sm-1 col-form-label"
                            >Username<span class="text-danger">*</span></label
                        >
                        <div class="col-sm-7">
                            <input
                                type="text"
                                class="form-control"
                                name="username"
                                id="username"
                                v-model="users.username"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lastName" class="col-sm-1 col-form-label"
                            >Password<span class="text-danger">*</span></label
                        >
                        <div class="col-sm-7">
                            <input
                                type="password"
                                class="form-control"
                                name="password"
                                id="password"
                                v-model="users.password"
                            />
                        </div>
                    </div>
                    <hr width="70%" />
                    <div class="row mb-3 mt-4">
                        <label
                            for="municipality"
                            class="col-sm-1 col-form-label"
                            >Municipality<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <div class="col-sm-7">
                            <small>(Please select your municipality)</small>
                            <v-select
                                label="municipality"
                                name="municipality"
                                id="municipality"
                                :options="municipality.data"
                                :reduce="(data) => data.id"
                                v-model="users.municipality"
                            >
                            </v-select>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for=""
                            >Type of Role<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <div
                            class="form-check mt-2"
                            v-for="(role, index) in roleTypes"
                            :key="index"
                        >
                            <input
                                class="form-check-input"
                                type="radio"
                                :id="'role' + index"
                                :value="role"
                                v-model="users.role_type"
                            />
                            <label
                                class="form-check-label"
                                :for="'role' + index"
                            >
                                {{ role }}
                            </label>
                        </div>
                        <div class="float-end">
                            <button
                                type="submit"
                                class="btn btn-md btn-success"
                            >
                                <i class="bi bi-save"></i>
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </LayoutApp>
</template>
