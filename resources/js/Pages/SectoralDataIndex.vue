<script setup>
import Layout from "../Shared/Layout.vue";
</script>

<template>
    <Layout>
        <div class="card">
            <div
                class="card-header text-white fw-bold"
                style="background-color: #581b98"
            >
                Sectoral Data
            </div>
            <div class="card-body p-4 mt-4">
                <div class="col-md-4">
                    <select class="form-select" name="" id="">
                        <option value="">Children</option>
                        <option value="">Former Rebel</option>
                        <option value="">Men</option>
                        <option value="">PWD</option>
                        <option value="">Senior Citizen</option>
                        <option value="">Solo Parent</option>
                        <option value="">Women</option>
                        <option value="">Youth</option>
                    </select>
                </div>

                <div class="table-responsive mt-5">
                    <table class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>Assistance Type</th>
                                <th>Name</th>
                                <th>Date of Intake</th>
                                <th>Sector</th>
                                <th>Municipality</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </Layout>
</template>
