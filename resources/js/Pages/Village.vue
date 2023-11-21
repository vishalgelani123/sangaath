<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-gray-200 px-4 py-3 flex items-center justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">All Villages</h1>
                </div>
                <div class="flex mt-0 ml-4">
                    <button @click="addVillage" type="button"
                        class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                        <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                        <span>New Village</span>
                    </button>
                </div>
            </div>
            <!-- Search field -->
            <div v-if="all_villages.length > 0" class="mt-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-sm">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </div>
                        <TextInput v-model="search_query" v-on:keyup="search()" v-on:change="search()" autocomplete="off" id="search" type="text" placeholder="Search Villages"
                            class="block w-full pl-10 font-medium" required />
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div v-if="all_villages.length == 0" class="mt-20 inline-block min-w-full align-middle">
                    <div class="flex items-center flex-col">
                        <img src="/images/map.png" class="w-72" alt="" />
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No villages available</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new village.</p>
                        <div class="mt-6">
                            <button @click="addVillage" type="button"
                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                                <span>New Village</span>
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
                                    <span class="lg:pl-2">Name</span>
                                </th>
								<th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                    scope="col">Site</th>
                                <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                    scope="col">Created On</th>
                                <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                    scope="col" />
								<th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                    scope="col" />
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <tr v-for="village in display_villages" :key="village.id">
                                <td
                                    class="w-1/2 max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                    <div class="flex items-center space-x-3 lg:pl-2">
										{{ village.name }}
                                    </div>
                                </td>
								<td class="px-6 py-3 text-sm font-medium text-gray-500">
									<div v-if="village.site">
										{{ village.site.name }}
									</div>
									<div v-else>
										<span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Deleted</span>
									</div>
                                </td>
                                <td
                                    class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                    {{ village.create_date }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                    <a @click="editVillage(village)" href="javascript:void(0)" class="text-blue-600 hover:text-blue-900">Edit</a>
                                </td>
								<td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                    <a @click="deleteVillage(village.name, village.id)" href="javascript:void(0)" class="text-red-600 hover:text-red-900">Delete</a>
                                </td>
                            </tr>
							<tr v-if="display_villages.length == 0">
								<td colspan="5" class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
									<span class="lg:pl-2 text-gray-600 font-medium">No results found!</span>
								</td>
							</tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <TransitionRoot as="template" :show="village_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="village_form.show_popup = false">
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
												class="text-lg font-medium leading-6 text-gray-900">{{ village_form.popup_title }}</DialogTitle>
											<div class="mt-1">
												<p class="text-sm text-gray-500">Enter the basic details to continue</p>
											</div>
										</div>
										<div class="my-5 flex flex-col gap-y-6">
											<div class="">
												<InputLabel for="name" value="Name" />

												<div class="relative rounded-md shadow-sm">
													<TextInput v-model="village_form.name.value"
														id="village_name" type="text" class="block w-full font-medium" required />
												</div>
												<p v-if="village_form.name.error" class="mt-1 text-red-600 text-sm">Please enter valid name</p>
											</div>
											<div class="">
												<InputLabel for="village_site" value="Site" />

												<select v-model="village_form.site.value" id="site_state" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
													<option value="" selected disabled>Select Site</option>
													<option v-for="site in sites" :key="site.id" :value="site.id">
														{{ site.name }} ({{ site.display_state }})
													</option>
												</select>
												<p v-if="village_form.site.error" class="mt-1 text-red-600 text-sm">Please enter valid state</p>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!village_form.processing" @click="validateForm" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
											<span>Save</span>
										</button>
										<button v-else-if="village_form.processing"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed">
											<span>Saving</span>
											<svg class="animate-spin ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
												fill="none" viewBox="0 0 24 24">
												<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
													stroke-width="4"></circle>
												<path class="opacity-75" fill="currentColor"
													d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
												</path>
											</svg>
										</button>
										<button v-if="!village_form.processing" @click="village_form.show_popup = false" type="button"
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

			<TransitionRoot as="template" :show="delete_form.show_popup">
				<Dialog as="div" class="relative z-10" @close="delete_form.show_popup = false">
				<TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
					<div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
				</TransitionChild>

				<div class="fixed inset-0 z-10 overflow-y-auto">
					<div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
					<TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
						<DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
						<div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
							<div class="sm:flex sm:items-start">
							<div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
								<ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
							</div>
							<div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
								<DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Delete {{ delete_form.village_name }}?</DialogTitle>
								<div class="mt-2">
								<p class="text-sm text-gray-500">Are you sure you want to delete this village? This action cannot be undone.</p>
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
									<svg class="animate-spin ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 24 24">
										<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
											stroke-width="4"></circle>
										<path class="opacity-75" fill="currentColor"
											d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
										</path>
									</svg>
								</button>
								<button v-if="!delete_form.processing" @click="delete_form.show_popup = false" type="button"
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
        PlusIcon
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
        },

        props: ["all_villages", "sites"],

        data() {
            return {
				display_villages: this.all_villages,
				search_query: "",
                village_form: {
                    show_popup: false,
					popup_title: "Create New Village",
					name: {
						value: "",
						error: false
					},
					site: {
						value: "",
						error: false
					},
					save_type: "new",
					village_id: null,
					processing: false
                },
				delete_form: {
					village_name: "",
					village_id: null,
					show_popup: false,
					processing: false
				}
            }
        },

        methods: {
			search() {
				var searchQuery = this.search_query.toString().toLowerCase();

				if (searchQuery.length > 0) {
					this.display_villages = [];
					for (var siteIdx in this.all_villages) {
						var village = this.all_villages[siteIdx];
						if (village.name.toString().toLowerCase().includes(searchQuery) || village.display_state.toString().toLowerCase().includes(searchQuery)) {
							this.display_villages.push(village);
							continue;
						}

						if (village.site) {
							if (village.site.name.toString().toLowerCase().includes(searchQuery)) {
								this.display_villages.push(village);
								continue;
							}
						}
					}
				}else {
					this.display_villages = this.all_villages;
				}
			},

            addVillage() {
				this.village_form.name.error = false;
				this.village_form.site.error = false;

				this.village_form.save_type = "new";
				this.village_form.village_id = null;

				this.village_form.popup_title = "Create New Village";
                this.village_form.show_popup = true;
            },

			editVillage(village) {
				this.village_form.name.error = false;
				this.village_form.site.error = false;

				this.village_form.save_type = "edit";
				this.village_form.village_id = village.id;

				this.village_form.name.value = village.name;
				this.village_form.site.value = village.site.id;

				this.village_form.popup_title = "Edit Village";
                this.village_form.show_popup = true;
			},

			deleteVillage(name, villageId) {
				this.delete_form.village_name = name;
				this.delete_form.village_id = villageId;

				this.delete_form.show_popup = true;
			},

			validateForm() {
				this.village_form.name.error = false;
				this.village_form.site.error = false;

				var nameString = this.village_form.name.value.toString();
				if (nameString.length == 0) {
					this.village_form.name.error = true;
					return;
				}

				var siteString = this.village_form.site.value.toString();
				if (siteString.length == 0) {
					this.village_form.site.error = true;
					return;
				}

				this.saveVillage(nameString, siteString);
			},

			saveVillage(name, site) {
				this.village_form.processing = true;

				var formData = new FormData();
				formData.append("name", name);
				formData.append("site_id", site);
				formData.append("save_type", this.village_form.save_type);
				formData.append("village_id", this.village_form.village_id);

				var vue = this;
				axios.post('/villages/save', formData).then(function(response) {
					vue.village_form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						vue.$inertia.visit('/villages', {
							only: ["all_villages"]
						});
					}
				});
			},

			deleteProcess() {
				this.delete_form.processing = true;

				var formData = new FormData();
				formData.append("village_id", this.delete_form.village_id);

				var vue = this;
				axios.post('/villages/delete', formData).then(function(response) {
					vue.delete_form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						vue.$inertia.visit('/villages', {
							only: ["all_villages"]
						});
					}
				});
			}
        }
    }

</script>
