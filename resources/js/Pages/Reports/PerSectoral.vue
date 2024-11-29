<script setup>
import { defineComponent, ref } from "vue";
import LayoutApp from "@/Shared/Layout.vue";
import VueApexCharts from "vue3-apexcharts";

const data = ref({
    series: [
        {
            name: "2025",
            data: [44, 55, 41, 67, 22, 43, 21, 33, 45, 31, 87, 65],
        },
    ],
    chartOptions: {
        annotations: {
            points: [
                {
                    x: "Bananas",
                    seriesIndex: 0,
                    label: {
                        borderColor: "#775DD0",
                        offsetY: 0,
                        style: {
                            color: "#fff",
                            background: "#775DD0",
                        },
                        text: "Bananas are good",
                    },
                },
            ],
        },
        chart: {
            height: 350,
            type: "bar",
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                columnWidth: "50%",
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 0,
        },
        grid: {
            row: {
                colors: ["#fff", "#f2f2f2"],
            },
        },
        xaxis: {
            labels: {
                rotate: -45,
            },
            categories: [
                ["Livelihood", "Assistance"],
                ["Medical", "Assistance", "PWD"],
                "Special Case/Rape",
                ["Repatriated", "OFW"],
                ["Special", "Case"],
                "Mentally ill",
                ["Former", "Rebel"],
                ["Financial", "Assistance"],
                "Solo Parent",
                ["Educational", "Assistance"],
                ["Medical", "Assistance"],
                ["Burial", "Assistance"],
            ],
            tickPlacement: "on",
        },
        yaxis: {
            title: {
                text: "2025",
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                shade: "light",
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 0.85,
                opacityTo: 0.85,
                stops: [50, 0, 100],
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
                <h1>AICS Per Sectoral Group</h1>
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
