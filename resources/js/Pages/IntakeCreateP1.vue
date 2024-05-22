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
                    <div class="card-body">
                        <form class="row g-3 mt-3">
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
                                <label for="age" class="form-label">Age</label>
                                <span class="text-danger">*</span>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="age"
                                    name="age"
                                />
                            </div>
                            <div class="col-md-3">
                                <label for="birthDate" class="form-label"
                                    >Birth Date</label
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
                                <input
                                    type="password"
                                    class="form-control"
                                    id="gender"
                                    name="gender"
                                />
                            </div>
                            <div class="col-md-3">
                                <label for="civilStatus" class="form-label"
                                    >Civil Status</label
                                >
                                <span class="text-danger">*</span>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="civilStatus"
                                    name="civilStatus"
                                />
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label"
                                    >Address</label
                                >
                                <span class="text-danger">*</span>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="address"
                                    name="address"
                                    placeholder="1234 Main St"
                                />
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

                            <div class="text-center">
                                <button
                                    type="submit"
                                    class="btn btn-primary me-2"
                                >
                                    Save
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
