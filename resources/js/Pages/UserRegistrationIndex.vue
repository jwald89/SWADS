<script setup>
import LayoutApp from "../Shared/Layout.vue";
import { ref, watch, reactive } from "vue";
import { debounce } from "lodash";
import { Link, router } from "@inertiajs/vue3";
import Pagination from "../components/Pagination.vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import vSelect from "vue-select";

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    search: {
        type: String,
        default: "",
    },
    municipality: {
        type: Object,
        required: true,
    },
});

const errors = reactive({});

const userData = reactive({
    last_name: "",
    first_name: "",
    middle_init: "",
    username: "",
    password: "",
    municipality: "",
    role_type: "",
});

const roleTypes = ["USER", "ADMIN", "LIAISON", "MUNICIPAL"];

const resetForm = () => {
    userData.last_name = "";
    userData.first_name = "";
    userData.middle_init = "";
    userData.username = "";
    userData.password = "";
    userData.municipality = "";
    userData.role_type = "";
};

const submitUserData = async () => {
    if (userData.last_name) {
        errors.last_name = "";
    }
    if (userData.first_name) {
        errors.first_name = "";
    }
    if (userData.middle_init) {
        errors.middle_init = "";
    }
    if (userData.username) {
        errors.username = "";
    }
    if (userData.password) {
        errors.password = "";
    }
    if (userData.municipality) {
        errors.municipality = "";
    }
    if (userData.role_type) {
        errors.role_type = "";
    }
    try {
        const response = await axios.post("/user/post", userData);

        props.users.data.unshift(response.data); // update the data table after the submission
        toast.success("Successfully created!", {
            autoClose: 1000,
        });

        router.visit("/user-registration/index", {
            preserveScroll: true,
        });

        const modalElement = document.querySelector("#addUser"); // For Add Modal
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }

        resetForm();
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    errors[key] = validationErrors[key][0]; // Capture the first error message for each field
                }
            }
            toast.error("Please fill in the blanks error!", {
                autoClose: 2000,
            });
        }

        console.error("Error submitting form:", error);
    }
};

// For Edit Modal
const editData = reactive({
    id: null,
    first_name: "",
    middle_init: "",
    last_name: "",
    username: "",
    password: "",
    municipality: "",
    role_type: "",
});

// Edit Process
const fetchEditData = async (id) => {
    try {
        const response = await axios.get(`/user/edit/${id}`);
        editData.id = response.data.id;
        editData.first_name = response.data.first_name;
        editData.middle_init = response.data.middle_init;
        editData.last_name = response.data.last_name;
        editData.username = response.data.username;
        editData.password = response.data.password;
        editData.municipality = response.data.municipality;
        editData.role_type = response.data.role_type;
    } catch (error) {
        toast.error("Failed to fetch data for editing.", { autoClose: 2000 });
        console.error(error);
    }
};

// Update User Data
const updateData = async () => {
    try {
        const response = await axios.put(
            `/user/update/${editData.id}`,
            editData
        );

        const modalElement = document.querySelector("#editUser"); // For Add Modal
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }

        toast.success("Your data successfully updated!", { autoClose: 3000 });

        router.visit("/user-registration/index", {
            preserveScroll: true,
        });

        // Find and update the specific item in the table
        const index = props.users.data.findIndex(
            (item) => item.id === editData.id
        );

        if (index !== -1) {
            props.users.data[index] = response.data;
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            Object.keys(validationErrors).forEach((key) => {
                errors[key] = validationErrors[key][0];
            });
            toast.error("Validation error. Check your input.", {
                autoClose: 2000,
            });
        }
    }
};

const search = ref(props.search || "");

watch(
    search,
    debounce(() => {
        router.visit(`/user-registration/index?search=${search.value}`, {
            preserveState: true,
            preserveScroll: true,
        });
    }, 500)
);
</script>

<template>
    <LayoutApp>
        <!-- ADD MODAL FORM -->
        <div
            class="modal fade"
            id="addUser"
            tabindex="-1"
            aria-labelledby="addStaffLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div
                        class="modal-header text-light"
                        style="background-color: #581b98"
                    >
                        <h1 class="modal-title fs-5" id="addStaffLabel">
                            Create User
                        </h1>
                        <button
                            type="button"
                            class="btn-close bg-white"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="card-body px-5 mt-4">
                        <form @submit.prevent="submitUserData">
                            <div class="row mb-3">
                                <label
                                    for="lastName"
                                    class="col-sm-2 col-form-label"
                                    >Last name<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="last_name"
                                        id="last_name"
                                        v-model="userData.last_name"
                                        :class="{
                                            'is-invalid': errors.last_name,
                                        }"
                                        placeholder="Surname"
                                    />
                                    <small
                                        v-if="errors.last_name"
                                        class="text-danger"
                                        >{{ errors.last_name }}</small
                                    >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="firstName"
                                    class="col-sm-2 col-form-label"
                                    >First name<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="first_name"
                                        id="first_name"
                                        v-model="userData.first_name"
                                        :class="{
                                            'is-invalid': errors.first_name,
                                        }"
                                        placeholder="Firstname"
                                    />
                                    <small
                                        v-if="errors.first_name"
                                        class="text-danger"
                                        >{{ errors.first_name }}</small
                                    >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="middleName"
                                    class="col-sm-2 col-form-label"
                                    >Middle Name <small>(Optional)</small
                                    ><span class="text-danger">*</span></label
                                >
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="middle_name"
                                        id="middle_name"
                                        v-model="userData.middle_init"
                                        :class="{
                                            'is-invalid': errors.middle_init,
                                        }"
                                        placeholder="Middlename"
                                    />
                                    <small
                                        v-if="errors.middle_init"
                                        class="text-danger"
                                        >{{ errors.middle_init }}</small
                                    >
                                </div>
                            </div>
                            <hr width="100%" />
                            <div class="row mb-3 mt-4">
                                <label
                                    for="username"
                                    class="col-sm-2 col-form-label"
                                    >Username<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="username"
                                        id="username"
                                        v-model="userData.username"
                                        :class="{
                                            'is-invalid': errors.username,
                                        }"
                                        placeholder="Username"
                                    />
                                    <small
                                        v-if="errors.username"
                                        class="text-danger"
                                        >{{ errors.username }}</small
                                    >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="password"
                                    class="col-sm-2 col-form-label"
                                    >Password<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <input
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        id="password"
                                        v-model="userData.password"
                                        :class="{
                                            'is-invalid': errors.password,
                                        }"
                                        placeholder="Password"
                                    />
                                    <small
                                        v-if="errors.password"
                                        class="text-danger"
                                        >{{ errors.password }}</small
                                    >
                                </div>
                            </div>
                            <hr width="100%" />
                            <div class="row mb-3 mt-4">
                                <label
                                    for="municipality"
                                    class="col-sm-2 col-form-label"
                                    >Municipality<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <small
                                        >(Please select your
                                        municipality)</small
                                    >
                                    <v-select
                                        label="municipality"
                                        name="municipality"
                                        id="municipality"
                                        :options="municipality.data"
                                        :reduce="(data) => data.id"
                                        v-model="userData.municipality"
                                        :class="{
                                            'is-invalid form-control':
                                                errors.municipality,
                                        }"
                                        placeholder="Select here.."
                                    >
                                    </v-select>
                                    <small
                                        v-if="errors.municipality"
                                        class="text-danger"
                                        >{{ errors.municipality }}</small
                                    >
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="typeRole"
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
                                        v-model="userData.role_type"
                                        :class="{
                                            'is-invalid': errors.role_type,
                                        }"
                                    />
                                    <label
                                        class="form-check-label"
                                        :for="'role' + index"
                                    >
                                        {{ role }}
                                    </label>
                                </div>
                                <small class="text-danger">{{
                                    errors.role_type
                                }}</small>
                                <div class="float-end">
                                    <button
                                        type="submit"
                                        class="btn btn-md btn-success"
                                    >
                                        <i class="bi bi-save"></i>
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ADD MODAL FORM -->

        <!-- EDIT MODAL FORM -->
        <div
            class="modal fade"
            id="editUser"
            tabindex="-1"
            aria-labelledby="editUserModal"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div
                        class="modal-header text-light"
                        style="background-color: #581b98"
                    >
                        <h1 class="modal-title fs-5" id="editUserModal">
                            Edit User
                        </h1>
                        <button
                            type="button"
                            class="btn-close bg-white"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="card-body px-4 mt-4">
                        <form @submit.prevent="updateData">
                            <div class="row mb-3">
                                <label
                                    for="lastName"
                                    class="col-sm-2 col-form-label"
                                    >Last name<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="last_name"
                                        id="last_name"
                                        v-model="editData.last_name"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="firstName"
                                    class="col-sm-2 col-form-label"
                                    >First name<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="first_name"
                                        id="first_name"
                                        v-model="editData.first_name"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="middleName"
                                    class="col-sm-2 col-form-label"
                                    >Middle Name<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="middle_name"
                                        id="middle_name"
                                        v-model="editData.middle_init"
                                    />
                                </div>
                            </div>
                            <hr width="100%" />
                            <div class="row mb-3 mt-4">
                                <label
                                    for="username"
                                    class="col-sm-2 col-form-label"
                                    >Username<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="username"
                                        id="username"
                                        v-model="editData.username"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="password"
                                    class="col-sm-2 col-form-label"
                                    >Password<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <input
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        id="password"
                                        v-model="editData.password"
                                    />
                                </div>
                            </div>
                            <hr width="100%" />
                            <div class="row mb-3 mt-4">
                                <label
                                    for="municipality"
                                    class="col-sm-2 col-form-label"
                                    >Municipality<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <div class="col-sm-10">
                                    <small
                                        >(Please select your
                                        municipality)</small
                                    >
                                    <v-select
                                        label="municipality"
                                        name="municipality"
                                        id="municipality"
                                        :options="municipality.data"
                                        :reduce="(data) => data.id"
                                        v-model="editData.municipality"
                                    >
                                    </v-select>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="typeRole"
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
                                        v-model="editData.role_type"
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
            </div>
        </div>
        <!-- END EDIT MODAL FORM -->

        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <h5 class="fw-bold">Users</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-space-around mb-4">
                    <div class="col-lg-6">
                        <input
                            type="text"
                            v-model="search"
                            class="form-control border border-dark"
                            autofocus
                            placeholder="Search here.."
                        />
                    </div>
                    <div class="col-lg-6">
                        <button
                            type="button"
                            class="btn btn-success float-end"
                            data-bs-toggle="modal"
                            data-bs-target="#addUser"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Add User
                        </button>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr class="bg-primary text-white">
                                <th>No.</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Municipality</th>
                                <th>Role Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(user, index) in users.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ user.username }}</td>
                                <td>
                                    {{
                                        user.first_name
                                            .split(" ")
                                            .map(
                                                (word) =>
                                                    word
                                                        .charAt(0)
                                                        .toUpperCase() +
                                                    word.slice(1).toLowerCase()
                                            )
                                            .join(" ")
                                    }}
                                    {{
                                        user.middle_init
                                            .substr(0, 1)
                                            .toUpperCase()
                                    }}.
                                    {{
                                        user.last_name
                                            .split(" ")
                                            .map(
                                                (word) =>
                                                    word
                                                        .charAt(0)
                                                        .toUpperCase() +
                                                    word.slice(1).toLowerCase()
                                            )
                                            .join(" ")
                                    }}
                                </td>
                                <td>{{ user.municipality.municipality }}</td>
                                <td>{{ user.role_type }}</td>
                                <td
                                    class="badge rounded-pill text-bg-warning mt-2"
                                >
                                    {{ user.status }}
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUser"
                                        @click="fetchEditData(user.id)"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :records="users" :link="users.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
