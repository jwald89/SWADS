<script setup>
import { defineComponent, ref } from "vue";
import LayoutApp from "@/Shared/Layout.vue";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps({
    totalMunicipal: {
        type: Object,
        required: true,
    },
    currentYear: {
        type: Object,
    },
});

const municipalities = [
    "Bayabas",
    "Carmen",
    "Marihatag",
    "Lanuza",
    "Madrid",
    "Lingig",
    "Cortes",
    "Cagwait",
    "San Agustin",
    "Tagbina",
    "Carrascal",
    "Lianga",
    "San Miguel",
    "Cantilan",
    "Hinatuan",
    "Barobo",
    "Tago",
    "Bislig City",
    "Tandag City",
];

const sumMunicipal = municipalities.map(
    (data) => props.totalMunicipal[data] || 0
);

const data = ref({
    options: {
        chart: {
            id: "Per Municipality Report",
        },
        xaxis: {
            categories: municipalities,
        },
    },
    series: [
        {
            name: props.currentYear,
            data: sumMunicipal,
        },
    ],
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
                <h1>AICS Per Municipality</h1>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <div>
                        <apexchart
                            width="100%"
                            type="bar"
                            :options="data.options"
                            :series="data.series"
                        ></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </LayoutApp>
</template>
