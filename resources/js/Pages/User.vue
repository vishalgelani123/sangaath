<template>
    <AppLayout>
        <div class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-gray-200 px-4 py-3 flex items-center justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">All Users</h1>
                </div>
                <div class="flex mt-0 ml-4">
                    <button @click="addUser" type="button"
                            class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                        <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true"/>
                        <span>New User</span>
                    </button>
                </div>
            </div>
            <!-- Search field -->
            <div v-if="all_users.length > 0" class="mt-6 px-4 sm:px-6 lg:px-8">
                <div class="max-w-sm">
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                        </div>
                        <TextInput v-model="search_query" v-on:keyup="search()" v-on:change="search()"
                                   autocomplete="off" id="search_input" type="text" placeholder="Search Users"
                                   class="block w-full pl-10 font-medium" required/>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div v-if="all_users.length == 0" class="mt-20 inline-block min-w-full align-middle">
                    <div class="flex items-center flex-col">
                        <img src="/images/user.png" class="w-72" alt=""/>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No users available</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new user.</p>
                        <div class="mt-6">
                            <button @click="addUser" type="button"
                                    class="group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                <PlusIcon class="-ml-0.5 mr-2 h-4 w-4" aria-hidden="true"/>
                                <span>New User</span>
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
                                scope="col">Site
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                scope="col">Role
                            </th>
                            <th class="hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell"
                                scope="col">Status
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                scope="col"/>
                            <th class="border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900"
                                scope="col"/>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                        <tr v-for="user in display_users" :key="user.id">
                            <td
                                class="w-1/3 max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                <div class="lg:pl-2">
                                    <div class="font-medium text-gray-900">{{ user.name }}</div>
                                    <div class="text-gray-500">{{ user.email }}</div>
                                </div>
                            </td>
                            <!--                            <td class="px-6 py-3 text-sm font-medium text-gray-500">-->
                            <!--                                <div v-if="user.site != null">-->
                            <!--                                    <div>{{ user.site.name }}</div>-->
                            <!--                                    <div class="mt-1 text-xs text-blue-400">-->
                            <!--                                        ({{ user.selected_villages.length }} Villages)-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </td>-->
                            <td class="px-6 py-3 text-sm font-medium text-gray-500">

                                <div v-if="user.role === 'sub_admin' || user.role === 'report_admin'">
                                    <!--                                    <option v-for="site in sites" :key="site.id" :value="site.id">-->
                                    <!--                                        {{ site.name }} -->
                                    <!--                                    </option>-->
                                    <!--                                    <div v-for="(site, index) in user.sites" :key="index">-->
                                    <!--                                        {{ site.name }}-->
                                    <!--                                        <div class="mt-1 text-xs text-blue-400">-->
                                    <!--                                            ({{ site.villages.length }} Villages)-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div v-if="user.site_id">
                                        <div v-for="siteId in user.site_id">
                                            <!-- Parse siteId as integer before comparing -->
                                            <div v-for="site in sites.filter(s => s.id === parseInt(siteId))"
                                                 :key="site.id">
                                                {{ site.name }}
                                            </div>
                                        </div>
                                        <div class="mt-1 text-xs text-blue-400">
                                            ({{ user.selected_villages.length }} Villages)
                                        </div>
                                    </div>
                                </div>

                                <div v-else>
                                    <div v-if="user.site != null">
                                        {{ user.site.name }}
                                        <div class="mt-1 text-xs text-blue-400">
                                            ({{ user.selected_villages.length }} Villages)
                                        </div>
                                    </div>
                                </div>
                            </td>


                            <td class="px-6 py-3 text-sm font-medium text-gray-500">
                                {{ user.display_role }}
                            </td>
                            <td
                                class="hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell">
                                <span v-if="user.status == 'active'"
                                      class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Active</span>
                                <span v-else
                                      class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Inactive</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                <a @click="editUser(user)" href="javascript:void(0)"
                                   class="text-blue-600 hover:text-blue-900">Edit</a>
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-right text-sm font-medium">
                                <a @click="deleteUser(user.name, user.id)" href="javascript:void(0)"
                                   class="text-red-600 hover:text-red-900">Delete</a>
                            </td>
                        </tr>
                        <tr v-if="display_users.length == 0">
                            <td colspan="5" class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">
                                <span class="lg:pl-2 text-gray-600 font-medium">No results found!</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <TransitionRoot as="template" :show="user_form.show_popup">
                <Dialog as="div" class="relative z-10" @close="user_form.show_popup = false">
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
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <DialogTitle as="h3"
                                                             class="text-lg font-medium leading-6 text-gray-900">
                                                    {{user_form.popup_title }}
                                                </DialogTitle>
                                                <div class="mt-1">
                                                    <p class="text-sm text-gray-500">Enter user details and allocate the
                                                        location</p>
                                                </div>
                                            </div>
                                            <div>
                                                <Switch v-model="user_form.is_active"
                                                        :class="[user_form.is_active ? 'bg-blue-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2']">
                                                    <span class="sr-only">Use setting</span>
                                                    <span
                                                        :class="[user_form.is_active ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
													<span
                                                        :class="[user_form.is_active ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']"
                                                        aria-hidden="true">
														<svg class="h-3 w-3 text-gray-400" fill="none"
                                                             viewBox="0 0 12 12">
														<path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor"
                                                              stroke-width="2" stroke-linecap="round"
                                                              stroke-linejoin="round"/>
														</svg>
													</span>
													<span
                                                        :class="[user_form.is_active ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']"
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
                                        </div>
                                        <div class="my-5 flex flex-col gap-y-6">
                                            <div class="grid grid-cols-2 gap-5">
                                                <div class="">
                                                    <InputLabel for="user_name" value="Name"/>

                                                    <div class="relative rounded-md shadow-sm">
                                                        <TextInput v-model="user_form.name.value"
                                                                   id="user_name" type="text"
                                                                   class="block w-full font-medium" required/>
                                                    </div>
                                                    <p v-if="user_form.name.error" class="mt-1 text-red-600 text-sm">
                                                        Please enter valid name</p>
                                                </div>

                                                <div class="">
                                                    <InputLabel for="user_role" value="Role"/>

                                                    <select v-model="user_form.role.value" id="user_role"
                                                            @change="loadRole"
                                                            class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
                                                        <option value="" selected disabled>Select Role</option>
                                                        <option value="project_coordinator">Project Co-ordinator
                                                        </option>
                                                        <option value="supervisor">Supervisor</option>
                                                        <option value="facilitator">Facilitator</option>
                                                        <option value="sub_admin">Sub Admin</option>
                                                        <option value="report_admin">Report Admin</option>
                                                    </select>
                                                    <p v-if="user_form.role.error" class="mt-1 text-red-600 text-sm">
                                                        Please select role for user</p>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-5">
                                                <div class="">
                                                    <InputLabel for="user_email" value="Email"/>

                                                    <div class="relative rounded-md shadow-sm">
                                                        <TextInput v-model="user_form.email.value"
                                                                   id="user_email" type="text"
                                                                   class="block w-full font-medium" required/>
                                                    </div>
                                                    <p v-if="user_form.email.error" class="mt-1 text-red-600 text-sm">
                                                        {{user_form.email.error_msg }}</p>
                                                </div>

                                                <div class="">
                                                    <div class="flex items-center justify-between">
                                                        <InputLabel for="user_password" value="Password"/>
                                                        <p class="mb-3 text-xs text-gray-500">Min. 8 chars</p>
                                                    </div>

                                                    <div class="relative rounded-md shadow-sm">
                                                        <TextInput v-model="user_form.password.value"
                                                                   placeholder="Leave blank for same password"
                                                                   id="user_password" type="password"
                                                                   class="block w-full font-medium" required/>
                                                    </div>
                                                    <p v-if="user_form.password.error"
                                                       class="mt-1 text-red-600 text-sm">Atleast 8 characters long</p>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-5">
                                                <!--                                                <div class="">-->
                                                <!--                                                    <InputLabel for="user_site" value="Site"/>-->

                                                <!--                                                    <select v-model="user_form.site.value" @change="getVillages"-->
                                                <!--                                                            id="site_state" :multiple="user_form.role.value === 'sub_admin'"-->
                                                <!--                                                            class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">-->
                                                <!--                                                        <option value="" selected disabled>Select Site</option>-->
                                                <!--                                                        <option v-for="site in sites" :key="site.id" :value="site.id">-->
                                                <!--                                                            {{ site.name }} ({{ site.display_state }})-->
                                                <!--                                                        </option>-->
                                                <!--                                                    </select>-->
                                                <!--                                                    <p v-if="user_form.site.error" class="mt-1 text-red-600 text-sm">-->
                                                <!--                                                        Please enter valid state</p>-->
                                                <!--                                                </div>-->
                                                <div class="">
                                                    <InputLabel for="user_site" value="Site"/>
                                                    <select v-model="user_form.site.value" @change="getVillages"
                                                            id="site_state" ref="selectElement"
                                                            :multiple="user_form.role.value === 'sub_admin' || user_form.role.value === 'report_admin'"

                                                            class="mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm">
                                                        <option value="" selected disabled>Select Site</option>
                                                        <option v-for="site in sites" :key="site.id" :value="site.id">
                                                            {{ site.name }} ({{ site.display_state }})
                                                        </option>
                                                    </select>
                                                    <p v-if="user_form.site.error" class="mt-1 text-red-600 text-sm">
                                                        Please select valid site(s)</p>
                                                </div>

                                                <div v-if="user_form.site.value != ''" id="display_hide">
                                                    <InputLabel for="user_allocated_villages"
                                                                value="Allocated Villages"/>

                                                    <fieldset v-if="site_villages.length > 0" class="space-y-1">
                                                        <div v-for="village in site_villages" :key="village.id"

                                                             class="relative flex items-start">
                                                            <div class="flex h-5 items-center">
                                                                <input :id="'village_'+village.id" type="checkbox"
                                                                       class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"/>
                                                            </div>
                                                            <div class="ml-3 text-sm">
                                                                <label :for="'village_'+village.id"
                                                                       class="font-medium text-gray-700 text-sm">{{village.name}}</label>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <p v-else class="font-medium text-gray-500 text-sm">No village for
                                                        this site</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button v-if="!user_form.processing" @click="validateForm" type="button"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                            <span>Save</span>
                                        </button>
                                        <button v-else-if="user_form.processing"
                                                class="group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed">
                                            <span>Saving</span>
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
                                        <button v-if="!user_form.processing" @click="user_form.show_popup = false"
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
                                                             class="text-lg font-medium leading-6 text-gray-900">Delete
                                                    {{ delete_form.village_name }}?
                                                </DialogTitle>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500">Are you sure you want to delete
                                                        this user? This action cannot be undone.</p>
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


    import {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot
    } from '@headlessui/vue'

    import {
        Combobox,
        ComboboxInput,
        ComboboxOptions,
        ComboboxOption,
        Switch,
    } from '@headlessui/vue'

    import TextInput from '@/Components/TextInput.vue';
    import InputLabel from '@/Components/InputLabel.vue';

    import {
        MagnifyingGlassIcon
    } from '@heroicons/vue/24/solid'
    import {
        PlusIcon
    } from '@heroicons/vue/20/solid'
    import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'

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
            ComboboxInput,
            ComboboxOptions,
            ComboboxOption,
            Switch,
            MagnifyingGlassIcon,
            PlusIcon,
            ExclamationTriangleIcon,
        },

        props: ["all_users", "sites", "villages"],

        data() {
            return {

                display_users: this.all_users,
                site_villages: [],
                search_query: "",
                user_form: {
                    show_popup: false,
                    popup_title: "Create New User",
                    is_active: true,
                    name: {
                        value: "",
                        error: false
                    },
                    role: {
                        value: "",
                        error: false
                    },
                    email: {
                        value: "",
                        error: false,
                        error_msg: "Please enter valid email"
                    },
                    password: {
                        value: "",
                        error: false
                    },
                    site: {
                        value: [],
                        error: false
                    },
                    villages: [],
                    save_type: "new",
                    user_id: null,
                    processing: false
                },

                delete_form: {
                    village_name: "",
                    user_id: null,
                    show_popup: false,
                    processing: false
                }
            }
        },

        methods: {
            initializeSelect2() {

                this.$nextTick(() => {
                    $(this.$refs.selectElement).select2()
                        .on('change', () => {
                            this.user_form.site.value = $(this.$refs.selectElement).val();
                            this.getVillages();
                        });
                });
            },

            search() {
                var searchQuery = this.search_query.toString().toLowerCase();

                if (searchQuery.length > 0) {
                    this.display_users = [];
                    for (var siteIdx in this.all_users) {
                        var user = this.all_users[siteIdx];
                        if (user.name.toString().toLowerCase().includes(searchQuery)) {
                            this.display_users.push(user);
                            continue;
                        }

                        if (user.email.toString().toLowerCase().includes(searchQuery)) {
                            this.display_users.push(user);
                            continue;
                        }

                        if (user.display_role.toString().toLowerCase().includes(searchQuery)) {
                            this.display_users.push(user);
                            continue;
                        }
                    }
                } else {
                    this.display_users = this.all_users;
                }
            },

            addUser() {
                this.user_form.name.error = false;
                this.user_form.site.error = false;

                this.user_form.save_type = "new";
                this.user_form.user_id = null;
                this.user_form.is_active = true;

                this.user_form.popup_title = "Create New User";
                this.user_form.show_popup = true;
            },

            editUser(user) {
                this.user_form.name.error = false;
                this.user_form.role.error = false;
                this.user_form.email.error = false;
                this.user_form.password.error = false;

                this.user_form.save_type = "edit";
                this.user_form.user_id = user.id;

                this.user_form.name.value = user.name;
                this.user_form.role.value = user.role;
                this.user_form.email.value = user.email;
                // this.user_form.site.value = user.site_id;
                if (user.role === 'sub_admin' || user.role === 'report_admin') {
                    // Split the site_id string by comma to get an array
                    this.user_form.site.value = user.site_id.split(',').map(Number);


                } else {
                    this.user_form.site.value = user.site_id;
                }

                this.user_form.is_active = user.status == 'active';

                this.getVillages();

                this.user_form.popup_title = "Edit User";
                this.user_form.show_popup = true;

                // var vue = this;
                setTimeout(function () {
                    for (var villageIdx in user.selected_villages) {
                        var villageId = user.selected_villages[villageIdx];
                        if (document.getElementById("village_" + villageId)) {
                            document.getElementById("village_" + villageId).checked = true;
                            if (user.role === 'sub_admin' || user.role === 'report_admin') {
                                $('#display_hide').hide();
                            }
                        }
                    }
                }, 200);
            },

            deleteUser(name, villageId) {
                this.delete_form.village_name = name;
                this.delete_form.user_id = villageId;

                this.delete_form.show_popup = true;
            },


            getVillages() {
                this.site_villages = [];
                let selectedSites = [];
                if (this.user_form.role.value === 'sub_admin' || this.user_form.role.value === 'report_admin') {
                    // alert( this.user_form.site.value);
                    // alert('sub admin');
                    this.initializeSelect2();
                    selectedSites = Array.isArray(this.user_form.site.value) ? this.user_form.site.value : this.user_form.site.value.split(',');
                } else {
                    // alert('user');
                    selectedSites = Array.isArray(this.user_form.site.value) ? this.user_form.site.value : [this.user_form.site.value];

                }
                for (const selectedSite of selectedSites) {
                    if (selectedSite in this.villages) {
                        this.site_villages.push(...this.villages[selectedSite]);
                    }
                }

                if (this.user_form.role.value === 'sub_admin' || this.user_form.role.value === 'report_admin') {
                    for (const village of this.site_villages) {
                        this.$nextTick(() => {
                            const checkbox = document.getElementById('village_' + village.id);
                            const label = document.querySelector(`[for='village_${village.id}']`);
                            if (checkbox && label) {
                                checkbox.checked = true;
                                checkbox.disabled = true;
                                $('#display_hide').hide();
                                checkbox.style.visibility = 'hidden';
                                label.style.visibility = 'hidden';
                            }
                        });
                    }
                }
            },

            loadRole() {
                if (this.user_form.role.value === 'sub_admin' || this.user_form.role.value === 'report_admin') {
                    this.user_form.site.value = [];
                    $('#display_hide').hide();
                } else {
                    this.user_form.site.value = '';
                }
                this.getVillages();
            },
            validateForm() {
                this.user_form.name.error = false;
                this.user_form.role.error = false;
                this.user_form.email.error = false;
                this.user_form.password.error = false;

                var nameString = this.user_form.name.value.toString();
                if (nameString.length == 0) {
                    this.user_form.name.error = true;
                    return;
                }

                var roleString = this.user_form.role.value.toString();
                if (roleString.length == 0) {
                    this.user_form.role.error = true;
                    return;
                }

                var emailString = this.user_form.email.value.toString();
                if (!this.isEmailValid(emailString)) {
                    this.user_form.email.error_msg = "Please enter valid email";
                    this.user_form.email.error = true;
                    return;
                }

                var passwordString = this.user_form.password.value.toString();
                if ((this.user_form.save_type == "edit" && passwordString.length > 0 && passwordString.length < 8) || (this.user_form.save_type == "new" && passwordString.length < 8)) {
                    this.user_form.password.error = true;
                    return;
                }

                this.saveUser(nameString, roleString, emailString, passwordString);
            },

            saveUser(name, role, email, password) {
                var siteString = this.user_form.site.value.toString();
                var allocatedVillages = [];

                for (var villageIdx in this.site_villages) {
                    var village = this.site_villages[villageIdx];
                    if (document.getElementById("village_" + village.id).checked) {
                        allocatedVillages.push(village.id);
                    }
                }

                this.user_form.processing = true;

                var formData = new FormData();
                formData.append("name", name);
                formData.append("role", role);
                formData.append("email", email);
                formData.append("password", password);
                formData.append("site", siteString);
                formData.append("allocated_villages", JSON.stringify(allocatedVillages));
                formData.append("status", this.user_form.is_active ? "active" : "inactive");
                formData.append("save_type", this.user_form.save_type);
                formData.append("user_id", this.user_form.user_id);

                var vue = this;
                axios.post('/users/save', formData).then(function (response) {
                    vue.user_form.processing = false;

                    var data = response.data;
                    if (data.status == 1) {
                        vue.$inertia.visit('/users', {
                            only: ["all_users"],

                        });
                    } else {
                        var errorMessage = data.error_msg;
                        vue.user_form.email.error_msg = errorMessage;
                        vue.user_form.email.error = true;
                    }
                });
            },

            deleteProcess() {
                this.delete_form.processing = true;

                var formData = new FormData();
                formData.append("user_id", this.delete_form.user_id);

                var vue = this;
                axios.post('/users/delete', formData).then(function (response) {
                    vue.delete_form.processing = false;

                    var data = response.data;
                    if (data.status == 1) {
                        vue.$inertia.visit('/users', {
                            only: ["all_users"]
                        });
                    }
                });
            },

            isEmailValid(email) {
                return /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+([^<>()\.,;:\s@\"]{2,}|[\d\.]+))$/.test(email);
            }
        },


        // working good but select only one
        // watch: {
        //     'user_form.show_popup': function(newValue) {
        //         if (newValue) { // When popup opens
        //             this.$nextTick(() => {
        //                 $(this.$refs.selectElement).select2()
        //                     .on('change', () => {
        //                         this.user_form.site.value = $(this.$refs.selectElement).val();
        //                         this.getVillages();
        //                     });
        //             });
        //         }
        //     }
        // },

        watch: {
            'user_form.show_popup': function (newValue) {
                if (newValue) { // When popup opens
                    this.initializeSelect2();
                }
            },
            'user_form.role.value': function (newValue) {
                if (this.user_form.show_popup) { // Only do this if the popup is open
                    $(this.$refs.selectElement).select2('destroy'); // Destroy current select2
                    this.initializeSelect2(); // Reinitialize select2
                }
            }
        },
    }

</script>
