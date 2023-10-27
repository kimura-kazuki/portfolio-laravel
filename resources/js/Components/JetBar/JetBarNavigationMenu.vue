<script setup>
import { GlobeAltIcon, ArrowSmallLeftIcon } from '@heroicons/vue/24/outline';
// import Command from '@/Modules/Command/Command.vue';
</script>

<template>
    <header class="items-center justify-between hidden px-6 py-4 bg-white border-b border-gray-200 lg:flex" id="header">
        <!-- Searchbar -->
        <div class="flex items-center">
            <!-- <div class="relative mr-4 lg:mx-0">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>

                <input class="w-32 p-2 pl-10 pr-4 bg-gray-100 border-transparent rounded-md form-input sm:w-64 border-1 focus:bg-transparent focus:border-indigo-300" type="text" placeholder="Search">
            </div> -->

<!-- <div class="text-sm breadcrumbs">
  <ul>
    <li><a>Home</a></li>
    <li><a>Documents</a></li>
    <li>Add Document</li>
  </ul>
</div> -->

<!-- <div class="flex items-center gap-2">
    <div class="block md:hidden">
        <button type="button" class="grid w-8 h-8 border rounded place-items-center border-brand-base">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
        </button>
    </div>
    <div class="flex items-center">
        <button type="button" class="grid flex-shrink-0 text-sm text-center border rounded cursor-pointer group h-7 w-7 place-items-center border-brand-base hover:bg-brand-surface-1">
            <span class="text-base text-lg font-light leading-4 leading-5 material-symbols-rounded text-brand-secondary group-hover:text-brand-base">
                <ArrowSmallLeftIcon class="w-4 h-4" />
            </span>
        </button>
        <a class="px-3 text-sm border-r-2 border-brand-base" href="/kazukikimura/projects">
            <p class="">Projects</p>
        </a>
        <div class="px-3 text-sm max-w-64">
            <p class=""><span class="break-words">test2 Views</span></p>
        </div>
    </div>
</div> -->


        </div>
        <!-- End Searchbar -->

        <div class="flex items-center">

            <!-- <Command /> -->

            <!-- Go to Home -->
            <!-- <div class="relative tooltip tooltip-bottom" data-tip="Homeへ戻る">
                <Link :href="route('home')" class="flex mx-4 text-gray-600 focus:outline-none" id="goToHome">
                    <GlobeAltIcon class="w-6 h-6" />
                </Link>
            </div> -->

            <!-- Notifications -->
            <div class="relative"
                v-if="$page.props.auth.user.role_name == 'Admin'"
            >
                <button @click="showingNotificationDropdown = ! showingNotificationDropdown" class="relative flex mx-4 text-gray-600 focus:outline-none">
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

                <div v-show="showingNotificationDropdown" @click="showingNotificationDropdown = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

                <!-- Notifications links -->
                <!-- <div v-show="showingNotificationDropdown" class="absolute right-0 z-10 mt-2 overflow-hidden bg-white border border-gray-200 rounded-lg shadow-xl w-80" style="width: 20rem; display: none;">
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
                </div> -->
                <!-- End Notifications links -->
            </div>
            <!-- End Notifications -->

            <!-- Dropdown Menu -->
            <div class="relative px-2">
                <button v-if="$page.props.jetstream.managesProfilePhotos" @click="showingUserDropdown = ! showingUserDropdown" class="flex text-sm transition duration-150 ease-in-out border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300" id="profileButton">
                    <img class="object-cover w-8 h-8 rounded-full" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name" />
                </button>
                <span v-else @click="showingUserDropdown = ! showingUserDropdown" class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                        {{ $page.props.auth.user.name }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </span>

                <div v-show="showingUserDropdown" @click="showingUserDropdown = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

                <!-- User menu links -->
                <div
                    v-show="showingUserDropdown"
                    class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white border border-gray-200 rounded-md shadow-xl"
                    id="accountMenu"
                    style="display: none;"
                >

                    <template v-if="$page.props.jetstream.hasTeamFeatures">

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ $t('Manage Team') }}
                        </div>

                        <Link :href="route('teams.show', $page.props.auth.user.current_team)" class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-100">Team Settings</Link>
                        <Link :href="route('teams.create')" v-if="$page.props.jetstream.canCreateTeams" class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-100">Create New Team</Link>
                        <div class="border-t border-gray-100"></div>
                        <!-- Team Switcher -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            Switch Teams
                        </div>

                        <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                            <form @submit.prevent="switchToTeam(team)">
                                <button class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                                    <div class="flex items-center">
                                        <svg v-if="team.id == $page.props.auth.user.current_team_id" class="w-5 h-5 mr-2 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <div>{{ team.name }}</div>
                                    </div>
                                </button>
                            </form>
                        </template>

                        <div class="border-t border-gray-100"></div>

                    </template>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ $t('Manage Account') }}
                    </div>

                    <Link
                        :href="route('profile.show')"
                        class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-100"
                    >
                        {{ $t('Profile') }}
                    </Link>

                    <Link
                        v-if="$page.props.jetstream.hasApiFeatures"
                        :href="route('api-tokens.index')"
                        class="block px-4 py-2 text-sm text-gray-500 hover:bg-gray-100"
                    >
                        {{ $t('API Tokens') }}
                    </Link>

                    <form @submit.prevent="logout">
                        <button class="block w-full px-4 py-2 text-sm text-left text-gray-500 hover:bg-gray-100 focus:outline-none">
                            {{ $t('Log Out') }}
                        </button>
                    </form>
                </div>
                <!-- End User menu links -->
            </div>
            <!-- End Dropdown Menu -->
        </div>
    </header>
</template>

<script>
import { Head, Link, router } from '@inertiajs/vue3';

export default {
    name: "JetBarNavigationMenu",
    components: { Head, Link, router },
    data() {
        return {
            showingNotificationDropdown: false,
            showingUserDropdown: false,
        }
    },
    methods: {
        switchToTeam(team) {
            router.put(route('current-team.update'), {
                'team_id': team.id
            }, {
                preserveState: false
            })
        },
        logout() {
            router.post(route('logout'));
        },
    }
}
</script>
