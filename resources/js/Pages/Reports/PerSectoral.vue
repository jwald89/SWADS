<script setup>
import { defineComponent, ref } from "vue";
import LayoutApp from "@/Shared/Layout.vue";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps({
    totalAssistance: {
        type: Object,
    },
    currentYear: {
        type: Object,
    },
});

const types = [
    "Medical",
    "Burial",
    "Educational",
    "Financial",
    "Livelihood",
    "Transportation",
    "Financial/ Solo Parent",
    "Financial/ Mentally ill",
    "Financial/ Special Case",
    "Financial/ Repatriated",
    "Financial/ VAWC",
];

// Map intakes data to match the month order
const assistance = types.map((type) => props.totalAssistance[type] || 0);

const data = ref({
    series: [
        {
            name: "CA " + props.currentYear,
            data: assistance,
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
            categories: types,
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
