<template>
    <div class="min-h-full">
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="relative z-40 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                                 enter-from="opacity-0" enter-to="opacity-100"
                                 leave="transition-opacity ease-linear duration-300"
                                 leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-600 bg-opacity-75"/>
                </TransitionChild>

                <div class="fixed inset-0 z-40 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                                     enter-from="-translate-x-full" enter-to="translate-x-0"
                                     leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                                     leave-to="-translate-x-full">
                        <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-white pt-5 pb-4">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                                             enter-to="opacity-100" leave="ease-in-out duration-300"
                                             leave-from="opacity-100"
                                             leave-to="opacity-0">
                                <div class="absolute top-0 right-0 -mr-12 pt-2">
                                    <button type="button"
                                            class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                            @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true"/>
                                    </button>
                                </div>
                            </TransitionChild>
                            <div class="flex flex-shrink-0 items-center px-4">
                                <img class="h-12 w-auto"
                                     src="/images/sangaath_logo.png"
                                     alt="Sangaath"/>
                            </div>
                            <div class="mt-5 h-0 flex-1 overflow-y-auto">
                                <nav class="px-2">
                                    <div class="space-y-1">
                                        <Link href="/dashboard"
                                              :class="[current_page == 'home' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                              :aria-current="current_page == 'home' ? 'page' : undefined">
                                            <HomeIcon
                                                :class="[current_page == 'home' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                aria-hidden="true"/>
                                            Home
                                        </Link>
                                        <Link v-if="profile.role == 'admin'"
                                              href="/charts/village-wise-applications"
                                              :class="[current_page == 'charts' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                              :aria-current="current_page == 'charts' ? 'page' : undefined">
                                            <ChartPieIcon
                                                :class="[current_page == 'charts' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                aria-hidden="true"/>
                                            Visual Charts
                                        </Link>
                                        <Link v-if="profile.role == 'supervisor' || profile.role == 'facilitator'"
                                              href="/household-register"
                                              :class="[current_page == 'household_register' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                              :aria-current="current_page == 'household_register' ? 'page' : undefined">
                                            <PencilSquareIcon
                                                :class="[current_page == 'household_register' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                aria-hidden="true"/>
                                            Household Register
                                        </Link>
                                        <Link v-if="profile.role == 'supervisor' || profile.role == 'facilitator' || profile.role == 'admin'"
                                              href="/documentation/incomplete"
                                              :class="[current_page == 'documentation' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                              :aria-current="current_page == 'documentation' ? 'page' : undefined">
                                            <ClipboardDocumentIcon
                                                :class="[current_page == 'documentation' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                aria-hidden="true"/>
                                            Documentation
                                        </Link>
                                        <Link
                                            v-if="profile.role == 'supervisor' || profile.role == 'project_coordinator'"
                                            href="/update-status"
                                            :class="[current_page == 'update_status' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                            :aria-current="current_page == 'update_status' ? 'page' : undefined">
                                            <ArrowUturnRightIcon
                                                :class="[current_page == 'update_status' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                aria-hidden="true"/>
                                            Update Status
                                        </Link>
                                        <Link
                                            v-if="profile.role == 'supervisor' || profile.role == 'project_coordinator'"
                                            href="/govt-submission"
                                            :class="[current_page == 'govt_submission' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                            :aria-current="current_page == 'govt_submission' ? 'page' : undefined">
                                            <BuildingLibraryIcon
                                                :class="[current_page == 'govt_submission' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                aria-hidden="true"/>
                                            Submit to Govt.
                                        </Link>
                                        <Link
                                            href="/followup/today"
                                            :class="[current_page == 'followup' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                            :aria-current="current_page == 'followup' ? 'page' : undefined">
                                            <CalendarDaysIcon
                                                :class="[current_page == 'followup' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                aria-hidden="true"/>
                                            Follow Ups
                                        </Link>
                                    </div>
                                    <div class="mt-8" v-if="profile.role == 'admin'">
                                        <h3 class="px-3 text-sm font-medium text-gray-500" id="mobile-teams-headline">
                                            Settings</h3>
                                        <div class="mt-1 space-y-1" role="group"
                                             aria-labelledby="mobile-teams-headline">
                                            <Link
                                                href="/sites"
                                                :class="[current_page == 'sites' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                                :aria-current="current_page == 'sites' ? 'page' : undefined">
                                                <span :class="['bg-blue-500', 'w-2.5 h-2.5 mr-4 rounded-full']"
                                                      aria-hidden="true"/>
                                                Sites
                                            </Link>
                                            <Link
                                                href="/villages"
                                                :class="[current_page == 'villages' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                                :aria-current="current_page == 'villages' ? 'page' : undefined">
                                                <span :class="['bg-red-500', 'w-2.5 h-2.5 mr-4 rounded-full']"
                                                      aria-hidden="true"/>
                                                Villages
                                            </Link>
                                            <Link
                                                href="/users"
                                                :class="[current_page == 'users' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                                :aria-current="current_page == 'users' ? 'page' : undefined">
                                                <span :class="['bg-green-500', 'w-2.5 h-2.5 mr-4 rounded-full']"
                                                      aria-hidden="true"/>
                                                Users
                                            </Link>
                                        </div>
                                    </div>
                                    <div class="mt-8" v-if="profile.role == 'admin'">
                                        <h3 class="px-3 text-sm font-medium text-gray-500" id="mobile-teams-headline">
                                            Schemes</h3>
                                        <div class="mt-1 space-y-1" role="group"
                                             aria-labelledby="mobile-teams-headline">
                                            <Link
                                                href="/schemes"
                                                :class="[current_page == 'schemes' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                                :aria-current="current_page == 'schemes' ? 'page' : undefined">
                                                <span :class="['bg-yellow-500', 'w-2.5 h-2.5 mr-4 rounded-full']"
                                                      aria-hidden="true"/>
                                                Schemes
                                            </Link>
                                            <Link
                                                href="/pre-requisites"
                                                :class="[current_page == 'pre-requisites' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                                                :aria-current="current_page == 'pre-requisites' ? 'page' : undefined">
                                                <span :class="['bg-pink-500', 'w-2.5 h-2.5 mr-4 rounded-full']"
                                                      aria-hidden="true"/>
                                                Pre-Requisites
                                            </Link>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                    <div class="w-14 flex-shrink-0" aria-hidden="true">
                        <!-- Dummy element to force sidebar to shrink to fit close icon -->
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div
            class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-r lg:border-gray-200 lg:bg-gray-100 lg:pt-5 lg:pb-4">
            <div class="flex flex-shrink-0 items-center px-6">
                <img class="h-12 w-auto" src="/images/sangaath_logo.png"
                     alt="Sangaath"/>
            </div>
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="mt-6 flex h-0 flex-1 flex-col overflow-y-auto">
                <!-- User account dropdown -->
                <Menu as="div" class="relative inline-block px-3 text-left">
                    <div>
                        <MenuButton
                            class="group w-full rounded-md bg-gray-100 px-3.5 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                            <span class="flex w-full items-center justify-between">
                                <span class="flex min-w-0 items-center justify-between space-x-3">
                                    <img class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-300"
                                         src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80"
                                         alt=""/>
                                    <span class="flex min-w-0 flex-1 flex-col">
                                        <span
                                            class="truncate text-sm font-medium text-gray-900">{{ profile.name }}</span>
                                        <span class="truncate text-sm text-gray-500">{{ profile.display_role }}</span>
                                    </span>
                                </span>
                                <ChevronUpDownIcon class="h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                                   aria-hidden="true"/>
                            </span>
                        </MenuButton>
                    </div>
                    <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                        <MenuItems
                            class="absolute right-0 left-0 z-10 mx-3 mt-1 origin-top divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div v-if="profile.role == 'admin'" class="py-1">
                                <!-- <MenuItem v-slot="{ active }">
                                <Link href="/profile"
                                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">View
                                    profile</Link>
                                </MenuItem> -->
                                <MenuItem v-if="profile.role == 'admin'" v-slot="{ active }">
                                    <Link href="/sites"
                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        Sites
                                    </Link>
                                </MenuItem>
                                <MenuItem v-if="profile.role == 'admin'" v-slot="{ active }">
                                    <Link href="/villages"
                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        Villages
                                    </Link>
                                </MenuItem>
                                <MenuItem v-if="profile.role == 'admin'" v-slot="{ active }">
                                    <Link href="/users"
                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        Users
                                    </Link>
                                </MenuItem>
                            </div>
                            <div v-if="profile.role == 'admin'" class="py-1">
                                <MenuItem v-slot="{ active }">
                                    <Link href="/schemes"
                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        Schemes
                                    </Link>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <Link href="/pre-requisites"
                                          :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        Pre-Requisites
                                    </Link>
                                </MenuItem>
                            </div>
                            <div class="py-1">
                                <MenuItem v-slot="{ active }">
                                    <a href="/logout"
                                       :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Logout</a>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
                <!-- Navigation -->
                <nav class="mt-10 px-3">
                    <div class="space-y-1">
                        <Link href="/dashboard"
                              :class="[current_page == 'home' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                              :aria-current="current_page == 'home' ? 'page' : undefined">
                            <HomeIcon
                                :class="[current_page == 'home' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                aria-hidden="true"/>
                            Home
                        </Link>
                        <Link v-if="profile.role == 'admin' || profile.role == 'sub_admin'"
                              href="/charts/village-wise-applications"
                              :class="[current_page == 'charts' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                              :aria-current="current_page == 'charts' ? 'page' : undefined">
                            <ChartPieIcon
                                :class="[current_page == 'charts' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                aria-hidden="true"/>
                            Visual Charts
                        </Link>
                        <Link v-if="profile.role == 'supervisor' || profile.role == 'facilitator'"
                              href="/household-register"
                              :class="[current_page == 'household_register' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                              :aria-current="current_page == 'household_register' ? 'page' : undefined">
                            <PencilSquareIcon
                                :class="[current_page == 'household_register' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                aria-hidden="true"/>
                            Household Register
                        </Link>
                        <Link v-if="profile.role == 'supervisor' || profile.role == 'facilitator' || profile.role == 'admin'"
                              href="/documentation/incomplete"
                              :class="[current_page == 'documentation' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                              :aria-current="current_page == 'documentation' ? 'page' : undefined">
                            <ClipboardDocumentIcon
                                :class="[current_page == 'documentation' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                aria-hidden="true"/>
                            Documentation
                        </Link>
                        <Link v-if="profile.role == 'supervisor' || profile.role == 'project_coordinator'"
                              href="/update-status"
                              :class="[current_page == 'update_status' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                              :aria-current="current_page == 'update_status' ? 'page' : undefined">
                            <ArrowUturnRightIcon
                                :class="[current_page == 'update_status' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                aria-hidden="true"/>
                            Update Status
                        </Link>
                        <Link v-if="profile.role == 'supervisor' || profile.role == 'project_coordinator'"
                              href="/govt-submission"
                              :class="[current_page == 'govt_submission' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                              :aria-current="current_page == 'govt_submission' ? 'page' : undefined">
                            <BuildingLibraryIcon
                                :class="[current_page == 'govt_submission' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                aria-hidden="true"/>
                            Submit to Govt.
                        </Link>
                        <Link v-if="profile.role != 'report_admin'"
                              href="/followup/today"
                              :class="[current_page == 'followup' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                              :aria-current="current_page == 'followup' ? 'page' : undefined">
                            <CalendarDaysIcon
                                :class="[current_page == 'followup' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']"
                                aria-hidden="true"/>
                            Follow Ups
                        </Link>
                        <Link v-if="profile.role == 'admin'"
                              href="/bulk-upload"
                              :class="[current_page == 'bulk_upload' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                              :aria-current="current_page == 'bulk_upload' ? 'page' : undefined">
                            <ArrowUpTrayIcon
                                :class="[current_page == 'bulk_upload' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-5 w-5']"
                                aria-hidden="true"/>
                            Bulk Upload
                        </Link>
                        <Link
                            v-if="profile.role == 'admin' || profile.role == 'sub_admin' || profile.role == 'report_admin'"
                            href="/data-export"
                            :class="[current_page == 'data_export' ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                            :aria-current="current_page == 'data_export' ? 'page' : undefined">
                            <ArrowDownTrayIcon
                                :class="[current_page == 'data_export' ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-5 w-5']"
                                aria-hidden="true"/>
                            Data Export
                        </Link>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Main column -->
        <div class="flex flex-col lg:pl-64">
            <!-- Search header -->
            <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 border-b border-gray-200 bg-white lg:hidden">
                <button type="button"
                        class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 lg:hidden"
                        @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <Bars3CenterLeftIcon class="h-6 w-6" aria-hidden="true"/>
                </button>
                <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-1">
                        <!-- <form class="flex w-full md:ml-0" action="#" method="GET">
                            <label for="search-field" class="sr-only">Search</label>
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center">
                                    <MagnifyingGlassIcon class="h-5 w-5" aria-hidden="true" />
                                </div>
                                <input id="search-field" name="search-field"
                                    class="block h-full w-full border-transparent py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
                                    placeholder="Search" type="search" />
                            </div>
                        </form> -->
                    </div>
                    <div class="flex items-center">
                        <!-- Profile dropdown -->
                        <Menu as="div" class="relative ml-3">
                            <div>
                                <MenuButton
                                    class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full"
                                         src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                         alt=""/>
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-100"
                                        enter-from-class="transform opacity-0 scale-95"
                                        enter-to-class="transform opacity-100 scale-100"
                                        leave-active-class="transition ease-in duration-75"
                                        leave-from-class="transform opacity-100 scale-100"
                                        leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <MenuItem v-slot="{ active }">
                                            <a href="/logout"
                                               :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Logout</a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>

<script>
    import {
        Dialog,
        DialogPanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        TransitionChild,
        TransitionRoot,
    } from '@headlessui/vue'
    import {
        Bars3CenterLeftIcon,
        Bars4Icon,
        ClockIcon,
        HomeIcon,
        PencilSquareIcon,
        ArrowUturnRightIcon,
        XMarkIcon,
        ClipboardDocumentIcon,
        BuildingLibraryIcon,
        CalendarDaysIcon,
        ChartPieIcon
    } from '@heroicons/vue/24/outline'
    import {
        ChevronRightIcon,
        ChevronUpDownIcon,
        EllipsisVerticalIcon,
        MagnifyingGlassIcon,
        ArrowUpTrayIcon,
        ArrowDownTrayIcon
    } from '@heroicons/vue/20/solid'

    import {Link} from '@inertiajs/inertia-vue3'

    export default {
        components: {
            Link,
            Dialog,
            DialogPanel,
            Menu,
            MenuButton,
            MenuItem,
            MenuItems,
            TransitionChild,
            TransitionRoot,
            Bars3CenterLeftIcon,
            Bars4Icon,
            ClockIcon,
            HomeIcon,
            PencilSquareIcon,
            ArrowUturnRightIcon,
            XMarkIcon,
            ChevronRightIcon,
            ChevronUpDownIcon,
            EllipsisVerticalIcon,
            MagnifyingGlassIcon,
            ClipboardDocumentIcon,
            BuildingLibraryIcon,
            CalendarDaysIcon,
            ChartPieIcon,
            ArrowUpTrayIcon,
            ArrowDownTrayIcon
        },

        data() {
            return {
                profile: {
                    name: this.$page.props.auth.user['first_name'],
                    role: this.$page.props.auth.user['role'],
                    display_role: this.$page.props.auth.user['display_role'],
                },
                current_page: this.$page.props.current_page,

                sidebarOpen: false,
                pinnedProjects: []
            }
        }
    }

</script>
