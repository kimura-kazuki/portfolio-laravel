<script setup>
// import { Head, Link, router } from '@inertiajs/vue3';

import AppLayout from '@/Layouts/AppLayout.vue';

import JetBarContainer from '@/Components/JetBar/JetBarContainer.vue';
import JetBarAlert from '@/Components/JetBar/JetBarAlert.vue';
import JetBarStatsContainer from '@/Components/JetBar/JetBarStatsContainer.vue';
import JetBarStatCard from '@/Components/JetBar/JetBarStatCard.vue';
// import JetBarTable from '@/Components/JetBar/JetBarTable.vue';
// import JetBarTableData from '@/Components/JetBar/JetBarTableData.vue';
// import JetBarBadge from '@/Components/JetBar/JetBarBadge.vue';
import JetBarIcon from '@/Components/JetBar/JetBarIcon.vue';

defineProps({
    userCount: Number,
    // receiptsBalance: Number,
    // orderCount: Number,
    // orderPendingCount: Number,
    // adminTasksTodayDue: Object,
});

// console.log(props.adminTasksTodayDue);
</script>

<template>
    <Head title="ダッシュボード" />

    <AppLayout>
        <template #header> ダッシュボード </template>

        <jet-bar-container>
            <JetBarAlert :text="$page.props.flash.message" />

            <jet-bar-stats-container>
                <jet-bar-stat-card
                    title="総ユーザー数"
                    :number="userCount"
                    type="warning"
                >
                    <template #icon>
                        <jet-bar-icon type="users" fill />
                    </template>
                </jet-bar-stat-card>

                <jet-bar-stat-card
                    title="「加盟料入金額」の総合計"
                    number="0"
                    type="success"
                >
                    <template #icon>
                        <jet-bar-icon type="money" fill />
                    </template>
                </jet-bar-stat-card>

                <jet-bar-stat-card title="全受注数" number="0" type="info">
                    <template #icon>
                        <jet-bar-icon type="cart" fill />
                    </template>
                </jet-bar-stat-card>

                <jet-bar-stat-card
                    title="未完了の受注"
                    number="0"
                    type="danger"
                >
                    <template #icon>
                        <jet-bar-icon type="message" fill />
                    </template>
                </jet-bar-stat-card>
            </jet-bar-stats-container>

            <!-- <jet-bar-table :headers="['name', 'title', 'status', 'role', '', '']" >
                <tr class="hover:bg-gray-50" v-for="index in 3" :key="index">
                    <jet-bar-table-data>Jane Cooper</jet-bar-table-data>
                    <jet-bar-table-data>
                        <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                        <div class="text-sm text-gray-500">Optimization</div>
                    </jet-bar-table-data>
                    <jet-bar-table-data>
                        <jet-bar-badge text="Active" type="success" />
                    </jet-bar-table-data>
                    <jet-bar-table-data>Admin</jet-bar-table-data>
                    <jet-bar-table-data>
                        <inertia-link href="#" class="text-indigo-600 hover:text-indigo-900">Edit</inertia-link>
                    </jet-bar-table-data>
                    <jet-bar-table-data>
                        <inertia-link href="#" class="text-gray-400 hover:text-gray-500">
                            <jet-bar-icon type="trash" fill />
                        </inertia-link>
                    </jet-bar-table-data>
                </tr>
            </jet-bar-table> -->
        </jet-bar-container>
    </AppLayout>
</template>
