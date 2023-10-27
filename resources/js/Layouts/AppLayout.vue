<script setup>
import { ref, computed, useSlots } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import JetApplicationMark from '@/Components/ApplicationMark.vue';
import JetBanner from '@/Components/Banner.vue';
import JetDropdown from '@/Components/Dropdown.vue';
import JetDropdownLink from '@/Components/DropdownLink.vue';
import JetNavLink from '@/Components/NavLink.vue';
import JetResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import JetBarNavigationMenu from "@/Components/JetBar/JetBarNavigationMenu.vue";
import JetBarSidebar from "@/Components/JetBar/JetBarSidebar.vue";
import JetBarSidebarAdmin from "@/Components/Admin/BarSidebar.vue";
import JetBarSidebarOwner from "@/Components/Owner/BarSidebar.vue";
import JetSectionBorder from '@/Components/SectionBorder.vue';
import NotificationSuccess from "@/Modules/Notifications/Success.vue";
import NotificationError from "@/Modules/Notifications/Error.vue";
// import Command from '@/Modules/Command/command/raycast/Raycast.vue';

const hasTopnav = computed(() => !! useSlots().topnav);
const hasHeader = computed(() => !! useSlots().header);

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="font-sans antialiased bg-gray-100">
        <jet-banner />

        <div class="flex-col w-full lg:flex lg:flex-row lg:min-h-screen">

            <!-- Sidebar -->
            <template v-if="$page.props.auth.user">
                <template v-if="$page.props.auth.user.role_name == 'SystemAdmin'">
                    <JetBarSidebarAdmin />
                </template>
                <template v-else-if="$page.props.auth.user.role_name == 'Admin'">
                    <JetBarSidebarAdmin />
                </template>
                <template v-else-if="$page.props.auth.user.role_name == 'Owner'">
                    <JetBarSidebarOwner />
                </template>
                <template v-else>
                    <JetBarSidebar />
                </template>
            </template>
            <!-- End Sidebar -->

            <div class="w-full">

                <!-- Top Navbar -->
                <JetBarNavigationMenu />
                <!-- End Top Navbar -->

                <!-- Content Container -->
                <main class="relative z-0 flex-1 py-6 overflow-y-auto focus:outline-none" tabindex="0">
                    <div v-if="hasTopnav" class="px-4 pt-3 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div class="flex justify-between">
                            <slot name="topnav"></slot>
                        </div>

                        <JetSectionBorder />
                    </div>

                    <div v-if="hasHeader" class="px-4 pt-3 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <!-- Title -->
                        <h1 class="text-lg font-semibold tracking-widest text-gray-900 uppercase dark-mode:text-white">
                            <slot name="header"></slot>
                        </h1>
                        <!-- End Title -->
                    </div>
                    <!-- Replace with your content -->
                    <div>
                        <!-- Content -->
                        <div class="min-h-full px-4 lg:min-h-96 sm:px-0">
                            <slot></slot>
                        </div>
                        <!-- End Content -->
                    </div>
                    <!-- /End replace -->
                </main>
                <!-- Content Container -->
            </div>
        </div>
    </div>

    <NotificationSuccess />
    <NotificationError />

</template>
