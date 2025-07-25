<script setup>
import LayoutApp from "../Shared/Layout.vue";
import Highcharts from "highcharts";
import { ref, watch, onMounted } from "vue";
import axios from "axios";

const props = defineProps({
    totalNums: String,
    totalAmt: String,
    monitorings: Object,
    monitorStatus: {
        type: Object,
        required: true,
    },
    sectorAvg: Object,
});

const sectorData = ref([]);
const assistanceData = ref([]);
const municipalData = ref([]);

const currentMunicipalFilter = ref("Year");
const currentAssistanceFilter = ref("Year");
const currentSectorFilter = ref("Year");

// Type sector data
const fetchSectorData = async (filter) => {
    currentSectorFilter.value =
        filter.charAt(0).toUpperCase() + filter.slice(1);
    try {
        const response = await axios.get(`/sector-data?filter=${filter}`);
        const data = response.data.data;
        sectorData.value = data.map((item) => ({
            name: item.name,
            y: parseFloat(item.cash_assistance) || 0,
        }));
        renderSerctorChart();
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

// Watch for changes in monitorStatus //
// Client data
watch(
    () => props.monitorStatus,
    (newValue) => {
        if (newValue) {
            sectorData.value = newValue
                .map((data) => ({
                    name: data.sector_name.name,
                    y: parseFloat(data.remarkable?.cash_assistance),
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
        document.getElementById("sectorsChartReport").innerHTML = ""; // Clear previous chart
        return; // Prevent rendering if no data
    }

    Highcharts.chart("sectorsChartReport", {
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
        colors: ["#808080", "#0000FF", "#8bbc21", "#FFD700", "#FFFF00"],
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: "₱ {point.y:,.2f}",
                },
            },
        },
        tooltip: {
            headerFormat:
                '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat:
                '<span style="color:{point.color}">{point.name}</span>: <b>₱ {point.y:,.2f}</b><br/>',
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

onMounted(() => {
    fetchSectorData("year");
});

// Type assistance data
const fetchAssistanceData = async (filter) => {
    currentAssistanceFilter.value =
        filter.charAt(0).toUpperCase() + filter.slice(1);
    try {
        const response = await axios.get(`/assistance-data?filter=${filter}`);
        const data = response.data.data;
        assistanceData.value = data.map((item) => ({
            name: item.name,
            y: parseFloat(item.cash_assistance) || 0,
        }));
        renderAnalyticChart();
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

watch(
    () => props.monitorStatus,
    (newValue) => {
        if (newValue) {
            assistanceData.value = newValue
                .map((data) => ({
                    name: data.assistance.name,
                    y: parseFloat(data.remarkable?.cash_assistance),
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

onMounted(() => {
    fetchAssistanceData("year");
});

// Municipality data
const fetchMunicipalData = async (filter) => {
    currentMunicipalFilter.value =
        filter.charAt(0).toUpperCase() + filter.slice(1);
    try {
        const response = await axios.get(`/municipality-data?filter=${filter}`);
        const data = response.data.data;
        municipalData.value = data.map((item) => ({
            name: item.municipality,
            y: parseFloat(item.cash_assistance) || 0,
        }));
        renderMunicipality();
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

watch(
    () => props.monitorStatus,
    (newValue) => {
        // if (newValue && Array.isArray(newValue)) {
        if (newValue) {
            municipalData.value = newValue
                .map((data) => ({
                    name: data.municipal.municipality,
                    y: parseFloat(data.remarkable?.cash_assistance),
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
            series: {
                pie: {
                    innerSize: 100,
                    depth: 45,
                },
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

onMounted(() => {
    fetchMunicipalData("year"); // Fetch initial data
});

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
                        <!-- Sector served Card -->
                        <!-- <div class="col-xxl-4 col-md-6">
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
                        </div> -->
                        <!-- End Sector served Card -->

                        <!-- Cash Assistance Card -->
                        <div class="col-xxl-6 col-md-12">
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
                        <!-- End Cash Assistance Card -->

                        <!-- Total Assistance Card -->
                        <div class="col-xxl-6 col-md-12">
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

                        <!-- Sector Reports -->
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
                                            <a
                                                class="dropdown-item"
                                                href="#"
                                                @click="
                                                    fetchSectorData('today')
                                                "
                                                >Today</a
                                            >
                                        </li>
                                        <li>
                                            <a
                                                class="dropdown-item"
                                                href="#"
                                                @click="
                                                    fetchSectorData('month')
                                                "
                                                >This Month</a
                                            >
                                        </li>
                                        <li>
                                            <a
                                                class="dropdown-item"
                                                href="#"
                                                @click="fetchSectorData('year')"
                                                >This Year</a
                                            >
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Sectors Report
                                        <span>| {{ currentSectorFilter }}</span>
                                    </h5>

                                    <!-- Line Chart -->
                                    <div id="sectorsChartReport"></div>
                                </div>
                            </div>
                        </div>
                        <!-- End Sector Reports -->

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
                                        <table class="table table-borderless">
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
                                                            data.first_name
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
                                                            data.middle_name ===
                                                            null
                                                                ? ""
                                                                : data.middle_name
                                                                      .substr(
                                                                          0,
                                                                          1
                                                                      )
                                                                      .toUpperCase() +
                                                                  "."
                                                        }}
                                                        {{
                                                            data.last_name
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
                                                    <td class="fw-bold">
                                                        {{
                                                            new Intl.NumberFormat(
                                                                "en-US",
                                                                {
                                                                    minimumFractionDigits: 2,
                                                                    maximumFractionDigits: 2,
                                                                }
                                                            ).format(
                                                                data.remarkable
                                                                    ?.cash_assistance
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status ==
                                                            'PSWDO'
                                                        "
                                                    >
                                                        <span
                                                            class="badge bg-pswdo"
                                                            >{{
                                                                data.status
                                                            }}</span
                                                        >
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status == 'PGO'
                                                        "
                                                    >
                                                        <span
                                                            class="badge bg-pgo"
                                                            >{{
                                                                data.status
                                                            }}</span
                                                        >
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status == 'PBO'
                                                        "
                                                    >
                                                        <span
                                                            class="badge bg-pbo"
                                                            >{{
                                                                data.status
                                                            }}</span
                                                        >
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status ==
                                                            'PACCO'
                                                        "
                                                    >
                                                        <span
                                                            class="badge bg-pacco"
                                                            >{{
                                                                data.status
                                                            }}</span
                                                        >
                                                    </td>
                                                    <td
                                                        v-if="
                                                            data.status == 'PTO'
                                                        "
                                                    >
                                                        <span
                                                            class="badge bg-pto"
                                                            >{{
                                                                data.status
                                                            }}</span
                                                        >
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
                                        Recent Assistance
                                        <span>| Year</span>
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
                                                            monitoring.first_name
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
                                                            monitoring.middle_name ===
                                                            null
                                                                ? ""
                                                                : monitoring.middle_name
                                                                      .substr(
                                                                          0,
                                                                          1
                                                                      )
                                                                      .toUpperCase() +
                                                                  "."
                                                        }}
                                                        {{
                                                            monitoring.last_name
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
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        @click="fetchAssistanceData('today')"
                                        >Today</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        @click="fetchAssistanceData('month')"
                                        >This Month</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        @click="fetchAssistanceData('year')"
                                        >This Year</a
                                    >
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">
                                Assistance Report
                                <span>| {{ currentAssistanceFilter }}</span>
                            </h5>

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
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        @click="fetchMunicipalData('today')"
                                        >Today</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        @click="fetchMunicipalData('month')"
                                        >This Month</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        @click="fetchMunicipalData('year')"
                                        >This Year</a
                                    >
                                </li>
                            </ul>
                        </div>

                        <div class="card-body pb-0">
                            <h5 class="card-title">
                                Municipalities Report
                                <span>| {{ currentMunicipalFilter }}</span>
                            </h5>

                            <div id="municipalChartReport"></div>
                        </div>
                    </div>
                    <!-- End Municipality Report -->
                </div>
                <!-- End Right side columns -->
            </div>
        </section>

        <!-- </main> -->
    </LayoutApp>
</template>

<style scoped>
#sectorsChartReport {
    min-height: 400px;
    width: 100%;
}

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
    background: #006a6a;
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
