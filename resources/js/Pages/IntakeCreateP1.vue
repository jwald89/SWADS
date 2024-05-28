<script setup>
defineProps({
    assistances: {
        type: Object,
        required: true,
    },
    municipality: {
        type: Object,
        required: true,
    },
    barangays: {
        type: Object,
        required: true,
    },
    civilStatus: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div
        class="tab-pane fade show active"
        id="identifying-data"
        role="tabpanel"
        aria-labelledby="home-tab"
    >
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body row g-3 mt-1">
                        <div class="col-md-4 mb-2">
                            <label for="classification">Classification</label>
                            <select
                                class="form-select"
                                name="classification"
                                id="classification"
                            >
                                <option value="non4ps">Non-poor 4Ps</option>
                                <option value="for-peace">4Ps</option>
                            </select>
                        </div>
                        <div class="col-md-5 float-end">
                            <label for="category"
                                >Please select type of assistance
                                <span class="text-danger">*</span></label
                            >
                            <select
                                class="form-select"
                                id="category"
                                name="category"
                            >
                                <option
                                    v-for="assistance in assistances.data"
                                    :key="assistance.id"
                                >
                                    {{ assistance.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="dateIntake">Date</label>
                            <input
                                type="date"
                                class="form-control"
                                name="dateIntake"
                                id="dateIntake"
                            />
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3 mt-1">
                            <div class="col-md-4">
                                <label for="lastName" class="form-label"
                                    >Last Name</label
                                >
                                <span class="text-danger">*</span>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="lastName"
                                    name="lastName"
                                />
                            </div>

                            <div class="col-md-4">
                                <label for="firstName" class="form-label"
                                    >First Name</label
                                >
                                <span class="text-danger">*</span>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="firstName"
                                    name="firstName"
                                />
                            </div>

                            <div class="col-md-4">
                                <label for="middleName" class="form-label"
                                    >Middle Name<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <small> (type N/A if none.)</small>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="middleName"
                                    name="middleName"
                                />
                            </div>

                            <div class="col-md-4">
                                <label for="nickName" class="form-label"
                                    >Nick Name<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="nickName"
                                    name="nickName"
                                />
                            </div>

                            <div class="col-md-2">
                                <label for="age" class="form-label">Age</label>
                                <span class="text-danger">*</span>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="age"
                                    name="age"
                                />
                            </div>

                            <div class="col-md-3">
                                <label for="birthDate" class="form-label"
                                    >Date of Birth</label
                                >
                                <span class="text-danger">*</span>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="birthDate"
                                    name="birthDate"
                                />
                            </div>

                            <div class="col-md-3">
                                <label for="gender" class="form-label"
                                    >Gender</label
                                >
                                <span class="text-danger">*</span>
                                <select
                                    class="form-select"
                                    id="gender"
                                    name="gender"
                                >
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="purok"
                                    >Purok<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    name="purok"
                                    id="purok"
                                />
                            </div>

                            <div class="col-md-3">
                                <label for="barangay"
                                    >Barangay<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <select
                                    class="form-select"
                                    name="barangay"
                                    id="barangay"
                                >
                                    <option
                                        v-for="barangay in barangays.data"
                                        :key="barangay.id"
                                    >
                                        {{ barangay.barangay }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="municipal"
                                    >Municipality<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <select
                                    class="form-select"
                                    name="municipal"
                                    id="municipal"
                                >
                                    <option
                                        v-for="municipal in municipality.data"
                                        :key="municipal.id"
                                    >
                                        {{ municipal.municipality }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="civilStatus"
                                    >Civil Status<span class="text-danger"
                                        >*</span
                                    ></label
                                >
                                <select
                                    class="form-select"
                                    id="civilStatus"
                                    name="civilStatus"
                                >
                                    <option
                                        v-for="civil in civilStatus"
                                        :key="civil"
                                    >
                                        {{ civil }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="occupation" class="form-label"
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
                                <label for="contactNo" class="form-label"
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
                                <label for="income" class="form-label"
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

                            <div class="mt-4">
                                <button
                                    type="button"
                                    class="btn btn-primary float-end"
                                >
                                    Next
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
