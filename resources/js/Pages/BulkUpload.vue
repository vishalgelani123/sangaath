<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-gray-200 px-4 py-3 flex items-center justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">All Bulk Uploads</h1>
                </div>
                <div class="flex mt-0 ml-4">
                    <button @click="uploadFile" type="button"
                        class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                        <ArrowUpTrayIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                        <span>Upload Now</span>
                    </button>
                </div>
            </div>
            <!-- Search field -->
            <div v-if="all_bulk_uploads.length > 0" class="mt-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-sm">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </div>
                        <TextInput v-model="search_query" v-on:keyup="search()" v-on:change="search()" autocomplete="off" id="search" type="text" placeholder="Search Bulk Uploads"
                            class="block w-full pl-10 font-medium" required />
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div v-if="all_bulk_uploads.length == 0" class="mt-20 inline-block min-w-full align-middle">
                    <div class="flex items-center flex-col">
                        <img src="/images/file.png" class="w-72" alt="" />
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No bulk uploads</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by uploading a file.</p>
                        <div class="mt-6">
                            <button @click="uploadFile" type="button"
                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                <ArrowUpTrayIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                                <span>Upload Now</span>
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
                                    <span class="lg:pl-2">File Type</span>
                                </th>
                                <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                    scope="col">Uploaded On</th>
								<th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                    scope="col" />
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <tr v-for="bulk_upload in display_bulk_uploads" :key="bulk_upload.id">
                                <td
                                    class="w-1/2 max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                    <div class="flex items-center space-x-3 lg:pl-2">
										{{ bulk_upload.file_type }}
                                    </div>
                                </td>
                                <td
                                    class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                    {{ bulk_upload.uploaded_at }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                    <a :href="bulk_upload.download_link" target="_blank" class="text-blue-600 hover:text-blue-900">Download</a>
                                </td>
                            </tr>
							<tr v-if="display_bulk_uploads.length == 0">
								<td colspan="5" class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
									<span class="lg:pl-2 text-gray-600 font-medium">No results found!</span>
								</td>
							</tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <TransitionRoot as="template" :show="bulk_upload_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="bulk_upload_form.show_popup = false">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                        enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                        leave-to="opacity-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                    </TransitionChild>

                    <div class="fixed inset-0 z-10 overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <TransitionChild as="template" enter="ease-out duration-300"
                                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                leave-from="opacity-100 translate-y-0 sm:scale-100"
                                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <DialogPanel
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="text-left">
											<DialogTitle as="h3"
												class="text-lg font-medium leading-6 text-gray-900">{{ bulk_upload_form.popup_title }}</DialogTitle>
											<div class="mt-1">
												<p class="text-sm text-gray-500">Enter the basic details to continue</p>
											</div>
										</div>
										<div class="my-5 flex flex-col gap-y-7">
											<div v-if="bulk_upload_form.file_error" class="rounded-md bg-red-50 p-4">
												<div class="flex">
													<div>
														<h3 v-if='bulk_upload_form.file_error.error == "invalid_header"' class="text-sm font-medium text-red-800">
															The provided file is invalid. Please upload a valid format
														</h3>
														<h3 v-else class="text-sm font-medium text-red-800">
															There are errors in the file you provided. <a :href="bulk_upload_form.file_error.download_link" class="hover:underline font-semibold">Download File</a>
														</h3>
													</div>
												</div>
											</div>
											<div class="">
												<InputLabel for="bulk_upload_site" value="Site" />

												<select v-model="bulk_upload_form.site.value" id="bulk_upload_site" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
													<option value="" selected disabled>Select Site</option>
													<option :value="site.id" v-for="site in sites" :key="site.id">{{ site.name }}</option>
												</select>
												<p v-if="bulk_upload_form.site.error" class="mt-1 text-red-600 text-sm">Please select a site</p>
											</div>

											<div class="">
												<div class="flex justify-between items-center">
													<InputLabel for="bulk_upload_type" value="Type" />
													<div v-if="bulk_upload_form.type.value.length > 0">
														<a v-if="bulk_upload_form.type.value == 'hh_head'" :href="templates['hh_head']" class="mb-3 text-xs text-blue-600 font-medium">Download Template</a>
														<a v-else :href="templates['hh_individual']" class="mb-3 text-xs text-blue-600 font-medium">Download Template</a>
													</div>
												</div>

												<select v-model="bulk_upload_form.type.value" id="bulk_upload_type" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
													<option value="" selected disabled>Select File Type</option>
													<option value="hh_head">Household Heads</option>
													<option value="individual_members">Individual Members</option>
												</select>
												<p v-if="bulk_upload_form.type.error" class="mt-1 text-red-600 text-sm">Please select file type</p>
											</div>

											<div class="">
												<InputLabel for="bulk_upload_file" value="File" />

												<div class="relative rounded-md shadow-sm">
													<TextInput @change="handleFile" ref="fileInput" accept="text/csv"
														id="bulk_upload_file" type="file" class="block w-full font-medium" required />
												</div>
												<p v-if="bulk_upload_form.file.error" class="mt-1 text-red-600 text-sm">Please select a file</p>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!bulk_upload_form.processing" @click="validateForm" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
											<span>Upload</span>
										</button>
										<button v-else-if="bulk_upload_form.processing"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed">
											<span>Uploading</span>
											<svg class="animate-spin ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
												fill="none" viewBox="0 0 24 24">
												<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
													stroke-width="4"></circle>
												<path class="opacity-75" fill="currentColor"
													d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
												</path>
											</svg>
										</button>
										<button v-if="!bulk_upload_form.processing" @click="bulk_upload_form.show_popup = false" type="button"
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
		ArrowUpTrayIcon
    } from '@heroicons/vue/20/solid'
	import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

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
			ArrowUpTrayIcon
        },

        props: ["all_bulk_uploads", "sites", "templates"],

        data() {
            return {
				display_bulk_uploads: this.all_bulk_uploads,
				search_query: "",
                bulk_upload_form: {
                    show_popup: false,
					popup_title: "Upload File",
					site: {
						value: "",
						error: false
					},
					type: {
						value: "",
						error: false
					},
					file: {
						value: null,
						error: false
					},
					file_error: null,
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
					this.display_bulk_uploads = [];
					for (var uploadIdx in this.all_bulk_uploads) {
						var bulk_upload = this.all_bulk_uploads[uploadIdx];
						if (bulk_upload.file_type.toString().toLowerCase().includes(searchQuery) || bulk_upload.uploaded_at.toString().toLowerCase().includes(searchQuery)) {
							this.display_bulk_uploads.push(bulk_upload);
						}
					}
				}else {
					this.display_bulk_uploads = this.all_bulk_uploads;
				}
			},

            uploadFile() {
				this.bulk_upload_form.site.error = false;
				this.bulk_upload_form.type.error = false;
				this.bulk_upload_form.file.error = false;
				this.bulk_upload_form.file_error = null;

				this.bulk_upload_form.save_type = "new";

				this.bulk_upload_form.popup_title = "Upload File";
                this.bulk_upload_form.show_popup = true;
            },

			handleFile(e)  {
				this.bulk_upload_form.file.value = e.target.files;
			},

			validateForm() {
				this.bulk_upload_form.site.error = false;
				this.bulk_upload_form.type.error = false;
				this.bulk_upload_form.file.error = false;
				this.bulk_upload_form.file_error = null;

				console.log(this.bulk_upload_form.file.value);

				var siteString = this.bulk_upload_form.site.value.toString();
				if (siteString.length == 0) {
					this.bulk_upload_form.site.error = true;
					return;
				}

				var typeString = this.bulk_upload_form.type.value.toString();
				if (typeString.length == 0) {
					this.bulk_upload_form.type.error = true;
					return;
				}

				const fileInput = this.bulk_upload_form.file.value;
				if (!fileInput || fileInput.length < 1) {
					this.bulk_upload_form.file.error = true;
					return;
				}

				this.uploadFileProcess(siteString, typeString);
			},

			uploadFileProcess(site, type) {
				this.bulk_upload_form.processing = true;

				const file = this.bulk_upload_form.file.value[0];

				var formData = new FormData();
				formData.append("site_id", site);
				formData.append("type", type);
				formData.append("file", file);
				formData.append("save_type", this.bulk_upload_form.save_type);

				var vue = this;
				axios.post('/bulk-upload/upload', formData).then(function(response) {
					vue.bulk_upload_form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						vue.$inertia.visit('/bulk-upload', {
							only: ["all_bulk_uploads"]
						});
					}else {
						vue.bulk_upload_form.file_error = data;
					}
				});
			},

			deleteProcess() {
				this.delete_form.processing = true;

				var formData = new FormData();
				formData.append("site_id", this.delete_form.site_id);

				var vue = this;
				axios.post('/sites/delete', formData).then(function(response) {
					vue.delete_form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						vue.$inertia.visit('/sites', {
							only: ["all_bulk_uploads"]
						});
					}
				});
			}
        }
    }

</script>
