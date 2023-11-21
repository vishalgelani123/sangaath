<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-gray-200 px-4 py-3 flex items-center justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Data Export</h1>
                </div>
                <div class="flex mt-0 ml-4">
                    <button @click="exportData" type="button"
                            class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                        <ArrowDownTrayIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true"/>
                        <span>Export Now</span>
                    </button>
                </div>
            </div>
            <!-- Search field -->
            <div v-if="data_exports.length > 0" class="mt-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-sm">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                        </div>
                        <TextInput v-model="search_query" v-on:keyup="search()" v-on:change="search()"
                                   autocomplete="off" id="search" type="text" placeholder="Search Data Exports"
                                   class="block w-full pl-10 font-medium" required/>
                    </div>
                </div>
            </div>

            <a href="" id="download_document_link" class="hidden" download></a>
            <div class="mt-6">
                <div v-if="data_exports.length == 0" class="mt-20 inline-block min-w-full align-middle">
                    <div class="flex items-center flex-col">
                        <img src="/images/file.png" class="w-72" alt=""/>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No data exports</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by exporting a file.</p>
                        <div class="mt-6">
                            <button @click="exportData" type="button"
                                    class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                <ArrowDownTrayIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true"/>
                                <span>Export Now</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div v-else class="inline-block min-w-full border-b border-gray-200 align-middle">
                    <table class="min-w-full">
                        <thead>
                        <tr class="border-t border-gray-200">
                            <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                scope="col">
                                <span class="lg:pl-2">Site</span>
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Date Range
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">ho_sangath@deepakfoundation.orgExported On
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                        <tr v-for="exportInstance in display_data_exports" :key="exportInstance.id">
                            <td
                                class="w-1/2 max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                <div class="flex items-center space-x-3 lg:pl-2">
                                    {{ exportInstance.site.name }}
                                </div>
                            </td>
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                    <span v-if="exportInstance.start_date">
                                        {{ exportInstance.start_date }} to {{ exportInstance.end_date }}
                                    </span>
                                <span v-else>All Data</span>
                            </td>
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ exportInstance.exported_at }}
                            </td>
                        </tr>
                        <tr v-if="display_data_exports.length == 0">
                            <td colspan="5" class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                <span class="lg:pl-2 text-gray-600 font-medium">No results found!</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <TransitionRoot as="template" :show="data_export_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="data_export_form.show_popup = false">
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
                                        <div class="text-left">
                                            <DialogTitle as="h3"
                                                         class="text-lg font-medium leading-6 text-gray-900">{{
                                                data_export_form.popup_title }}
                                            </DialogTitle>
                                            <div class="mt-1">
                                                <p class="text-sm text-gray-500">Enter the basic details to continue</p>
                                            </div>
                                        </div>
                                        <div class="my-5 flex flex-col gap-y-7">
                                            <div v-if="data_export_form.file_error" class="rounded-md bg-red-50 p-4">
                                                <div class="flex">
                                                    <div>
                                                        <h3 v-if='data_export_form.file_error.error == "invalid_header"'
                                                            class="text-sm font-medium text-red-800">
                                                            The provided file is invalid. Please upload a valid format
                                                        </h3>
                                                        <h3 v-else class="text-sm font-medium text-red-800">
                                                            There are errors in the file you provided. <a
                                                            :href="data_export_form.file_error.download_link"
                                                            class="hover:underline font-semibold">Download File</a>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="">
                                                <DatePicker v-model="data_export_form.date_range" mode="date"
                                                            :columns="1" is-range placement="top">
                                                    <template v-slot="{ inputValue, inputEvents }">
                                                        <div class="w-full">
                                                            <div class="flex items-center justify-between">
                                                                <InputLabel value="Date Filter"/>
                                                            </div>

                                                            <div class="relative rounded-md shadow-sm">
                                                                <TextInput
                                                                    :value="`${inputValue.start} - ${inputValue.end}`"
                                                                    v-on="inputEvents.start" readonly type="text"/>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </DatePicker>
                                            </div>

                                            <div class="mt-7">
                                                <InputLabel for="data_export_site" value="Site"/>

                                                <select v-model="data_export_form.site.value" id="data_export_site"
                                                        class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
                                                    <option value="" selected disabled>Select Site</option>
                                                    <option :value="site.id" v-for="site in sites" :key="site.id">{{
                                                        site.name }}
                                                    </option>
                                                </select>
                                                <p v-if="data_export_form.site.error" class="mt-1 text-red-600 text-sm">
                                                    Please select a site</p>
                                            </div>
                                            <div class="mt-5">
                                                <InputLabel for="include_date" value="Including Blank Date"/>

                                                <select v-model="data_export_form.include_date" id="include_date"
                                                        class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>


                                            <!-- <div class="">
                                                <InputLabel for="data_export_village" value="Village" />

                                                <select v-model="data_export_form.village.value" id="data_export_village" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
                                                    <option value="" selected disabled>Select Village</option>
                                                    <option :value="village.id" v-for="village in villages[data_export_form.site.value]" :key="village.id">{{ village.name }}</option>
                                                </select>
                                                <p v-if="data_export_form.village.error" class="mt-1 text-red-600 text-sm">Please select a village</p>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="mt-12 bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!data_export_form.processing" @click="validateForm" type="button"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                            <span>Export</span>
                                        </button>
                                        <button v-else-if="data_export_form.processing"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed">
                                            <span>Exporting</span>
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
                                        <button v-if="!data_export_form.processing"
                                                @click="data_export_form.show_popup = false" type="button"
                                                class="mr-3 group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
                                            <span>Cancel</span>
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

    import {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot
    } from '@headlessui/vue'
    import TextInput from '@/Components/TextInput.vue';
    import InputLabel from '@/Components/InputLabel.vue';

    import {
        MagnifyingGlassIcon
    } from '@heroicons/vue/24/solid'
    import {
        PlusIcon,
        ArrowDownTrayIcon
    } from '@heroicons/vue/20/solid'
    import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'

    import {setupCalendar, Calendar, DatePicker} from 'v-calendar';
    import 'v-calendar/style.css';

    export default {
        components: {
            AppLayout,
            TextInput,
            InputLabel,
            Dialog,
            DialogPanel,
            DialogTitle,
            TransitionChild,
            TransitionRoot,
            MagnifyingGlassIcon,
            PlusIcon,
            ExclamationTriangleIcon,
            ArrowDownTrayIcon,
            Calendar,
            DatePicker
        },

        props: ["data_exports", "sites", "villages"],

        data() {
            return {
                display_data_exports: this.data_exports,
                search_query: "",
                data_export_form: {
                    show_popup: false,
                    popup_title: "Export Data",
                    site: {
                        value: "",
                        error: false
                    },
                    include_date: 'no',
                    village: {
                        value: "",
                        error: false
                    },
                    date_range: {
                        start: new Date(),
                        end: new Date(),
                    },
                    save_type: "new",
                    site_id: null,
                    processing: false
                }
            }
        },

        methods: {
            search() {
                var searchQuery = this.search_query.toString().toLowerCase();

                if (searchQuery.length > 0) {
                    this.display_data_exports = [];
                    for (var uploadIdx in this.data_exports) {
                        var exportInstance = this.data_exports[uploadIdx];
                        if (exportInstance.village.name.toString().toLowerCase().includes(searchQuery) || exportInstance.site.name.toString().toLowerCase().includes(searchQuery) || exportInstance.exported_at.toString().toLowerCase().includes(searchQuery)) {
                            this.display_data_exports.push(exportInstance);
                        }
                    }
                } else {
                    this.display_data_exports = this.data_exports;
                }
            },

            exportData() {
                this.data_export_form.site.error = false;
                this.data_export_form.village.error = false;

                this.data_export_form.save_type = "new";

                this.data_export_form.popup_title = "Export Data";
                this.data_export_form.show_popup = true;
            },

            validateForm() {
                this.data_export_form.site.error = false;
                this.data_export_form.village.error = false;

                var siteString = this.data_export_form.site.value.toString();
                if (siteString.length == 0) {
                    this.data_export_form.site.error = true;
                    return;
                }

                var villageString = this.data_export_form.village.value.toString();
                // if (villageString.length == 0) {
                // 	this.data_export_form.village.error = true;
                // 	return;
                // }

                this.dataExportProcess(siteString, villageString);
            },

            dataExportProcess(site, village) {
                this.data_export_form.processing = true;

                const formattedStartDate = this.data_export_form.date_range.start.toISOString().split("T")[0];
                const formattedEndDate = this.data_export_form.date_range.end.toISOString().split("T")[0];
                const includeDate = this.data_export_form.include_date;

                var formData = new FormData();
                formData.append("site_id", site);
                formData.append("include_date", includeDate);
                formData.append("start_date", formattedStartDate);
                formData.append("end_date", formattedEndDate);
                formData.append("village_id", village);
                formData.append("save_typData Export\n" +
                    "\ne", this.data_export_form.save_type);

                var vue = this;
                axios.post('/data-export/export', formData).then(function (response) {
                    vue.data_export_form.processing = false;

                    var data = response.data;
                    if (data.status == 1) {
                        vue.$inertia.visit('/data-export', {
                            only: ["data_exports"]
                        });
                    }

                    var data = response.data;
                    var downloadLink = data.download_link;

                    document.getElementById("download_document_link").setAttribute("href", downloadLink);
                    document.getElementById("download_document_link").click();
                });
            },
        }
    }

</script>
