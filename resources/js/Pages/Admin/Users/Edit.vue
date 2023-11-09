<script setup>
// import { router } from '@inertiajs/vue3';

import AppLayout from '@/Layouts/AppLayout.vue';

import JetSectionBorder from '@/Jetstream/SectionBorder.vue';

import JetBarContainer from '@/Components/JetBar/JetBarContainer.vue';
import JetBarAlert from '@/Components/JetBar/JetBarAlert.vue';

import UserForm from '@/Pages/Admin/Users/Edit/UserForm.vue';
import CompanyForm from '@/Pages/Admin/Users/Edit/CompanyForm.vue';
import BankAccountInformationForm from '@/Pages/Admin/Users/Edit/BankAccountInformationForm.vue';
import UserReferralCodeForm from '@/Pages/Admin/Users/Edit/UserReferralCodeForm.vue';
import OwnerInformationForm from '@/Pages/Admin/Users/Edit/OwnerInformationForm.vue';

const props = defineProps({
    userId: Number,
    user: Object,
    userBank: Object,
    userCompany: Object,
    // isApprovedOptions: Object,
    sexOptions: Object,
    bankAccountHolderTypeCodeOptions: Object,
    userReferralCode: String,
    userIntroducer: Object,
    customerUserQrCodeUrl: String,
    advertiserUserQrCodeUrl: String,
});

// const back = () => {
//     // let urlPrev = usePage().props.value.urlPrev;
//     // if (urlPrev !== 'empty') {
//     //     Inertia.visit(urlPrev);
//     // } else {
//     //     Inertia.visit(route('admin.users.index'));
//     // }

//     // history.back();

//     var ref = document.referrer;
//     let indexPageUrl = route('admin.users.index');
//     let reg = new RegExp(indexPageUrl);
//     var result = ref.match(reg);

//     if (result) {
//         history.back();
//     } else {
//         router.visit(indexPageUrl);
//     }
// };
</script>

<template>
    <AppLayout>
        <template #topnav>
            <div>
                <InertiaLink
                    :href="route('admin.users.index')"
                    class="gap-2 normal-case btn btn-sm md:btn-md btn-ghost lg:gap-3"
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
                        <span>Back</span>
                    </div>
                </InertiaLink>
                <!-- <a @click="back()" class="gap-2 normal-case btn btn-sm md:btn-md btn-ghost lg:gap-3">
                    <svg class="w-6 h-6 fill-current md:h-8 md:w-8" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z"></path></svg>
                    <div class="flex flex-col items-start">
                        <span class="hidden text-xs font-normal text-base-content/50 md:block">戻る</span>
                        <span>Back</span>
                    </div>
                </a> -->
            </div>
        </template>

        <template #header> ユーザー編集 </template>

        <JetBarContainer>
            <!-- <JetBarAlert :text="$page.props.flash.message" />
            <JetBarAlert :text="$page.props.flash.error" type="danger" /> -->

            <JetBarAlert
                v-if="props.user.deleted_at"
                text="ユーザーは削除済みです。"
                type="danger"
            />

            <!-- 加盟店のみ -->
            <!-- <template v-if="props.user.role_name === 'Advertiser'">
                <IsApprovedForm :user="user" :isApprovedOptions="isApprovedOptions" />

                <JetSectionBorder />
            </template> -->

            <!-- ユーザー情報 -->
            <UserForm
                :user="user"
                :sex-options="sexOptions"
                :user-introducer="userIntroducer"
            />

            <JetSectionBorder />

            <!-- 加盟店のみ -->
            <template
                v-if="
                    props.user.role_name === 'Advertiser' ||
                    props.user.role_name === 'Owner'
                "
            >
                <CompanyForm :user="user" :user-company="userCompany" />

                <JetSectionBorder />
            </template>

            <!-- 銀行情報 -->
            <BankAccountInformationForm
                :user="user"
                :user-bank="userBank"
                :bank-account-holder-type-code-options="
                    bankAccountHolderTypeCodeOptions
                "
            />

            <JetSectionBorder />

            <!-- オーナーのみ: オーナー情報 -->
            <template v-if="props.user.role_name === 'Owner'">
                <OwnerInformationForm :user="user" />

                <JetSectionBorder />
            </template>

            <!-- 紹介コード -->
            <UserReferralCodeForm
                :user="user"
                :user-referral-code="userReferralCode"
                :customer-user-qr-code-url="customerUserQrCodeUrl"
                :advertiser-user-qr-code-url="advertiserUserQrCodeUrl"
            />

            <JetSectionBorder />
        </JetBarContainer>
    </AppLayout>
</template>

<style></style>
