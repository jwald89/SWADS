<template>
    <div
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
                                >Last Name<span class="text-danger"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="lastName"
                                name="lastName"
                            />
                        </div>
                        <div class="col-md-4">
                            <label for="firstName"
                                >First Name<span class="text-danger"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="firstName"
                                name="firstName"
                            />
                        </div>
                        <div class="col-md-4">
                            <label for="middleName"
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
                        <div class="col-md-5">
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
                        <div class="col-md-7">
                            <label for="relationship"
                                >Relationship<span class="text-danger"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="relationship"
                                name="relationship"
                            />
                        </div>
                        <div class="col-12">
                            <label for="educationalBg"
                                >Educational Attainment</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="educationalBg"
                                name="educationalBg"
                            />
                        </div>
                        <div class="col-md-12">
                            <label for="remarks">Remarks</label>
                            <input
                                type="text"
                                class="form-control"
                                id="remarks"
                                name="remarks"
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
</template>
