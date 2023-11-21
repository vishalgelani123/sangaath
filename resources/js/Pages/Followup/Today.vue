<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="flex items-center justify-between">
                <div class="w-full border-b border-gray-200">
                    <nav class="-mb-px flex" aria-label="Tabs">
                        <Link
                            :class="['border-blue-500 text-blue-600', 'w-1/3 py-4 px-1 text-center border-b-2 font-semibold text-sm']"
                            aria-current="page">Today
                        </Link>
                        <Link href="/followup/previous"
                              :class="['border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm']"
                              aria-current="page">Previous Pending
                        </Link>
                        <Link href="/followup/benefit-received"
                              :class="['border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm']"
                              aria-current="page">Benefit Received
                        </Link>
                        <Link href="/followup/rejected"
                              :class="['border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm']"
                              aria-current="page">Rejected
                        </Link>
                    </nav>
                </div>
                <!-- <div class="flex mt-0 ml-4">
                    <button @click="addSite" type="button"
                        class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                        <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                        <span>New Site</span>
                    </button>
                </div> -->
            </div>
            <!-- Search field -->
            <div v-if="all_forms.length > 0" class="mt-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-sm">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                        </div>
                        <TextInput v-model="search_query" v-on:keyup="search()" v-on:change="search()"
                                   autocomplete="off" id="search" type="text" placeholder="Search Today Followups"
                                   class="block w-full pl-10 font-medium" required/>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div v-if="all_forms.length == 0" class="mt-20 inline-block min-w-full align-middle">
                    <div class="flex items-center flex-col">
                        <img src="/images/document-complete.png" class="w-72" alt=""/>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No Follow Ups</h3>
                        <p class="mt-1 text-sm text-gray-500">You have no follow up for today.</p>
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
                                scope="col">Scheme
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Application date
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Days
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                scope="col"/>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                        <tr v-for="form in display_forms" :key="form.id">
                            <td
                                class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                <div class="lg:pl-2">
                                    <div class="font-medium text-gray-900">{{ form.beneficiary.name }}</div>
                                    <div class="text-gray-500">{{ form.beneficiary.village.name }}</div>
                                </div>
                            </td>
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ form.scheme.name }}
                            </td>
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ form.govt_submission_date }}
                            </td>
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                {{ form.followup_days }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                <a @click="startApplication(form)" href="javascript:void(0)"
                                   class="text-blue-600 hover:text-blue-900">Update</a>
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xs">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="mb-5 flex justify-between items-center">
                                            <div>
                                                <DialogTitle as="h3"
                                                             class="text-lg font-medium leading-6 text-gray-900">
                                                    {{application_form.popup_title }}
                                                </DialogTitle>
                                                <div class="mt-1">
                                                    <p class="text-sm text-gray-500">Select the details to update
                                                        status</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-5 flex flex-col gap-y-5">
                                            <div class="flex justify-between">
                                                <InputLabel for="update_status_date" value="Has benefited?"/>
                                                <Switch v-model="application_form.has_benefitted"
                                                        :class="[application_form.has_benefitted ? 'bg-blue-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2']">
                                                    <span class="sr-only">Use setting</span>
                                                    <span
                                                        :class="[application_form.has_benefitted ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
													<span
                                                        :class="[application_form.has_benefitted ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']"
                                                        aria-hidden="true">
														<svg class="h-3 w-3 text-gray-400" fill="none"
                                                             viewBox="0 0 12 12">
														<path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor"
                                                              stroke-width="2" stroke-linecap="round"
                                                              stroke-linejoin="round"/>
														</svg>
													</span>
													<span
                                                        :class="[application_form.has_benefitted ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']"
                                                        aria-hidden="true">
														<svg class="h-3 w-3 text-blue-600" fill="currentColor"
                                                             viewBox="0 0 12 12">
														<path
                                                            d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"/>
														</svg>
													</span>
													</span>
                                                </Switch>
                                            </div>
                                            <div class="">
                                                <InputLabel for="application_date"
                                                            :value="application_form.has_benefitted ? 'Date' : 'Follow Up Date'"/>

                                                <div class="relative rounded-md shadow-sm">
                                                    <!--                                                    <TextInput v-model="application_form.date.value" :max="maxDate"-->
                                                    <!--                                                               id="application_date" type="date"-->
                                                    <!--                                                               class="block w-full font-medium" required/>-->
                                                    <TextInput v-model="application_form.date.value" :max="maxDate"
                                                               id="application_date" type="date"
                                                               class="block w-full font-medium" required onkeydown="return false;"/>

                                                </div>
                                                <p v-if="application_form.date.error" class="mt-1 text-red-600 text-sm">
                                                    Please select valid date</p>
                                            </div>
                                            <div v-if="!application_form.has_benefitted" class="">
                                                <InputLabel for="name" value="Reject reason"/>

                                                <div class="relative rounded-md shadow-sm">
                                                    <TextInput v-model="application_form.reject_reason.value"
                                                               id="site_name" type="text"
                                                               class="block w-full font-medium" required/>
                                                </div>
                                                <p v-if="application_form.reject_reason.error"
                                                   class="mt-1 text-red-600 text-sm">Please enter reject reason</p>
                                            </div>
                                            <div v-if="!application_form.has_benefitted" class="">
                                                <InputLabel for="discrepancy" value="Discrepancy"/>

                                                <div class="relative rounded-md shadow-sm">
                                                    <TextInput v-model="application_form.discrepancy.value"
                                                               id="discrepancy" type="text"
                                                               class="block w-full font-medium" required/>
                                                </div>
                                                <p v-if="application_form.discrepancy.error"
                                                   class="mt-1 text-red-600 text-sm">Please enter discrepancy</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!application_form.processing" @click="validateForm" type="button"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                            <span>Update</span>
                                        </button>
                                        <button v-else-if="application_form.processing"
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
                                        <button v-if="!application_form.processing"
                                                @click="application_form.show_popup = false" type="button"
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
        TransitionRoot,
        Switch
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
    import {ExclamationTriangleIcon, EyeIcon, CloudArrowUpIcon, CheckIcon} from '@heroicons/vue/24/outline'

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
            Switch,
            Link,
            MagnifyingGlassIcon,
            PlusIcon,
            ExclamationTriangleIcon,
            EyeIcon,
            CloudArrowUpIcon,
            CheckIcon,
            CheckCircleIcon,
            XCircleIcon
        },

        props: ["all_forms"],

        data() {
            return {
                display_forms: this.all_forms,
                search_query: "",
                application_form: {
                    show_popup: false,
                    popup_title: "",
                    form_id: "",
                    has_benefitted: false,
                    reject_reason: {
                        value: "",
                        error: false
                    },
                    discrepancy: {
                        value: "",
                        error: false
                    },
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

        methods: {
            search() {
                var searchQuery = this.search_query.toString().toLowerCase();

                if (searchQuery.length > 0) {
                    this.display_forms = [];
                    for (var formIdx in this.all_forms) {
                        var form = this.all_forms[formIdx];
                        if (form.beneficiary.name.toString().toLowerCase().includes(searchQuery)) {
                            this.display_forms.push(form);
                            continue;
                        }

                        if (form.scheme.name.toString().toLowerCase().includes(searchQuery)) {
                            this.display_forms.push(form);
                            continue;
                        }

                        if (form.beneficiary.village.name.toString().toLowerCase().includes(searchQuery)) {
                            this.display_forms.push(form);
                            continue;
                        }
                    }
                } else {
                    this.display_forms = this.all_forms;
                }
            },

            startApplication(form) {
                this.application_form.popup_title = form.beneficiary.name;
                this.application_form.form_id = form.id;

                this.application_form.show_popup = true;
            },

            validateForm() {
                var form = this.application_form;

                form.date.error = false;
                form.reject_reason.error = false;
                form.discrepancy.error = false;

                var hasBenefitted = this.application_form.has_benefitted;

                var dateString = form.date.value.toString();
                if (dateString.length == 0) {
                    form.date.error = true;
                    return;
                }

                var rejectReasonString = "";
                var discrepancyString = "";
                if (!hasBenefitted) {
                    var rejectReasonString = form.reject_reason.value.toString();
                    if (rejectReasonString.length == 0) {
                        form.reject_reason.error = true;
                        return;
                    }

                    var discrepancyString = form.discrepancy.value.toString();
                    if (discrepancyString.length == 0) {
                        form.discrepancy.error = true;
                        return;
                    }
                }

                this.updateStatus(hasBenefitted, dateString, rejectReasonString, discrepancyString);
            },

            updateStatus(hasBenefitted, date, rejectReason, discrepancy) {
                this.application_form.processing = true;

                var formData = new FormData();
                formData.append("form_id", this.application_form.form_id);
                formData.append("has_benefitted", hasBenefitted ? 1 : -1);
                formData.append("date", date);
                formData.append("reject_reason", rejectReason);
                formData.append("discrepancy", discrepancy);

                var vue = this;
                axios.post('/followup/update-status', formData).then(function (response) {
                    vue.application_form.processing = false;

                    var data = response.data;
                    if (data.status == 1) {
                        vue.$inertia.visit('/followup/today', {
                            only: ["all_forms"]
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
        },
        mounted() {
            this.maxDate = this.formatToday();
        },
    }

</script>
