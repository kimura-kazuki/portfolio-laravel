<script setup>
// import { ref } from 'vue';
// import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { Link, useForm } from '@inertiajs/vue3';
import route from 'ziggy'

import { notify } from 'notiwind';

import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
// import JetTextarea from '@/Jetstream/Textarea.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
// import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
// import JetSectionBorder from '@/Jetstream/SectionBorder.vue';
// import JetSectionBorderForm from '@/Jetstream/SectionBorderForm.vue';

const props = defineProps({
    user: Object,
    sexOptions: Object,
    userIntroducer: Object,
});

const form = useForm({
    _method: 'PUT',
    membership_number: props.user.membership_number,
    name: props.user.name,
    name_kana: props.user.name_kana,
    // email: props.user.email,
    sex_code: props.user.sex_code,
    date_of_birth: props.user.date_of_birth,
    introducer_code: props.user.introducer_code,
    is_approved: props.user.is_approved,
    is_approved_kyc: props.user.is_approved_kyc,
});

const editUserByAdmin = () => {
    form.post(route('admin.users.update', props.user.id), {
        errorBag: 'adminUserUpdate',
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
            console.log(errors);
            notify(
                {
                    group: 'error',
                    title: 'Error',
                    // text: errors.message ?? errors,
                    text: 'エラーが発生しました。',
                },
                5000,
            );
        },
    });
};
</script>

<template>
    <JetFormSection
        class="mt-10 sm:mt-0"
        @submitted="editUserByAdmin"
    >
        <template #title> ユーザー情報 </template>

        <template #description> ユーザー情報を編集します。 </template>

        <template #form>
            <!-- 会員種別 -->
            <div class="col-span-6 sm:col-span-6">
                <JetLabel for="role" value="会員種別" />
                <JetInput
                    id="email"
                    :value="user.role_label"
                    type="email"
                    class="block w-full mt-1 border-gray-300 disabled:opacity-50"
                    autocomplete="email"
                    disabled
                />
                <JetInputError :message="form.errors.role" class="mt-2" />
            </div>

            <!-- 会員番号 -->
            <div class="col-span-6 sm:col-span-6">
                <JetLabel
                    for="membership_number"
                    value="会員番号（オーナーのみ編集可）"
                />
                <template v-if="user.role_name == 'Owner'">
                    <JetInput
                        id="membership_number"
                        v-model="form.membership_number"
                        type="text"
                        class="block w-full mt-1 border-gray-300 disabled:opacity-50"
                        autocomplete="membership_number"
                    />
                </template>
                <template v-else>
                    <JetInput
                        id="membership_number"
                        :value="user.membership_number"
                        type="text"
                        class="block w-full mt-1 border-gray-300 disabled:opacity-50"
                        autocomplete="membership_number"
                        disabled
                    />
                </template>
                <JetInputError
                    :message="form.errors.membership_number"
                    class="mt-2"
                />
            </div>

            <!-- name -->
            <div class="col-span-6 sm:col-span-6">
                <JetLabel for="name" value="名前" />
                <JetInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="name"
                />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- name_kana-->
            <div class="col-span-6 sm:col-span-6">
                <JetLabel for="name_kana" value="名前（カナ）" />
                <JetInput
                    id="name_kana"
                    v-model="form.name_kana"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="name_kana"
                />
                <JetInputError :message="form.errors.name_kana" class="mt-2" />
            </div>

            <!-- email -->
            <div class="col-span-6 sm:col-span-6">
                <JetLabel
                    for="email"
                    value="メールアドレス（メールアドレスとパスワードは本人のみ編集可能です）"
                />
                <JetInput
                    id="email"
                    :value="user.email"
                    type="email"
                    class="block w-full mt-1 border-gray-300 disabled:opacity-50"
                    autocomplete="email"
                    disabled
                />
                <JetInputError :message="form.errors.email" class="mt-2" />
            </div>

            <!-- 性別 -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="sex_code" value="性別" />
                <select
                    id="sex_code"
                    v-model="form.sex_code"
                    class="w-full max-w-xs mt-1 select select-bordered"
                    @keypress.enter.prevent
                >
                    <option selected>選択して下さい</option>
                    <option
                        v-for="sexOption in sexOptions"
                        :key="sexOption.value"
                        :value="sexOption.value"
                    >
                        {{ sexOption.name }}
                    </option>
                </select>
                <JetInputError :message="form.errors.sex_code" class="mt-2" />
            </div>

            <!-- 生年月日 -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="date_of_birth" value="生年月日" />
                <JetInput
                    id="date_of_birth"
                    v-model="form.date_of_birth"
                    type="date"
                    class="block w-full mt-1"
                    placeholder="1900/1/1"
                    autocomplete="date_of_birth"
                />
                <JetInputError
                    :message="form.errors.date_of_birth"
                    class="mt-2"
                />
            </div>

            <!-- 会員登録時に設定された紹介者コード（親ユーザー） -->
            <div class="col-span-6 sm:col-span-6">
                <JetLabel
                    for="introducer_code"
                    value="会員登録時に設定された紹介者コード（親ユーザー）"
                />
                <JetInput
                    id="email"
                    v-model="form.introducer_code"
                    type="text"
                    class="block w-full mt-1 border-gray-300 disabled:opacity-50"
                />
                <JetInputError
                    :message="form.errors.introducer_code"
                    class="mt-2"
                />
            </div>
            <div v-if="userIntroducer" class="col-span-6 sm:col-span-6">
                <span class="text-sm">この紹介者コードのユーザー（親）：</span>
                <Link
                    :href="route('admin.users.edit', userIntroducer.id)"
                    class="text-sm text-gray-600 underline hover:text-gray-900"
                >
                    {{ userIntroducer.name }}
                </Link>
            </div>

            <!-- 承認 -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="is_approved" value="承認" />
                <select
                    id="is_approved"
                    v-model="form.is_approved"
                    class="w-full max-w-xs mt-1 select select-bordered"
                    @keypress.enter.prevent
                >
                    <option value="0">未確認</option>
                    <option value="1">承認</option>
                    <option value="2">却下</option>
                </select>
                <JetInputError
                    :message="form.errors.is_approved"
                    class="mt-2"
                />
            </div>

            <!-- Kyc承認 -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="is_approved_kyc" value="本人確認書類" />
                <select
                    id="is_approved_kyc"
                    v-model="form.is_approved_kyc"
                    class="w-full max-w-xs mt-1 select select-bordered"
                    @keypress.enter.prevent
                >
                    <option value="0">未確認</option>
                    <option value="1">承認</option>
                    <option value="2">却下</option>
                </select>
                <JetInputError
                    :message="form.errors.is_approved_kyc"
                    class="mt-2"
                />
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                {{ $t('Saved.') }}
            </JetActionMessage>

            <JetButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                {{ $t('Save') }}
            </JetButton>
        </template>
    </JetFormSection>
</template>

<style></style>
