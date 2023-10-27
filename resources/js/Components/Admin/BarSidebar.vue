<script setup>
import { HomeIcon, UsersIcon, TagIcon, Squares2X2Icon, InboxIcon, GlobeAltIcon, CalendarDaysIcon } from '@heroicons/vue/24/outline';
import { Head, Link, router } from '@inertiajs/vue3';

const goToHome = () => {
    location.href = route('home');
}
</script>

<script>
import JetBarResponsiveLinks from "@/Components/JetBar/JetBarResponsiveLinks.vue";
export default {
    name: "JetBarSidebar",
    components: {JetBarResponsiveLinks},
    data() {
        return {
            showingNotificationDropdown: false,
            showingNavigationDropdown: false,
            showingSidebarNavigationDropdown: false,
        }
    },
}
</script>

<template>
    <div class="flex flex-col flex-shrink-0 w-full text-gray-700 bg-white lg:w-64 dark-mode:text-gray-200 dark-mode:bg-gray-800 lg:border-r">
        <div class="flex flex-row items-center justify-between flex-shrink-0 px-4 py-4 lg:px-8">
            <!-- App Title -->
            <!-- <Link :href="route('dashboard')" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">Curva</Link> -->
            <Link
                :href="route('dashboard')"
                class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">
                Knowledge SFA
            </Link>
            <!-- End App Title -->

            <div class="flex flex-row">
                <Link
                    :href="route('home')"
                    id="goToHome"
                    class="flex mx-4 text-gray-600 focus:outline-none lg:hidden"
                >
                    <GlobeAltIcon class="w-6 h-6" />
                </Link>

                <template v-if="$page.props.auth.user.role_name == 'Admin'">
                    <button @click="showingNotificationDropdown = ! showingNotificationDropdown" class="relative flex mx-4 text-gray-600 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                        <span
                            v-if="$page.props.auth.adminTasksCount > 0"
                            class="absolute right-0 px-1 py-0 text-xs text-white translate-x-1/2 bg-red-500 rounded-full -top-1">
                            {{ $page.props.auth.adminTasksCount }}
                        </span>
                    </button>
                </template>

                <button class="px-2 rounded-lg lg:hidden focus:outline-none focus:shadow-outline" @click="showingNavigationDropdown = !showingNavigationDropdown">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                        <path v-show="!showingNavigationDropdown" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        <path v-show="showingNavigationDropdown" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Notifications -->
        <template v-if="$page.props.auth.user.role_name == 'Admin'">
            <div v-show="showingNotificationDropdown" @click="showingNotificationDropdown = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

            <!-- Notifications links -->
            <div v-show="showingNotificationDropdown" class="z-10 flex-grow px-4 pb-4 lg:block lg:pb-0 lg:overflow-y-auto" style="display: none;">
                <div class="block px-4 py-2 text-xs text-gray-400">
                    本日期限のタスク
                    <template v-if="$page.props.auth.adminTasksCount == 0">
                        はありません
                    </template>
                    <template v-else>
                        が {{ $page.props.auth.adminTasksCount }} 件あります
                    </template>
                </div>

                <template v-for="adminTask in $page.props.auth.adminTasks" :key="adminTask.id">
                    <a :href="route('admin.admin-tasks.edit', adminTask.id)" class="flex items-center px-4 py-3 -mx-2 text-gray-600 hover:bg-gray-100">
                        <figure class="w-1/6">
                            <img class="object-cover w-8 h-8 mx-1 rounded-full" :src="$page.props.auth.user.profile_photo_url" alt="avatar">
                        </figure>
                        <p class="w-full mx-2 text-sm">
                            {{ adminTask.title }}
                        </p>
                    </a>
                </template>
            </div>
        </template>
        <!-- End Notifications links -->

        <div v-show="showingNavigationDropdown" @click="showingNavigationDropdown = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>
        <!-- Sidebar Links -->
        <nav :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="z-10 flex-grow px-4 pb-4 lg:block lg:pb-0 lg:overflow-y-auto">
            <Link :class="route().current('admin.index') ? 'bg-gray-200' : 'bg-transparent'" class="flex items-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg group dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('admin.index')">
                <HomeIcon class="flex-shrink-0 w-5 h-5 mr-3 text-gray-500" />
                <span class="justify-between w-full lg:flex"><div class="flex">ダッシュボード</div></span>
            </Link>

            <Link :class="route().current('admin.users.*') ? 'bg-gray-200' : 'bg-transparent'" class="flex items-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg group dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('admin.users.index')">
                <!-- <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 flex-shrink-0 text-gray-500 mr-3 [&[aria-current='page']]:text-inherit" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> -->
                <UsersIcon class="flex-shrink-0 w-5 h-5 mr-3 text-gray-500" />
                <span class="justify-between w-full lg:flex"><div class="flex">ユーザー管理</div></span>
            </Link>

            <JetBarResponsiveLinks />

        </nav>

        <small class="hidden mx-3 mt-1 mb-2 text-center opacity-50 lg:block" style="font-size: 0.5rem;">© 2023 Knowledge SFA</small>

        <div v-show="showingSidebarNavigationDropdown" @click="showingSidebarNavigationDropdown = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>
        <!-- End Sidebar Links -->
    </div>
</template>
