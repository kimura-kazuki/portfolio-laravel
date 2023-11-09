<script setup>
// import { Head, Link, router, useForm } from '@inertiajs/vue3';

import AppLayout from '@/Layouts/AppLayout.vue';

// import JetSectionBorder from '@/Jetstream/SectionBorder.vue';

import JetBarContainer from '@/Components/JetBar/JetBarContainer.vue';
// import JetBarAlert from '@/Components/JetBar/JetBarAlert.vue';
import JetBarBadge from '@/Components/JetBar/JetBarBadge.vue';

defineProps({
    userId: Number,
    user: Object,
    userBank: Object,
    userCompany: Object,
    sexOptions: Object,
    bankAccountHolderTypeCodeOptions: Object,
});

const roleColor = {
    SystemAdmin: 'rose', // システム管理者
    Admin: 'teal', // 運営者
    Owner: 'sky', // オーナー
    // 'GrandMaster': 'pink', // グランドマスター
    // 'LabMaster': 'orange', // ラボマスター
    Staff: 'lime', // 加盟店
};

// const status = {
//     0: {
//         class: 'warning',
//         text: '繰越中',
//     },
//     1: {
//         class: 'success',
//         text: '報酬確定',
//     },
// };
</script>

<template>
    <AppLayout>
        <template #topnav>
            <div>
                <Link
                    :href="route('admin.users.index')"
                    class="gap-2 normal-case bg-white shadow-sm btn btn-sm md:btn-md btn-ghost lg:gap-3"
                >
                    <svg
                        class="w-6 h-6 fill-current md:h-8 md:w-8"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z"
                        ></path>
                    </svg>
                    <div class="flex flex-col items-start">
                        <span
                            class="hidden text-xs font-normal text-base-content/50 md:block"
                            >戻る</span
                        >
                        <span>ユーザー一覧</span>
                    </div>
                </Link>
            </div>
        </template>

        <template #header> ユーザー詳細 </template>

        <JetBarContainer>
            <!-- <JetBarAlert :text="$page.props.flash.message" />
            <JetBarAlert :text="$page.props.flash.error" type="danger" /> -->

            <div class="mb-5 md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2
                        class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate"
                    >
                        {{ user.name }}
                    </h2>
                    <div
                        class="flex flex-col mt-1 sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6"
                    >
                        <div
                            class="flex items-center mt-2 text-sm text-gray-500"
                        >
                            <svg
                                class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                ></path>
                            </svg>
                            {{ user.created_at_formated }}
                        </div>
                        <!-- <div class="flex items-center mt-2 space-x-1 text-sm text-gray-500">
                            <span class="block w-2 h-2 rounded-full" style="background-color: #60a5fa"></span>
                            <span>Paid</span>
                        </div> -->
                        <div
                            class="flex items-center mt-2 space-x-1 text-sm text-gray-500"
                        >
                            <!-- <span class="block w-2 h-2 rounded-full" style="background-color: #fbbf24"></span>
                            <span>{{ props.user.role_label }}</span> -->
                            <JetBarBadge
                                :text="user.role_label"
                                :type="roleColor[user.role_name]"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 mt-5">
                <div class="col-span-3 xl:col-span-2"></div>
                <div class="col-span-3 space-y-5 xl:col-span-1">
                    <div
                        class="-mx-4 overflow-hidden bg-white shadow sm:rounded-lg sm:-mx-0"
                    >
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                ユーザー情報
                            </h3>
                        </div>
                        <div class="px-4 py-6 sm:p-6">
                            <div
                                class="-m-6 -mx-4 divide-y divide-gray-200 sm:-mx-6"
                            >
                                <div
                                    class="flex items-center px-3 py-4 sm:py-5 sm:px-6"
                                >
                                    <div class="flex-shrink-0 mr-4">
                                        <img
                                            class="object-cover w-10 h-10 rounded-full"
                                            :src="user.profile_photo_url"
                                            :alt="user.name"
                                        />
                                    </div>
                                    <div
                                        class="flex items-center justify-between w-full"
                                    >
                                        <span class="text-sm font-medium">
                                            {{ user.name }}
                                        </span>
                                    </div>
                                </div>
                                <div class="px-3 py-4 text-sm sm:py-5 sm:px-6">
                                    <h4 class="text-xs font-medium uppercase">
                                        生年月日
                                    </h4>
                                    <ul class="mt-3 space-y-1">
                                        <li class="">
                                            {{ user.date_of_birth }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="px-3 py-4 text-sm sm:py-5 sm:px-6">
                                    <h4 class="text-xs font-medium uppercase">
                                        会員種別
                                    </h4>
                                    <ul class="mt-3 space-y-1">
                                        <li class="">
                                            {{ user.role_label }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="px-3 py-4 text-sm sm:py-5 sm:px-6">
                                    <h4 class="text-xs font-medium uppercase">
                                        連絡先情報
                                    </h4>
                                    <ul class="mt-3 space-y-1">
                                        <li class="">
                                            {{ user.email }}
                                        </li>
                                        <li class="">
                                            {{ user.phone }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="px-3 py-4 text-sm sm:py-5 sm:px-6">
                                    <h4 class="text-xs font-medium uppercase">
                                        住所
                                    </h4>
                                    <ul class="mt-3 space-y-1">
                                        <li class="">
                                            {{ user.user_locations[0]?.phone }}
                                        </li>
                                        <li class="">
                                            〒
                                            {{
                                                user.user_locations[0]
                                                    ?.postal_code
                                            }}
                                        </li>
                                        <li class="">
                                            {{
                                                user.user_locations[0]
                                                    ?.prefecture?.name
                                            }}
                                        </li>
                                        <li class="">
                                            {{
                                                user.user_locations[0]?.address1
                                            }}
                                        </li>
                                        <li class="">
                                            {{
                                                user.user_locations[0]?.address2
                                            }}
                                        </li>
                                    </ul>
                                </div>

                                <div class="px-3 py-4 text-sm sm:py-5 sm:px-6">
                                    <h4 class="text-xs font-medium uppercase">
                                        銀行口座
                                    </h4>
                                    <address class="mt-2 not-italic">
                                        {{ userBank?.bank_name }}<br />
                                        {{ userBank?.bank_branch_name }}<br />
                                        {{
                                            userBank?.bank_account_holder_type_code
                                        }}<br />
                                        {{ userBank?.bank_account_number
                                        }}<br />
                                        {{ userBank?.bank_account_holder_name }}
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </JetBarContainer>
    </AppLayout>
</template>

<style></style>
