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
    first_name: "",
    middle_name: "",
    last_name: "",
    title: "",
});

const resetForm = () => {
    data.description = "";
    data.first_name = "";
    data.middle_name = "";
    data.last_name = "";
    data.title = "";
};

const submitData = async () => {
    if (data.description) {
        errors.description = "";
    }
    if (data.first_name) {
        errors.first_name = "";
    }
    if (data.last_name) {
        errors.last_name = "";
    }
    if (data.title) {
        errors.title = "";
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
        editData.first_name = response.data.first_name;
        editData.middle_name = response.data.middle_name;
        editData.last_name = response.data.last_name;
        editData.title = response.data.title;
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div
                        class="modal-header text-light"
                        style="background-color: #581b98"
                    >
                        <h1 class="modal-title fs-5" id="addOffChargeLabel">
                            <i class="bi bi-shop-window"></i>
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
                            <div class="card">
                                <div class="card-body">
                                    <div class="mt-1">
                                        <label
                                            for="description"
                                            class="col-form-label"
                                            >Office name<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="description"
                                            id="description"
                                            v-model="data.description"
                                            :class="{
                                                'is-invalid':
                                                    errors.description,
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
                            </div>

                            <h6>
                                <i class="bi bi-person-fill"></i> Signatory Name
                            </h6>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mt-4">
                                        <label for="firstname"
                                            >First name<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="firstname"
                                            id="firstname"
                                            v-model="data.first_name"
                                            :class="{
                                                'is-invalid': errors.first_name,
                                            }"
                                        />
                                        <small
                                            v-if="errors.first_name"
                                            class="text-danger"
                                            >{{ errors.first_name }}</small
                                        >
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="middlename"
                                            >Middle name
                                            <small>(Optional)</small>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="middlename"
                                            id="middlename"
                                            v-model="data.middle_name"
                                        />
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="lastname"
                                            >Last name<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="lastname"
                                            id="lastname"
                                            v-model="data.last_name"
                                            :class="{
                                                'is-invalid': errors.last_name,
                                            }"
                                        />
                                        <small
                                            v-if="errors.last_name"
                                            class="text-danger"
                                            >{{ errors.last_name }}</small
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mt-4">
                                        <label for="title"
                                            >Title<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="title"
                                            id="title"
                                            v-model="data.title"
                                            :class="{
                                                'is-invalid': errors.title,
                                            }"
                                        />
                                        <small
                                            v-if="errors.title"
                                            class="text-danger"
                                            >{{ errors.title }}</small
                                        >
                                    </div>
                                </div>
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
            <div class="modal-dialog modal-lg">
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
                            <div class="card">
                                <div class="card-body">
                                    <div class="mt-1">
                                        <label
                                            for="description"
                                            class="col-form-label"
                                            >Office name<span
                                                class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="description"
                                            id="description"
                                            v-model="editData.description"
                                            :class="{
                                                'is-invalid':
                                                    errors.description,
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
                            </div>

                            <h6>
                                <i class="bi bi-person-fill"></i> Signatory Name
                            </h6>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mt-4">
                                        <label for="firstname"
                                            >First name<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="firstname"
                                            id="firstname"
                                            v-model="editData.first_name"
                                        />
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="middlename"
                                            >Middle name
                                            <small>(Optional)</small>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="middlename"
                                            id="middlename"
                                            v-model="editData.middle_name"
                                        />
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="lastname"
                                            >Last name<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="lastname"
                                            id="lastname"
                                            v-model="editData.last_name"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mt-4">
                                        <label for="title"
                                            >Title<span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-control-md"
                                            name="title"
                                            id="title"
                                            v-model="editData.title"
                                        />
                                    </div>
                                </div>
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
                    <i class="bi bi-shop-window"></i> Office Charges
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
                    <div class="col-md-6">
                        <button
                            type="button"
                            class="btn btn-success float-end"
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
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="text-center">No.</th>
                                <th>Office Head</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody
                            v-for="(office, index) in offices.data"
                            :key="index"
                        >
                            <tr>
                                <td class="text-center">{{ index + 1 }}</td>
                                <td class="text-start">
                                    {{ office.first_name }}
                                    {{ office.middle_name }}
                                    {{ office.last_name }}
                                </td>
                                <td>{{ office.title }}</td>
                                <td>
                                    {{ office.description }}
                                </td>
                                <td class="text-center">
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
