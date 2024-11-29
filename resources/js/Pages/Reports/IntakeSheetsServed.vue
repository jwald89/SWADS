<script setup>
import { defineComponent, ref } from "vue";
import LayoutApp from "@/Shared/Layout.vue";
import VueApexCharts from "vue3-apexcharts";

const data = ref({
    series: [
        {
            name: "Inflation",
            data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2],
        },
    ],
    chartOptions: {
        chart: {
            height: 350,
            type: "bar",
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                dataLabels: {
                    position: "top", // top, center, bottom
                },
            },
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val + "%";
            },
            offsetY: -20,
            style: {
                fontSize: "12px",
                colors: ["#304758"],
            },
        },

        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
            position: "top",
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            crosshairs: {
                fill: {
                    type: "gradient",
                    gradient: {
                        colorFrom: "#D8E3F0",
                        colorTo: "#BED1E6",
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    },
                },
            },
            tooltip: {
                enabled: true,
            },
        },
        yaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return val + "%";
                },
            },
        },
        title: {
            text: "2025",
            floating: true,
            offsetY: 330,
            align: "right",
            style: {
                color: "#444",
            },
        },
    },
});

defineComponent({
    VueApexCharts,
});
</script>

<template>
    <LayoutApp>
        <div class="row">
            <div
                class="card-header text-light"
                style="background-color: #581b98"
            >
                <h1>Intake Sheets & Certificate of Eligibility Served</h1>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <div>
                        <apexchart
                            width="100%"
                            type="bar"
                            :options="data.chartOptions"
                            :series="data.series"
                        ></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
