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
            <div class="card-header bg-dark text-white">
                <div class="d-flex justify-space-around">
                    <div class="col-lg-6">
                        <h5 class="fw-bold">Create Record</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            href="/monitoring"
                            >Back</Link
                        >
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="row g-3 mt-3" action="">
                    <div class="col-md-6">
                        <label for="claimant"
                            >Claimant<span class="text-danger">*</span></label
                        >
                        <select
                            class="form-select"
                            name="claimant"
                            id="claimant"
                        >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="beneficiary"
                            >Beneficiary<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <select
                            class="form-select"
                            name="beneficiary"
                            id="beneficiary"
                        >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="age"
                            >Age<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="age"
                            name="age"
                        />
                    </div>
                    <div class="col-md-2">
                        <label for="gender"
                            >Gender<span class="text-danger">*</span></label
                        >
                        <select class="form-select" name="gender" id="gender">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="contactNo"
                            >Contact No.<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            class="form-control"
                            name="contactNo"
                            id="contactNo"
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="sector"
                            >Sector<span class="text-danger">*</span></label
                        >
                        <select class="form-select" name="sector" id="sector">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="muninicipal"
                            >Municipality<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <select
                            class="form-select"
                            name="muninicipal"
                            id="muninicipal"
                        >
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="barangay"
                            >Barangay<span class="text-danger">*</span></label
                        >
                        <select
                            class="form-select"
                            name="barangay"
                            id="barangay"
                        >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="clientType"
                            >Type of Client<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            name="clientType"
                            id="clientType"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="assistanceType"
                            >Type of Assistance<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <select
                            class="form-select"
                            name="assistanceType"
                            id="assistanceType"
                        >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="amount"
                            >Amount<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="amount"
                            name="amount"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="charges"
                            >Charges<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="charges"
                            name="charges"
                        />
                    </div>
                    <div class="col-md-3">
                        <label for="intakeDate"
                            >Date of Intake<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="date"
                            class="form-control"
                            id="intakeDate"
                            name="intakeDate"
                        />
                    </div>
                    <div class="col-md-5">
                        <label for="staff"
                            >Staff Administered<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <select class="form-select" name="staff" id="staff">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="liaison"
                            >Liaison<span class="text-danger">*</span></label
                        >
                        <select class="form-select" name="liaison" id="staff">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="dateStatus"
                            >Status Date<span class="text-danger"
                                >*</span
                            ></label
                        >
                        <input
                            type="date"
                            class="form-control"
                            id="dateStatus"
                            name="dateStatus"
                        />
                    </div>
                    <div class="col-md-8">
                        <label for="dateStatus"
                            >Remarks<span class="text-danger">*</span></label
                        >
                        <textarea
                            type="date"
                            class="form-control"
                            id="remarks"
                            name="remarks"
                            rows="1"
                        >
                        </textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="status"
                            >Status<span class="text-danger">*</span></label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="status"
                            name="status"
                        />
                    </div>
                    <div class="mt-4">
                        <button
                            type="button"
                            class="btn btn-md btn-success float-end"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</template>
