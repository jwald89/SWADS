<script setup>
import { defineComponent } from "vue";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";
import { Link } from "@inertiajs/vue3";

defineComponent({
    Link,
    Navbar,
    Sidebar,
});
</script>

<template>
    <Navbar />
    <Sidebar />
    <main class="main" id="main">
        <div class="card">
            <div
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                Intake Lists
            </div>
            <div class="card-body">
                <div class="d-flex justify-space-around mt-4">
                    <div class="col-lg-6">
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
                    <div class="col-lg-6 float-end">
                        <Link
                            class="btn btn-md btn-primary float-end"
                            href="/intake/create"
                            >Create New</Link
                        >
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date Created</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Address</th>
                                <th>Contact No.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</template>
