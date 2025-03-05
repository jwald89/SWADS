<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import { ref, watch, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import { toast } from "vue3-toastify";
import Pagination from "../../components/Pagination.vue";
import axios from "axios";

const props = defineProps({
    sectors: {
        type: Object,
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
        const response = await axios.post("/sectors/post", data);

        props.sectors.data.unshift(response.data); // update the data table after the submission
        toast.success("Successfully created!", {
            autoClose: 1000,
        });

        const modalElement = document.querySelector("#addSector"); // For Add Modal
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
        const response = await axios.get(`/sectors/edit/${id}`);
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
            `/sectors/edit/${editData.id}`,
            editData
        );

        const modalElement = document.querySelector("#editSector"); // For Add Modal
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }

        toast.success("Your data successfully updated!", { autoClose: 3000 });

        // Find and update the specific item in the table
        const index = props.sectors.data.findIndex(
            (item) => item.id === editData.id
        );

        if (index !== -1) {
            props.sectors.data[index] = response.data;
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
        router.visit(`/sectors?search=${search.value}`, {
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
            id="addSector"
            tabindex="-1"
            aria-labelledby="addSectorLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div
                        class="modal-header text-light"
                        style="background-color: #581b98"
                    >
                        <h1 class="modal-title fs-5" id="addSectorLabel">
                            <i class="bi bi-collection-fill"></i>
                            Add Sector
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
                                <label for="sector" class="col-form-label"
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
            id="editSector"
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
                            Edit Sector
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
                                <label for="sector" class="col-form-label"
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
                <h5 class="fw-bold">
                    <i class="bi bi-collection-fill"></i> Sector
                </h5>
            </div>
            <div class="card-body p-4">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between mb-4"
                >
                    <div class="col-12 col-md-6 mb-2">
                        <div class="input-group fw-bold">
                            <span class="input-group-text" id="basic-addon1"
                                ><i class="bi bi-search"></i
                            ></span>
                            <input
                                type="text"
                                class="form-control"
                                v-model="search"
                                autofocus
                                placeholder="Search here.."
                                aria-label="Search here.."
                                aria-describedby="basic-addon1"
                            />
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button
                            type="button"
                            class="btn btn-success"
                            data-bs-toggle="modal"
                            data-bs-target="#addSector"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Add New
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr class="bg-primary text-white">
                                <th>No.</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(sector, index) in sectors.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ sector.name }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editSector"
                                        @click="fetchEditData(sector.id)"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :records="sectors" :link="sectors.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
