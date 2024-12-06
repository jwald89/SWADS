<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import { ref, watch, reactive } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import axios from "axios";
import { debounce } from "lodash";
import Pagination from "../../components/Pagination.vue";

const props = defineProps({
    assistanceType: {
        type: Object,
        required: true,
    },
    search: {
        type: String,
        default: "",
    },
});

const errors = reactive({});

const data = reactive({
    name: "",
});

const resetForm = () => {
    data.name = "";
};

const submitData = async () => {
    if (data.name) {
        errors.name = "";
    }
    try {
        const response = await axios.post("/type-assistance/post", data);

        props.assistanceType.data.unshift(response.data);
        toast.success("Successfully added!", {
            autoClose: 3000,
        });

        const modalElement = document.querySelector("#addAssistanceType"); // For Add Modal
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
const editData = reactive({ id: null, name: "" });

const fetchEditData = async (id) => {
    try {
        const response = await axios.get(`/type-assistance/edit/${id}`);
        editData.id = response.data.id;
        editData.name = response.data.name;
    } catch (error) {
        toast.error("Failed to fetch data for editing.", { autoClose: 2000 });
        console.error(error);
    }
};

// Update Assistance Type
const updateData = async () => {
    try {
        const response = await axios.put(
            `/type-assistance/edit/${editData.id}`,
            editData
        );

        const modalElement = document.querySelector("#editAssistanceType"); // For Add Modal
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }

        toast.success("Your data successfully updated!", { autoClose: 3000 });

        // Find and update the specific item in the table
        const index = props.assistanceType.data.findIndex(
            (item) => item.id === editData.id
        );

        if (index !== -1) {
            props.assistanceType.data[index] = response.data;
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
        router.visit(`/type-assistance?search=${search.value}`, {
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
            id="addAssistanceType"
            tabindex="-1"
            aria-labelledby="assistanceTypeLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div
                        class="modal-header text-light"
                        style="background-color: #581b98"
                    >
                        <h1 class="modal-title fs-5" id="assistanceTypeLabel">
                            Add Assitance type
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
                                <label
                                    for="recipient-name"
                                    class="col-form-label"
                                    >Name:</label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-md"
                                    name="name"
                                    id="name"
                                    v-model="data.name"
                                    :class="{ 'is-invalid': errors.name }"
                                    placeholder="Enter a name.."
                                />
                                <small v-if="errors.name" class="text-danger">{{
                                    errors.name
                                }}</small>
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
            id="editAssistanceType"
            tabindex="-1"
            aria-labelledby="assistanceTypeLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div
                        class="modal-header text-light"
                        style="background-color: #581b98"
                    >
                        <h1 class="modal-title fs-5" id="assistanceTypeLabel">
                            Edit Assistance
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
                                <label
                                    for="recipient-name"
                                    class="col-form-label"
                                    >Name:</label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-md"
                                    name="name"
                                    id="name"
                                    v-model="editData.name"
                                />
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
                <h5 class="fw-bold">Type Assistance</h5>
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
                            data-bs-target="#addAssistanceType"
                            data-bs-whatever="@fat"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Add New
                        </button>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(data, index) in assistanceType.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.name }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editAssistanceType"
                                        @click="fetchEditData(data.id)"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </button>
                                    <Link
                                        href=""
                                        class="btn btn-sm btn-danger me-2"
                                        title="Delete"
                                    >
                                        <i class="bi bi-trash"></i>
                                        <!-- Delete -->
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination
                        :records="assistanceType"
                        :link="assistanceType.path"
                    />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
