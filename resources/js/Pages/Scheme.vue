<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-gray-200 px-4 py-3 flex items-center justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">All Schemes</h1>
                </div>
                <div class="flex mt-0 ml-4">
                    <button @click="addScheme" type="button"
                        class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                        <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                        <span>New Scheme</span>
                    </button>
                </div>
            </div>
            <!-- Search field -->
            <div v-if="all_schemes.length > 0" class="mt-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-sm">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </div>
                        <TextInput v-model="search_query" v-on:keyup="search()" v-on:change="search()" autocomplete="off" id="search_input" type="text" placeholder="Search Schemes"
                            class="block w-full pl-10 font-medium" required />
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div v-if="all_schemes.length == 0" class="mt-20 inline-block min-w-full align-middle">
                    <div class="flex items-center flex-col">
                        <img src="/images/documents.png" class="w-72" alt="" />
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No schemes available</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new scheme.</p>
                        <div class="mt-6">
                            <button @click="addScheme" type="button"
                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true" />
                                <span>New Scheme</span>
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
                                    scope="col">Category</th>
								<th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                    scope="col">Type</th>
								<th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                    scope="col">Followup</th>
                                <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                    scope="col">Status</th>
								<th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                    scope="col" />
                                <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                    scope="col" />
								<!-- <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                    scope="col" /> -->
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <tr v-for="scheme in display_schemes" :key="scheme.id">
                                <td
                                    class="w-1/3 max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                    <div class="lg:pl-2">
										<div class="font-medium text-gray-900">{{ scheme.name }}</div>
                        				<div class="text-gray-500">{{ scheme.department }}</div>
                                    </div>
                                </td>
								<td class="px-6 py-3 text-sm font-medium text-gray-500">
                                    {{ scheme.display_category }} level
                                </td>
								<td class="px-6 py-3 text-sm font-medium text-gray-500">
									<span v-if="scheme.type == 'scheme'" class="inline-flex items-center rounded bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800">
										<svg class="mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
											<circle cx="4" cy="4" r="3" />
										</svg>
										Scheme
									</span>
									<span v-else class="inline-flex items-center rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">
										<svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
											<circle cx="4" cy="4" r="3" />
										</svg>
										Pre-Requisite
									</span>
                                </td>
								<td class="w-5 px-6 py-3 text-sm font-medium text-gray-500">
                                    {{ scheme.followup_days }} days
                                </td>
                                <td
                                    class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
									<span v-if="scheme.is_active == 1" class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Active</span>
									<span v-else class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Inactive</span>
                                </td>
								<td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                    <a @click="editRules(scheme)" href="javascript:void(0)" class="text-blue-600 hover:text-blue-900">Rules</a>
                                </td>
                                <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                    <a @click="editScheme(scheme)" href="javascript:void(0)" class="text-blue-600 hover:text-blue-900">Edit</a>
                                </td>
								<!-- <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                    <a @click="deleteScheme(scheme.name, scheme.id)" href="javascript:void(0)" class="text-red-600 hover:text-red-900">Delete</a>
                                </td> -->
                            </tr>
							<tr v-if="display_schemes.length == 0">
								<td colspan="5" class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
									<span class="lg:pl-2 text-gray-600 font-medium">No results found!</span>
								</td>
							</tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <TransitionRoot as="template" :show="scheme_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="scheme_form.show_popup = false">
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
													class="text-lg font-medium leading-6 text-gray-900">{{ scheme_form.popup_title }}</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">Enter scheme details and allocate the location</p>
												</div>
											</div>
											<div>
												<Switch v-model="scheme_form.is_active" :class="[scheme_form.is_active ? 'bg-blue-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2']">
													<span class="sr-only">Use setting</span>
													<span :class="[scheme_form.is_active ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
													<span :class="[scheme_form.is_active ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
														<svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
														<path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
														</svg>
													</span>
													<span :class="[scheme_form.is_active ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
														<svg class="h-3 w-3 text-blue-600" fill="currentColor" viewBox="0 0 12 12">
														<path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
														</svg>
													</span>
													</span>
												</Switch>
											</div>
										</div>
										<div class="my-5 flex flex-col gap-y-6">
											<div class="grid grid-cols-2 gap-5">
												<div class="">
													<InputLabel for="scheme_state" value="Category" />

													<select v-model="scheme_form.category.value" id="scheme_state" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option value="" selected disabled>Select Scheme Category</option>
														<option value="central">Central Level</option>
														<option value="state">State Level</option>
														<option value="district">District Level</option>
														<option value="block">Block Level</option>
														<option value="panchayat">Panchayat Level</option>
														<option value="village">Village Level</option>
														<option value="other">Other</option>
													</select>
													<p v-if="scheme_form.category.error" class="mt-1 text-red-600 text-sm">Please select valid category</p>
												</div>

												<div class="">
													<InputLabel for="scheme_department" value="Department" />

													<div class="relative rounded-md shadow-sm">
														<TextInput v-model="scheme_form.department.value"
															id="scheme_department" type="text" class="block w-full font-medium" required />
													</div>
													<p v-if="scheme_form.department.error" class="mt-1 text-red-600 text-sm">Please enter valid department</p>
												</div>
											</div>
											<div class="grid grid-cols-2 gap-5">
												<div class="">
													<InputLabel for="scheme_name" value="Name" />

													<div class="relative rounded-md shadow-sm">
														<TextInput v-model="scheme_form.name.value"
															id="scheme_name" type="text" class="block w-full font-medium" required />
													</div>
													<p v-if="scheme_form.name.error" class="mt-1 text-red-600 text-sm">Please enter valid name</p>
												</div>

												<div class="">
													<InputLabel for="scheme_type" value="Type" />

													<select v-model="scheme_form.type.value" id="scheme_type" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option value="" selected disabled>Select Scheme Type</option>
														<option value="scheme">Scheme</option>
														<option value="prerequisite">Pre-Requisite</option>
													</select>
													<p v-if="scheme_form.type.error" class="mt-1 text-red-600 text-sm">Please select scheme type</p>
												</div>
											</div>
											<div class="grid grid-cols-2 gap-5">
												<div class="">
													<InputLabel for="scheme_followup_days" value="Follow Up Days" />

													<div class="relative rounded-md shadow-sm">
														<TextInput v-model="scheme_form.followup_days.value"
															maxlength="2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
															id="scheme_followup_days" type="number" class="block w-full font-medium" required />
													</div>
													<p v-if="scheme_form.followup_days.error" class="mt-1 text-red-600 text-sm">Please enter valid followup days</p>
												</div>

												<div>
													<InputLabel for="user_allocated_villages" value="Documents Required" />

													<Combobox as="div" v-model="scheme_form.pre_requisites" multiple>
														<div class="relative mt-1">
														<ComboboxInput 
															v-model="scheme_form.pre_requisite_search"
															@keypress="filterPreRequisites"
															@change="filterPreRequisites"
															@focusin="filterPreRequisites"
															class="w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm" />
														<ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
															<ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
														</ComboboxButton>

														<ComboboxOptions v-if="filteredPreRequisites.length > 0" class="absolute z-50 bottom-12 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
															<ComboboxOption v-for="document in filteredPreRequisites" :key="document.id" :value="document.id" as="template" v-slot="{ active, selected }">
																<li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-blue-600 text-white' : 'text-gray-900']">
																	<span :class="['block truncate', selected && 'font-semibold']">
																	{{ document.name }}
																	</span>

																	<span v-if="selected" :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-blue-600']">
																	<CheckIcon class="h-5 w-5" aria-hidden="true" />
																	</span>
																</li>
															</ComboboxOption>
														</ComboboxOptions>
														</div>
													</Combobox>
													<p v-if="scheme_form.pre_requisite_error" class="mt-1 text-red-600 text-sm">Please select atleast 1 document</p>
												</div>
											</div>
										</div>
										<div v-if="scheme_form.pre_requisites.length > 0" class="mt-2 mb-5 gap-y-6">
											<div>
												<h4
													class="text-base font-medium leading-6 text-gray-900">Documents Required</h4>
												<div class="mt-1">
													<p class="text-sm text-gray-500">These documents would be required to apply for this scheme</p>
												</div>
											</div>
											<div class="mt-2">
												<ul role="list" class="divide-y divide-gray-200">
													<li v-for="documentId in scheme_form.pre_requisites" :key="documentId" class="flex items-center justify-between py-2">
														<p class="text-sm text-gray-900">{{ prerequisites[documentId].name }}</p>
														<div @click="removeDocument(documentId)" class="cursor-pointer">
															<XCircleIcon class="h-5 w-5 text-red-600" />
														</div>
													</li>
												</ul>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!scheme_form.processing" @click="validateForm" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
											<span>Save</span>
										</button>
										<button v-else-if="scheme_form.processing"
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
										<button v-if="!scheme_form.processing" @click="scheme_form.show_popup = false" type="button"
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

			<TransitionRoot as="template" :show="rules_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="rules_form.show_popup = false">
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
													class="text-lg font-medium leading-6 text-gray-900">{{ rules_form.popup_title }}</DialogTitle>
												<div class="mt-1">
													<p class="text-sm text-gray-500">This scheme will only be visible when the person passes these rules</p>
												</div>
											</div>
										</div>
										<div class="my-5 flex flex-col gap-y-2">
											<div
												v-for="(rule, ruleIdx) in rules_form.rules" 
												:key="ruleIdx"
												class="grid grid-cols-10 gap-5 items-start">
												<div class="col-start-1 col-end-5">
													<InputLabel v-if="ruleIdx == 0" for="scheme_rule_field" value="Field" />

													<select v-model="rule.field.value" @change="setRuleValues(ruleIdx)" id="scheme_rule_field" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option value="state" selected>State</option>
														<option value="social_status">Social Status</option>
														<option value="caste">Caste</option>
														<option value="age">Age</option>
														<option value="gender">Gender</option>
														<option value="marital_status">Marital Status</option>
														<option value="disability_status">Disability Status</option>
														<option value="type_of_house">Type of House</option>
														<option value="aadhaar_card">Aadhaar Card</option>
														<option value="bank_account">Bank A/c</option>
														<option value="election_card">Election Card</option>
														<option value="widow_status">Widow Status</option>
														<option value="status_of_women">Status of Women</option>
														<option value="land_ownership">Land Ownership</option>
														<option value="card_score">Card Score</option>
													</select>
												</div>

												<div class="col-start-5 col-end-7">
													<InputLabel v-if="ruleIdx == 0" for="scheme_rule_operator" value="Operator" />

													<select v-model="rule.operator.value" id="scheme_rule_operator" class="mt-1 block w-full rounded-md border border-gray-200 font-bold bg-gray-50 px-3 py-2 text-blue-600 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option v-if="rule_values[rule.field.value] != 'number'" value="equal_to">=</option>
														<option v-if="rule_values[rule.field.value] == 'number'" value="greater_than" selected>&gt;</option>
														<option v-if="rule_values[rule.field.value] == 'number'" value="less_than" selected>&le;</option>
													</select>
												</div>

												<div class="col-start-7 col-end-10">
													<InputLabel v-if="ruleIdx == 0" for="scheme_rule_value" value="Value" />

													<div v-if="!Array.isArray(rule_values[rule.field.value])" class="relative rounded-md shadow-sm">
														<TextInput v-model="rule.matching_value.value"
															id="scheme_rule_value" :type="rule_values[rule.field.value]" class="block w-full font-medium" required />
													</div>
													<select v-else v-model="rule.matching_value.value" id="scheme_rule_value" class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
														<option v-for="(option, optionIdx) in rule_values[rule.field.value]" :key="option.value" :value="option.value" :selected="optionIdx == 0">
															{{ option.name }}
														</option>
													</select>
													<p v-if="rule.matching_value.error" class="mt-1 text-red-600 text-sm">Please enter valid value</p>
												</div>

												<div class="col-span-1">
													<div
														@click="removeCondition(rule)"
														:class="[rules_form.rules.length == 1 ? 'cursor-not-allowed' : 'cursor-pointer']">
														<TrashIcon v-bind:class="{'opacity-50': rules_form.rules.length == 1, 'mt-12': ruleIdx == 0, 'mt-4': ruleIdx > 0}" class="h-4 w-4 text-red-600" />
													</div>
												</div>
											</div>
											<div class="mt-4">
												<button @click="addCondition"
													type="button" 
													class="inline-flex items-center rounded border border-transparent bg-blue-100 px-2.5 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
													<PlusIcon class="h-4 w-4 mr-1.5" />
													Add Condition
												</button>
											</div>
										</div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!rules_form.processing" @click="saveRulesForm" type="button"
											class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
											<span>Save</span>
										</button>
										<button v-else-if="rules_form.processing"
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
										<button v-if="!rules_form.processing" @click="rules_form.show_popup = false" type="button"
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
								<DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Delete {{ delete_form.scheme_name }}?</DialogTitle>
								<div class="mt-2">
								<p class="text-sm text-gray-500">Are you sure you want to delete this scheme? This action cannot be undone.</p>
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

	import {
		Combobox,
		ComboboxButton,
		ComboboxInput,
		ComboboxLabel,
		ComboboxOption,
		ComboboxOptions,
		Switch
	} from '@headlessui/vue'

    import TextInput from '@/Components/TextInput.vue';
    import InputLabel from '@/Components/InputLabel.vue';

    import {
        MagnifyingGlassIcon
    } from '@heroicons/vue/24/solid'
    import {
        PlusIcon,
		CheckIcon,
		ChevronUpDownIcon
    } from '@heroicons/vue/20/solid'
	import { ExclamationTriangleIcon, XCircleIcon, TrashIcon } from '@heroicons/vue/24/outline'

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
			Combobox,
			ComboboxButton,
			ComboboxInput,
			ComboboxLabel,
			ComboboxOption,
			ComboboxOptions,
			Switch,
			MagnifyingGlassIcon,
            PlusIcon,
			ExclamationTriangleIcon,
			CheckIcon,
			ChevronUpDownIcon,
			XCircleIcon,
			TrashIcon
        },

        props: ["all_schemes", "prerequisites", "rule_values"],

        data() {
            return {
				filteredPreRequisites: this.prerequisites,
				query: "",
				display_schemes: this.all_schemes,
				site_villages: [],
				search_query: "",
                scheme_form: {
                    show_popup: false,
					popup_title: "Create New Scheme",
					is_active: true,
					pre_requisite_search: "",
					category: {
						value: "",
						error: false
					},
					department: {
						value: "",
						error: false
					},
					name: {
						value: "",
						error: false
					},
					type: {
						value: "",
						error: false
					},
					followup_days: {
						value: "",
						error: false
					},
					pre_requisites: [],
					pre_requisite_error: false,
					save_type: "new",
					scheme_id: null,
					processing: false,
                },
				rules_form: {
					show_popup: false,
					popup_title: "Set Rules",
					rules: [],
					scheme_id: null,
					processing: false
				},
				delete_form: {
					scheme_name: "",
					scheme_id: null,
					show_popup: false,
					processing: false
				}
            }
        },

        methods: {
			search() {
				var searchQuery = this.search_query.toString().toLowerCase();

				if (searchQuery.length > 0) {
					this.display_schemes = [];
					for (var siteIdx in this.all_schemes) {
						var scheme = this.all_schemes[siteIdx];
						if (scheme.name.toString().toLowerCase().includes(searchQuery)) {
							this.display_schemes.push(scheme);
							continue;
						}

						if (scheme.department.toString().toLowerCase().includes(searchQuery)) {
							this.display_schemes.push(scheme);
							continue;
						}

						if (scheme.type.toString().toLowerCase().includes(searchQuery)) {
							this.display_schemes.push(scheme);
							continue;
						}

						if (scheme.category.toString().toLowerCase().includes(searchQuery)) {
							this.display_schemes.push(scheme);
							continue;
						}
					}
				}else {
					this.display_schemes = this.all_schemes;
				}
			},

			filterPreRequisites(e) {
				var searchQuery = e.target.value.toString().toLowerCase();

				this.filteredPreRequisites = [];

				if (searchQuery.length > 0) {
					for (var preRequisiteIdx in this.prerequisites) {
						var preRequisite = this.prerequisites[preRequisiteIdx];

						if (preRequisite.name.toLowerCase().includes(searchQuery)) {
							this.filteredPreRequisites.push(preRequisite);
						}
					}
				}else {
					this.filteredPreRequisites = this.prerequisites;
				}
			},
			
			removeDocument(documentId) {
				this.scheme_form.pre_requisites = this.scheme_form.pre_requisites.filter(x => x !== documentId);
			},

            addScheme() {
				this.scheme_form.category.error = false;
				this.scheme_form.department.error = false;
				this.scheme_form.name.error = false;
				this.scheme_form.type.error = false;
				this.scheme_form.followup_days.error = false;

				this.scheme_form.save_type = "new";
				this.scheme_form.scheme_id = null;
				this.scheme_form.is_active = true;

				this.scheme_form.popup_title = "Create New Scheme";
                this.scheme_form.show_popup = true;
            },

			editScheme(scheme) {
				this.scheme_form.category.error = false;
				this.scheme_form.department.error = false;
				this.scheme_form.name.error = false;
				this.scheme_form.type.error = false;
				this.scheme_form.followup_days.error = false;

				this.scheme_form.save_type = "edit";
				this.scheme_form.scheme_id = scheme.id;

				this.scheme_form.category.value = scheme.category;
				this.scheme_form.department.value = scheme.department;
				this.scheme_form.name.value = scheme.name;
				this.scheme_form.type.value = scheme.type;
				this.scheme_form.followup_days.value = scheme.followup_days;
				this.scheme_form.pre_requisites = scheme.documents_id;

				this.scheme_form.is_active = scheme.is_active == 1;

				this.scheme_form.popup_title = "Edit Scheme";
                this.scheme_form.show_popup = true;
			},

			editRules(scheme) {
				var existingRules = scheme.rules;
				this.rules_form.scheme_id = scheme.id;

				this.rules_form.popup_title = scheme.name;
				this.rules_form.show_popup = true;

				if (existingRules.length == 0) {
					this.rules_form.rules = [];
					// var matchingValueSelected = this.rule_values["state"][0].value;
					// this.rules_form.rules = [
					// 	{
					// 		field: {
					// 			value: "state",
					// 			error: false
					// 		},
					// 		operator: {
					// 			value: "equal_to",
					// 			error: false
					// 		},
					// 		matching_value: {
					// 			value: matchingValueSelected,
					// 			error: false
					// 		}
					// 	}
					// ];
				}else {
					this.rules_form.rules = [];
					for (var ruleIdx in existingRules) {
						var rule = existingRules[ruleIdx];

						this.rules_form.rules.push({
							field: {
								value: rule.rule_name,
								error: false
							},
							operator: {
								value: rule.match_type,
								error: false
							},
							matching_value: {
								value: rule.rule_value,
								error: false
							}
						});

						this.setRuleValues(ruleIdx, {operator: rule.match_type, matching_value: rule.rule_value});
					}
				}
			},

			setRuleValues(index, values = null) {
				var field = this.rules_form.rules[index].field.value;
				var ruleValues = this.rule_values[field];

				this.rules_form.rules[index].matching_value.value = "";
				if (ruleValues == "number") {
					if (values == null) {
						this.rules_form.rules[index].operator.value = "greater_than";
					}else {
						this.rules_form.rules[index].operator.value = values.operator;
						this.rules_form.rules[index].matching_value.value = values.matching_value;
					}
				}else {
					this.rules_form.rules[index].operator.value = "equal_to";
					if (values == null) {
						this.rules_form.rules[index].matching_value.value = ruleValues[0].value;
					}else {
						this.rules_form.rules[index].matching_value.value = values.matching_value;
					}
				}
			},

			addCondition() {
				var existingConditions = this.rules_form.rules;
				for (var conditionIdx in existingConditions) {
					var condition = existingConditions[conditionIdx];
					var conditionValue = condition.matching_value.value.toString();
					if (conditionValue.length == 0) {
						condition.matching_value.error = true;
						return;
					}
					condition.matching_value.error = false;
				}

				var matchingValueSelected = this.rule_values["state"][0].value;
				this.rules_form.rules.push({
					field: {
						value: "state",
						error: false
					},
					operator: {
						value: "equal_to",
						error: false
					},
					matching_value: {
						value: matchingValueSelected,
						error: false
					}
				});
				// console.log(this.rules_form.rules);
			},

			removeCondition(condition) {
				if (this.rules_form.rules.length == 1) {
					// Don't remove if this is the only condition
					return;
				}
				this.rules_form.rules = this.rules_form.rules.filter(x => x !== condition);
			},

			deleteScheme(name, schemeId) {
				this.delete_form.scheme_name = name;
				this.delete_form.scheme_id = schemeId;

				this.delete_form.show_popup = true;
			},

			validateForm() {
				this.scheme_form.category.error = false;
				this.scheme_form.department.error = false;
				this.scheme_form.name.error = false;
				this.scheme_form.type.error = false;
				this.scheme_form.followup_days.error = false;

				var categoryString = this.scheme_form.category.value.toString();
				if (categoryString.length == 0) {
					this.scheme_form.category.error = true;
					return;
				}

				var departmentString = this.scheme_form.department.value.toString();
				if (departmentString.length == 0) {
					this.scheme_form.department.error = true;
					return;
				}

				var nameString = this.scheme_form.name.value.toString();
				if (nameString.length == 0) {
					this.scheme_form.name.error = true;
					return;
				}

				var typeString = this.scheme_form.type.value.toString();
				if (typeString.length == 0) {
					this.scheme_form.type.error = true;
					return;
				}

				var followupDaysString = this.scheme_form.followup_days.value.toString();
				if (followupDaysString.length == 0) {
					this.scheme_form.followup_days.error = true;
					return;
				}

				var selectedPreRequisites = this.scheme_form.pre_requisites;
				if (selectedPreRequisites.length == 0) {
					this.scheme_form.pre_requisite_error = true;
					return;
				}

				this.saveScheme(categoryString, departmentString, nameString, typeString, followupDaysString, selectedPreRequisites);
			},

			saveScheme(category, department, name, type, followupDays, preRequisites) {

				this.scheme_form.processing = true;

				var formData = new FormData();
				formData.append("category", category);
				formData.append("department", department);
				formData.append("name", name);
				formData.append("type", type);
				formData.append("followup_days", followupDays);
				formData.append("pre_requisites", JSON.stringify(preRequisites));
				formData.append("is_active", this.scheme_form.is_active ? 1 : 0);
				formData.append("save_type", this.scheme_form.save_type);
				formData.append("scheme_id", this.scheme_form.scheme_id);

				var vue = this;
				axios.post('/schemes/save', formData).then(function(response) {
					vue.scheme_form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						vue.$inertia.visit('/schemes', {
							only: ["all_schemes"]
						});
					}
				});
			},

			saveRulesForm() {
				this.rules_form.processing = true;

				var formData = new FormData();
				formData.append("rules", JSON.stringify(this.rules_form.rules));
				formData.append("scheme_id", this.rules_form.scheme_id);

				var vue = this;
				axios.post('/schemes/rules', formData).then(function (response) {
					vue.rules_form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						vue.$inertia.visit('/schemes', {
							only: ["all_schemes"]
						});
					}
				});
			},

			deleteProcess() {
				this.delete_form.processing = true;

				var formData = new FormData();
				formData.append("scheme_id", this.delete_form.scheme_id);

				var vue = this;
				axios.post('/schemes/delete', formData).then(function(response) {
					vue.delete_form.processing = false;

					var data = response.data;
					if (data.status == 1) {
						vue.$inertia.visit('/schemes', {
							only: ["all_schemes"]
						});
					}
				});
			},

			isEmailValid(email) {
                return /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+([^<>()\.,;:\s@\"]{2,}|[\d\.]+))$/.test(email);
            }
        }
    }

</script>
