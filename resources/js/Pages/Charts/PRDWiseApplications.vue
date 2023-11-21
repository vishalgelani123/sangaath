<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="flex items-center justify-between">
                <div class="w-full border-b border-gray-200">
                    <nav class="-mb-px flex" aria-label="Tabs">
                        <Link href="/charts/village-wise-applications"
                            :class="['border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm']"
                            aria-current="page">
                        Village Wise Applications
                        </Link>
                        <Link href="/charts/scheme-wise-applications"
                            :class="['border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm']"
                            aria-current="page">
                        Scheme Wise Applications
                        </Link>
                        <Link
                            :class="['border-blue-500 text-blue-600', 'w-1/5 py-4 px-1 text-center border-b-2 font-semibold text-sm']"
                            aria-current="page">
                        PRD Wise Applications
                        </Link>
                        <Link href="/charts/card-disbursement"
                            :class="['border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm']"
                            aria-current="page">
                        Card Disbursement
                        </Link>
                        <Link href="/charts/prerequisite-digitized"
                            :class="['border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm']"
                            aria-current="page">
                        Pre-Requisite Digitized
                        </Link>
                    </nav>
                </div>
            </div>

            <!-- Basic Charts -->
            <div class="mt-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-sm">
                    <InputLabel for="village_site" value="Filter by Site" />

                    <select v-model="filter.site" @change="getData" id="filter_site"
                        class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
                        <option value="all">All Sites</option>
                        <option v-for="site in sites" :key="site.id" :value="site.id">
                            {{ site.name }} ({{ site.display_state }})
                        </option>
                    </select>
                </div>
                <div class="mt-10">
                    <apexchart width="100%" height="500px" type="bar" :options="chart.options" :series="chart.series">
                    </apexchart>
                </div>
            </div>
            <div class="mt-4">
                <div class="inline-block min-w-full border-b border-gray-200 align-middle">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-t border-gray-200">
                                <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                    scope="col">#</th>
                                <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                    scope="col">
                                    <span class="lg:pl-2">Scheme</span>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                    scope="col">Applications</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <tr v-for="(application, applicationIdx) in applications" :key="applicationIdx">
                                <td
                                    class="hidden whitespace-nowrap px-6 py-1.5 text-right text-sm text-gray-500 md:table-cell">
                                    {{ applicationIdx + 1 }}</td>
                                <td
                                    class="w-full max-w-0 whitespace-nowrap px-6 py-1.5 text-sm font-medium text-gray-900">
                                    <div class="lg:pl-2">
                                        {{ application.scheme }}
                                    </div>
                                </td>
                                <td
                                    class="hidden whitespace-nowrap px-6 py-1.5 text-right text-sm text-gray-500 md:table-cell">
                                    {{ application.count }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputLabel from '@/Components/InputLabel.vue';

    import VueApexCharts from "vue3-apexcharts";

    import {
        MapPinIcon,
        HomeIcon,
        UserGroupIcon,
        DocumentTextIcon
    } from '@heroicons/vue/24/outline'

    import {
        Link
    } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            apexchart: VueApexCharts,
            AppLayout,
            TextInput,
            InputLabel,
            MapPinIcon,
            HomeIcon,
            UserGroupIcon,
            DocumentTextIcon,
            Link
        },

        props: ["sites"],

        data() {
            return {
                applications: [],
                filter: {
                    site: "all"
                },
                chart: {
                    series: [],
                    options: {
                        chart: {
                            type: 'bar',
                            height: 400,
                            stacked: true,
                            toolbar: {
                                show: false
                            },
                            zoom: {
                                enabled: false
                            }
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                legend: {
                                    position: 'bottom',
                                    offsetX: -10,
                                    offsetY: 0
                                }
                            }
                        }],
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                borderRadius: 2
                            },
                        },
                        xaxis: {
                            type: 'string',
                            categories: [],
                        },
                        legend: {
                            position: 'top',
                            offsetY: 0
                        },
                        fill: {
                            opacity: 1
                        }
                    },
                }
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {
                var siteId = this.filter.site;

                var formData = new FormData();
                formData.append("site_id", siteId);

                var vue = this;
                axios.post("/charts/prd-wise-applications", formData).then(function (response) {
                    var data = response.data;

                    if (data.status == 1) {
                        var chartData = data.data;

                        vue.applications = chartData.application_list;

                        vue.chart.series = [{
                            name: 'Applications',
                            data: Object.values(chartData.applications)
                        }];

                        vue.chart.options = {
                            ...vue.chart.options,
                            ...{
                                xaxis: {
                                    categories: chartData.categories,
                                },
                            },
                        };
                    }
                });
            }
        }
    }

</script>
