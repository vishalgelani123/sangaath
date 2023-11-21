<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-gray-200 px-4 py-5 flex items-center justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Update Status</h1>
                </div>
                <div class="flex mt-0 ml-4">
                    <!-- <button @click="addSite" type="button"
                        class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                        <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                        <span>New Site</span>
                    </button> -->
                </div>
            </div>
            <!-- Search field -->
            <div v-if="initial_forms.length > 0" class="mt-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-sm">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                        </div>
                        <TextInput v-model="search_query" v-on:keyup="debouncedSearch" v-on:change="debouncedSearch"
                                   autocomplete="off" id="search" type="text" placeholder="Search Forms"
                                   class="block w-full pl-10 font-medium" required/>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div v-if="initial_forms.length == 0" class="mt-20 inline-block min-w-full align-middle">
                    <div class="flex items-center flex-col">
                        <img src="/images/document-complete.png" class="w-72" alt=""/>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No forms available</h3>
                        <p class="mt-1 text-sm text-gray-500">You have no forms available to update.</p>
                    </div>
                </div>
                <div v-else class="inline-block min-w-full border-b border-gray-200 align-middle">
                    <a href="" id="download_document_link" class="hidden" download></a>
                    <table class="min-w-full">
                        <thead>
                        <tr class="border-t border-gray-200">
                            <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                scope="col">
                                <span class="lg:pl-2">Name</span>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900"
                                scope="col">Village
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Applied for
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Applied on
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Documentation on
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                scope="col"/>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                        <tr v-for="form in (search_query.length > 0 && is_search_complete ? searched_forms : loaded_forms)"
                            :key="form.id">
                            <td
                                class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                <div class="flex items-center space-x-3 lg:pl-2">
                                    {{ form.beneficiary?.name }}
                                </div>
                            </td>
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ form.beneficiary?.village?.name }}
                            </td>
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ form.scheme?.name }}
                            </td>
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ form.applied_date }}
                            </td>
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ form.documentation_date }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                <a @click="updateStatus(form.beneficiary?.name, form.id)" href="javascript:void(0)"
                                   class="text-blue-600 hover:text-blue-900">Update Status</a>
                            </td>
                        </tr>
                        <tr v-if="display_forms.length == 0">
                            <td colspan="5" class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                <span class="lg:pl-2 text-gray-600 font-medium">No results found!</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <TransitionRoot as="template" :show="update_status_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="update_status_form.show_popup = false">
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xs">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <DialogTitle as="h3"
                                                             class="text-lg font-medium leading-6 text-gray-900">{{
                                                    update_status_form.popup_title }}
                                                </DialogTitle>
                                                <div class="mt-1">
                                                    <p class="text-sm text-gray-500">Select date to update status of the
                                                        form</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-5 flex flex-col gap-y-6">
                                            <div class="">
                                                <InputLabel for="update_status_date" value="Date"/>

                                                <div class="relative rounded-md shadow-sm">
                                                    <TextInput v-model="update_status_form.date.value" :max="maxDate"
                                                               id="update_status_date" type="date"
                                                               class="block w-full font-medium" required
                                                               onkeydown="return false;" />

                                                </div>
                                                <p v-if="update_status_form.date.error" class="mt-1 text-red-600 text-sm">Please select a valid date</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!update_status_form.processing" @click="validateForm"
                                                type="button"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                            <span>Update</span>
                                        </button>
                                        <button v-else-if="update_status_form.processing"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed">
                                            <span>Updating</span>
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
                                        <button v-if="!update_status_form.processing"
                                                @click="update_status_form.show_popup = false" type="button"
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
    import {debounce} from 'lodash';

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
        MagnifyingGlassIcon,
        CheckCircleIcon,
        XCircleIcon
    } from '@heroicons/vue/24/solid'
    import {
        PlusIcon
    } from '@heroicons/vue/20/solid'
    import {
        ExclamationTriangleIcon,
        EyeIcon,
        CloudArrowDownIcon,
        CloudArrowUpIcon,
        CheckIcon
    } from '@heroicons/vue/24/outline'

    import {Link} from '@inertiajs/inertia-vue3'

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
            Link,
            MagnifyingGlassIcon,
            PlusIcon,
            ExclamationTriangleIcon,
            EyeIcon,
            CloudArrowDownIcon,
            CloudArrowUpIcon,
            CheckIcon,
            CheckCircleIcon,
            XCircleIcon
        },

        props: ["initial_forms"],

        data() {
            return {
                searched_forms: [],
                loaded_forms: this.initial_forms,
                display_forms: this.initial_forms,
                last_search_query: "",
                search_query: "",
                is_search_complete: false,
                is_loading: false,
                has_reached_search_bottom: false,
                has_reached_bottom: false,
                search_loaded_rows: 0,
                loaded_rows: 50,
                update_status_form: {
                    show_popup: false,
                    popup_title: "",
                    form_id: "",
                    date: {
                        value: "",
                        error: false
                    },
                    processing: false
                },
                documents: {},
                delete_form: {
                    site_name: "",
                    form_id: null,
                    show_popup: false,
                    processing: false
                }
            }
        },

        mounted() {
            this.maxDate = this.formatToday();

            window.addEventListener('scroll', function () {
                const scrollPosition = window.innerHeight + window.scrollY;
                const bodyHeight = document.body.scrollHeight;
                const distanceToBottom = bodyHeight - scrollPosition;
                const buffer = 200; // Number of pixels to buffer before triggering the request

                const hasReachedBottom = this.search_query.length > 0 ? this.has_reached_search_bottom : this.has_reached_bottom;
                if (!hasReachedBottom && !this.is_loading && distanceToBottom < buffer) {
                    this.is_loading = true;
                    this.loadMoreData();
                }
            }.bind(this));
        },

        methods: {
            debouncedSearch: debounce(function () {
                this.search();
            }, 500),

            search() {
                var searchQuery = this.search_query.toString().toLowerCase().trim();

                if (searchQuery.length > 0 && searchQuery != this.last_search_query) {
                    this.has_reached_search_bottom = false;
                    this.loadMoreData(true);
                }
                // var searchQuery = this.search_query.toString().toLowerCase();

                // if (searchQuery.length > 0) {
                // 	this.display_forms = [];
                // 	for (var formIdx in this.all_forms) {
                // 		var form = this.all_forms[formIdx];
                // 		if (form.beneficiary?.name.toString().toLowerCase().includes(searchQuery)) {
                // 			this.display_forms.push(form);
                // 			continue;
                // 		}

                // 		if (form.scheme?.name.toString().toLowerCase().includes(searchQuery)) {
                // 			this.display_forms.push(form);
                // 			continue;
                // 		}

                // 		if (form.beneficiary?.village?.name.toString().toLowerCase().includes(searchQuery)) {
                // 			this.display_forms.push(form);
                // 			continue;
                // 		}

                // 		if (form.applied_date.toString().toLowerCase().includes(searchQuery)) {
                // 			this.display_forms.push(form);
                // 			continue;
                // 		}
                // 	}
                // }else {
                // 	this.display_forms = this.all_forms;
                // }
            },

            loadMoreData(is_first_search = false) {
                if (is_first_search) {
                    this.search_loaded_rows = 0;
                    this.searched_forms = [];
                    this.has_reached_search_bottom = false;
                }

                let search_query = null;
                let skipping_rows = this.loaded_rows;
                if (this.search_query.length > 0) {
                    search_query = `&search=${this.search_query}`;
                    this.last_search_query = this.search_query.toString().toLowerCase();
                    skipping_rows = this.search_loaded_rows;
                }

                axios.get(`/update-status?is_ajax=1&skip=${skipping_rows}${search_query ?? ''}`).then(function (response) {
                    const data = response.data;

                    if (data.rows) {
                        if (search_query) {
                            this.searched_forms.push(...data.rows);
                            this.search_loaded_rows = this.searched_forms.length;
                        } else {
                            this.loaded_forms.push(...data.rows);
                            this.loaded_rows = this.loaded_forms.length;
                        }
                        this.is_loading = false;
                        this.is_search_complete = true;

                        if (data.rows.length == 0) {
                            if (search_query) {
                                this.has_reached_search_bottom = true;
                            } else {
                                this.has_reached_bottom = true;
                            }
                        }
                    }
                }.bind(this));
            },

            updateStatus(name, formId) {
                this.update_status_form.form_id = formId;
                this.update_status_form.popup_title = name;

                this.update_status_form.date.error = false;

                this.update_status_form.show_popup = true;
            },

            validateForm() {
                this.update_status_form.date.error = false;

                var dateString = this.update_status_form.date.value;
                if (dateString.length == 0) {
                    this.update_status_form.date.error = true;
                    return;
                }

                this.updateStatusProcess(dateString);
            },

            updateStatusProcess(date) {
                this.update_status_form.processing = true;

                var formData = new FormData();
                formData.append("form_id", this.update_status_form.form_id);
                formData.append("date", date);

                var vue = this;
                axios.post('/update-status/save', formData).then(function (response) {
                    vue.delete_form.processing = false;
                    var data = response.data;
                    if (data.status == 1) {
                        vue.$inertia.visit('/update-status', {
                            // only: ["all_forms"]
                        });
                    }
                });
            },
            formatToday() {
                let today = new Date();
                let year = today.getFullYear();
                let month = ('0' + (today.getMonth() + 1)).slice(-2);
                let day = ('0' + today.getDate()).slice(-2);
                return year + '-' + month + '-' + day;
            },
        }
    }

</script>
