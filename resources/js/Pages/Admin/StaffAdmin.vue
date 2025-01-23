<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import { ref, watch, reactive } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../../components/Pagination.vue";

const props = defineProps({
    staff: {
        type: Object,
    },
    search: {
        type: String,
        default: "",
    },
});

const errors = reactive({});

const data = reactive({
    lastname: "",
    firstname: "",
    middlename: "",
});

const resetForm = () => {
    data.lastname = "";
    data.firstname = "";
    data.middlename = "";
};

const submitData = async () => {
    if (data.lastname) {
        errors.lastname = "";
    }
    if (data.firstname) {
        errors.firstname = "";
    }
    if (data.middlename) {
        errors.middlename = "";
    }
    try {
        const response = await axios.post("/staff-admin/post", data);

        props.staff.data.unshift(response.data); // update the data table after the submission
        toast.success("Successfully created!", {
            autoClose: 1000,
        });

        const modalElement = document.querySelector("#addStaff"); // For Add Modal
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

// For Edit Modal
const editData = reactive({
    id: null,
    firstname: "",
    middlename: "",
    lastname: "",
});

const fetchEditData = async (id) => {
    try {
        const response = await axios.get(`/staff-admin/edit/${id}`);
        editData.id = response.data.id;
        editData.firstname = response.data.firstname;
        editData.middlename = response.data.middlename;
        editData.lastname = response.data.lastname;
    } catch (error) {
        toast.error("Failed to fetch data for editing.", { autoClose: 2000 });
        console.error(error);
    }
};

// Update Assistance Type
const updateData = async () => {
    try {
        const response = await axios.put(
            `/staff-admin/edit/${editData.id}`,
            editData
        );

        const modalElement = document.querySelector("#editStaff"); // For Add Modal
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }

        toast.success("Your data successfully updated!", { autoClose: 3000 });

        // Find and update the specific item in the table
        const index = props.staff.data.findIndex(
            (item) => item.id === editData.id
        );

        if (index !== -1) {
            props.staff.data[index] = response.data;
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
        router.visit(`/staff-admin?search=${search.value}`, {
            preserveState: true,
            preserveScroll: true,
        });
    })
);
</script>

<template>
    <LayoutApp>
        <!-- ADD MODAL FORM -->
        <div
            class="modal fade"
            id="addStaff"
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
                            Add Staff Administer
                        </h1>
                        <button
                            type="button"
                            class="btn-close bg-white"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form @submit.prevent="submitData">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="firstname" class="col-form-label"
                                    >Firstname<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-md"
                                    name="firstname"
                                    id="firstname"
                                    v-model="data.firstname"
                                    :class="{ 'is-invalid': errors.firstname }"
                                />
                                <small
                                    v-if="errors.firstname"
                                    class="text-danger"
                                    >{{ errors.firstname }}</small
                                >
                            </div>
                            <div class="mb-3">
                                <label for="middlename" class="col-form-label"
                                    >Middlename<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-md"
                                    name="middlename"
                                    id="middlename"
                                    v-model="data.middlename"
                                    :class="{ 'is-invalid': errors.middlename }"
                                />
                                <small
                                    v-if="errors.middlename"
                                    class="text-danger"
                                    >{{ errors.middlename }}</small
                                >
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="col-form-label"
                                    >Lastname<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-md"
                                    name="lastname"
                                    id="lastname"
                                    v-model="data.lastname"
                                    :class="{ 'is-invalid': errors.lastname }"
                                />
                                <small
                                    v-if="errors.lastname"
                                    class="text-danger"
                                    >{{ errors.lastname }}</small
                                >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-warning"
                                data-bs-dismiss="modal"
                            >
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i>
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END ADD MODAL FORM -->

        <!-- EDIT MODAL FORM -->
        <div
            class="modal fade"
            id="editStaff"
            tabindex="-1"
            aria-labelledby="editStaffLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div
                        class="modal-header text-light"
                        style="background-color: #581b98"
                    >
                        <h1 class="modal-title fs-5" id="editStaffLabel">
                            Edit Staff Administer
                        </h1>
                        <button
                            type="button"
                            class="btn-close bg-white"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form @submit.prevent="updateData">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="firstname" class="col-form-label"
                                    >Firstname<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-md"
                                    name="firstname"
                                    id="firstname"
                                    v-model="editData.firstname"
                                    :class="{ 'is-invalid': errors.firstname }"
                                />
                                <small
                                    v-if="errors.firstname"
                                    class="text-danger"
                                    >{{ errors.firstname }}</small
                                >
                            </div>
                            <div class="mb-3">
                                <label for="middlename" class="col-form-label"
                                    >Middlename<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-md"
                                    name="middlename"
                                    id="middlename"
                                    v-model="editData.middlename"
                                    :class="{ 'is-invalid': errors.middlename }"
                                />
                                <small
                                    v-if="errors.middlename"
                                    class="text-danger"
                                    >{{ errors.middlename }}</small
                                >
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="col-form-label"
                                    >Lastname<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-md"
                                    name="lastname"
                                    id="lastname"
                                    v-model="editData.lastname"
                                    :class="{ 'is-invalid': errors.lastname }"
                                />
                                <small
                                    v-if="errors.lastname"
                                    class="text-danger"
                                    >{{ errors.lastname }}</small
                                >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-warning"
                                data-bs-dismiss="modal"
                            >
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END EDIT MODAL FORM -->

        <div class="card">
            <div
                class="card-header text-white"
                style="background-color: #581b98"
            >
                <h5 class="fw-bold">Staff Administered</h5>
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
                            class="btn btn-primary float-end"
                            data-bs-toggle="modal"
                            data-bs-target="#addStaff"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Add New
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(staff, index) in staff.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>
                                    {{
                                        staff.lastname
                                            .split(" ")
                                            .map(
                                                (word) =>
                                                    word
                                                        .charAt(0)
                                                        .toUpperCase() +
                                                    word.slice(1).toLowerCase()
                                            )
                                            .join("")
                                    }}
                                </td>
                                <td>
                                    {{
                                        staff.firstname
                                            .split(" ")
                                            .map(
                                                (word) =>
                                                    word
                                                        .charAt(0)
                                                        .toUpperCase() +
                                                    word.slice(1).toLowerCase()
                                            )
                                            .join("")
                                    }}
                                </td>
                                <td>
                                    {{
                                        staff.middlename
                                            .split(" ")
                                            .map(
                                                (word) =>
                                                    word
                                                        .charAt(0)
                                                        .toUpperCase() +
                                                    word.slice(1).toLowerCase()
                                            )
                                            .join("")
                                    }}
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editStaff"
                                        @click="fetchEditData(staff.id)"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :records="staff" :link="staff.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
