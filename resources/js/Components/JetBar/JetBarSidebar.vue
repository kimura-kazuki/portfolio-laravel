<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { HomeIcon, Squares2X2Icon, InboxIcon, ShoppingBagIcon, UserIcon, CurrencyYenIcon, GlobeAltIcon } from '@heroicons/vue/24/outline';
</script>

<script>
import JetBarResponsiveLinks from "@/Components/JetBar/JetBarResponsiveLinks.vue";
export default {
    name: "JetBarSidebar",
    components: {JetBarResponsiveLinks},
    data() {
        return {
            showingNavigationDropdown: false,
            showingSidebarNavigationDropdown: false,
        }
    },
}
</script>

<template>
    <div class="flex flex-col flex-shrink-0 w-full text-gray-700 bg-white lg:w-64 dark-mode:text-gray-200 dark-mode:bg-gray-800 lg:border-r" id="sidebar">
        <div class="flex flex-row items-center justify-between flex-shrink-0 px-4 py-4 lg:px-8">
            <!-- App Title -->
            <!-- <Link :href="route('dashboard')" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline" id="logo">Curva</Link> -->
            <Link
                :href="route('dashboard')"
                class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">
                <!-- <img
                    class="w-32"
                    src="/images/common/logo.png"
                    alt="Curva"
                > -->
                Knowledge SFA
            </Link>
            <!-- End App Title -->

            <div class="flex flex-row">
                <!-- Go to Home -->
                <div class="relative tooltip tooltip-bottom" data-tip="Homeへ戻る">
                    <!-- <a :href="route('home')" class="flex mx-1 text-gray-600 focus:outline-none"> -->
                    <Link :href="route('home')" class="flex mx-4 text-gray-600 focus:outline-none lg:hidden" id="goToHome">
                        <GlobeAltIcon class="w-6 h-6" />
                    </Link>
                </div>

                <button class="rounded-lg lg:hidden focus:outline-none focus:shadow-outline" @click="showingNavigationDropdown = !showingNavigationDropdown">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                        <path v-show="!showingNavigationDropdown" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        <path v-show="showingNavigationDropdown" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div v-show="showingNavigationDropdown" @click="showingNavigationDropdown = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>
        <!-- Sidebar Links -->
        <nav :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="z-10 flex-grow px-4 pb-4 lg:block lg:pb-0 lg:overflow-y-auto">
            <template v-if="$page.props.jetstream.hasTeamFeatures">
                <Link v-if="$page.props.jetstream.canCreateTeams" :class="route().current('teams.create') ? 'bg-gray-200' : 'bg-transparent'" class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('teams.create')">Create Team</Link>
                <Link :class="route().current('teams.show') ? 'bg-gray-200' : 'bg-transparent'" class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('teams.show', $page.props.auth.user.current_team)">Team Settings</Link>
            </template>

            <Link :class="route().current('dashboard') ? 'bg-gray-200' : 'bg-transparent'" class="flex items-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg group dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('dashboard')">
                <!-- <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 flex-shrink-0 text-gray-500 mr-3 [&[aria-current='page']]:text-inherit" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> -->
                <HomeIcon class="flex-shrink-0 w-5 h-5 mr-3 text-gray-500" />
                <span class="flex justify-between w-full"><div class="flex">ダッシュボード</div></span>
            </Link>

            <!-- <template
                v-if="$page.props.auth.user.role_name == 'Owner' || $page.props.auth.user.role_name == 'Advertiser'"
            >
                <Link :class="route().current('dashboard.products.*') ? 'bg-gray-200' : 'bg-transparent'" class="flex items-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg group dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('dashboard.products.index')">
                    <Squares2X2Icon class="flex-shrink-0 w-5 h-5 mr-3 text-gray-500" />
                    <span class="flex justify-between w-full"><div class="flex">商品管理</div></span>
                </Link>
            </template>

            <template v-if="$page.props.auth.user.role_name == 'Owner' || $page.props.auth.user.role_name == 'Advertiser'">
                <Link :class="route().current('dashboard.receive-orders.*') ? 'bg-gray-200' : 'bg-transparent'" class="flex items-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg group dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('dashboard.receive-orders.index')">
                    <InboxIcon class="flex-shrink-0 w-5 h-5 mr-3 text-gray-500" />
                    <span class="flex justify-between w-full"><div class="flex">受注管理</div></span>
                </Link>
            </template>

            <Link :class="route().current('dashboard.orders.*') ? 'bg-gray-200' : 'bg-transparent'" class="flex items-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg group dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('dashboard.orders.index')">
                <ShoppingBagIcon class="flex-shrink-0 w-5 h-5 mr-3 text-gray-500" />
                <span class="flex justify-between w-full"><div class="flex">紹介依頼履歴</div></span>
            </Link>

            <Link :class="route().current('dashboard.introduced-persons.*') ? 'bg-gray-200' : 'bg-transparent'" class="flex items-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg group dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('dashboard.introduced-persons.index')">
                <UserIcon class="flex-shrink-0 w-5 h-5 mr-3 text-gray-500" />
                <span class="flex justify-between w-full"><div class="flex">紹介者管理</div></span>
            </Link>

            <Link :class="route().current('dashboard.reward.*') ? 'bg-gray-200' : 'bg-transparent'" class="flex items-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg group dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('dashboard.reward.index')">
                <CurrencyYenIcon class="flex-shrink-0 w-5 h-5 mr-3 text-gray-500" />
                <span class="flex justify-between w-full"><div class="flex">報酬獲得履歴</div></span>
            </Link>

            <template v-if="$page.props.auth.user.role_name == 'Owner'">
                <Link :class="route().current('dashboard.owner-point-histories.*') ? 'bg-gray-200' : 'bg-transparent'" class="flex items-center px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg group dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :href="route('dashboard.owner-point-histories.index')">
                    <CurrencyYenIcon class="flex-shrink-0 w-5 h-5 mr-3 text-gray-500" />
                    <span class="flex justify-between w-full"><div class="flex">ポイント獲得履歴</div></span>
                </Link>
            </template> -->

            <!-- <div class="relative">
                <button @click="showingSidebarNavigationDropdown = !showingSidebarNavigationDropdown" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 lg:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                    <span>Dropdown</span>
                    <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': showingSidebarNavigationDropdown, 'rotate-0': !showingSidebarNavigationDropdown}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform lg:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <transition enter-active-class="transition duration-100 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0" >
                    <div v-if="showingSidebarNavigationDropdown" class="absolute right-0 z-20 w-full mt-2 origin-top-right rounded-md shadow-lg">
                        <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Link #1</a>
                            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Link #2</a>
                            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Link #3</a>
                        </div>
                    </div>
                </transition>
            </div> -->

            <jet-bar-responsive-links />

        </nav>
        <div v-show="showingSidebarNavigationDropdown" @click="showingSidebarNavigationDropdown = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>
        <!-- End Sidebar Links -->
    </div>
</template>
