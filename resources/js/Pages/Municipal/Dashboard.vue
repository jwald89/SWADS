<script setup>
import LayoutApp from "@/Shared/Layout.vue";
</script>

<template>
    <LayoutApp>
        <!-- <main id="main" class="main"> -->
        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-12">
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
                                        Sector's Overview <span>| Today</span>
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                        >
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>145</h6>
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
                                        Total Amount of Assistance
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
                                    <h5 class="card-title">
                                        Total No. of Assistance
                                    </h5>

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
                                                <th scope="row">
                                                    {{ monitoring.claimant }}
                                                </th>
                                                <td>
                                                    {{
                                                        monitoring.municipality
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        monitoring.assistance_type
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
                                                    {{ status.date_intake }}
                                                </td>
                                                <td>
                                                    {{ status.claimant }}
                                                </td>
                                                <td>
                                                    {{ status.sector }}
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
                    </div>
                    <!-- End Website Traffic -->
                </div>
                <!-- End Right side columns -->
            </div>
        </section>

        <!-- </main> -->
    </LayoutApp>
</template>
