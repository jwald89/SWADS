<script setup>
import LayoutApp from "../../Shared/Layout.vue";
import Highcharts from "highcharts";
import { ref, watch, onMounted } from "vue";

const props = defineProps({
    sectorAvg: String,
    totalBrgy: String,
    barangays: {
        type: Array,
        required: true,
    },
    sectors: String,
});

const brgyData = ref([]);
const sectorData = ref([]);

// Barangay data
watch(
    () => props.barangays,
    (newValue) => {
        if (newValue && Array.isArray(newValue)) {
            brgyData.value = newValue
                .map((data) => ({
                    name: data.barangay.barangay,
                    y: 1,
                    drilldown: data.barangay.barangay,
                }))
                .filter((item) => !isNaN(item.y)) // Filter out any NaN values
                .reduce((acc, current) => {
                    const existing = acc.find(
                        (item) => item.name === current.name
                    );
                    if (existing) {
                        existing.y += current.y; // Aggregate the numbers
                    } else {
                        acc.push({ ...current }); // Add new barangay
                    }
                    return acc;
                }, []);
        } else {
            brgyData.value = [];
        }
    },
    { immediate: true }
);

const renderBrgy = () => {
    if (brgyData.value.length === 0) {
        document.getElementById("brgyChartReport").innerHTML = "";
        return; // Prevent rendering if no data
    }

    Highcharts.chart("brgyChartReport", {
        chart: {
            type: "column",
        },
        title: {
            text: "Total barangay is served",
        },
        accessibility: {
            announceNewData: {
                enabled: true,
            },
        },
        xAxis: {
            type: "category",
        },
        legend: {
            enabled: false,
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: "{point.y}",
                },
            },
        },

        tooltip: {
            headerFormat:
                '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat:
                '<span style="color:{point.color}">{point.name}</span>: ' +
                "<b>{point.y}</b> of total<br/>",
        },

        series: [
            {
                name: "Barangays",
                colorByPoint: true,
                data: brgyData.value,
            },
        ],
        drilldown: {
            breadcrumbs: {
                position: {
                    align: "right",
                },
            },
            series: [
                {
                    data: brgyData.value,
                },
            ],
        },
    });

    // (function (H) {
    //     H.seriesTypes.pie.prototype.animate = function (init) {
    //         const series = this,
    //             chart = series.chart,
    //             points = series.points,
    //             { animation } = series.options,
    //             { startAngleRad } = series;

    //         function fanAnimate(point, startAngleRad) {
    //             const graphic = point.graphic,
    //                 args = point.shapeArgs;

    //             if (graphic && args) {
    //                 graphic
    //                     .attr({
    //                         start: startAngleRad,
    //                         end: startAngleRad,
    //                         opacity: 1,
    //                     })
    //                     .animate(
    //                         {
    //                             start: args.start,
    //                             end: args.end,
    //                         },
    //                         {
    //                             duration: animation.duration / points.length,
    //                         },
    //                         function () {
    //                             if (points[point.index + 1]) {
    //                                 fanAnimate(
    //                                     points[point.index + 1],
    //                                     args.end
    //                                 );
    //                             }
    //                             if (point.index === series.points.length - 1) {
    //                                 series.dataLabelsGroup.animate(
    //                                     { opacity: 1 },
    //                                     void 0,
    //                                     function () {
    //                                         points.forEach((point) => {
    //                                             point.opacity = 1;
    //                                         });
    //                                         series.update(
    //                                             {
    //                                                 enableMouseTracking: true,
    //                                             },
    //                                             false
    //                                         );
    //                                         chart.update({
    //                                             plotOptions: {
    //                                                 pie: {
    //                                                     innerSize: "40%",
    //                                                     borderRadius: 8,
    //                                                 },
    //                                             },
    //                                         });
    //                                     }
    //                                 );
    //                             }
    //                         }
    //                     );
    //             }
    //         }

    //         if (init) {
    //             points.forEach((point) => {
    //                 point.opacity = 0; // Hide points on init
    //             });
    //         } else {
    //             fanAnimate(points[0], startAngleRad);
    //         }
    //     };
    // })(Highcharts);

    // // Render the Highcharts pie chart
    // Highcharts.chart("brgyChartReport", {
    //     chart: {
    //         type: "pie",
    //     },
    //     title: {
    //         text: "Total of barangay served",
    //     },
    //     tooltip: {
    //         headerFormat: "",
    //         pointFormat:
    //             '<span style="color:{point.color}">\u25cf</span> ' +
    //             "{point.name}: <b>{point.y}</b>",
    //     },
    //     accessibility: {
    //         point: {
    //             valueSuffix: "%",
    //         },
    //     },
    //     plotOptions: {
    //         pie: {
    //             allowPointSelect: true,
    //             borderWidth: 2,
    //             cursor: "pointer",
    //             dataLabels: {
    //                 enabled: true,
    //                 format: "<b>{point.name}</b><br>{point.percentage}%",
    //                 distance: 20,
    //             },
    //         },
    //     },
    //     series: [
    //         {
    //             enableMouseTracking: false, // Disable mouse tracking on load
    //             animation: {
    //                 duration: 2000,
    //             },
    //             colorByPoint: true,
    //             data: brgyData.value,
    //         },
    //     ],
    // });
};

// Sector data
watch(
    () => props.barangays,
    (newValue) => {
        if (newValue && Array.isArray(newValue)) {
            sectorData.value = newValue
                .map((data) => ({
                    name: data.sector.name,
                    y: 1,
                }))
                .filter((item) => !isNaN(item.y)) // Filter out any NaN values
                .reduce((acc, current) => {
                    const existing = acc.find(
                        (item) => item.name === current.name
                    );
                    if (existing) {
                        existing.y += current.y; // Aggregate the numbers
                    } else {
                        acc.push({ ...current }); // Add new barangay
                    }
                    return acc;
                }, []);
        } else {
            sectorData.value = [];
        }
    },
    { immediate: true }
);

const renderSector = () => {
    if (sectorData.value.length === 0) {
        document.getElementById("sectorChartReport").innerHTML = "";
        return; // Prevent rendering if no data
    }

    Highcharts.chart("sectorChartReport", {
        chart: {
            type: "pie",
        },
        title: {
            text: "Total of sector served",
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
                name: "Total Numbers",
                colorByPoint: true,
                data: sectorData.value,
            },
        ],
    });
};

// Render the chart whenever barangay changes //
watch(brgyData, sectorData, renderBrgy, renderSector);

// Render the chart when the component is mounted //
onMounted(() => {
    renderBrgy();
    renderSector();
});
</script>

<template>
    <LayoutApp>
        <!-- <main id="main" class="main"> -->
        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">
                        <!-- Sector Card -->
                        <div class="col-xxl-6">
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
                                        Sectors Total Served
                                        <span>| Today</span>
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
                        <!-- End Sector Card -->

                        <!-- Barangay Card -->
                        <div class="col-xxl-6">
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
                                        Total Barangay Served
                                        <span>| Today</span>
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center text-success"
                                        >
                                            <i
                                                class="bi bi-journal-richtext"
                                            ></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ totalBrgy }}</h6>
                                            <span
                                                class="text-muted small pt-2 ps-1"
                                                >This Year</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Sector Card -->

                        <div class="col-xxl-4">
                            <!-- Sector Report -->
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

                                <div class="card-body pb-0">
                                    <h5 class="card-title">
                                        Sectors Report
                                        <span>| Today</span>
                                    </h5>

                                    <div id="sectorChartReport"></div>
                                </div>
                            </div>
                            <!-- End Sector Report -->
                        </div>

                        <div class="col-xxl-8">
                            <!-- Barangay Report -->
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

                                <div class="card-body pb-0">
                                    <h5 class="card-title">
                                        Barangays Report
                                        <span>| Today</span>
                                    </h5>

                                    <div id="brgyChartReport"></div>
                                </div>
                            </div>
                            <!-- End Barangay Report -->
                        </div>

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
                                                <th scope="col">Sector</th>
                                                <th scope="col">Client</th>
                                                <th scope="col">Age</th>
                                                <th scope="col">
                                                    Date of Birth
                                                </th>
                                                <th scope="col">Barangay</th>
                                                <th scope="col">
                                                    Date_encoded
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    data, index
                                                ) in barangays"
                                                :key="index"
                                            >
                                                <td>
                                                    {{ data.sector.name }}
                                                </td>
                                                <td>
                                                    {{ data.first_name }}
                                                </td>
                                                <td>
                                                    {{ data.age }}
                                                </td>
                                                <td>
                                                    {{ data.birthdate }}
                                                </td>
                                                <td>
                                                    {{ data.barangay.barangay }}
                                                </td>
                                                <td>
                                                    {{ data.date_encoded }}
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
            </div>
        </section>

        <!-- </main> -->
    </LayoutApp>
</template>
