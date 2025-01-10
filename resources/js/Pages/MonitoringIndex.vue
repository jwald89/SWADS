<script setup>
import { defineComponent, watch, ref } from "vue";
import LayoutApp from "../Shared/Layout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "../components/Pagination.vue";
import axios from "axios";
import { toast } from "vue3-toastify";

const props = defineProps({
    monitoring: {
        type: Object,
        requried: true,
    },
    search: {
        type: String,
        default: "",
    },
});

const page = usePage();

const hasAccess = (type) => {
    type = type.map((t) => t.toUpperCase());
    return type.includes(page.props.role_type);
};

const search = ref(props.search || "");

const formatDate = (dateString) => {
    const date = new Date(dateString);

    // Custom formatting: Day, 3-letter month, and year
    const options = { year: "numeric", month: "short", day: "numeric" };

    // Format the date using toLocaleDateString
    let formattedDate = date.toLocaleDateString("en-US", options);

    // Add a period after the 3-letter month
    formattedDate = formattedDate.replace(/([a-zA-Z]{3})/, "$1.");

    return formattedDate;
};

const delData = async (id) => {
    try {
        alertify.confirm(
            "Delete Record",
            "Are you sure you want to delete this record?",
            function (_, value) {
                axios
                    .post(`/monitoring/destroy/${id}`, {
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
                        router.visit("/monitoring", {
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

defineComponent({
    Pagination,
});

watch(
    search,
    debounce(() => {
        router.visit(`/monitoring?search=${search.value}`, {
            preserveState: true,
            preserveScroll: true,
        });
    }, 500)
);
</script>

<template>
    <LayoutApp>
        <div class="card">
            <div
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                Monitoring Lists
            </div>
            <div class="card-body">
                <div class="d-flex justify-space-around mt-4">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <input
                                type="text"
                                v-model="search"
                                class="form-control border border-dark"
                                autofocus
                                placeholder="Search here.."
                            />
                        </div>
                    </div>
                    <div
                        class="col-lg-6 float-end"
                        v-if="hasAccess(['admin', 'user'])"
                    >
                        <Link
                            class="btn btn-md btn-primary float-end"
                            :href="`/monitoring/create`"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Create New
                        </Link>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Assistance Type</th>
                                <th>Claimant</th>
                                <th>Date of Intake</th>
                                <th>Sector</th>
                                <th>Municipality</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr
                                v-for="(data, index) in monitoring.data"
                                :key="index"
                                :class="{
                                    'bg-claimed': data.status === 'CLAIMED',
                                }"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.assistance_type }}</td>
                                <td>
                                    {{
                                        data.intake.first_name
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
                                        data.intake.middle_name
                                            .substr(0, 1)
                                            .toUpperCase()
                                    }}.
                                    {{
                                        data.intake.last_name
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
                                <td>
                                    {{ formatDate(data.date_intake) }}
                                </td>
                                <td>{{ data.sector.name }}</td>
                                <td>{{ data.municipality }}</td>
                                <td>
                                    {{
                                        new Intl.NumberFormat("en-US", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        }).format(data.amount)
                                    }}
                                </td>
                                <td
                                    v-if="data.status == 'PSWDO'"
                                    class="bg-pswdo text-light fw-bold"
                                >
                                    {{ data.status }}
                                </td>
                                <td
                                    v-if="data.status == 'PGO'"
                                    class="bg-pgo text-light fw-bold"
                                >
                                    {{ data.status }}
                                </td>
                                <td
                                    v-if="data.status == 'PBO'"
                                    class="bg-pbo text-dark fw-bold"
                                >
                                    {{ data.status }}
                                </td>
                                <td
                                    v-if="data.status == 'PACCO'"
                                    class="bg-pacco text-dark fw-bold"
                                >
                                    {{ data.status }}
                                </td>
                                <td
                                    v-if="data.status == 'PTO'"
                                    class="bg-pto text-light fw-bold"
                                >
                                    {{ data.status }}
                                </td>
                                <td
                                    v-if="data.status == 'CLAIMED'"
                                    class="fw-bold"
                                >
                                    {{ data.status }}
                                </td>
                                <td>
                                    <!-- For ADMIN and USER role button -->
                                    <Link
                                        :href="`/monitoring/edit/${data.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['admin', 'user'])"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </Link>
                                    <!-- For LIAISON role button -->
                                    <Link
                                        :href="`/liaison/monitoring/edit/${data.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['liaison'])"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Update -->
                                    </Link>
                                    <!-- For ADMIN and USER role button -->
                                    <Link
                                        href=""
                                        class="btn btn-sm btn-info me-2"
                                        v-if="hasAccess(['admin', 'user'])"
                                        title="Details"
                                    >
                                        <i class="bi bi-eye"></i>
                                        <!-- Details -->
                                    </Link>
                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        v-if="hasAccess(['admin', 'user'])"
                                        title="Delete"
                                        @click="delData(data.id)"
                                    >
                                        <i class="bi bi-trash"></i>
                                        <!-- Delete -->
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :records="monitoring" :link="monitoring.path" />
                </div>
            </div>
        </div>
    </LayoutApp>
</template>

<style scoped>
.bg-claimed {
    background: #a7ff83;
}

.bg-pswdo {
    background: #c300ff;
}

.bg-pbo {
    background: #f5eded;
}

.bg-pto {
    background: #ff6200;
}

.bg-pacco {
    background: #ffbe0a;
}

.bg-pgo {
    background: #2f89fc;
}
</style>
