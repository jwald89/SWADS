<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import { ref, watch, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../../components/Pagination.vue";
import { toast } from "vue3-toastify";
import axios from "axios";

const props = defineProps({
    offices: {
        type: Object,
    },
    search: {
        type: String,
        default: "",
    },
});

const errors = reactive({});

const data = reactive({
    description: "",
});

const resetForm = () => {
    data.description = "";
};

const submitData = async () => {
    if (data.description) {
        errors.description = "";
    }
    try {
        const response = await axios.post("/office-charges/post", data);

        props.offices.data.unshift(response.data); // update the data table after the submission
        toast.success("Successfully created!", {
            autoClose: 1000,
        });

        const modalElement = document.querySelector("#addOfficeCharge"); // For Add Modal
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
const editData = reactive({ id: null, description: "" });

const fetchEditData = async (id) => {
    try {
        const response = await axios.get(`/office-charges/edit/${id}`);
        editData.id = response.data.id;
        editData.description = response.data.description;
    } catch (error) {
        toast.error("Failed to fetch data for editing.", { autoClose: 2000 });
        console.error(error);
    }
};

// Update Assistance Type
const updateData = async () => {
    try {
        const response = await axios.put(
            `/office-charges/edit/${editData.id}`,
            editData
        );

        const modalElement = document.querySelector("#editOfficeCharge"); // For Add Modal
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }

        toast.success("Your data successfully updated!", { autoClose: 3000 });

        // Find and update the specific item in the table
        const index = props.offices.data.findIndex(
            (item) => item.id === editData.id
        );

        if (index !== -1) {
            props.offices.data[index] = response.data;
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

const delData = async (id) => {
    try {
        alertify.confirm(
            "Delete Record",
            "Are you sure you want to delete this record?",
            function (_, value) {
                axios
                    .post(`/office-charges/destroy/${id}`, {
                        key: value,
                        _method: "DELETE",
                    })
                    .then((_) => {
                        toast.success(
                            "You have successfully delete a record!",
                            {
                                autoClose: 2000,
                            }
                        );
                        router.visit("/office-charges", {
                            preserveScroll: true,
                        });
                    })
                    .catch((error) => {
                        toast.error(error.response.data.message, {
                            autoClose: 2000,
                        });
                    });
            },
            function () {}
        );
    } catch (error) {
        console.error("Error submitting form:", error);
    }
};

const search = ref(props.search || "");

watch(
    search,
    debounce(() => {
        router.visit(`/office-charges?search=${search.value}`, {
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
            id="addOfficeCharge"
            tabindex="-1"
            aria-labelledby="addOffChargeLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div
                        class="modal-header text-light"
                        style="background-color: #581b98"
                    >
                        <h1 class="modal-title fs-5" id="addOffChargeLabel">
                            Add Office
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
                                <label for="description" class="col-form-label"
                                    >Name:</label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-md"
                                    name="description"
                                    id="description"
                                    v-model="data.description"
                                    :class="{
                                        'is-invalid': errors.description,
                                    }"
                                    placeholder="Enter a name.."
                                />
                                <small
                                    v-if="errors.description"
                                    class="text-danger"
                                    >{{ errors.description }}</small
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
            id="editOfficeCharge"
            tabindex="-1"
            aria-labelledby="offChargeLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div
                        class="modal-header text-light"
                        style="background-color: #581b98"
                    >
                        <h1 class="modal-title fs-5" id="offChargeLabel">
                            Edit Office
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
                                <label for="description" class="col-form-label"
                                    >Name:</label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-md"
                                    name="description"
                                    id="description"
                                    v-model="editData.description"
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
                <h5 class="fw-bold">Office Charges</h5>
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
                            data-bs-target="#addOfficeCharge"
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
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(office, index) in offices.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ office.description }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editOfficeCharge"
                                        @click="fetchEditData(office.id)"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :records="offices" :link="offices.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
