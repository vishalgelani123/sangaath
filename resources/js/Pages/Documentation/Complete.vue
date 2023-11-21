<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="flex items-center justify-between">
                <div class="w-full border-b border-gray-200">
                    <nav class="-mb-px flex" aria-label="Tabs">
                        <Link href="/documentation/incomplete"
                              :class="['border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm']"
                              aria-current="page">Incomplete
                        </Link>
                        <Link href="/documentation/pending"
                              :class="['border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm']"
                              aria-current="page">Pending
                        </Link>
                        <Link
                            :class="['border-blue-500 text-blue-600', 'w-1/3 py-4 px-1 text-center border-b-2 font-semibold text-sm']"
                            aria-current="page">Complete
                        </Link>
                    </nav>
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
                                   autocomplete="off" id="search" type="text" placeholder="Search Complete Forms"
                                   class="block w-full pl-10 font-medium" required/>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div v-if="initial_forms.length == 0" class="mt-20 inline-block min-w-full align-middle">
                    <div class="flex items-center flex-col">
                        <img src="/images/document-complete.png" class="w-72" alt=""/>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No Complete documents</h3>
                        <p class="mt-1 text-sm text-gray-500">You have no completed documents.</p>
                    </div>
                </div>
                <div v-else class="inline-block min-w-full border-b border-gray-200 align-middle">
                    <table class="min-w-full">
                        <thead>
                        <tr class="border-t border-gray-200">
                            <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                scope="col">
                                <span class="lg:pl-2">Name</span>
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Applied for
                            </th>
                            <th v-if="profile.role == 'admin'"
                                class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Village
                            </th>
                            <!-- <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Applied on</th> -->
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Documented on
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
                                <div class="font-medium">{{ form.scheme?.name }}</div>
                                <div class="text-gray-500">On {{ form.applied_date }}</div>
                            </td>
                            <td v-if="profile.role == 'admin'"
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                <div class="text-gray-500">{{ form.village?.name }}</div>
                            </td>
                            <!-- <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ form.applied_date }}</td> -->
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ form.documentation_date }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                <a @click="deleteForm(form.id)" href="javascript:void(0)"
                                   class="text-red-600 hover:text-red-900">Delete</a>
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

            <TransitionRoot as="template" :show="application_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="application_form.show_popup = false">
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <DialogTitle as="h3"
                                                             class="text-lg font-medium leading-6 text-gray-900">{{
                                                    application_form.popup_title }}
                                                </DialogTitle>
                                                <div class="mt-1">
                                                    <p class="text-sm text-gray-500">Upload the documents below to
                                                        continue</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="application_form.documents != null" class="mt-5">
                                            <div v-if="Object.keys(application_form.documents).length > 0"
                                                 class="grid grid-cols-2 gap-3">
                                                <input @change="previewImage($event)" type="file" accept="image/*"
                                                       id="document_selector" class="hidden"/>
                                                <div v-for="document in application_form.documents"
                                                     :key="document.prerequisite_id"
                                                     @click="selectDocument(document.prerequisite_id)"
                                                     v-bind:class="{'cursor-pointer': !document.is_selected}"
                                                     class="w-full group hover:bg-gray-100 relative border border-gray-200 rounded grid grid-cols-12 items-center px-3 py-2">
                                                    <div class="col-span-11">
                                                        <p class="text-xs font-medium text-gray-700">{{
                                                            document.pre_requisite.name }}</p>
                                                    </div>
                                                    <CloudArrowUpIcon v-if="!document.is_selected"
                                                                      class="text-right text-blue-600 h-5 w-5"/>
                                                    <div v-else>
                                                        <CheckCircleIcon
                                                            class="group-hover:hidden text-right text-green-600 h-5 w-5"/>
                                                        <div
                                                            class="hidden group-hover:flex absolute right-5 bottom-2 gap-3">
                                                            <EyeIcon @click="viewDocument(document.prerequisite_id)"
                                                                     class="cursor-pointer text-blue-600 h-5 w-5"/>
                                                            <XCircleIcon
                                                                @click="removeDocument(document.prerequisite_id)"
                                                                class="cursor-pointer text-red-600 h-5 w-5"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <p class="text-sm text-gray-600 italic">No documents needed for this
                                                    scheme</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 flex justify-between sm:px-6">
                                        <button
                                            v-if="!application_form.mark_complete_processing && !application_form.incomplete_processing"
                                            @click="application_form.show_popup = false" type="button"
                                            class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
                                            <span>Close</span>
                                        </button>
                                        <div v-else></div>

                                        <div class="flex flex-row-reverse gap-6">
                                            <button
                                                v-if="!application_form.mark_complete_processing && !application_form.incomplete_processing"
                                                @click="saveSchemeIncomplete" type="button"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                                <span>Save as In-Complete</span>
                                            </button>

                                            <button
                                                v-if="!application_form.mark_complete_processing && !application_form.incomplete_processing"
                                                @click="markCompleteScheme" type="button"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
                                                <span>Mark as complete</span>
                                            </button>

                                            <button
                                                v-if="application_form.mark_complete_processing || application_form.incomplete_processing"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed">
                                                <span>Saving</span>
                                                <svg class="animate-spin ml-3 h-5 w-5 text-white"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor"
                                                            stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>

            <TransitionRoot as="template" :show="delete_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="delete_form.show_popup = false">
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div
                                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <ExclamationTriangleIcon class="h-6 w-6 text-red-600"
                                                                         aria-hidden="true"/>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <DialogTitle as="h3"
                                                             class="text-lg font-medium leading-6 text-gray-900">Delete?
                                                </DialogTitle>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500">Are you sure you want to delete
                                                        this form? This action cannot be undone.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!delete_form.processing" @click="deleteProcess" type="button"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-red-600 text-white hover:text-slate-100 hover:bg-red-500 active:bg-red-800 active:text-red-100 focus-visible:outline-red-600">
                                            <span>Delete</span>
                                        </button>
                                        <button v-else-if="delete_form.processing"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-red-600 opacity-60 text-white cursor-not-allowed">
                                            <span>Deleting</span>
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
                                        <button v-if="!delete_form.processing" @click="delete_form.show_popup = false"
                                                type="button"
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
                profile: {
                    name: this.$page.props.auth.user['first_name'],
                    role: this.$page.props.auth.user['role'],
                    display_role: this.$page.props.auth.user['display_role'],
                },
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
                application_form: {
                    show_popup: false,
                    applied_popup_show: false,
                    popup_title: "",
                    form_id: "",
                    member_row_id: "",
                    scheme_id: "",
                    selecting_pre_requisite_id: null,
                    documents: null,
                    eligible_status: "",
                    incomplete_processing: false,
                    mark_complete_processing: false
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

                // var searchQuery = this.search_query.toString().toLowerCase().trim();

                // if (searchQuery.length > 0) {
                // 	if (!this.is_loading_all) {
                // 		this.loadMoreData(true);
                // 	}

                // 	this.display_forms = [];
                // 	for (var formIdx in this.loaded_forms) {
                // 		var form = this.loaded_forms[formIdx];
                // 		if (form.beneficiary.name.toString().toLowerCase().includes(searchQuery)) {
                // 			this.display_forms.push(form);
                // 			continue;
                // 		}

                // 		if (form.scheme.name.toString().toLowerCase().includes(searchQuery)) {
                // 			this.display_forms.push(form);
                // 			continue;
                // 		}

                // 		if (form.beneficiary.village.name.toString().toLowerCase().includes(searchQuery)) {
                // 			this.display_forms.push(form);
                // 			continue;
                // 		}

                // 		if (form.applied_date.toString().toLowerCase().includes(searchQuery)) {
                // 			this.display_forms.push(form);
                // 			continue;
                // 		}
                // 	}
                // }else {
                // 	this.display_forms = this.loaded_forms;
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

                axios.get(`/documentation/complete?is_ajax=1&skip=${skipping_rows}${search_query ?? ''}`).then(function (response) {
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

            startApplication(form) {
                this.application_form.popup_title = form.beneficiary.name;
                this.application_form.scheme_id = form.scheme_id;
                this.application_form.form_id = form.id;
                this.application_form.member_row_id = form.beneficiary.id;

                this.application_form.show_popup = true;
                this.application_form.eligible_status = "eligible";

                var vue = this;
                axios.get('/household/scheme/' + form.scheme_id + '/' + form.beneficiary.id).then(function (response) {
                    var data = response.data.data;

                    if (data != null) {
                        var documents = data.documents;
                        vue.application_form.documents = {};
                        for (var documentIdx in documents) {
                            var document = documents[documentIdx];
                            if (!document.is_selected) {
                                document.is_selected = false;
                                document.preview_url = "";
                            }
                            document.file = "";
                            vue.application_form.documents[document.prerequisite_id] = document;
                        }
                    }
                });

            },

            selectDocument(preRequisiteId, form = "application_form") {
                var isSelected = this[form].documents[preRequisiteId].is_selected;

                if (!isSelected) {
                    this[form].selecting_pre_requisite_id = preRequisiteId;
                    document.getElementById("document_selector").click();
                } else {
                    this.viewDocument(preRequisiteId, form);
                }
            },

            viewDocument(preRequisiteId, form = "application_form") {
                var previewURL = this[form].documents[preRequisiteId].preview_url;
                window.open(previewURL, "_blank");
            },

            removeDocument(preRequisiteId, form = "application_form") {
                var document = this[form].documents[preRequisiteId];

                document.is_selected = false;
                document.preview_url = "";
                document.file = "";
            },

            previewImage(event, form = "application_form") {
                if (event.target.files[0] != undefined) {
                    var imgURL = URL.createObjectURL(event.target.files[0]);

                    var filesize = ((event.target.files[0].size / 1024) / 1024).toFixed(4); // MB
                    if (filesize > 10) {
                        alert("Image too large! Please select an image smaller than 10 MB");
                    } else {
                        var preRequisiteId = this[form].selecting_pre_requisite_id;
                        this[form].documents[preRequisiteId].is_selected = true;
                        this[form].documents[preRequisiteId].preview_url = imgURL;
                        this[form].documents[preRequisiteId].file = event.target.files[0];
                    }
                    document.getElementById("document_selector").value = "";
                }
            },

            saveSchemeIncomplete() {
                var formData = new FormData();

                var documents = this.application_form.documents;

                var selectedDocuments = [];
                for (var preRequisiteId in documents) {
                    var document = this.application_form.documents[preRequisiteId];

                    if (document.file != "") {
                        formData.append("document_" + preRequisiteId, document.file);
                        selectedDocuments.push(preRequisiteId);
                    }
                }
                formData.append("selected_documents", JSON.stringify(selectedDocuments));
                formData.append("scheme_id", this.application_form.scheme_id);
                formData.append("member_row_id", this.application_form.member_row_id);
                formData.append("form_id", this.application_form.form_id);

                this.application_form.incomplete_processing = true;

                var vue = this;
                axios.post("/application/save-incomplete", formData).then(function (response) {
                    // vue.application_form.incomplete_processing = false;
                    // vue.application_form.show_popup = false;
                    // vue.application_form.applied_popup_show = true;

                    vue.$inertia.visit('/documentation/incomplete', {
                        only: ["loaded_forms"]
                    });
                });
            },

            markCompleteScheme() {
                var formData = new FormData();

                var documents = this.application_form.documents;

                var selectedDocuments = [];
                for (var preRequisiteId in documents) {
                    var document = this.application_form.documents[preRequisiteId];

                    if (document.file != "") {
                        formData.append("document_" + preRequisiteId, document.file);
                        selectedDocuments.push(preRequisiteId);
                    }
                }
                formData.append("selected_documents", JSON.stringify(selectedDocuments));
                formData.append("scheme_id", this.application_form.scheme_id);
                formData.append("member_row_id", this.application_form.member_row_id);
                formData.append("form_id", this.application_form.form_id);
                formData.append("eligible_status", this.application_form.eligible_status);

                this.application_form.incomplete_processing = true;

                var vue = this;
                axios.post("/application/skip-apply", formData).then(function (response) {
                    // vue.application_form.mark_complete_processing = false;
                    // vue.application_form.show_popup = false;
                    // vue.application_form.applied_popup_show = true;
                    vue.$inertia.visit('/documentation/incomplete', {
                        only: ["loaded_forms"]
                    });
                });
            },

            deleteForm(formId) {
                this.delete_form.form_id = formId;

                this.delete_form.show_popup = true;
            },

            deleteProcess() {
                this.delete_form.processing = true;

                var formData = new FormData();
                formData.append("form_id", this.delete_form.form_id);

                var vue = this;
                axios.post('/documentation/complete/delete', formData).then(function (response) {
                    vue.delete_form.processing = false;

                    var data = response.data;
                    if (data.status == 1) {
                        vue.$inertia.visit('/documentation/complete', {
                            only: ["loaded_forms"]
                        });
                    }
                });
            }
        }
    }

</script>
