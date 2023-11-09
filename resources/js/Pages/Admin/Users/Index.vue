<script setup>
// import { Head, Link, router } from '@inertiajs/vue3';
import route from 'ziggy-js';

import axios from 'axios';
import Swal from 'sweetalert2';

import AppLayout from '@/Layouts/AppLayout.vue';

import JetBarContainer from '@/Components/JetBar/JetBarContainer.vue';
import JetBarAlert from '@/Components/JetBar/JetBarAlert.vue';
// import JetBarStatsContainer from '@/Components/JetBar/JetBarStatsContainer.vue';
// import JetBarStatCard from '@/Components/JetBar/JetBarStatCard.vue';
// import JetBarTable from '@/Components/JetBar/JetBarTable.vue';
// import JetBarTableData from '@/Components/JetBar/JetBarTableData.vue';
import JetBarBadge from '@/Components/JetBar/JetBarBadge.vue';
import JetBarIcon from '@/Components/JetBar/JetBarIcon.vue';
// import JetBarSimplePagination from '@/Components/JetBar/JetBarSimplePagination.vue';

// import { Table, setTranslations } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import { Table, setTranslations } from '@/Components/InertiaTable/main.js';

setTranslations({
    next: '次へ',
    no_results_found: 'データはありません。',
    of: '件',
    per_page: '件 / ページ',
    previous: '前へ',
    results: '件中',
    to: '〜',
});

defineProps({
    users: Object,
});

const roleColor = {
    SystemAdmin: 'rose', // システム管理者
    Admin: 'teal', // 運営者
    Owner: 'sky', // オーナー
    // 'GrandMaster': 'pink', // グランドマスター
    // 'LabMaster': 'orange', // ラボマスター
    Staff: 'lime', // 加盟店
    // 'Customer': 'orange', // 無料会員
};

const statusType = {
    Unconfirmed: 'danger-outline', // 未確認
    Approved: 'info-outline', // 承認
    Reject: 'normal-outline', // 却下
};

// const deleteUser = (id, index) => {
const deleteUser = (id) => {
    Swal.fire({
        icon: 'warning',
        text: 'ユーザーを削除しますか？',
        confirmButtonColor: '#41b882',
        cancelButtonColor: '#ff7674',
        showCancelButton: true,
        showLoaderOnConfirm: true,
        allowOutsideClick: function () {
            return !Swal.isLoading();
        },
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .delete(route('admin.users.destroy', id), {
                    data: { userId: id },
                })
                // .then((res) => {
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: '完了',
                        text: 'ユーザーを削除しました。',
                    // }).then((result) => {
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    });
};

// const changeGlobalSearchValue = (slotProps, $event) => {
//     slotProps.onChange($event.target.value);
// };
</script>

<template>
    <Head title="ユーザー管理" />

    <AppLayout>
        <template #header> ユーザー管理 </template>

        <JetBarContainer>
            <JetBarAlert :text="$page.props.flash.message" />

            <Link
                id="create"
                :href="route('admin.users.create')"
                class="inline-flex items-center px-4 py-2 mb-3 text-sm font-semibold tracking-widest text-white uppercase transition bg-blue-800 border border-transparent rounded-md shadow hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25"
            >
                新規追加
            </Link>

            <Table
                :resource="users"
                :inertia="$inertia"
                :prevent-overlapping-requests="false"
                :input-debounce-ms="1000"
                :preserve-scroll="true"
            >
                <template #cell(id)="{ item: user }">
                    <div class="text-sm text-gray-900">
                        <Link
                            :href="route('admin.users.show', user.id)"
                            class="text-indigo-600 hover:text-indigo-900"
                        >
                            # {{ user.id }}
                        </Link>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ user.created_at_formated }}
                    </div>
                </template>
                <template #cell(name)="{ item: user }">
                    <div
                        class="flex items-center font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        <div class="-space-x-6 avatar-group">
                            <div class="avatar">
                                <div class="w-12">
                                    <img
                                        class="object-cover w-8 h-8 rounded-full"
                                        :src="user.profile_photo_url"
                                        :alt="user.name"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="pl-3">
                            <div class="text-sm text-gray-900">
                                {{ user.name }}
                            </div>
                        </div>
                    </div>
                </template>
                <template #cell(role_label)="{ item: user }">
                    <JetBarBadge
                        :text="user.role_label"
                        :type="roleColor[user.role_name]"
                    />
                </template>
                <template #cell(is_approved_label)="{ item: user }">
                    <JetBarBadge
                        :text="user.is_approved_label"
                        :type="statusType[user.is_approved_name]"
                    />
                </template>
                <template #cell(参照)="{ item: user }">
                    <div class="relative flex-grow">
                        <Link
                            :href="route('admin.users.show', user.id)"
                            class="text-indigo-600 hover:text-indigo-900"
                            >参照</Link
                        >
                    </div>
                </template>
                <template #cell(編集)="{ item: user }">
                    <div class="relative flex-grow">
                        <Link
                            :href="route('admin.users.edit', user.id)"
                            class="text-indigo-600 hover:text-indigo-900"
                            >編集</Link
                        >
                    </div>
                </template>
                <template #cell(削除)="{ item: user }">
                    <div
                        v-if="!user.deleted_at_formated"
                        class="relative flex-grow"
                    >
                        <button
                            class="text-gray-400 hover:text-gray-500"
                            @click="deleteUser(user.id, index)"
                        >
                            <JetBarIcon type="trash" fill />
                        </button>
                    </div>
                    <div v-else class="relative flex-grow">
                        <span class="text-xs text-red-500">削除済み</span>
                    </div>
                </template>

                <!-- <template v-slot:tableGlobalSearch="slotProps">
                    <div class="relative flex-grow">
                        <input
                            type="text"
                            placeholder="検索"
                            @keyup.enter="changeGlobalSearchValue(slotProps, $event)"
                            class="block w-full text-sm border-gray-300 rounded-md shadow-sm pl-9 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg></div>
                    </div>
                </template> -->
            </Table>
        </JetBarContainer>
    </AppLayout>
</template>

<style scoped>
table {
    overflow: hidden;
    border-radius: 0.375rem 0.375rem 0 0;
}
nav {
    overflow: hidden;
    border-radius: 0 0 0.375rem 0.375rem;
}
</style>
