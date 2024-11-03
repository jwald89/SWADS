<template>
    <div>
        <div id="container" ref="chartContainer"></div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import Highcharts from "highcharts";

const chartContainer = ref(null);

onMounted(() => {
    // Create the chart after the component is mounted
    Highcharts.chart(chartContainer.value, {
        chart: {
            type: "column",
        },
        title: {
            align: "left",
            text: "Sector Data Statistics. January, 2025 <br><br>",
        },
        // subtitle: {
        //     align: "left",
        //     text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>',
        // },
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
                text: "Total percent sector data",
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
                    format: "{point.y:.1f}%",
                },
            },
        },
        tooltip: {
            headerFormat:
                '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat:
                '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>',
        },
        series: [
            {
                name: "Sectors",
                colorByPoint: true,
                data: [
                    {
                        name: "Senior Citizen",
                        y: 63.06,
                        drilldown: "Senior Citizen",
                    },
                    { name: "Children", y: 19.84, drilldown: "Children" },
                    { name: "PWD", y: 4.18, drilldown: "PWD" },
                    { name: "Women", y: 4.12, drilldown: "Women" },
                    { name: "Youth", y: 2.33, drilldown: "Youth" },
                    {
                        name: "Solo Parent",
                        y: 0.45,
                        drilldown: "Solo Parent",
                    },
                    { name: "Men", y: 1.582, drilldown: null },
                ],
            },
        ],
        drilldown: {
            series: [
                {
                    name: "Chrome",
                    id: "Chrome",
                    data: [
                        ["v65.0", 0.1],
                        ["v64.0", 1.3],
                        ["v63.0", 53.02],
                    ],
                },
                {
                    name: "Safari",
                    id: "Safari",
                    data: [
                        ["v11.0", 3.39],
                        ["v10.1", 0.96],
                    ],
                },
                // Add other drilldown series as needed
            ],
        },
    });
});
</script>

<style scoped>
#container {
    width: 100%;
    height: 400px;
}
</style>
