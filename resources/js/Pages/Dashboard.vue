<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

import AppLayout from '@/Layouts/AppLayout.vue';

import JetBarContainer from "@/Components/JetBar/JetBarContainer.vue";
import JetBarAlert from "@/Components/JetBar/JetBarAlert.vue";
import JetBarStatsContainer from "@/Components/JetBar/JetBarStatsContainer.vue";
import JetBarStatCard from "@/Components/JetBar/JetBarStatCard.vue";
import JetBarTable from "@/Components/JetBar/JetBarTable.vue";
import JetBarTableData from "@/Components/JetBar/JetBarTableData.vue";
import JetBarBadge from "@/Components/JetBar/JetBarBadge.vue";
import JetBarIcon from "@/Components/JetBar/JetBarIcon.vue";

const props = defineProps({
    // userCount: Number,
    // receiptsBalance: Number,
    // orderCount: Number,
    // orderPendingCount: Number,
    // adminTasksTodayDue: Object,
});

</script>

<template>
    <AppLayout>
        <template #header>
            ダッシュボード
        </template>

        <jet-bar-container>

            <jet-bar-stats-container>
                <jet-bar-stat-card title="総ユーザー数" :number="0" type="warning">
                    <template v-slot:icon>
                        <jet-bar-icon type="users" fill />
                    </template>
                </jet-bar-stat-card>

                <jet-bar-stat-card title="◯◯数" :number="0" type="success">
                    <template v-slot:icon>
                        <jet-bar-icon type="money" fill />
                    </template>
                </jet-bar-stat-card>

                <jet-bar-stat-card title="全受注数" :number="0" type="info">
                    <template v-slot:icon>
                        <jet-bar-icon type="cart" fill />
                    </template>
                </jet-bar-stat-card>

                <jet-bar-stat-card title="未完了の受注" :number="0" type="danger">
                    <template v-slot:icon>
                        <jet-bar-icon type="message" fill />
                    </template>
                </jet-bar-stat-card>
            </jet-bar-stats-container>

        </jet-bar-container>

    </AppLayout>
</template>
