<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import Highcharts from "highcharts";
import { ref, watch, onMounted } from "vue";

const props = defineProps({
    totalNums: String,
    totalAmt: String,
    monitorings: Object,
    monitorStatus: {
        type: Array,
        required: true,
    },
    sectorAvg: Object,
});

const assistanceData = ref([]);
const municipalData = ref([]);

// Type assistance data
watch(
    () => props.monitorStatus,
    (newValue) => {
        if (newValue && Array.isArray(newValue)) {
            assistanceData.value = newValue
                .map((data) => ({
                    name: data.assistance.name,
                    y: parseFloat(data.amount), // Ensure this is a number
                }))
                .filter((item) => !isNaN(item.y))
                .reduce((acc, current) => {
                    const existing = acc.find(
                        (item) => item.name === current.name
                    );
                    if (existing) {
                        existing.y += current.y; // Aggregate the amounts
                    } else {
                        acc.push({ ...current }); // Add new municipality
                    }
                    return acc;
                }, []);
        } else {
            assistanceData.value = [];
        }
    },
    { immediate: true }
);

const renderAnalyticChart = () => {
    if (assistanceData.value.length === 0) {
        document.getElementById("assistanceChartReport").innerHTML = ""; // Clear previous chart
        return; // Prevent rendering if no data
    }

    Highcharts.chart("assistanceChartReport", {
        chart: {
            type: "pie",
        },
        title: {
            text: "Cash assistance per category",
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: "pointer",
                dataLabels: [
                    {
                        enabled: true,
                        distance: 20,
                    },
                    {
                        enabled: true,
                        distance: -40,
                        format: "{point.percentage:.1f}%",
                        style: {
                            fontSize: "1.2em",
                            textOutline: "none",
                            opacity: 0.7,
                        },
                        filter: {
                            operator: ">",
                            property: "percentage",
                            value: 10,
                        },
                    },
                ],
            },
        },
        series: [
            {
                name: "Amount",
                colorByPoint: true,
                data: assistanceData.value,
            },
        ],
    });
};

// Municipality data
watch(
    () => props.monitorStatus,
    (newValue) => {
        if (newValue && Array.isArray(newValue)) {
            municipalData.value = newValue
                .map((data) => ({
                    name: data.municipal.municipality,
                    y: parseFloat(data.amount),
                }))
                .filter((item) => !isNaN(item.y)) // Filter out any NaN values
                .reduce((acc, current) => {
                    const existing = acc.find(
                        (item) => item.name === current.name
                    );
                    if (existing) {
                        existing.y += current.y; // Aggregate the amounts
                    } else {
                        acc.push({ ...current }); // Add new municipality
                    }
                    return acc;
                }, []);
        } else {
            municipalData.value = [];
        }
    },
    { immediate: true }
);

const renderMunicipality = () => {
    if (municipalData.value.length === 0) {
        document.getElementById("municipalChartReport").innerHTML = "";
        return; // Prevent rendering if no data
    }

    Highcharts.chart("municipalChartReport", {
        chart: {
            type: "pie",
            options3d: {
                enabled: true,
                alpha: 45,
            },
        },
        title: {
            text: "Cash amount served per municipality",
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45,
            },
        },
        series: [
            {
                name: "Amount",
                data: municipalData.value,
            },
        ],
    });
};

// Render the chart whenever sectorData changes //
watch(assistanceData, municipalData, renderAnalyticChart, renderMunicipality);

// Render the chart when the component is mounted //
onMounted(() => {
    renderAnalyticChart();
    renderMunicipality();
});

const formatName = (fname) => {
    return fname !== null
        ? fname
              .split(" ")
              .map(
                  (word) =>
                      word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
              )
              .join(" ")
        : "";
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
                                        Total sector served
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                        >
                                            <i
                                                class="bi bi-file-spreadsheet-fill"
                                            ></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ sectorAvg }}</h6>
                                            <span
                                                class="text-muted small pt-2 ps-1"
                                                >This Year</span
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
                                            <i class="bi bi-cash"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                ₱
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
                                                >Cash</span
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
                                            <i class="bi bi-kanban"></i>
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

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Recent Assistance <span>| Today</span>
                                    </h5>

                                    <div class="table-scroll">
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        Claimant
                                                    </th>
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
                                                                .first_name ===
                                                            null
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
                                                                .last_name ===
                                                            null
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
                                                            monitoring.municipal
                                                                .municipality
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            monitoring
                                                                .assistance.name
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
                                        Assistance Voucher Status
                                        <span>| Today</span>
                                    </h5>

                                    <div class="table-scroll">
                                        <table
                                            class="table table-borderless datatable"
                                        >
                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        Date Intake
                                                    </th>
                                                    <th scope="col">
                                                        Claimant
                                                    </th>
                                                    <th scope="col">Sector</th>
                                                    <th scope="col">
                                                        Office Charge
                                                    </th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                v-for="(
                                                    data, index
                                                ) in monitorStatus"
                                                :key="index"
                                                :class="{
                                                    'bg-claimed':
                                                        data.status ===
                                                        'CLAIMED',
                                                }"
                                            >
                                                <tr>
                                                    <td class="text-primary">
                                                        {{
                                                            formatDate(
                                                                data.date_intake
                                                            )
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            data.intake
                                                                .first_name ===
                                                            null
                                                                ? ""
                                                                : formatName(
                                                                      data
                                                                          .intake
                                                                          .first_name
                                                                  )
                                                        }}
                                                        {{
                                                            data.intake
                                                                .middle_name ===
                                                            null
                                                                ? ""
                                                                : formatName(
                                                                      data.intake.middle_name.substr(
                                                                          0,
                                                                          1
                                                                      )
                                                                  )
                                                        }}.
                                                        {{
                                                            data.intake
                                                                .last_name ===
                                                            null
                                                                ? ""
                                                                : formatName(
                                                                      data
                                                                          .intake
                                                                          .last_name
                                                                  )
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            data.sector_name
                                                                .name
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            data.charging_office
                                                                .description
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            new Intl.NumberFormat(
                                                                "en-US",
                                                                {
                                                                    minimumFractionDigits: 2,
                                                                    maximumFractionsDigits: 2,
                                                                }
                                                            ).format(
                                                                data.amount
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status ==
                                                            'PSWDO'
                                                        "
                                                        class="badge bg-pswdo text-light fw-bold"
                                                    >
                                                        {{ data.status }}
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status == 'PGO'
                                                        "
                                                        class="badge bg-pgo text-light fw-bold"
                                                    >
                                                        {{ data.status }}
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status == 'PBO'
                                                        "
                                                        class="badge bg-pbo text-dark fw-bold"
                                                    >
                                                        {{ data.status }}
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status ==
                                                            'PACCO'
                                                        "
                                                        class="badge bg-pacco text-dark fw-bold"
                                                    >
                                                        {{ data.status }}
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status == 'PTO'
                                                        "
                                                        class="badge bg-pto text-light fw-bold"
                                                    >
                                                        {{ data.status }}
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status ==
                                                            'CLAIMED'
                                                        "
                                                        class="fw-bold"
                                                    >
                                                        {{ data.status }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
                            <h5 class="card-title">Assistance Report</h5>

                            <div id="assistanceChartReport"></div>
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

                            <div id="municipalChartReport"></div>
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

<style scoped>
#assistanceChartReport {
    min-height: 400px;
    width: 100%;
}

#municipalChartReport {
    min-height: 400px;
    width: 100%;
}

.table-scroll {
    max-height: 25vh !important;
    overflow-y: scroll;
}

.bg-claimed {
    background: #a7ff83;
}

.bg-pswdo {
    background: #c300ff;
}

.bg-pbo {
    background: #f5eded;
}

.bg-pto {
    background: #ff6200;
}

.bg-pacco {
    background: #ffbe0a;
}

.bg-pgo {
    background: #2f89fc;
}
</style>
