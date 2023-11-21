<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-gray-200 px-4 py-5 flex items-center justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Home</h1>
                </div>
                <div class="flex gap-4 mt-0 ml-4">
                    <!-- <button @click="dailyReport" type="button"
						class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
						<DocumentTextIcon class="-ml-0.5 mr-2 h-5 w-5" aria-hidden="true" />
                        <span>Daily Report</span>
					</button> -->
                </div>
            </div>

            <!-- Overview -->
            <div class="mt-6 px-4 sm:px-6 lg:px-8">
                <h2 class="text-sm font-medium text-gray-900">Overview</h2>
                <ul role="list" class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">
                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['bg-pink-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">
                            <MapPinIcon class="h-7 w-7" />
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{ overview.alloted_villages }}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Alloted Villages</p>
                            </div>
                        </div>
                    </li>

                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['bg-blue-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">
                            <HomeIcon class="h-7 w-7" />
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{ overview.households }}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Households</p>
                            </div>
                        </div>
                    </li>

                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['bg-yellow-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">
                            <UserGroupIcon class="h-7 w-7" />
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{ overview.population }}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Population</p>
                            </div>
                        </div>
                    </li>

                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['bg-green-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">
                            <DocumentTextIcon class="h-7 w-7" />
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{ overview.applications }}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Applications</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Application Status -->
            <div class="mt-6 px-4 sm:px-6 lg:px-8">
                <h2 class="text-sm font-medium text-gray-900">Application Status</h2>
                <ul role="list" class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">
                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']" style="background: #008ffb">
                            <DocumentTextIcon class="h-7 w-7"/>
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{applicationStatus.Incomplete}}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Incomplete</p>
                            </div>
                        </div>
                    </li>
                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']"
                            style="background: #00a76d">
                            <DocumentTextIcon class="h-7 w-7"/>
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{applicationStatus.Documentation}}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Documentation</p>
                            </div>
                        </div>
                    </li>
                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']" style="background: #feb019">
                            <DocumentTextIcon class="h-7 w-7"/>
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{applicationStatus.Verified}}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Verified by F.S.</p>
                            </div>
                        </div>
                    </li>

                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']" style="background: #ff4560">
                            <DocumentTextIcon class="h-7 w-7"/>
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{applicationStatus.Govt}}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Govt. Submission</p>
                            </div>
                        </div>
                    </li>
                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']"
                            style="background: #554298">
                            <DocumentTextIcon class="h-7 w-7"/>
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{applicationStatus.Benefitted}}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Benefitted</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>


            <!-- Basic Charts -->
            <div class="mt-10 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-7 gap-3">
                    <div class="col-span-4">
                        <h2 class="text-sm font-medium text-gray-900">Last 5 Households</h2>
                        <div v-if="households.length > 0" class="mt-2 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="whitespace-nowrap py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                    <th scope="col" class="whitespace-nowrap px-2 py-2 text-left text-sm font-semibold text-gray-900">Registered On</th>
                                    <th scope="col" class="whitespace-nowrap px-2 py-2 text-left text-sm font-semibold text-gray-900">Card</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="household in households" :key="household.id">
                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-6">
                                        <div
                                            @click="$inertia.visit('/household/'+household.id)"
                                            title="Open details"
                                            class="cursor-pointer font-medium text-gray-900 underline underline-offset-2 decoration-blue-500/30 hover:decoration-blue-500/80 decoration-2">{{ household.name }}</div>
                                        <div class="text-gray-500"># {{ household.hh_id }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ household.register_date }}</td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">
                                        <span v-if="household.card_disbursement_status == 1" class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Disbursed</span>
                                        <span v-else class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Not Disbursed</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <h2 class="text-sm font-medium text-gray-900">Applications</h2>
                        <div class="mt-2">
                            <apexchart width="100%" type="pie" :options="charts.applications.options"
                                       :series="charts.applications.series"></apexchart>
                        </div>
                    </div>
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
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        Switch,
        RadioGroup,
        RadioGroupLabel,
        RadioGroupOption
    } from '@headlessui/vue'

    export default {
        components: {
            apexchart: VueApexCharts,
            AppLayout,
            TextInput,
            InputLabel,
            Dialog,
            DialogPanel,
            DialogTitle,
            TransitionChild,
            TransitionRoot,
            Switch,
            RadioGroup,
            RadioGroupLabel,
            RadioGroupOption,
            MapPinIcon,
            HomeIcon,
            UserGroupIcon,
            DocumentTextIcon
        },

        props: ["overview", "households", "applications", "users","applicationStatus"],

        data() {
            return {
                charts: {
                    applications: {
                        series: Object.values(this.applications),
                        options: {
                            chart: {
                                width: 380,
                                type: 'pie',
                            },
                            labels: Object.keys(this.applications),
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        width: 200
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        },
                    }
                },
                daily_report: {
                    show_popup: false,
                    popup_title: "",
                    user: {
                        value: "",
                        error: false
                    },
                    processing: false
                },
                daily_report_viewer: {
                    show_popup: false,
                    popup_title: "",
                    report: null
                }
            }
        },

        methods: {
            dailyReport() {
                this.daily_report.user.error = false;

                this.daily_report.show_popup = true;
            },

            fetchDailyReport() {
                var form = this.daily_report;

                form.user.error = false;

                var userString = form.user.value.toString();
                if (userString.length == 0) {
                    form.user.error = true;
                    return;
                }

                form.processing = true;

                var formData = new FormData();
                formData.append("user_id", userString);

                var vue = this;
                axios.post("/dashboard/daily-report", formData).then(function (response) {
                    var data = response.data;

                    form.processing = false;
                    if (data.status == 1) {
                        var reportData = data.data.report;

                        vue.daily_report.show_popup = false;

                        vue.daily_report_viewer.report = reportData;
                        vue.daily_report_viewer.show_popup = true;
                    }
                });
            }
        }
    }

</script>
