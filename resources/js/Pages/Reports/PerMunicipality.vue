<script setup>
import { defineComponent, ref } from "vue";
import LayoutApp from "@/Shared/Layout.vue";
import VueApexCharts from "vue3-apexcharts";

const data = ref({
    options: {
        chart: {
            id: "vuechart-example",
        },
        xaxis: {
            categories: [
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
            ],
        },
    },
    series: [
        {
            name: "2025",
            data: [
                30, 40, 45, 50, 49, 60, 70, 91, 30, 40, 45, 50, 49, 60, 70, 91,
                55, 88, 38,
            ],
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
