<template>
    <div class="relative block lg:hidden" v-if="$page.props.jetstream.hasTeamFeatures">
        <button @click="showingSidebarManageTeamsDropdown = !showingSidebarManageTeamsDropdown" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 lg:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
            <span>Manage Teams</span>
            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': showingSidebarManageTeamsDropdown, 'rotate-0': !showingSidebarManageTeamsDropdown}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform lg:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
        <transition enter-active-class="transition duration-100 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0" >
            <div v-if="showingSidebarManageTeamsDropdown" class="absolute right-0 z-20 w-full mt-2 origin-top-right rounded-md shadow-lg">
                <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Manage Team
                    </div>
                    <Link :href="route('teams.show', $page.props.auth.user.current_team)" :class="route().current('teams.show') ? 'bg-gray-200' : 'bg-transparent'" class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">Team Settings</Link>
                    <Link :href="route('teams.create')" :class="route().current('teams.create') ? 'bg-gray-200' : 'bg-transparent'" v-if="$page.props.jetstream.canCreateTeams" class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">Create New Team</Link>
                    <div class="border-t border-gray-100"></div>
                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Switch Teams
                    </div>

                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                        <form @submit.prevent="switchToTeam(team)">
                            <button class="block w-full px-4 py-2 mt-2 text-sm font-semibold rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                <div class="flex items-center">
                                    <svg v-if="team.id == $page.props.auth.user.current_team_id" class="w-5 h-5 mr-2 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <div>{{ team.name }}</div>
                                </div>
                            </button>
                        </form>
                    </template>
                </div>
            </div>
        </transition>
    </div>

    <div v-show="showingSidebarManageAccountDropdown" @click="showingSidebarManageAccountDropdown = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

    <div class="relative block lg:hidden" >
        <button @click="showingSidebarManageAccountDropdown = !showingSidebarManageAccountDropdown" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 lg:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
            <span>{{ $t('Manage Account') }}</span>
            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': showingSidebarManageAccountDropdown, 'rotate-0': !showingSidebarManageAccountDropdown}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform lg:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
        <transition enter-active-class="transition duration-100 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0" >
            <div v-if="showingSidebarManageAccountDropdown" class="absolute right-0 z-20 w-full mt-2 origin-top-right rounded-md shadow-lg">
                <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                    <Link
                        v-if="!($page.props.auth.user.role_name == 'Admin' || $page.props.auth.user.role_name == 'SystemAdmin')"
                        :href="route('profile.kyc')"
                        :class="route().current('profile.kyc') ? 'bg-gray-200' : 'bg-transparent'"
                        class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                    >
                        本人確認手続き
                    </Link>

                    <Link
                        v-if="!($page.props.auth.user.role_name == 'Admin' || $page.props.auth.user.role_name == 'SystemAdmin')"
                        :href="route('profile.referral-code')"
                        :class="route().current('profile.referral-code') ? 'bg-gray-200' : 'bg-transparent'"
                        class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                    >
                        紹介コード
                    </Link>

                    <Link :href="route('profile.show')" :class="route().current('profile.show') ? 'bg-gray-200' : 'bg-transparent'" class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">{{ $t('Profile') }}</Link>

                    <Link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures" class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">API Tokens</Link>

                    <Link :href="route('home')" class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">ホームへ戻る</Link>

                    <form @submit.prevent="logout">
                        <button class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 lg:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                            {{ $t('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </transition>
    </div>

    <div v-show="showingSidebarManageTeamsDropdown" @click="showingSidebarManageTeamsDropdown = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

</template>

<script>
import { router, Link } from '@inertiajs/vue3';

export default {
    name: "JetBarResponsiveLinks",
    components: { router, Link },
    data() {
        return {
            showingSidebarManageAccountDropdown: false,
            showingSidebarManageTeamsDropdown: false,
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
