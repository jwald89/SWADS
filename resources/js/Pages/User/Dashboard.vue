<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import Chart from "@/components/Chart.vue";

const props = defineProps({
    totalNums: {
        type: String,
    },
    totalAmt: {
        type: String,
    },
    monitorings: {
        type: Object,
    },
    monitorStatus: {
        type: Object,
    },
    sumOfSectors: {
        type: String,
    },
});

const formatName = (fname) => {
    return fname
        .split(" ")
        .map(
            (word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
        )
        .join(" ");
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
</script>

<template>
    <LayoutApp>
        <!-- <main id="main" class="main"> -->
        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">
                        <!-- Sales Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="filter">
                                    <a
                                        class="icon"
                                        href="#"
                                        data-bs-toggle="dropdown"
                                        ><i class="bi bi-three-dots"></i
                                    ></a>
                                    <ul
                                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                                    >
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >Today</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >This Month</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >This Year</a
                                            >
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Sector's Overview
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                        >
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ sumOfSectors }}</h6>
                                            <span
                                                class="text-muted small pt-2 ps-1"
                                                >Month</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="filter">
                                    <a
                                        class="icon"
                                        href="#"
                                        data-bs-toggle="dropdown"
                                        ><i class="bi bi-three-dots"></i
                                    ></a>
                                    <ul
                                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                                    >
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >Today</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >This Month</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >This Year</a
                                            >
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total amount of assistance
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                        >
                                            <i
                                                class="bi bi-currency-dollar"
                                            ></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                {{
                                                    new Intl.NumberFormat(
                                                        "en-US",
                                                        {
                                                            minimumFractionDigits: 2,
                                                            maximumFractionsDigits: 2,
                                                        }
                                                    ).format(totalAmt)
                                                }}
                                            </h6>
                                            <span
                                                class="text-muted small pt-2 ps-1"
                                                >Money</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Revenue Card -->

                        <!-- Customers Card -->
                        <div class="col-xxl-4 col-xl-12">
                            <div class="card info-card customers-card">
                                <div class="filter">
                                    <a
                                        class="icon"
                                        href="#"
                                        data-bs-toggle="dropdown"
                                        ><i class="bi bi-three-dots"></i
                                    ></a>
                                    <ul
                                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                                    >
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >Today</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >This Month</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >This Year</a
                                            >
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Total assistance</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                        >
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ totalNums }}</h6>
                                            <span
                                                class="text-muted small pt-2 ps-1"
                                                >This Year</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Customers Card -->

                        <!-- Recent Assistance -->
                        <div class="col-12">
                            <div class="card top-selling overflow-auto">
                                <div class="filter">
                                    <a
                                        class="icon"
                                        href="#"
                                        data-bs-toggle="dropdown"
                                        ><i class="bi bi-three-dots"></i
                                    ></a>
                                    <ul
                                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                                    >
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >Today</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >This Month</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >This Year</a
                                            >
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body pb-0">
                                    <h5 class="card-title">
                                        Recent Assistance <span>| Today</span>
                                    </h5>

                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col">Claimant</th>
                                                <th scope="col">
                                                    Municipality
                                                </th>
                                                <th scope="col">
                                                    Type Assistance
                                                </th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            v-for="(
                                                monitoring, index
                                            ) in monitorings"
                                            :key="index"
                                        >
                                            <tr>
                                                <td scope="row">
                                                    {{
                                                        monitoring.intake
                                                            .first_name === null
                                                            ? ""
                                                            : formatName(
                                                                  monitoring
                                                                      .intake
                                                                      .first_name
                                                              )
                                                    }}
                                                    {{
                                                        monitoring.intake
                                                            .middle_name ===
                                                        null
                                                            ? ""
                                                            : formatName(
                                                                  monitoring.intake.middle_name.substr(
                                                                      0,
                                                                      1
                                                                  )
                                                              )
                                                    }}.
                                                    {{
                                                        monitoring.intake
                                                            .last_name === null
                                                            ? ""
                                                            : formatName(
                                                                  monitoring
                                                                      .intake
                                                                      .last_name
                                                              )
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        monitoring.municipality
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        monitoring.assistance
                                                            .name
                                                    }}
                                                </td>
                                                <td class="fw-bold">
                                                    ₱
                                                    {{
                                                        new Intl.NumberFormat(
                                                            "en-US",
                                                            {
                                                                minimumFractionDigits: 2,
                                                                maximumFractionsDigits: 2,
                                                            }
                                                        ).format(
                                                            monitoring.amount
                                                        )
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End Recent Assistance -->

                        <!-- Assistance Status -->
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="filter">
                                    <a
                                        class="icon"
                                        href="#"
                                        data-bs-toggle="dropdown"
                                        ><i class="bi bi-three-dots"></i
                                    ></a>
                                    <ul
                                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                                    >
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >Today</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >This Month</a
                                            >
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                >This Year</a
                                            >
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Assistance Status <span>| Today</span>
                                    </h5>

                                    <table
                                        class="table table-borderless datatable"
                                    >
                                        <thead>
                                            <tr>
                                                <th scope="col">Date Intake</th>
                                                <th scope="col">Claimant</th>
                                                <th scope="col">Sector</th>
                                                <th scope="col">Charges</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            v-for="(
                                                status, index
                                            ) in monitorStatus"
                                            :key="index"
                                        >
                                            <tr>
                                                <td class="text-primary">
                                                    {{
                                                        formatDate(
                                                            status.date_intake
                                                        )
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        status.intake
                                                            .first_name === null
                                                            ? ""
                                                            : formatName(
                                                                  status.intake
                                                                      .first_name
                                                              )
                                                    }}
                                                    {{
                                                        status.intake
                                                            .middle_name ===
                                                        null
                                                            ? ""
                                                            : formatName(
                                                                  status.intake.middle_name.substr(
                                                                      0,
                                                                      1
                                                                  )
                                                              )
                                                    }}.
                                                    {{
                                                        status.intake
                                                            .last_name === null
                                                            ? ""
                                                            : formatName(
                                                                  status.intake
                                                                      .last_name
                                                              )
                                                    }}
                                                </td>
                                                <td>
                                                    {{ status.sector.name }}
                                                </td>
                                                <td>
                                                    {{ status.charges }}
                                                </td>
                                                <td>
                                                    {{
                                                        new Intl.NumberFormat(
                                                            "en-US",
                                                            {
                                                                minimumFractionDigits: 2,
                                                                maximumFractionsDigits: 2,
                                                            }
                                                        ).format(status.amount)
                                                    }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-success"
                                                        >{{
                                                            status.status
                                                        }}</span
                                                    >
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End Assistance Status -->
                    </div>
                </div>
                <!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">
                    <!-- Recent Activity -->
                    <div class="card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"
                                ><i class="bi bi-three-dots"></i
                            ></a>
                            <ul
                                class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                            >
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="#">Today</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        >This Month</a
                                    >
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        >This Year</a
                                    >
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Analytics Report</h5>

                            <div class="activity">
                                <Chart />
                            </div>
                        </div>
                    </div>
                    <!-- End Recent Activity -->

                    <!-- Municipality Report -->
                    <div class="card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"
                                ><i class="bi bi-three-dots"></i
                            ></a>
                            <ul
                                class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                            >
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="#">Today</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        >This Month</a
                                    >
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        >This Year</a
                                    >
                                </li>
                            </ul>
                        </div>

                        <div class="card-body pb-0">
                            <h5 class="card-title">
                                Municipality Report
                                <span>| Today</span>
                            </h5>

                            <div
                                id="trafficChart"
                                style="min-height: 400px"
                                class="echart"
                            ></div>
                        </div>
                    </div>
                    <!-- End Website Traffic -->
                </div>
                <!-- End Right side columns -->
            </div>
        </section>

        <!-- </main> -->
    </LayoutApp>
</template>
