<script setup>
import { defineComponent, ref } from "vue";
import LayoutApp from "@/Shared/Layout.vue";
import VueApexCharts from "vue3-apexcharts";

const colors = ref();

const data = ref({
    series: [
        {
            data: [21, 22, 10, 28, 16],
            name: "2025",
        },
    ],
    chartOptions: {
        chart: {
            height: 350,
            type: "bar",
            events: {
                click: function (chart, w, e) {
                    // console.log(chart, w, e)
                },
            },
        },
        colors: colors,
        plotOptions: {
            bar: {
                columnWidth: "45%",
                distributed: true,
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        xaxis: {
            categories: [
                ["Youth"],
                ["Children"],
                ["Senior Citizen"],
                ["Women"],
                ["Men"],
            ],
            labels: {
                style: {
                    colors: colors,
                    fontSize: "12px",
                },
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
                <h1>AICS Served Per Sectoral Group</h1>
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
