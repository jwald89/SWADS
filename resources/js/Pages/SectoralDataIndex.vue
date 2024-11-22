<script setup>
import Layout from "../Shared/Layout.vue";
import vSelect from "vue-select";
import { defineComponent } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const props = defineProps({
    municipalities: {
        type: Object,
    },
    sectors: {
        type: Object,
    },
    months: {
        type: Object,
    },
    data: {
        type: Object,
    },
});

const page = usePage();

const hasAccess = (type) => {
    type = type.map((t) => t.toUpperCase());
    return type.includes(page.props.role_type);
};

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

defineComponent({
    vSelect,
});
</script>

<template>
    <Layout>
        <div class="card">
            <div
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                <div class="col-lg-12 d-flex">
                    <div class="col-lg-6">
                        Sectoral Data
                        <span class="h6">
                            - Inventory of “Pag-asa Youth Association of the
                            Philippines” (PYAP)</span
                        >
                    </div>
                    <div class="col-lg-6 float-end">
                        <Link
                            :href="`/sectoral/create`"
                            class="btn btn-sm btn-light float-end"
                        >
                            <i class="bi bi-journal-plus"></i>
                            Create New
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 m-2">
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Filter the sector type</label>
                        <v-select
                            class="fw-bold"
                            :options="sectors.data"
                            :reduce="(data) => data"
                            label="name"
                        ></v-select>
                    </div>
                    <div class="col-md-3" v-if="hasAccess(['admin', 'user'])">
                        <label for="">Filter the municipality</label>
                        <v-select
                            class="fw-bold"
                            :options="municipalities.data"
                            :reduce="(data) => data"
                            label="municipality"
                        ></v-select>
                    </div>
                    <div
                        class="div col-md-3"
                        v-if="hasAccess(['municipal'])"
                    ></div>
                    <div class="col-md-2 offset-md-2">
                        <label for="">Month</label>
                        <v-select class="fw-bold" :options="months"></v-select>
                    </div>
                    <div class="col-md-2">
                        <label for="">Year</label>
                        <select name="" id="" class="form-select">
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive mt-5">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No.</th>
                                <th>Sector</th>
                                <th>Client</th>
                                <th>Age</th>
                                <th>Date of Birth</th>
                                <th>Municipality</th>
                                <th>Date Encoded</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="(sectoral, index) in data"
                            :key="index"
                        >
                            <tr>
                                <td>{{ index + 1 }}</td>
                                <td>{{ sectoral.sector.name }}</td>
                                <td>
                                    {{
                                        sectoral.first_name
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
                                        sectoral.middle_name
                                            .substr(0, 1)
                                            .toUpperCase()
                                    }}.
                                    {{
                                        sectoral.last_name
                                            .charAt(0)
                                            .toUpperCase() +
                                        sectoral.last_name.slice(1)
                                    }}
                                </td>
                                <td>{{ sectoral.age }}</td>
                                <td>{{ formatDate(sectoral.birthdate) }}</td>
                                <td>
                                    {{ sectoral.municipality.municipality }}
                                </td>
                                <td class="text-primary">
                                    {{ formatDate(sectoral.date_encoded) }}
                                </td>
                                <td>
                                    <Link
                                        :href="`/sectoral/edit/${sectoral.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['admin', 'user'])"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Edit -->
                                    </Link>
                                    <Link
                                        :href="`/municipal/edit-municipal/${sectoral.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        v-if="hasAccess(['municipal'])"
                                        title="Update"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- Update -->
                                    </Link>
                                    <Link
                                        href=""
                                        class="btn btn-sm btn-info me-2"
                                        title="Details"
                                    >
                                        <i class="bi bi-eye"></i>
                                        <!-- Details -->
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </Layout>
</template>
