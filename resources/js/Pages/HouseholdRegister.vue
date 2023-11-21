<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-gray-200 px-4 py-3 flex items-center justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <h1 class="text-base lg:text-lg font-medium leading-6 text-gray-900 sm:truncate">Last 10 Households</h1>
                </div>
                <div class="flex gap-4 mt-0 ml-4">
					<button @click="cardDistribution" type="button"
						class="group inline-flex items-center justify-center rounded-full py-1 lg:py-1.5 px-5 lg:px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
						<CreditCardIcon class="-ml-0.5 mr-2 h-5 w-5" aria-hidden="true" />
                        <span class="hidden lg:block">Card Distribution</span>
						<span class="lg:hidden">Card</span>
					</button>
					<button @click="viewHousehold" type="button"
						class="group inline-flex items-center justify-center rounded-full py-1 lg:py-1.5 px-5 lg:px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
						<UserIcon class="-ml-0.5 mr-2 h-5 w-5" aria-hidden="true" />
                        <span class="hidden lg:block">View Household</span>
						<span class="lg:hidden">Household</span>
					</button>
                    <button @click="addHousehold" type="button"
                        class="group inline-flex items-center justify-center rounded-full py-1 lg:py-1.5 px-4 lg:px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                        <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                        <span class="hidden lg:block">New Household</span>
						<span class="lg:hidden">New</span>
                    </button>
                </div>
            </div>
            <!-- Search field -->
            <div v-if="households.length > 0" class="mt-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-sm">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </div>
                        <TextInput v-model="search_query" v-on:keyup="search()" v-on:change="search()" autocomplete="off" id="search" type="text" placeholder="Search Households"
                            class="block w-full pl-10 font-medium" required />
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div v-if="households.length == 0" class="mt-20 inline-block min-w-full align-middle">
                    <div class="flex items-center flex-col">
                        <img src="/images/documents.png" class="w-72" alt="" />
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No pre-requisite available</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new pre-requisite.</p>
                        <div class="mt-6">
                            <button @click="addHousehold" type="button"
                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                                <span>New Household</span>
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
								<th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                    scope="col">Village</th>
								<th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                    scope="col">Age</th>
                                <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                    scope="col" />
								<!-- <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                    scope="col" /> -->
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <tr v-for="household in display_households" :key="household.id">
                                <td
                                    class="w-1/3 max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                    <div class="lg:pl-2">
										<div class="font-medium text-gray-900">{{ household.name }}</div>
                        				<div class="text-gray-500"># {{ household.hh_id }}</div>
                                    </div>
                                </td>
								<td
                                    class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
									<div v-if="household.village">
										{{ household.village.name }}
									</div>
									<div v-else>
										<span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Deleted</span>
									</div>
                                </td>
								<td
                                    class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
									{{ household.age }}
                                </td>
								<td></td>
                                <!-- <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                    <a @click="editHousehold(household)" href="javascript:void(0)" class="text-blue-600 hover:text-blue-900">Edit</a>
                                </td>
								<td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                    <a @click="deleteHousehold(household.name, household.id)" href="javascript:void(0)" class="text-red-600 hover:text-red-900">Delete</a>
                                </td> -->
                            </tr>
							<tr v-if="display_households.length == 0">
								<td colspan="5" class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
									<span class="lg:pl-2 text-gray-600 font-medium">No results found!</span>
								</td>
							</tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <TransitionRoot as="template" :show="household_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="household_form.show_popup = false">
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
											<div>
												<DialogTitle as="h3"
													class="text-lg font-medium leading-6 text-gray-900">{{ household_form.popup_title }}</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">Enter the details of the household head</p>
												</div>
											</div>
										</div>
										<div class="my-5 flex flex-col gap-y-6">
											<div class="grid grid-cols-2 gap-5">
												<div class="">
													<InputLabel for="household_village" value="Village" />

													<select v-model="household_form.village.value" id="household_village" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option value="" selected disabled>Select Village</option>
														<option v-for="village in allocated_villages" :key="village.id" :value="village.village_id">{{ village.village_name.name }}</option>
													</select>
													<p v-if="household_form.village.error" class="mt-1 text-red-600 text-sm">Please select household village</p>
												</div>
												<div class="">
													<InputLabel for="name" value="Name" />

													<div class="relative rounded-md shadow-sm">
														<TextInput v-model="household_form.name.value"
															id="household_name" type="text" class="block w-full font-medium" required />
													</div>
													<p v-if="household_form.name.error" class="mt-1 text-red-600 text-sm">Please enter valid name</p>
												</div>
											</div>
											<div class="grid grid-cols-2 gap-5">
												<div class="">
													<InputLabel for="household_mobile_aadhaar" value="Mobile or Aadhaar" />

													<div class="relative rounded-md shadow-sm">
														<TextInput v-model="household_form.mobile_aadhaar.value"
															maxlength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
															id="household_mobile_aadhaar" type="number" class="block w-full font-medium" required />

															<div v-if="household_form.mobile_aadhaar.value.length > 0" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
																<img v-if="household_form.mobile_aadhaar.value.length == 10" src="/images/call.svg" class="h-5 w-71" aria-hidden="true" />
																<img v-if="household_form.mobile_aadhaar.value.length > 11" src="/images/aadhaar.svg" class="h-5 w-71" aria-hidden="true" />
															</div>

													</div>
													<p v-if="household_form.mobile_aadhaar.error" class="mt-1 text-red-600 text-sm">Please enter valid mobile or aadhaar</p>
												</div>
												<div class="">
													<InputLabel for="household_social_status" value="Social Status" />

													<select v-model="household_form.social_status.value" id="household_social_status" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option value="" selected disabled>Select Social Status</option>
														<option value="apl">APL</option>
														<option value="apl-1">APL - 1</option>
														<option value="apl-2">APL - 2</option>
														<option value="bpl">BPL</option>
														<option value="bpl_antyodaya">BPL Antyodaya</option>
													</select>
													<p v-if="household_form.social_status.error" class="mt-1 text-red-600 text-sm">Please select social status</p>
												</div>
											</div>
											<div class="grid grid-cols-2 gap-5">
												<div class="">
													<InputLabel for="household_state" value="State" />

													<div class="relative rounded-md shadow-sm">
														<TextInput disabled
															:value="state"
															id="household_state" type="text" class="block w-full font-medium" required />
													</div>
													<p class="mt-2 text-xs text-gray-400 font-medium">This cannot be modified</p>
												</div>
												<div class="">
													<InputLabel for="household_age" value="Age" />

													<div class="relative rounded-md shadow-sm">
														<TextInput v-model="household_form.age.value"
															maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
															id="household_age" type="number" class="block w-full font-medium" required />
													</div>
													<p v-if="household_form.age.error" class="mt-1 text-red-600 text-sm">{{ household_form.age.error_msg }}</p>
												</div>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!household_form.processing" @click="validateForm" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
											<span>Save</span>
										</button>
										<button v-else-if="household_form.processing"
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
										<button v-if="!household_form.processing" @click="household_form.show_popup = false" type="button"
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

			<TransitionRoot as="template" :show="card_distribution_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="card_distribution_form.show_popup = false">
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
                                        <div class="flex justify-between items-center">
											<div>
												<DialogTitle as="h3"
													class="text-lg font-medium leading-6 text-gray-900">{{ card_distribution_form.popup_title }}</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">{{ card_distribution_form.popup_description }}</p>
												</div>
											</div>
										</div>
										<div v-if="card_distribution_form.view == 'enter_hhid'" class="my-5 flex flex-col gap-y-6">
											<div v-if="card_distribution_form.already_distributed" class="border-l-4 border-green-400 bg-green-50 p-4">
												<div class="flex">
													<div class="flex-shrink-0">
														<CheckCircleIcon class="h-5 w-5 text-green-500" aria-hidden="true" />
													</div>
													<div class="ml-3">
														<p class="text-sm text-green-700">
															Card is already distributed.
														</p>
													</div>
												</div>
											</div>
											<div class="">
												<InputLabel for="view_household_number" value="Household Number" />

												<div class="relative rounded-md shadow-sm">
													<TextInput v-model="card_distribution_form.hh_id.value"
														id="view_household_number" type="number" class="block w-full font-medium" required />
												</div>
												<p v-if="card_distribution_form.hh_id.error" class="mt-1 text-red-600 text-sm">{{ card_distribution_form.hh_id.error_msg }}</p>
											</div>
										</div>
										<div v-else class="my-5 flex flex-col gap-y-6">
											<div class="flex justify-between">
												<InputLabel for="card_distributed" value="Card Distributed?" />
												<Switch v-model="card_distribution_form.has_distributed" :class="[card_distribution_form.has_distributed ? 'bg-blue-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2']">
													<span class="sr-only">Use setting</span>
													<span :class="[card_distribution_form.has_distributed ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
														<span :class="[card_distribution_form.has_distributed ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
															<svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
															<path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
															</svg>
														</span>
														<span :class="[card_distribution_form.has_distributed ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
															<svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
															<path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
															</svg>
														</span>
													</span>
												</Switch>
											</div>
										</div>
                                    </div>
                                    <div v-if="card_distribution_form.view == 'enter_hhid'" class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!card_distribution_form.processing" @click="checkCardDistribution" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
											<span>Check</span>
										</button>
										<button v-else-if="card_distribution_form.processing"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed">
											<span>Checking</span>
											<svg class="animate-spin ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
												fill="none" viewBox="0 0 24 24">
												<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
													stroke-width="4"></circle>
												<path class="opacity-75" fill="currentColor"
													d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
												</path>
											</svg>
										</button>
										<button v-if="!card_distribution_form.processing" @click="card_distribution_form.show_popup = false" type="button"
											class="mr-3 group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
											<span>Cancel</span>
										</button>
                                    </div>
									<div v-else class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!card_distribution_form.processing" @click="updateCardDistributionStatus" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
											<span>Update</span>
										</button>
										<button v-else-if="card_distribution_form.processing"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed">
											<span>Updating</span>
											<svg class="animate-spin ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
												fill="none" viewBox="0 0 24 24">
												<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
													stroke-width="4"></circle>
												<path class="opacity-75" fill="currentColor"
													d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
												</path>
											</svg>
										</button>
										<button v-if="!card_distribution_form.processing" @click="card_distribution_form.show_popup = false" type="button"
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

			<TransitionRoot as="template" :show="view_household_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="view_household_form.show_popup = false">
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
                                        <div class="flex justify-between items-center">
											<div>
												<DialogTitle as="h3"
													class="text-lg font-medium leading-6 text-gray-900">View Household</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">Enter Household Number to view household</p>
												</div>
											</div>
										</div>
										<div class="my-5 flex flex-col gap-y-6">
											<div class="">
												<InputLabel for="view_household_number" value="Household Number" />

												<div class="relative rounded-md shadow-sm">
													<TextInput v-model="view_household_form.hh_id.value"
														id="view_household_number" type="number" class="block w-full font-medium" required />
												</div>
												<p v-if="view_household_form.hh_id.error" class="mt-1 text-red-600 text-sm">{{ view_household_form.hh_id.error_msg }}</p>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!view_household_form.processing" @click="viewHouseholdProcess" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
											<span>View</span>
										</button>
										<button v-else-if="view_household_form.processing"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed">
											<span>Checking</span>
											<svg class="animate-spin ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
												fill="none" viewBox="0 0 24 24">
												<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
													stroke-width="4"></circle>
												<path class="opacity-75" fill="currentColor"
													d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
												</path>
											</svg>
										</button>
										<button v-if="!view_household_form.processing" @click="view_household_form.show_popup = false" type="button"
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
		CheckCircleIcon
    } from '@heroicons/vue/24/solid'
    import {
        PlusIcon
    } from '@heroicons/vue/20/solid'
	import { ExclamationTriangleIcon, UserIcon, CreditCardIcon } from '@heroicons/vue/24/outline'

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
			MagnifyingGlassIcon,
            PlusIcon,
			ExclamationTriangleIcon,
			CreditCardIcon,
			CheckCircleIcon,
			UserIcon
        },

        props: ["allocated_villages", "households", "state"],

        data() {
            return {
				display_households: this.households,
				search_query: "",
                household_form: {
                    show_popup: false,
					popup_title: "Create New Household",
					is_active: true,
					village: {
						value: "",
						error: false
					},
					name: {
						value: "",
						error: false
					},
					mobile_aadhaar: {
						value: "",
						error: false
					},
					social_status: {
						value: "",
						error: false
					},
					age: {
						value: "",
						error: false,
						error_msg: "Please enter household age"
					},
					save_type: "new",
					household_id: null,
					processing: false
                },
				card_distribution_form: {
					show_popup: false,
					view: "enter_hhid",
					popup_title: "Card Distribution Form",
					popup_description: "Enter HH Id to check card distribution",
					hh_id: {
						value: "",
						error: false,
						error_msg: "Please enter valid HH ID"
					},
					hh_row_id: "",
					already_distributed: false,
					has_distributed: false,
					processing: false
				},
				view_household_form: {
					hh_id: {
						value: "",
						error: false,
						error_msg: "Please enter valid HH ID"
					},
					show_popup: false,
					processing: false
				},
				delete_form: {
					household_name: "",
					household_id: null,
					show_popup: false,
					processing: false
				}
            }
        },

        methods: {
			search() {
				var searchQuery = this.search_query.toString().toLowerCase();

				if (searchQuery.length > 0) {
					this.display_households = [];
					for (var siteIdx in this.households) {
						var household = this.households[siteIdx];
						if (household.name.toString().toLowerCase().includes(searchQuery)) {
							this.display_households.push(household);
							continue;
						}

						if (household.hh_id.toString().toLowerCase().includes(searchQuery)) {
							this.display_households.push(household);
							continue;
						}

						if (household.age.toString().toLowerCase().includes(searchQuery)) {
							this.display_households.push(household);
							continue;
						}

						if (household.village) {
							if (household.village.name.toString().toLowerCase().includes(searchQuery)) {
								this.display_households.push(household);
								continue;
							}
						}
					}
				}else {
					this.display_households = this.households;
				}
			},

			cardDistribution() {
				this.card_distribution_form.popup_title = "Card Distribution Form";
				this.card_distribution_form.popup_description = "Enter HH Id to check card distribution";
				this.card_distribution_form.view = "enter_hhid";

				this.card_distribution_form.already_distributed = false;
				this.card_distribution_form.has_distributed = false;

				this.card_distribution_form.hh_id.value = "";

				this.card_distribution_form.show_popup = true;
			},

			checkCardDistribution() {
				var form = this.card_distribution_form;
				form.hh_id.error = false;

				var hhNumber = form.hh_id.value;
				if (hhNumber.length == 0) {
					form.hh_id.error = true;
					form.hh_id.error_msg = "Please enter valid HH ID";
					return;
				}

				form.processing = true;

				var formData = new FormData();
				formData.append("hh_id", hhNumber);

				var vue = this;
				axios.post('/household-register/card-distribution', formData).then(function (response) {
					form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						if (data.data.card_distribution == 1) {
							form.already_distributed = true;
						}else {
							form.hh_row_id = data.data.id;
							form.view = "card_distribution_details";
							form.popup_title = data.data.name;
							form.popup_description = "Check the card distribution status";
						}
					}else {
						form.hh_id.error = true;
						form.hh_id.error_msg = data.error_msg;
					}
				});
			},

			updateCardDistributionStatus() {
				var form = this.card_distribution_form;

				form.processing = true;

				var formData = new FormData();
				formData.append("hh_row_id", form.hh_row_id);
				formData.append("distributed", form.has_distributed ? 1 : 0);

				var vue = this;
				axios.post('/household-register/card-distribution/update', formData).then(function (response) {
					form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						form.show_popup = false;
					}else {
						form.hh_id.error = true;
						form.hh_id.error_msg = data.error_msg;
					}
				});
			},

			viewHousehold() {
				this.view_household_form.show_popup = true;
			},

			viewHouseholdProcess() {
				var form = this.view_household_form;
				form.hh_id.error = false;
				
				var hhNumber = form.hh_id.value;
				if (hhNumber.length == 0) {
					form.hh_id.error = true;
					form.hh_id.error_msg = "Please enter valid HH ID";
					return;
				}

				form.processing = true;

				var formData = new FormData();
				formData.append("hh_id", hhNumber);

				var vue = this;
				axios.post('/household-register/check-hhid', formData).then(function(response) {
					form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						// console.log(data.data);
						vue.$inertia.visit('/household/'+data.data.id);
					}else {
						form.hh_id.error = true;
						form.hh_id.error_msg = data.error_msg;
					}
				});
			},

            addHousehold() {
				this.household_form.village.error = false;
				this.household_form.name.error = false;
				this.household_form.mobile_aadhaar.error = false;
				this.household_form.social_status.error = false;
				this.household_form.age.error = false;
				this.household_form.age.error_msg = "Please enter household age";

				this.household_form.save_type = "new";
				this.household_form.household_id = null;
				this.household_form.is_active = true;

				this.household_form.popup_title = "Create New Household";
                this.household_form.show_popup = true;
            },

			editHousehold(household) {
				this.household_form.village.error = false;
				this.household_form.name.error = false;
				this.household_form.mobile_aadhaar.error = false;
				this.household_form.social_status.error = false;
				this.household_form.age.error = false;
				this.household_form.age.error_msg = "Please enter household age";

				this.household_form.save_type = "edit";
				this.household_form.household_id = household.id;

				this.household_form.name.value = household.name;
				this.household_form.is_active = household.is_active == 1;

				this.household_form.popup_title = "Edit Household";
                this.household_form.show_popup = true;
			},

			deleteHousehold(name, siteId) {
				this.delete_form.household_name = name;
				this.delete_form.household_id = siteId;

				this.delete_form.show_popup = true;
			},

			validateForm() {
				var form = this.household_form;

				form.village.error = false;
				form.name.error = false;
				form.mobile_aadhaar.error = false;
				form.social_status.error = false;
				form.age.error = false;
				form.age.error_msg = "Please enter household age";

				var villageString = form.village.value.toString();
				if (villageString.length == 0) {
					form.village.error = true;
					return;
				}

				var nameString = form.name.value.toString();
				if (nameString.length == 0) {
					form.name.error = true;
					return;
				}

				var mobileAadhaarString = form.mobile_aadhaar.value.toString();
				if (mobileAadhaarString.length != 10 && mobileAadhaarString.length != 12) {
					form.mobile_aadhaar.error = true;
					return;
				}

				var socialStatusString = form.social_status.value.toString();
				if (socialStatusString.length == 0) {
					form.social_status.error = true;
					return;
				}

				var ageString = form.age.value.toString();
				if (parseInt(ageString) < 18) {
					form.age.error = true;
					form.age.error_msg = "Only 18+ age allowed";
					return;
				}

				this.saveHousehold(villageString, nameString, mobileAadhaarString, socialStatusString, ageString);
			},

			saveHousehold(village, name, mobileAadhaar, socialStatus, age) {
				this.household_form.processing = true;

				var formData = new FormData();
				formData.append("village_id", village);
				formData.append("name", name);
				formData.append("mobile_aadhaar", mobileAadhaar);
				formData.append("social_status", socialStatus);
				formData.append("age", age);
				formData.append("state", this.state);
				formData.append("save_type", this.household_form.save_type);
				formData.append("household_id", this.household_form.household_id);
				formData.append("is_active", this.household_form.is_active ? 1 : 0);

				var vue = this;
				axios.post('/household-register/save', formData).then(function(response) {
					vue.household_form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						vue.$inertia.visit('/household-register', {
							only: ["households"]
						});
					}
				});
			},

			deleteProcess() {
				this.delete_form.processing = true;

				var formData = new FormData();
				formData.append("household_id", this.delete_form.household_id);

				var vue = this;
				axios.post('/pre-requisites/delete', formData).then(function(response) {
					vue.delete_form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						vue.$inertia.visit('/pre-requisites', {
							only: ["households"]
						});
					}
				});
			}
        }
    }

</script>
