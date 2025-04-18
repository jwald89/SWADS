<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import { ref, watch, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import axios from "axios";
import Pagination from "../../components/Pagination.vue";
import { toast } from "vue3-toastify";

const props = defineProps({
    municipality: {
        type: Object,
        required: true,
    },
    search: {
        type: String,
        default: "",
    },
});

// For Edit Modal
const editData = reactive({ id: null, municipality: "" });

const fetchEditData = async (id) => {
    try {
        const response = await axios.get(`/municipality/edit/${id}`);
        editData.id = response.data.id;
        editData.municipality = response.data.municipality;
    } catch (error) {
        toast.error("Failed to fetch data for editing.", { autoClose: 2000 });
        console.error(error);
    }
};

// Update Assistance Type
const updateData = async () => {
    try {
        const response = await axios.put(
            `/municipality/edit/${editData.id}`,
            editData
        );

        const modalElement = document.querySelector("#editMunicipality");
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }

        toast.success("Your data successfully updated!", { autoClose: 3000 });

        // Find and update the specific item in the table
        const index = props.municipality.data.findIndex(
            (item) => item.id === editData.id
        );

        if (index !== -1) {
            props.municipality.data[index] = response.data;
            console.log("DATA INDEX :", props.municipality.data[index]);
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
        router.visit(`/municipality?search=${search.value}`, {
            preserveState: true,
            preserveScroll: true,
        });
    }, 500)
);
</script>

<template>
    <LayoutApp>
        <!-- EDIT MODAL FORM -->
        <div
            class="modal fade"
            id="editMunicipality"
            tabindex="-1"
            aria-labelledby="municipalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div
                        class="modal-header text-light"
                        style="background-color: #581b98"
                    >
                        <h1 class="modal-title fs-5" id="municipalLabel">
                            Edit Municipality
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
                                    v-model="editData.municipality"
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
                <h5 class="fw-bold">Municipality</h5>
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
                    <!-- <div class="col-lg-6">
                        <Link
                            :href="`/municipality/create`"
                            class="btn btn-md btn-primary float-end"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Create New
                        </Link>
                    </div> -->
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Municipality</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(data, index) in municipality.data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.municipality }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editMunicipality"
                                        @click="fetchEditData(data.id)"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </button>
                                    <!-- <Link
                                        href=""
                                        class="btn btn-sm btn-danger me-2"
                                        title="Delete"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </Link> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination
                        :records="municipality"
                        :link="municipality.path"
                    />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
