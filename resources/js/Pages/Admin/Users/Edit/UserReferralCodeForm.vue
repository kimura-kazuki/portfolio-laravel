<script setup>
// import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import route from 'ziggy'

import { notify } from 'notiwind';

// import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
// import JetTextarea from '@/Jetstream/Textarea.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
// import JetActionMessage from '@/Jetstream/ActionMessage.vue';
// import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
// import JetSectionBorder from '@/Jetstream/SectionBorder.vue';
// import JetSectionBorderForm from '@/Jetstream/SectionBorderForm.vue';

// import JetBarContainer from '@/Components/JetBar/JetBarContainer.vue';
// import JetBarAlert from '@/Components/JetBar/JetBarAlert.vue';
// import JetBarStatsContainer from '@/Components/JetBar/JetBarStatsContainer.vue';
// import JetBarStatCard from '@/Components/JetBar/JetBarStatCard.vue';
// import JetBarTable from '@/Components/JetBar/JetBarTable.vue';
// import JetBarTableData from '@/Components/JetBar/JetBarTableData.vue';
// import JetBarBadge from '@/Components/JetBar/JetBarBadge.vue';
// import JetBarIcon from '@/Components/JetBar/JetBarIcon.vue';
// import { isIntegerKey } from '@vue/shared';

const props = defineProps({
    user: Object,
    userReferralCode: String,
    customerUserQrCodeUrl: String,
    advertiserUserQrCodeUrl: String,
});

const form = useForm({
    _method: 'PUT',

    user_referral_code: props.userReferralCode,
    user_referral_url: route('register') + '?code=' + props.userReferralCode,
});

const editUserReferralCode = () => {
    form.post(route('admin.users.update.bank-account', props.user.id), {
        errorBag: 'adminUserReferralCodeUpdate',
        preserveScroll: true,
        onSuccess: (page) => {
            notify(
                {
                    group: 'success',
                    title: 'Success',
                    text: page.props.flash.message,
                },
                5000,
            );
        },
        onError: (errors) => {
            console.log('error');
            console.log(errors);
        },
    });
};
</script>

<template>
    <JetFormSection
        class="mt-10 sm:mt-0"
        @submitted="editUserReferralCode"
    >
        <template #title> 紹介コード </template>

        <template #description>
            紹介コードを閲覧します。編集不可です。
        </template>

        <template #form>
            <!-- 紹介コード -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="user_referral_code" value="紹介コード" />
                <JetInput
                    id="user_referral_code"
                    v-model="form.user_referral_code"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="user_referral_code"
                    readonly="readonly"
                />
                <JetInputError
                    :message="form.errors.user_referral_code"
                    class="mt-2"
                />
            </div>

            <!-- 無料会員紹介URL -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="user_referral_code" value="無料会員紹介URL" />
                <JetInput
                    id="user_referral_code"
                    v-model="form.user_referral_url"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="user_referral_code"
                    readonly="readonly"
                />
                <img :src="customerUserQrCodeUrl" />
                <JetInputError
                    :message="form.errors.user_referral_code"
                    class="mt-2"
                />
            </div>

            <!-- 加盟店紹介URL -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="user_referral_code" value="加盟店紹介URL" />
                <JetInput
                    id="user_referral_code"
                    v-model="form.user_referral_url"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="user_referral_code"
                    readonly="readonly"
                />
                <img :src="advertiserUserQrCodeUrl" />
                <JetInputError
                    :message="form.errors.user_referral_code"
                    class="mt-2"
                />
            </div>

            <!-- QRコード -->
            <!-- <div v-if="qrCodeUrl" class="col-span-6 sm:col-span-4">
                <JetLabel for="user_referral_code" value="QRコード" />
                <img :src="qrCodeUrl" />
            </div> -->
        </template>

        <!-- <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                {{ $t('Saved.') }}
            </JetActionMessage>

            <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ $t('Save') }}
            </JetButton>
        </template> -->
    </JetFormSection>
</template>

<style></style>
