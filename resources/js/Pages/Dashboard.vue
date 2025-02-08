<script setup>
import LayoutApp from "../Shared/Layout.vue";
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

const sectorData = ref([]);
const assistanceData = ref([]);
const municipalData = ref([]);

// Watch for changes in monitorStatus //
// Client data
watch(
    () => props.monitorStatus,
    (newValue) => {
        if (newValue && Array.isArray(newValue)) {
            sectorData.value = newValue
                .map((data) => ({
                    name: data.sector.name,
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
            sectorData.value = [];
        }
    },
    { immediate: true }
);

const renderSerctorChart = () => {
    if (sectorData.value.length === 0) {
        document.getElementById("reportsChart").innerHTML = ""; // Clear previous chart
        return; // Prevent rendering if no data
    }

    Highcharts.chart("reportsChart", {
        chart: {
            type: "column",
        },
        title: {
            text: "Cash amount served per sector",
        },
        accessibility: {
            announceNewData: {
                enabled: true,
            },
        },
        xAxis: {
            type: "category",
        },
        yAxis: {
            title: {
                text: "",
            },
        },
        legend: {
            enabled: false,
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: "{point.y:.2f}", // Adjusted to show actual amounts
                },
            },
        },
        tooltip: {
            headerFormat:
                '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat:
                '<span style="color:{point.color}">{point.name}</span>: <b>₱{point.y:.2f}</b><br/>',
        },
        series: [
            {
                name: "Amount",
                colorByPoint: true,
                data: sectorData.value,
            },
        ],
    });
};

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
        document.getElementById("analyticsReport").innerHTML = ""; // Clear previous chart
        return; // Prevent rendering if no data
    }

    Highcharts.chart("analyticsReport", {
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
                    name: data.municipality,
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
        document.getElementById("municipalChart").innerHTML = "";
        return; // Prevent rendering if no data
    }

    Highcharts.chart("municipalChart", {
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
watch(
    sectorData,
    assistanceData,
    municipalData,
    renderSerctorChart,
    renderAnalyticChart,
    renderMunicipality
);

// Render the chart when the component is mounted //
onMounted(() => {
    renderSerctorChart();
    renderAnalyticChart();
    renderMunicipality();
});

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
                                                {{ totalAmt }}
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
                                                        monitoring.intake.first_name
                                                            .split(" ")
                                                            .map(
                                                                (word) =>
                                                                    word
                                                                        .charAt(
                                                                            0
                                                                        )
                                                                        .toUpperCase() +
                                                                    word
                                                                        .slice(
                                                                            1
                                                                        )
                                                                        .toLowerCase()
                                                            )
                                                            .join(" ")
                                                    }}
                                                    {{
                                                        monitoring.intake.middle_name
                                                            .substr(0, 1)
                                                            .toUpperCase()
                                                    }}.
                                                    {{
                                                        monitoring.intake.last_name
                                                            .split(" ")
                                                            .map(
                                                                (word) =>
                                                                    word
                                                                        .charAt(
                                                                            0
                                                                        )
                                                                        .toUpperCase() +
                                                                    word
                                                                        .slice(
                                                                            1
                                                                        )
                                                                        .toLowerCase()
                                                            )
                                                            .join(" ")
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
                                                        status.intake.first_name
                                                            .split(" ")
                                                            .map(
                                                                (word) =>
                                                                    word
                                                                        .charAt(
                                                                            0
                                                                        )
                                                                        .toUpperCase() +
                                                                    word
                                                                        .slice(
                                                                            1
                                                                        )
                                                                        .toLowerCase()
                                                            )
                                                            .join(" ")
                                                    }}
                                                    {{
                                                        status.intake.middle_name
                                                            .substr(0, 1)
                                                            .toUpperCase()
                                                    }}.
                                                    {{
                                                        status.intake.last_name
                                                            .split(" ")
                                                            .map(
                                                                (word) =>
                                                                    word
                                                                        .charAt(
                                                                            0
                                                                        )
                                                                        .toUpperCase() +
                                                                    word
                                                                        .slice(
                                                                            1
                                                                        )
                                                                        .toLowerCase()
                                                            )
                                                            .join(" ")
                                                    }}
                                                </td>
                                                <td>
                                                    {{ status.sector.name }}
                                                </td>
                                                <td>
                                                    {{ status.charges }}
                                                </td>
                                                <td class="fw-bold">
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

                        <!-- Reports -->
                        <div class="col-12">
                            <div class="card">
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
                                        Sectors Report <span>/Today</span>
                                    </h5>

                                    <!-- Line Chart -->
                                    <div id="reportsChart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- End Reports -->
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

                            <div id="analyticsReport"></div>
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
                                Municipalities Report
                                <span>| Today</span>
                            </h5>

                            <div id="municipalChart"></div>
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
#reportsChart {
    min-height: 400px;
    width: 100%;
}

#analyticsReport {
    min-height: 400px;
    width: 100%;
}

#municipalReport {
    min-height: 400px;
    width: 100%;
}
</style>
