<script setup>
import { defineComponent, onMounted, ref } from "vue";
import LayoutApp from "../Shared/Layout.vue";
// import Navbar from "@/components/Navbar.vue";
// import Sidebar from "@/components/Sidebar.vue";
import axios from "axios";
import { Link } from "@inertiajs/vue3";

const personalData = defineProps({
    perInfos: {
        type: Object,
    },
    famComps: {
        type: Object,
    },
});

const getData = async () => {
    try {
        const response = await axios.get("/intake");
        personalData.value = response.data.data;
        console.log("Data fetched successfully.");
    } catch (error) {
        console.error("Error submitting form:", error);
    }
};

defineComponent({
    Link,
    // Navbar,
    // Sidebar,
    LayoutApp,
});

onMounted(() => {
    getData();
});
</script>

<template>
    <!-- <Navbar />
    <Sidebar /> -->
    <LayoutApp>
        <!-- <main class="main" id="main"> -->
        <div class="card">
            <div
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                Intake Lists
            </div>
            <div class="card-body">
                <div class="d-flex justify-space-around mt-4">
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search here.."
                            />
                            <button class="btn btn-secondary" type="button">
                                Search
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-8 float-end">
                        <Link
                            class="btn btn-md btn-primary float-end"
                            href="/intake/create"
                            >Create New</Link
                        >
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table">
                        <thead class="text-center">
                            <tr>
                                <th>Assistance</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Address</th>
                                <th>Contact No.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-center"
                            v-for="detail in perInfos"
                            :key="detail.id"
                        >
                            <tr>
                                <td>
                                    {{
                                        detail.category
                                            .charAt(0)
                                            .toUpperCase() +
                                        detail.category.slice(1)
                                    }}
                                </td>
                                <td>
                                    {{
                                        detail.last_name
                                            .charAt(0)
                                            .toUpperCase() +
                                        detail.last_name.slice(1)
                                    }},
                                    {{
                                        detail.first_name
                                            .charAt(0)
                                            .toUpperCase() +
                                        detail.first_name.slice(1)
                                    }}
                                    {{
                                        detail.middle_name
                                            .charAt(0)
                                            .toUpperCase() +
                                        detail.middle_name.slice(1)
                                    }}
                                </td>
                                <td>
                                    {{
                                        detail.sex.charAt(0).toUpperCase() +
                                        detail.sex.slice(1)
                                    }}
                                </td>
                                <td>{{ detail.birthdate }}</td>
                                <td>
                                    {{
                                        detail.purok
                                            ? "Prk. " + detail.purok + ","
                                            : ""
                                    }}
                                    {{
                                        detail.street
                                            ? detail.street + " St.,"
                                            : ""
                                    }}
                                    {{ detail.barangay }},
                                    {{ detail.municipality }}
                                </td>
                                <td>{{ detail.contact_no }}</td>
                                <td>
                                    <Link
                                        :href="`/intake/edit/${detail.id}`"
                                        class="btn btn-sm btn-primary me-2"
                                        >Edit</Link
                                    >
                                    <Link
                                        :href="`/intake/show/${detail.id}`"
                                        class="btn btn-sm btn-info me-2"
                                        >Details</Link
                                    >
                                    <a
                                        :href="`/intake/print/${detail.id}`"
                                        class="btn btn-sm btn-warning me-2"
                                        target="_blank"
                                    >
                                        Print
                                    </a>
                                    <a
                                        :href="`/intake/export/${detail.id}`"
                                        class="btn btn-sm btn-success"
                                    >
                                        Export
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- </main> -->
    </LayoutApp>
</template>
