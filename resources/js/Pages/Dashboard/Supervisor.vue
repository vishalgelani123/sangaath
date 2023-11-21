<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-gray-200 px-4 py-5 flex items-center justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Home</h1>
                </div>
                <div class="flex gap-4 mt-0 ml-4">

                </div>
            </div>

            <!-- Overview -->
            <div class="mt-6 px-4 sm:px-6 lg:px-8">
                <h2 class="text-sm font-medium text-gray-900">Overview </h2>
                <ul role="list" class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">
                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['bg-pink-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">
                            <MapPinIcon class="h-7 w-7"/>
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{overview.alloted_villages
                                    }}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Alloted Villages</p>
                            </div>
                        </div>
                    </li>

                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['bg-blue-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">
                            <HomeIcon class="h-7 w-7"/>
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{
                                    overview.households }}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Households</p>
                            </div>
                        </div>
                    </li>

                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['bg-yellow-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">
                            <UserGroupIcon class="h-7 w-7"/>
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{
                                    overview.population }}</a>
                                <p class="-mt-1 text-gray-500 text-sm">Population</p>
                            </div>
                        </div>
                    </li>

                    <li class="relative col-span-1 flex rounded-md shadow-sm">
                        <div
                            :class="['bg-green-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md']">
                            <DocumentTextIcon class="h-7 w-7"/>
                        </div>
                        <div
                            class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-1.5 text-sm">
                                <a href="#"
                                   class="font-semibold text-lg text-gray-900 hover:text-gray-600">{{
                                    overview.applications }}</a>
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
                        <h2 class="text-sm font-medium text-gray-900">Follow Ups</h2>
                        <div class="mt-2">
                            <apexchart width="100%" type="bar" :options="charts.followup.options"
                                       :series="charts.followup.series"></apexchart>
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

            <TransitionRoot as="template" :show="daily_report.show_popup">
                <Dialog as="div" class="relative z-10" @close="daily_report.show_popup = false">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                                     enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                                     leave-to="opacity-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
                    </TransitionChild>

                    <div class="fixed inset-0 z-10 overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <TransitionChild as="template" enter="ease-out duration-300"
                                             enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             enter-to="opacity-100 translate-y-0 sm:scale-100"
                                             leave="ease-in duration-200"
                                             leave-from="opacity-100 translate-y-0 sm:scale-100"
                                             leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <DialogPanel
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <DialogTitle as="h3"
                                                             class="text-lg font-medium leading-6 text-gray-900">Daily
                                                    Report
                                                </DialogTitle>
                                                <div class="mt-1">
                                                    <p class="text-sm text-gray-500">Select an user to check daily
                                                        report</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-5 flex flex-col gap-y-6">
                                            <div class="">
                                                <InputLabel for="daily_report_user" value="User"/>

                                                <select v-model="daily_report.user.value" id="site_state"
                                                        class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
                                                    <option value="" selected disabled>Select User</option>
                                                    <option v-for="user in users" :key="user.id" :value="user.id">{{
                                                        user.name }}
                                                    </option>
                                                </select>
                                                <p v-if="daily_report.user.error" class="mt-1 text-red-600 text-sm">
                                                    Please select a user to check report</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 gap-3 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!daily_report.processing" @click="fetchDailyReport" type="button"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                            <span>Check</span>
                                        </button>
                                        <button v-else-if="daily_report.processing"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed">
                                            <span>Checking</span>
                                            <svg class="animate-spin ml-3 h-5 w-5 text-white"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button @click="daily_report.show_popup = false" type="button"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
                                            <span>Cancel</span>
                                        </button>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>

            <TransitionRoot as="template" :show="daily_report_viewer.show_popup">
                <Dialog as="div" class="relative z-10" @close="daily_report_viewer.show_popup = false">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                                     enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                                     leave-to="opacity-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
                    </TransitionChild>

                    <div class="fixed inset-0 z-10 overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <TransitionChild as="template" enter="ease-out duration-300"
                                             enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             enter-to="opacity-100 translate-y-0 sm:scale-100"
                                             leave="ease-in duration-200"
                                             leave-from="opacity-100 translate-y-0 sm:scale-100"
                                             leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <DialogPanel
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <DialogTitle as="h3"
                                                             class="text-lg font-medium leading-6 text-gray-900">{{
                                                    daily_report_viewer.report.user.name }}
                                                </DialogTitle>
                                                <div class="mt-1">
                                                    <p class="text-sm text-gray-500">This is the daily report of {{
                                                        daily_report_viewer.report.user.name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5" v-if="daily_report_viewer.report != null">
                                            <div
                                                class="overflow-hidden ring-1 ring-black ring-opacity-10 md:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-300">
                                                    <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col"
                                                            class="py-2 pl-4 pr-3 w-20 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                            Report
                                                        </th>
                                                        <th scope="col"
                                                            class="px-3 py-2 text-right text-sm font-semibold text-gray-900">
                                                            Today
                                                        </th>
                                                        <th scope="col"
                                                            class="px-3 py-2 text-right text-sm font-semibold text-gray-900">
                                                            Cumulative
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-gray-200 bg-white">
                                                    <tr v-for="(reportName, reportIdx) in daily_report_viewer.report.names"
                                                        :key="reportIdx">
                                                        <td class="whitespace-nowrap py-2 pl-4 pr-3 w-20 text-sm sm:pl-6">
                                                            <div>
                                                                <div class="font-medium text-gray-900">{{ reportName
                                                                    }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="whitespace-nowrap text-right px-3 py-2 text-sm text-gray-500">
                                                            {{ daily_report_viewer.report.today[reportIdx] }}
                                                            <!-- <div v-if="application.documentation_date != null" class="text-gray-900">{{ application.documentation_date }}</div> -->
                                                        </td>
                                                        <td class="whitespace-nowrap text-right px-3 py-2 text-sm text-gray-500">
                                                            <div class="mr-5">
                                                                {{ daily_report_viewer.report.cumulative[reportIdx] }}
                                                            </div>
                                                            <!-- <div v-if="application.liasoning_date != null" class="text-gray-900">{{ application.liasoning_date }}</div> -->
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 gap-3 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button @click="daily_report_viewer.show_popup = false" type="button"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
                                            <span>Close</span>
                                        </button>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
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

        props: ["overview", "followup", "applications", "users", "applicationStatus"],

        data() {
            return {
                charts: {
                    followup: {
                        series: [{
                            name: 'Today',
                            data: this.followup["today_followups"]
                        }, {
                            name: 'Previous',
                            data: this.followup["previous_followups"]
                        }],
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
                                categories: this.followup["village_names"],
                            },
                            legend: {
                                position: 'top',
                                offsetY: 0
                            },
                            fill: {
                                opacity: 1
                            }
                        },
                    },
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
