<script setup>
import { defineComponent } from "vue";
import Navbar from "@/components/Navbar.vue";
import Sidebar from "@/components/Sidebar.vue";
import IntakeCreateP1 from "../Pages/IntakeCreateP1.vue";
import IntakeCreateP2 from "../Pages/IntakeCreateP2.vue";
import IntakeCreateP3 from "../Pages/IntakeCreateP3.vue";
import IntakeCreateP4 from "../Pages/IntakeCreateP4.vue";
import { Link } from "@inertiajs/vue3";

defineComponent({
    Link,
    Navbar,
    Sidebar,
    IntakeCreateP1,
    IntakeCreateP2,
    IntakeCreateP3,
    IntakeCreateP4,
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
                        <h5 class="fw-bold">Create Intake</h5>
                    </div>
                    <div class="col-lg-6">
                        <Link
                            class="btn btn-sm btn-light float-end"
                            href="/intake"
                            >Back</Link
                        >
                    </div>
                </div>
            </div>
            <div class="card-body mt-4">
                <ul
                    class="nav nav-tabs nav-tabs-bordered d-flex"
                    id="borderedTabJustified"
                    role="tablist"
                >
                    <li class="nav-item flex-fill" role="presentation">
                        <button
                            class="nav-link w-100 active"
                            id="home-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#identifying-data"
                            type="button"
                            role="tab"
                            aria-controls="home"
                            aria-selected="true"
                        >
                            I. IDENTIFYING DATA
                        </button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button
                            class="nav-link w-100"
                            id="profile-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#family-composition"
                            type="button"
                            role="tab"
                            aria-controls="profile"
                            aria-selected="false"
                        >
                            II. FAMILY COMPOSITION
                        </button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button
                            class="nav-link w-100"
                            id="contact-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#circumstances-referral"
                            type="button"
                            role="tab"
                            aria-controls="contact"
                            aria-selected="false"
                        >
                            III. CIRCUMSTANCES & REFERRAL
                        </button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button
                            class="nav-link w-100"
                            id="contact-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#remarks-recommendation"
                            type="button"
                            role="tab"
                            aria-controls="contact"
                            aria-selected="false"
                        >
                            IV. REMARKS/ RECOMMENDATIONS
                        </button>
                    </li>
                </ul>
                <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                    <IntakeCreateP1 />
                    <IntakeCreateP2 />
                    <IntakeCreateP3 />
                    <IntakeCreateP4 />
                    <!-- <div
                        class="tab-pane fade show active"
                        id="identifying-data"
                        role="tabpanel"
                        aria-labelledby="home-tab"
                    >
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form class="row g-3 mt-3">
                                                <div class="col-md-4">
                                                    <label
                                                        for="lastName"
                                                        class="form-label"
                                                        >Last Name</label
                                                    >
                                                    <span class="text-danger"
                                                        >*</span
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="lastName"
                                                        name="lastName"
                                                    />
                                                </div>
                                                <div class="col-md-4">
                                                    <label
                                                        for="firstName"
                                                        class="form-label"
                                                        >First Name</label
                                                    >
                                                    <span class="text-danger"
                                                        >*</span
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="firstName"
                                                        name="firstName"
                                                    />
                                                </div>
                                                <div class="col-md-4">
                                                    <label
                                                        for="middleName"
                                                        class="form-label"
                                                        >Middle Name</label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="middleName"
                                                        name="middleName"
                                                    />
                                                </div>
                                                <div class="col-md-3">
                                                    <label
                                                        for="age"
                                                        class="form-label"
                                                        >Age</label
                                                    >
                                                    <span class="text-danger"
                                                        >*</span
                                                    >
                                                    <input
                                                        type="email"
                                                        class="form-control"
                                                        id="age"
                                                        name="age"
                                                    />
                                                </div>
                                                <div class="col-md-3">
                                                    <label
                                                        for="birthDate"
                                                        class="form-label"
                                                        >Birth Date</label
                                                    >
                                                    <span class="text-danger"
                                                        >*</span
                                                    >
                                                    <input
                                                        type="date"
                                                        class="form-control"
                                                        id="birthDate"
                                                        name="birthDate"
                                                    />
                                                </div>
                                                <div class="col-md-3">
                                                    <label
                                                        for="gender"
                                                        class="form-label"
                                                        >Gender</label
                                                    >
                                                    <span class="text-danger"
                                                        >*</span
                                                    >
                                                    <input
                                                        type="password"
                                                        class="form-control"
                                                        id="gender"
                                                        name="gender"
                                                    />
                                                </div>
                                                <div class="col-md-3">
                                                    <label
                                                        for="civilStatus"
                                                        class="form-label"
                                                        >Civil Status</label
                                                    >
                                                    <span class="text-danger"
                                                        >*</span
                                                    >
                                                    <input
                                                        type="password"
                                                        class="form-control"
                                                        id="civilStatus"
                                                        name="civilStatus"
                                                    />
                                                </div>
                                                <div class="col-12">
                                                    <label
                                                        for="address"
                                                        class="form-label"
                                                        >Address</label
                                                    >
                                                    <span class="text-danger"
                                                        >*</span
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="address"
                                                        name="address"
                                                        placeholder="1234 Main St"
                                                    />
                                                </div>
                                                <div class="col-md-6">
                                                    <label
                                                        for="occupation"
                                                        class="form-label"
                                                        >Occupation</label
                                                    >
                                                    <small> (optional)</small>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="occupation"
                                                        name="occupation"
                                                    />
                                                </div>
                                                <div class="col-md-4">
                                                    <label
                                                        for="contactNo"
                                                        class="form-label"
                                                        >Contact No.</label
                                                    >
                                                    <small> (optional)</small>
                                                    <input
                                                        class="form-control"
                                                        id="contactNo"
                                                        name="contactNo"
                                                    />
                                                </div>
                                                <div class="col-md-2">
                                                    <label
                                                        for="income"
                                                        class="form-label"
                                                        >Income</label
                                                    >
                                                    <small> (optional)</small>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="income"
                                                        name="income"
                                                    />
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            id="gridCheck"
                                                        />
                                                        <label
                                                            class="form-check-label"
                                                            for="gridCheck"
                                                        >
                                                            Check me out
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary me-2"
                                                    >
                                                        Save
                                                    </button>
                                                    <button
                                                        type="reset"
                                                        class="btn btn-secondary"
                                                    >
                                                        Reset
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div> -->
                    <!-- <diva
                        class="tab-pane fade"
                        id="family-composition"
                        role="tabpanel"
                        aria-labelledby="profile-tab"
                    >
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body mt-4">
                                    <form class="row g-3">
                                        <div class="col-md-4">
                                            <label for="lastName"
                                                >Last Name<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder=""
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="firstname"
                                                >First Name<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder=""
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="lastname"
                                                >Middle Name</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder=""
                                            />
                                        </div>
                                        <div class="col-md-5">
                                            <label for="age"
                                                >Age<span class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder=""
                                            />
                                        </div>
                                        <div class="col-md-7">
                                            <label for="relationship"
                                                >Relationship<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder=""
                                            />
                                        </div>
                                        <div class="col-12">
                                            <label for="educational-bg"
                                                >Educational Attainment</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder=""
                                            />
                                        </div>
                                        <div class="col-md-12">
                                            <label for="remarks">Remarks</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder=""
                                            />
                                        </div>

                                        <div class="text-center">
                                            <button
                                                type="submit"
                                                class="btn btn-primary me-2"
                                            >
                                                Save
                                            </button>
                                            <button
                                                type="reset"
                                                class="btn btn-secondary"
                                            >
                                                Reset
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </diva> -->
                    <!-- <div
                        class="tab-pane fade"
                        id="circumstances-referral"
                        role="tabpanel"
                        aria-labelledby="contact-tab"
                    >
                        <label for="comment">Textarea:</label>
                        <textarea
                            class="form-control"
                            rows="5"
                            id="comment"
                            name="text"
                        >
Referrals</textarea
                        >
                    </div> -->
                    <!-- <diva
                        class="tab-pane fade"
                        id="remarks"
                        role="tabpanel"
                        aria-labelledby="contact-tab"
                    >
                        <label for="comment">Textarea:</label>
                        <textarea
                            class="form-control"
                            rows="5"
                            id="comment"
                            name="text"
                        >
Remaks</textarea
                        >

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary me-2">
                                Save
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                Reset
                            </button>
                        </div>
                    </diva> -->
                </div>
                <div class="mt-4 float-end">
                    <button type="button" class="btn btn-md btn-success">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>
