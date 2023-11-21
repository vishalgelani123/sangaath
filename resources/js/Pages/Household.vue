<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-gray-200 px-4 py-3 flex items-center justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1 flex-col">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">{{ household.name }}</h1>
					<p class="text-xs text-gray-500 font-medium"># {{ household.hh_id }}</p>
                </div>
                <div class="flex gap-4 mt-0 ml-4">
                    <button @click="addMember" type="button"
                        class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                        <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                        <span>New Member</span>
                    </button>
                </div>
            </div>
            <!-- Search field -->
            <div v-if="beneficiaries.length > 0" class="mt-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-sm">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </div>
                        <TextInput v-model="search_query" v-on:keyup="search()" v-on:change="search()" autocomplete="off" id="search" type="text" placeholder="Search members"
                            class="block w-full pl-10 font-medium" required />
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div v-if="beneficiaries.length == 0" class="mt-20 inline-block min-w-full align-middle">
                    <div class="flex items-center flex-col">
                        <img src="/images/documents.png" class="w-72" alt="" />
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No pre-requisite available</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new pre-requisite.</p>
                        <div class="mt-6">
                            <button @click="addMember" type="button"
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
                                    scope="col">Age</th>
                                <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                    scope="col">Eligiblity</th>
								<th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                    scope="col" />
								<th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                    scope="col" />
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <tr v-for="beneficiary in display_beneficiaries" :key="beneficiary.id">
                                <td
                                    class="w-1/3 max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                    <div class="lg:pl-2">
										<div class="font-medium text-gray-900">{{ beneficiary.name }}</div>
                        				<div class="text-gray-500"># {{ beneficiary.member_id }}</div>
                                    </div>
                                </td>
								<td
                                    class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
									{{ beneficiary.age }}
                                </td>
								<td
                                    class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
									<div v-if="beneficiary.is_data_incomplete"
										@click="completePendingData(beneficiary)" 
										class="cursor-pointer flex justify-end items-end">
										<ExclamationTriangleIcon class="h-5 w-5 mr-2 text-red-600" />
										<span class="font-medium text-red-500">Data Pending</span>
									</div>
									<a v-else @click="getSchemes(beneficiary.id, beneficiary.name)" href="javascript:void(0)" class="font-medium text-blue-600 hover:text-blue-900">
										Eligiblity
									</a>
                                </td>
                                <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                    <a @click="getPreRequisites(beneficiary.id, beneficiary.name)" href="javascript:void(0)" class="text-blue-600 hover:text-blue-900">
										Pre-Requisites
									</a>
                                </td>
								<td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                    <a @click="getApplications(beneficiary.id, beneficiary.name)" href="javascript:void(0)" class="text-blue-600 hover:text-blue-900">
										Applications
									</a>
                                </td>
                            </tr>
							<tr v-if="display_beneficiaries.length == 0">
								<td colspan="5" class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
									<span class="lg:pl-2 text-gray-600 font-medium">No results found!</span>
								</td>
							</tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <TransitionRoot as="template" :show="member_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="member_form.show_popup = false">
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xs">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
											<div>
												<DialogTitle as="h3"
													class="text-lg font-medium leading-6 text-gray-900">Add New Member</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">Enter the details of the new member</p>
												</div>
											</div>
										</div>
										<div class="my-5 flex flex-col gap-y-6">
											<div class="">
												<InputLabel for="member_name" value="Name" />

												<div class="relative rounded-md shadow-sm">
													<TextInput v-model="member_form.name.value"
														id="member_name" type="text" class="block w-full font-medium" required />
												</div>
												<p v-if="member_form.name.error" class="mt-1 text-red-600 text-sm">Please enter valid name</p>
											</div>
											<div class="">
												<InputLabel for="member_age" value="Age" />

												<div class="relative rounded-md shadow-sm">
													<TextInput v-model="member_form.age.value"
														maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
														id="member_age" type="number" class="block w-full font-medium" required />
												</div>
												<p v-if="member_form.age.error" class="mt-1 text-red-600 text-sm">Please enter member age</p>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!member_form.processing" @click="validateForm" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
											<span>Save</span>
										</button>
										<button v-else-if="member_form.processing"
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
										<button v-if="!member_form.processing" @click="member_form.show_popup = false" type="button"
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

			<TransitionRoot as="template" :show="complete_data_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="complete_data_form.show_popup = false">
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
													class="text-lg font-medium leading-6 text-gray-900">{{ complete_data_form.popup_title }}</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">Complete details to view eligible schemes</p>
												</div>
											</div>
										</div>
										<div class="my-5 flex flex-col gap-y-6">
											<div class="grid grid-cols-2 gap-5">
												<div class="">
													<InputLabel for="complete_data_gender" value="Gender" />

													<RadioGroup v-model="complete_data_form.gender.value" class="mt-2">
														<div class="grid grid-cols-3 gap-2">
															<RadioGroupOption as="template" v-for="gender in genders" :key="gender" :value="gender" v-slot="{ active, checked }">
																<div :class="['cursor-pointer focus:outline-none', active ? 'ring-2 ring-offset-2 ring-blue-500' : '', checked ? 'bg-blue-600 border-transparent text-white hover:bg-blue-700' : 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50', 'border rounded-md py-2 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1']">
																	<RadioGroupLabel as="span" class="capitalize font-medium">{{ gender }}</RadioGroupLabel>
																</div>
															</RadioGroupOption>
														</div>
													</RadioGroup>
													<p v-if="complete_data_form.gender.error" class="mt-1 text-red-600 text-sm">Please select a gender</p>
												</div>
												<div class="">
													<InputLabel for="complete_data_marital_status" value="Marital Status" />

													<select v-model="complete_data_form.marital_status.value" id="complete_data_marital_status" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option value="" selected disabled>Select Marital Status</option>
														<option value="currently_married">Currently Married</option>
														<option value="never_married">Never Married</option>
														<option value="divorced">Divorced</option>
														<option value="separated">Separated</option>
														<option value="widow_widower">Widow / Widower</option>
													</select>
													<p v-if="complete_data_form.marital_status.error" class="mt-1 text-red-600 text-sm">Please select marital status</p>
												</div>
											</div>
											<div class="grid grid-cols-2 gap-5">
												<div class="">
													<InputLabel for="complete_data_disability_status" value="Disability Status" />

													<select v-model="complete_data_form.disability_status.value" id="complete_data_disability_status" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option value="" selected disabled>Select Disability</option>
														<option value="blindness">Blindness / Partial Blindness</option>
														<option value="no_disability">No Disability</option>
														<option value="physical_disability">Physical Disability</option>
														<option value="mental">Mental</option>
														<option value="speech_hearing">Speech / hearing</option>
													</select>
													<p v-if="complete_data_form.disability_status.error" class="mt-1 text-red-600 text-sm">Please select disability type</p>
												</div>
												<div class="">
													<InputLabel for="complete_data_house_type" value="Type of House" />

													<select v-model="complete_data_form.type_of_house.value" id="complete_data_house_type" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option value="" selected disabled>Select Type of House</option>
														<option value="kaccha">Kaccha</option>
														<option value="semi_kaccha">Semi Kaccha</option>
														<option value="pucca">Pucca</option>
													</select>
													<p v-if="complete_data_form.type_of_house.error" class="mt-1 text-red-600 text-sm">Please select house type</p>
												</div>
											</div>
											<div class="mt-1 grid grid-cols-2 gap-5">
												<div class="flex justify-between items-start">
													<InputLabel for="complete_data_aadhaar_card" value="Aadhaar Card" />

													<Switch v-model="complete_data_form.aadhaar_card.value" :class="[complete_data_form.aadhaar_card.value ? 'bg-blue-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2']">
														<span class="sr-only">Use setting</span>
														<span :class="[complete_data_form.aadhaar_card.value ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
														<span :class="[complete_data_form.aadhaar_card.value ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
															<svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
															<path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
															</svg>
														</span>
														<span :class="[complete_data_form.aadhaar_card.value ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
															<svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
															<path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
															</svg>
														</span>
														</span>
													</Switch>
												</div>
												<div class="flex justify-between items-start">
													<InputLabel for="complete_data_bank_account" value="Bank Account" />

													<Switch v-model="complete_data_form.bank_account.value" :class="[complete_data_form.bank_account.value ? 'bg-blue-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2']">
														<span class="sr-only">Use setting</span>
														<span :class="[complete_data_form.bank_account.value ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
														<span :class="[complete_data_form.bank_account.value ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
															<svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
															<path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
															</svg>
														</span>
														<span :class="[complete_data_form.bank_account.value ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
															<svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
															<path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
															</svg>
														</span>
														</span>
													</Switch>
												</div>
											</div>
											<div class="grid grid-cols-2 gap-5">
												<div class="flex justify-between items-start">
													<InputLabel for="complete_data_election_card" value="Election Card" />

													<Switch v-model="complete_data_form.election_card.value" :class="[complete_data_form.election_card.value ? 'bg-blue-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2']">
														<span class="sr-only">Use setting</span>
														<span :class="[complete_data_form.election_card.value ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
														<span :class="[complete_data_form.election_card.value ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
															<svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
															<path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
															</svg>
														</span>
														<span :class="[complete_data_form.election_card.value ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
															<svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
															<path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
															</svg>
														</span>
														</span>
													</Switch>
												</div>
												<div class="flex justify-between items-start">
													<InputLabel for="complete_data_land_ownership" value="Land Ownership" />

													<Switch v-model="complete_data_form.land_ownership.value" :class="[complete_data_form.land_ownership.value ? 'bg-blue-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2']">
														<span class="sr-only">Use setting</span>
														<span :class="[complete_data_form.land_ownership.value ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
														<span :class="[complete_data_form.land_ownership.value ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
															<svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
															<path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
															</svg>
														</span>
														<span :class="[complete_data_form.land_ownership.value ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
															<svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
															<path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
															</svg>
														</span>
														</span>
													</Switch>
												</div>
											</div>
											<div class="-mt-0.5 grid grid-cols-2 gap-5">
												<div class="">
													<InputLabel for="complete_data_widow_status" value="Widow Status" />

													<select v-model="complete_data_form.widow_status.value" id="complete_data_widow_status" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option value="" selected disabled>Select Widow Status</option>
														<option value="currently_married">Currently Married</option>
														<option value="never_married">Never Married</option>
														<option value="divorced">Divorced</option>
														<option value="separated">Separated</option>
														<option value="widow_widower">Widow / Widower</option>
													</select>
													<p v-if="complete_data_form.widow_status.error" class="mt-1 text-red-600 text-sm">Please select widow status</p>
												</div>
												<div class="">
													<InputLabel for="complete_data_card_score" value="Card Score" />

													<RadioGroup v-model="complete_data_form.card_score.value" class="mt-2">
														<div class="grid grid-cols-2 gap-2">
															<RadioGroupOption as="template" v-for="card_score in card_scores" :key="card_score.value" :value="card_score.value" v-slot="{ active, checked }">
																<div :class="['cursor-pointer focus:outline-none', active ? 'ring-2 ring-offset-2 ring-blue-500' : '', checked ? 'bg-blue-600 border-transparent text-white hover:bg-blue-700' : 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50', 'border rounded-md py-2 px-3 flex items-center justify-center text-sm font-medium sm:flex-1']">
																	<RadioGroupLabel as="span" class="font-medium">{{ card_score.name }}</RadioGroupLabel>
																</div>
															</RadioGroupOption>
														</div>
													</RadioGroup>
													<p v-if="complete_data_form.card_score.error" class="mt-1 text-red-600 text-sm">Please select card score</p>
												</div>
											</div>
											<div>
												<div class="">
													<InputLabel for="complete_data_income" value="Income" />

													<RadioGroup v-model="complete_data_form.income.value" class="mt-2">
														<div class="grid grid-cols-3 gap-2">
															<RadioGroupOption as="template" v-for="income in incomes" :key="income.value" :value="income.value" v-slot="{ active, checked }">
																<div :class="['cursor-pointer focus:outline-none', active ? 'ring-2 ring-offset-2 ring-blue-500' : '', checked ? 'bg-blue-600 border-transparent text-white hover:bg-blue-700' : 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50', 'border rounded-md py-2 px-3 flex items-center justify-center text-sm font-medium sm:flex-1']">
																	<RadioGroupLabel as="span" class="font-medium">{{ income.name }}</RadioGroupLabel>
																</div>
															</RadioGroupOption>
														</div>
													</RadioGroup>
													<p v-if="complete_data_form.income.error" class="mt-1 text-red-600 text-sm">Please select income</p>
												</div>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!complete_data_form.processing" @click="validatePendingDataForm" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
											<span>Save</span>
										</button>
										<button v-else-if="complete_data_form.processing"
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
										<button v-if="!complete_data_form.processing" @click="complete_data_form.show_popup = false" type="button"
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

			<TransitionRoot as="template" :show="view_schemes.show_popup">
                <Dialog as="div" class="relative z-10" @close="view_schemes.show_popup = false">
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
											<div>
												<DialogTitle as="h3"
													class="text-lg font-medium leading-6 text-gray-900">{{ view_schemes.popup_title }}</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">Switch between tabs to see different type of schemes</p>
												</div>
											</div>
										</div>
										<div v-if="view_schemes.schemes != null">
											<div class="mt-5 border-b border-gray-200">
												<nav class="-mb-px flex space-x-8" aria-label="Tabs">
													<a @click="view_schemes.tab = 'eligible'" 
														href="javascript:void(0)" 
														:class="[view_schemes.tab == 'eligible' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200', 'whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm']" :aria-current="view_schemes.tab == 'eligible' ? 'page' : undefined">
														Eligible
														<span class="flex items-center" :class="[view_schemes.tab == 'eligible' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-900', 'ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium']">
															{{ view_schemes.schemes["eligible"].length }}
														</span>
													</a>
													<a @click="view_schemes.tab = 'pre_requisite'" 
														href="javascript:void(0)" 
														:class="[view_schemes.tab == 'pre_requisite' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200', 'whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm']" :aria-current="view_schemes.tab == 'eligible' ? 'page' : undefined">
														Pre-Requisites
														<span class="flex items-center" :class="[view_schemes.tab == 'pre_requisite' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-900', 'ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium']">
															{{ view_schemes.schemes["pre_requisite"].length }}
														</span>
													</a>
													<a @click="view_schemes.tab = 'partial_match'" 
														href="javascript:void(0)" 
														:class="[view_schemes.tab == 'partial_match' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200', 'whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm']" :aria-current="view_schemes.tab == 'eligible' ? 'page' : undefined">
														Partial Match
														<span class="flex items-center" :class="[view_schemes.tab == 'partial_match' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-900', 'ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium']">
															{{ view_schemes.schemes["partial_match"].length }}
														</span>
													</a>
												</nav>
											</div>
											<div class="mt-2">
												<div>
													<ul role="list" class="">
														<li v-for="scheme in view_schemes.schemes[view_schemes.tab]" :key="scheme.idl">
															<a @click="applyScheme(scheme.id, scheme.name)" href="javascript:void(0)" 
																class="block cursor-pointer hover:bg-gray-100 rounded-[5px]">
																<div class="flex items-center justify-between px-4 py-2">
																	<p class="truncate text-sm font-medium text-gray-700">{{ scheme.name }}</p>
																	<div>
																		<ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
																	</div>
																</div>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
										<button @click="view_schemes.show_popup = false" type="button"
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

			<TransitionRoot as="template" :show="apply_scheme.show_popup">
                <Dialog as="div" class="relative z-10" @close="apply_scheme.show_popup = false">
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
											<div>
												<DialogTitle as="h3"
													class="text-lg font-medium leading-6 text-gray-900">{{ apply_scheme.popup_title }}</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">Upload the documents below to continue</p>
												</div>
											</div>
										</div>
										<div v-if="apply_scheme.documents != null" class="mt-5">
											<div v-if="Object.keys(apply_scheme.documents).length > 0" class="grid grid-cols-2 gap-3">
												<input @change="previewImage($event)" type="file" accept="image/*" id="document_selector" class="hidden" />
												<div v-for="document in apply_scheme.documents" :key="document.prerequisite_id" 
													@click="selectDocument(document.prerequisite_id)"
													v-bind:class="{'cursor-pointer': !document.is_selected}"
													class="w-full group hover:bg-gray-100 relative border border-gray-200 rounded grid grid-cols-12 items-center px-3 py-2">
													<div class="col-span-11">
														<p class="text-xs font-medium text-gray-700">{{ document.pre_requisite.name }}</p>
													</div>
													<CloudArrowUpIcon v-if="!document.is_selected" class="text-right text-blue-600 h-5 w-5" />
													<div v-else>
														<CheckCircleIcon class="group-hover:hidden text-right text-green-600 h-5 w-5" />
														<div class="hidden group-hover:flex absolute right-5 bottom-2 gap-3">
															<EyeIcon @click="viewDocument(document.prerequisite_id)" class="cursor-pointer text-blue-600 h-5 w-5" />
															<XCircleIcon @click="removeDocument(document.prerequisite_id)" class="cursor-pointer text-red-600 h-5 w-5" />
														</div>
													</div>
												</div>
											</div>
											<div v-else>
												<p class="text-sm text-gray-600 italic">No documents needed for this scheme</p>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 flex justify-between sm:px-6">
										<button v-if="!apply_scheme.skip_apply_processing && !apply_scheme.incomplete_processing" @click="apply_scheme.show_popup = false" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
											<span>Close</span>
										</button>
										<div v-else></div>

										<div class="flex flex-row-reverse gap-6">
											<button v-if="!apply_scheme.skip_apply_processing && !apply_scheme.incomplete_processing" 
												@click="saveSchemeIncomplete" type="button"
												class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
												<span>Save as In-Complete</span>
											</button>

											<button v-if="!apply_scheme.skip_apply_processing && !apply_scheme.incomplete_processing" 
												@click="skipApplyScheme" type="button"
												class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
												<span>Skip & Apply</span>
											</button>

											<button v-if="apply_scheme.skip_apply_processing || apply_scheme.incomplete_processing"
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
										</div>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>

			<TransitionRoot as="template" :show="pre_requisite_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="pre_requisite_form.show_popup = false">
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full max-w-3xl lg:max-w-5xl">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
											<div>
												<DialogTitle as="h3"
													class="text-lg font-medium leading-6 text-gray-900">{{ pre_requisite_form.popup_title }}</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">Upload the documents below to continue</p>
												</div>
											</div>
										</div>
										<div v-if="pre_requisite_form.documents != null" class="mt-5">
											<div v-if="Object.keys(pre_requisite_form.documents).length > 0" class="grid grid-cols-2 lg:grid-cols-3 gap-2">
												<input @change="previewImage($event, 'pre_requisite_form')" type="file" accept="image/*" id="document_selector" class="hidden" />
												<div v-for="document in pre_requisite_form.documents" :key="document.id" 
													@click="selectDocument(document.id, 'pre_requisite_form')"
													v-bind:class="{'cursor-pointer': !document.is_selected}"
													class="w-full group hover:bg-gray-100 relative border border-gray-200 rounded grid grid-cols-12 items-center px-3 py-2">
													<div class="col-span-11">
														<p class="text-xs font-medium text-gray-700">{{ document.name }}</p>
													</div>
													<CloudArrowUpIcon v-if="!document.is_selected" class="text-right text-blue-600 h-5 w-5" />
													<div v-else>
														<CheckCircleIcon class="group-hover:hidden text-right text-green-600 h-5 w-5" />
														<div class="hidden group-hover:flex absolute right-5 bottom-2 gap-3">
															<EyeIcon @click="viewDocument(document.id, 'pre_requisite_form')" class="cursor-pointer text-blue-600 h-5 w-5" />
															<XCircleIcon @click="removeDocument(document.id, 'pre_requisite_form')" class="cursor-pointer text-red-600 h-5 w-5" />
														</div>
													</div>
												</div>
											</div>
											<div v-else>
												<p class="text-sm text-gray-600 italic">No documents needed for this scheme</p>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6">
										<div class="flex flex-row-reverse gap-6">
											<button v-if="!pre_requisite_form.processing" 
												@click="savePreRequisites" type="button"
												class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
												<span>Save</span>
											</button>

											<button v-if="!pre_requisite_form.processing" 
												@click="pre_requisite_form.show_popup = false" type="button"
												class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50  active:bg-gray-100 focus-visible:outline-blue-600">
												<span>Cancel</span>
											</button>

											<button v-if="pre_requisite_form.processing"
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
										</div>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>

			<TransitionRoot as="template" :show="applications_popup.show_popup">
                <Dialog as="div" class="relative z-10" @close="applications_popup.show_popup = false">
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
											<div>
												<DialogTitle as="h3"
													class="text-lg font-medium leading-6 text-gray-900">{{ applications_popup.popup_title }}</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">Applications this member has applied for</p>
												</div>
											</div>
										</div>
										<div class="mt-5" v-if="applications_popup.applications != null">
											<div class="overflow-hidden ring-1 ring-black ring-opacity-10 md:rounded-lg">
												<table class="min-w-full divide-y divide-gray-300">
													<thead class="bg-gray-50">
														<tr>
															<th scope="col" class="py-2 pl-4 pr-3 w-20 text-left text-sm font-semibold text-gray-900 sm:pl-6">Scheme</th>
															<th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Documentation</th>
															<th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">FS verification</th>
															<th scope="col" class="px-3 py-2 text-left text-sm font-semibold text-gray-900">Govt. submission</th>
														</tr>
													</thead>
													<tbody class="divide-y divide-gray-200 bg-white">
														<tr v-for="application in applications_popup.applications" :key="application.id">
															<td class="whitespace-nowrap py-2 pl-4 pr-3 w-20 text-sm sm:pl-6">
																<div>
																	<div class="font-medium text-gray-900">{{ application.scheme.name }}</div>
																	<div class="text-gray-500">{{ application.scheme.department }}</div>
																</div>
															</td>
															<td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
																<div v-if="application.documentation_date != null" class="text-gray-900">{{ application.documentation_date }}</div>
															</td>
															<td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
																<div v-if="application.liasoning_date != null" class="text-gray-900">{{ application.liasoning_date }}</div>
															</td>
															<td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
																<div v-if="application.govt_submission_date != null" class="text-gray-900">{{ application.govt_submission_date }}</div>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
										<button @click="applications_popup.show_popup = false" type="button"
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

			<TransitionRoot as="template" :show="apply_scheme.applied_popup_show">
				<Dialog as="div" class="relative z-10" @close="apply_scheme.applied_popup_show = false">
				<TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
					<div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
				</TransitionChild>

				<div class="fixed inset-0 z-10 overflow-y-auto">
					<div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
					<TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
						<DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
						<div>
							<div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
							<CheckIcon class="h-6 w-6 text-green-600" aria-hidden="true" />
							</div>
							<div class="mt-3 text-center sm:mt-5">
							<DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Applied successfully</DialogTitle>
							<div class="mt-2">
								<p class="text-sm text-gray-500">You have applied successfully to {{ apply_scheme.popup_title }}.</p>
							</div>
							</div>
						</div>
						<div class="mt-5 sm:mt-6">
							<button type="button" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:text-sm" @click="apply_scheme.applied_popup_show = false">Close</button>
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
		Switch,
		RadioGroup,
		RadioGroupLabel,
		RadioGroupOption
    } from '@headlessui/vue'
    import TextInput from '@/Components/TextInput.vue';
    import InputLabel from '@/Components/InputLabel.vue';

    import {
        MagnifyingGlassIcon,
		CheckCircleIcon,
		XCircleIcon
    } from '@heroicons/vue/24/solid'
    import {
        PlusIcon,
		ChevronRightIcon
    } from '@heroicons/vue/20/solid'
	import { ExclamationTriangleIcon, UserIcon, EyeIcon, CloudArrowUpIcon, CheckIcon } from '@heroicons/vue/24/outline'

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
			RadioGroup,
			RadioGroupLabel,
			RadioGroupOption,
			Switch,
			MagnifyingGlassIcon,
            PlusIcon,
			ExclamationTriangleIcon,
			ChevronRightIcon,
			UserIcon,
			EyeIcon,
			XCircleIcon,
			CloudArrowUpIcon,
			CheckCircleIcon,
			CheckIcon
        },

        props: ["household", "beneficiaries"],

        data() {
            return {
				display_beneficiaries: this.beneficiaries,
				search_query: "",
				genders: ["male", "female", "other"],
				card_scores: [
					{
						"name": "0 to 20",
						"value": "0_20"
					},
					{
						"name": "Above 20",
						"value": "above_20"
					}
				],
				incomes: [
					{
						"name": "< 1,20,000",
						value: "Less than 1,20,000"
					},
					{
						"name": "1,20,000 - 4,00,000",
						value: "1,20,000 - 4,00,000"
					},
					{
						"name": "> 4,00,000",
						value: "> 4,00,000"
					}
				],
                member_form: {
                    show_popup: false,
					is_active: true,
					name: {
						value: "",
						error: false
					},
					age: {
						value: "",
						error: false
					},
					save_type: "new",
					member_id: null,
					processing: false
                },
				complete_data_form: {
					show_popup: false,
					popup_title: "",
					gender: {
						value: "",
						error: false
					},
					marital_status: {
						value: "",
						error: false
					},
					disability_status: {
						value: "",
						error: false
					},
					type_of_house: {
						value: "",
						error: false
					},
					aadhaar_card: {
						value: false,
						error: false
					},
					bank_account: {
						value: false,
						error: false
					},
					election_card: {
						value: false,
						error: false
					},
					widow_status: {
						value: "",
						error: false
					},
					land_ownership: {
						value: false,
						error: false
					},
					card_score: {
						value: "",
						error: false
					},
					income: {
						value: "",
						error: false
					},
					member_id: "",
					processing: false
				},
				view_schemes: {
					show_popup: false,
					popup_title: "",
					member_row_id: "",
					tab: 'eligible',
					schemes: null
				},
				apply_scheme: {
					show_popup: false,
					applied_popup_show: false,
					popup_title: "",
					member_id: "",
					scheme_id: "",
					selecting_pre_requisite_id: null,
					documents: null,
					eligible_status: "",
					incomplete_processing: false,
					skip_apply_processing: false
				},
				documents: {

				},
				pre_requisite_form: {
					show_popup: false,
					popup_title: "",
					member_row_id: "",
					documents: null,
					processing: false
				},
				applications_popup: {
					show_popup: false,
					popup_title: "",
					member_row_id: "",
					applications: null
				}
            }
        },

        methods: {
			search() {
				var searchQuery = this.search_query.toString().toLowerCase();

				if (searchQuery.length > 0) {
					this.display_beneficiaries = [];
					for (var siteIdx in this.beneficiaries) {
						var beneficiary = this.beneficiaries[siteIdx];
						if (beneficiary.name.toString().toLowerCase().includes(searchQuery)) {
							this.display_beneficiaries.push(beneficiary);
							continue;
						}

						if (beneficiary.member_id.toString().toLowerCase().includes(searchQuery)) {
							this.display_beneficiaries.push(beneficiary);
							continue;
						}

						if (beneficiary.age.toString().toLowerCase().includes(searchQuery)) {
							this.display_beneficiaries.push(beneficiary);
							continue;
						}
					}
				}else {
					this.display_beneficiaries = this.beneficiaries;
				}
			},

			completePendingData(beneficiary) {
				this.complete_data_form.show_popup = true;
				this.complete_data_form.popup_title = beneficiary.name;
				this.complete_data_form.member_id = beneficiary.member_id;

				if (beneficiary.gender) {
					this.complete_data_form.gender.value = beneficiary.gender;
				}

				// console.log(beneficiary);
				if (beneficiary.marital_status) {
					this.complete_data_form.marital_status.value = beneficiary.marital_status;
				}

				if (beneficiary.disability) {
					this.complete_data_form.disability_status.value = beneficiary.disability;
				}

				if (beneficiary.type_of_house || beneficiary.type_of_house != "") {
					this.complete_data_form.type_of_house.value = beneficiary.type_of_house;
				}

				if (beneficiary.aadhaar_card == 1) {
					this.complete_data_form.aadhaar_card.value = beneficiary.aadhaar_card == 1;
				}

				if (beneficiary.bank_account == 1) {
					this.complete_data_form.bank_account.value = beneficiary.bank_account == 1;
				}

				if (beneficiary.election_card == 1) {
					this.complete_data_form.election_card.value = beneficiary.election_card == 1;
				}

				if (beneficiary.land_ownership == 1) {
					this.complete_data_form.land_ownership.value = beneficiary.land_ownership == 1;
				}

				if (beneficiary.widow_status) {
					this.complete_data_form.widow_status.value = beneficiary.widow_status;
				}

				var cardScore = this.household.card_score;
				if (cardScore) {
					this.complete_data_form.card_score.value = cardScore;
				}

				if (beneficiary.income) {
					this.complete_data_form.income.value = beneficiary.income;
				}
			},

			validatePendingDataForm() {
				var form = this.complete_data_form;AppLayout
				
				var gender = form.gender.value.toString();
				if (gender.length == 0) {
					form.gender.error = true;
					return;
				}

				var maritalStatus = form.marital_status.value.toString();
				if (maritalStatus.length == 0) {
					form.marital_status.error = true;
					return;
				}

				var disabilityStatus = form.disability_status.value.toString();
				if (disabilityStatus.length == 0) {
					form.disability_status.error = true;
					return;
				}

				var typeOfHouse = form.type_of_house.value.toString();
				if (typeOfHouse.length == 0) {
					form.type_of_house.error = true;
					return;
				}

				var widowStatus = form.widow_status.value.toString();
				if (widowStatus.length == 0) {
					form.widow_status.error = true;
					return;
				}

				var cardScore = form.card_score.value.toString();
				if (cardScore.length == 0) {
					form.card_score.error = true;
					return;
				}

				var income = form.income.value.toString();
				if (income.length == 0) {
					form.income.error = true;
					return;
				}

				var aadhaarCard = form.aadhaar_card.value ? 1 : 0;
				var bankAccount = form.bank_account.value ? 1 : 0;
				var electionCard = form.election_card.value ? 1 : 0;
				var landOwnership = form.land_ownership.value ? 1 : 0;

				this.savePendingData(gender, maritalStatus, disabilityStatus, typeOfHouse, aadhaarCard, bankAccount, electionCard, landOwnership, widowStatus, cardScore, income);
			},

			savePendingData(gender, maritalStatus, disabilityStatus, typeOfHouse, aadhaarCard, bankAccount, electionCard, landOwnership, widowStatus, cardScore, income) {
				var form = this.complete_data_form;

				form.processing = true;

				var formData = new FormData();
				formData.append("gender", gender);
				formData.append("marital_status", maritalStatus);
				formData.append("disability_status", disabilityStatus);
				formData.append("type_of_house", typeOfHouse);
				formData.append("aadhaar_card", aadhaarCard);
				formData.append("bank_account", bankAccount);
				formData.append("election_card", electionCard);
				formData.append("land_ownership", landOwnership);
				formData.append("widow_status", widowStatus);
				formData.append("card_score", cardScore);
				formData.append("income", income);
				formData.append("member_id", form.member_id);
				formData.append("hh_id", this.household.hh_id);
				formData.append("village_id", this.household.village_id);

				var vue = this;
				axios.post('/household/save-pending', formData).then(function (response) {
					var data = response.data;

					form.processing = false;
					if (data.status == 1) {
						vue.$inertia.visit('/household/'+vue.household.id, {
							only: ["beneficiaries"]
						});
					}
				});
			},

            addMember() {
				this.member_form.name.error = false;
				this.member_form.age.error = false;

				this.member_form.save_type = "new";
				this.member_form.member_id = null;
				this.member_form.is_active = true;

                this.member_form.show_popup = true;
            },

			validateForm() {
				var form = this.member_form;

				form.name.error = false;
				form.age.error = false;

				var nameString = form.name.value.toString();
				if (nameString.length == 0) {
					form.name.error = true;
					return;
				}

				var ageString = form.age.value.toString();
				if (ageString.length == 0) {
					form.age.error = true;
					return;
				}

				this.saveMember(nameString, ageString);
			},

			saveMember(name, age) {
				this.member_form.processing = true;

				var formData = new FormData();
				formData.append("name", name);
				formData.append("age", age);
				formData.append("save_type", this.member_form.save_type);
				formData.append("hh_id", this.household.hh_id);
				formData.append("village_id", this.household.village_id);
				formData.append("existing_member_count", this.beneficiaries.length);
				formData.append("is_active", this.member_form.is_active ? 1 : 0);

				var vue = this;
				axios.post('/household/save-member', formData).then(function(response) {
					vue.member_form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						vue.$inertia.visit('/household/'+vue.household.id, {
							only: ["beneficiaries"]
						});
					}
				});
			},

			getApplications(id, name) {
				this.applications_popup.popup_title = name+" applications";
				this.applications_popup.show_popup = true;
				this.applications_popup.member_row_id = id;

				var vue = this;
				axios.get('/household/applications/'+id).then(function (response) {
					var applications = response.data.data.applications;

					if (applications != null) {
						console.log(applications);
						vue.applications_popup.applications = applications;
						// vue.view_schemes.schemes = data.schemes;
					}
				});
			},

			getPreRequisites(id, name) {
				this.pre_requisite_form.popup_title = "Pre-Requisites for "+name;
				this.pre_requisite_form.show_popup = true;
				this.pre_requisite_form.member_row_id = id;

				var vue = this;
				axios.get('/household/prerequisites/'+id).then(function (response) {
					var preRequisites = response.data.data.pre_requisites;

					if (preRequisites != null) {
						vue.pre_requisite_form.documents = preRequisites;
						// vue.view_schemes.schemes = data.schemes;
					}
				});
			},

			savePreRequisites() {
				var form = this.pre_requisite_form;

				form.processing = true;

				var documents = form.documents;

				var selectedDocuments = [];
				var uploadingDocuments = [];

				var formData = new FormData();

				for (var preRequisiteId in documents) {
					var document = form.documents[preRequisiteId];

					if (document.is_selected && (!document.file || document.file == "")) {
						selectedDocuments.push(preRequisiteId);
					}
					if (document.file && document.file != "") {
						formData.append("document_"+preRequisiteId, document.file);
						uploadingDocuments.push(preRequisiteId);
					}
				}

				formData.append("selected_documents", JSON.stringify(selectedDocuments));
				formData.append("uploading_documents", JSON.stringify(uploadingDocuments));
				formData.append("member_row_id", form.member_row_id);

				var vue = this;
				axios.post("/household/save-prerequisites", formData).then(function (response) {
					form.processing = false;
					form.show_popup = false;
				});
			},

			getSchemes(id, name) {
				this.view_schemes.popup_title = "Schemes for "+name;
				this.view_schemes.show_popup = true;
				this.view_schemes.member_row_id = id;

				var formData = new FormData();
				formData.append("hh_id", this.household.id);
				formData.append("member_row_id", id);

				var vue = this;
				axios.post('/household/schemes', formData).then(function (response) {
					var data = response.data.data;

					if (data != null) {
						vue.view_schemes.schemes = data.schemes;
					}
				});
			},

			applyScheme(schemeId, name) {
				this.apply_scheme.popup_title = name;
				this.apply_scheme.scheme_id = schemeId;

				this.view_schemes.show_popup = false;
				this.apply_scheme.show_popup = true;
				this.apply_scheme.eligible_status = this.view_schemes.tab;

				var vue = this;
				axios.get('/household/scheme/'+schemeId+'/'+this.view_schemes.member_row_id).then(function (response) {
					var data = response.data.data;

					if (data != null) {
						var documents = data.documents;
						vue.apply_scheme.documents = {};
						for (var documentIdx in documents) {
							var document = documents[documentIdx];
							if (!document.is_selected) {
								document.is_selected = false;
								document.preview_url = "";	
							}
							document.file = "";
							vue.apply_scheme.documents[document.prerequisite_id] = document;
						}
					}
				});
			},

			selectDocument(preRequisiteId, form="apply_scheme") {
				var isSelected = this[form].documents[preRequisiteId].is_selected;
				
				if (!isSelected) {
					this[form].selecting_pre_requisite_id = preRequisiteId;
					document.getElementById("document_selector").click();
				}else {
					this.viewDocument(preRequisiteId, form);
				}
			},

			viewDocument(preRequisiteId, form="apply_scheme") {
				var previewURL = this[form].documents[preRequisiteId].preview_url;
				window.open(previewURL, "_blank");
			},

			removeDocument(preRequisiteId, form="apply_scheme") {
				var document = this[form].documents[preRequisiteId];

				document.is_selected = false;
				document.preview_url = "";
				document.file = "";
			},

			previewImage(event, form="apply_scheme") {
                if (event.target.files[0] != undefined) {
                    var imgURL = URL.createObjectURL(event.target.files[0]);

                    var filesize = ((event.target.files[0].size/1024)/1024).toFixed(4); // MB
                    if (filesize > 10) {
                        alert("Image too large! Please select an image smaller than 10 MB");
                    }else {
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

				var documents = this.apply_scheme.documents;

				var selectedDocuments = [];
				for (var preRequisiteId in documents) {
					var document = this.apply_scheme.documents[preRequisiteId];

					if (document.file != "") {
						formData.append("document_"+preRequisiteId, document.file);
						selectedDocuments.push(preRequisiteId);
					}
				}
				formData.append("selected_documents", JSON.stringify(selectedDocuments));
				formData.append("scheme_id", this.apply_scheme.scheme_id);
				formData.append("member_row_id", this.view_schemes.member_row_id);

				this.apply_scheme.incomplete_processing = true;

				var vue = this;
				axios.post("/application/save-incomplete", formData).then(function (response) {
					vue.apply_scheme.incomplete_processing = false;
					vue.apply_scheme.show_popup = false;
					vue.apply_scheme.applied_popup_show = true;
				});
			},

			skipApplyScheme() {
				var formData = new FormData();

				var documents = this.apply_scheme.documents;

				var selectedDocuments = [];
				for (var preRequisiteId in documents) {
					var document = this.apply_scheme.documents[preRequisiteId];

					if (document.file != "") {
						formData.append("document_"+preRequisiteId, document.file);
						selectedDocuments.push(preRequisiteId);
					}
				}
				formData.append("selected_documents", JSON.stringify(selectedDocuments));
				formData.append("scheme_id", this.apply_scheme.scheme_id);
				formData.append("member_row_id", this.view_schemes.member_row_id);
				formData.append("eligible_status", this.apply_scheme.eligible_status);

				this.apply_scheme.incomplete_processing = true;

				var vue = this;
				axios.post("/application/skip-apply", formData).then(function (response) {
					vue.apply_scheme.skip_apply_processing = false;
					vue.apply_scheme.show_popup = false;
					vue.apply_scheme.applied_popup_show = true;
				});
			}
        }
    }

</script>
