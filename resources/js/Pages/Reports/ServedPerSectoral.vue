<script setup>
import { defineComponent, ref } from "vue";
import LayoutApp from "/resources/js/Shared//Layout.vue";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps({
    sectors: {
        type: Array,
        required: true,
    },
    totalSectors: {
        type: Object,
        required: true,
    },
    currentYear: {
        type: Object,
    },
});

const colors = ref();
const sectorData = ref(props.sectors);

// Map intakes data to match the month order
const sector = sectorData.value.map((sec) => props.totalSectors[sec] || 0);

const data = ref({
    series: [
        {
            data: sector,
            name: "CY " + props.currentYear,
        },
    ],
    chartOptions: {
        chart: {
            height: 350,
            type: "bar",
            events: {
                click: function (chart, w, e) {},
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
            categories: sectorData,
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
