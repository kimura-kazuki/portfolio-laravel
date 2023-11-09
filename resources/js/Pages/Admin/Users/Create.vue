<script setup>
// import { Head, Link, router } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';
import route from 'ziggy'

import { notify } from 'notiwind';

import AppLayout from '@/Layouts/AppLayout.vue';

import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
// import JetTextarea from '@/Jetstream/Textarea.vue';
// import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
// import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import JetSectionBorderForm from '@/Jetstream/SectionBorderForm.vue';

import JetBarContainer from '@/Components/JetBar/JetBarContainer.vue';
import JetBarAlert from '@/Components/JetBar/JetBarAlert.vue';
// import JetBarStatsContainer from '@/Components/JetBar/JetBarStatsContainer.vue';
// import JetBarStatCard from '@/Components/JetBar/JetBarStatCard.vue';
// import JetBarTable from '@/Components/JetBar/JetBarTable.vue';
// import JetBarTableData from '@/Components/JetBar/JetBarTableData.vue';
// import JetBarBadge from '@/Components/JetBar/JetBarBadge.vue';
// import JetBarIcon from '@/Components/JetBar/JetBarIcon.vue';

defineProps({
    sexOptions: Object,
    // isApprovedOptions: Object,
    bankAccountHolderTypeCodeOptions: Object,
    userRoles: Object,
});

const form = useForm('post', route('admin.users.store'), {
    role: '',

    email: '',
    password: '',
    password_confirmation: '',

    name: '',
    name_kana: '',
    company_name: '',
    phone: '',
    date_of_birth: '',

    bank_name: '',
    bank_branch_name: '',
    bank_account_holder_type_code: '',
    bank_account_number: '',
    bank_account_holder_name: '',

    introducer_code: '',
});

const bankAccountHolderTypeOptions = [
    {
        code: '1',
        name: '当座預金',
    },
    {
        code: '2',
        name: '普通預金',
    },
];

const createUserByAdmin = () => {
    form.post(route('admin.users.store'), {
        errorBag: 'adminUserStore',
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
                <!-- <a @click="back()" class="gap-2 normal-case btn btn-sm md:btn-md btn-ghost lg:gap-3">
                    <svg class="w-6 h-6 fill-current md:h-8 md:w-8" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z"></path></svg>
                    <div class="flex flex-col items-start">
                        <span class="hidden text-xs font-normal text-base-content/50 md:block">戻る</span>
                        <span>Back</span>
                    </div>
                </a> -->
            </div>
        </template>

        <template #header> ユーザー新規追加 </template>

        <JetBarContainer>
            <JetBarAlert :text="$page.props.flash.message" />

            <JetFormSection @submitted="createUserByAdmin">
                <template #title> ユーザー情報 </template>

                <template #description> ユーザー情報を追加します。 </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel for="role" value="役割" />
                        <select
                            id="role"
                            v-model="form.role"
                            class="border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full mt-1 p-2.5"
                            @keypress.enter.prevent
                        >
                            <option disabled selected>選択して下さい</option>
                            <option
                                v-for="(userRole, index) in userRoles"
                                :key="index"
                                :value="index"
                            >
                                {{ userRole }}
                            </option>
                        </select>
                        <JetInputError
                            :message="form.errors.role"
                            class="mt-2"
                        />
                    </div>

                    <JetSectionBorderForm />

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel for="email" value="メールアドレス" />
                        <JetInput
                            id="email"
                            v-model="form.email"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="email"
                            @change="form.validate('email')"
                        />
                        <JetInputError
                            :message="form.errors.email"
                            class="mt-2"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel
                            for="password"
                            value="パスワード（8桁以上で入力してください）"
                        />
                        <JetInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="block w-full mt-1"
                            autocomplete="password"
                            @change="form.validate('password')"
                        />
                        <JetInputError
                            :message="form.errors.password"
                            class="mt-2"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel
                            for="password_confirmation"
                            value="パスワード（確認用）"
                        />
                        <JetInput
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="block w-full mt-1"
                            autocomplete="password_confirmation"
                            @change="form.validate('password_confirmation')"
                        />
                        <JetInputError
                            :message="form.errors.password_confirmation"
                            class="mt-2"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel for="name" value="お名前" />
                        <JetInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="name"
                            @change="form.validate('name')"
                        />
                        <JetInputError
                            :message="form.errors.name"
                            class="mt-2"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel for="name_kana" value="お名前（カナ）" />
                        <JetInput
                            id="name_kana"
                            v-model="form.name_kana"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="name_kana"
                            @change="form.validate('name_kana')"
                        />
                        <JetInputError
                            :message="form.errors.name_kana"
                            class="mt-2"
                        />
                    </div>

                    <!-- <div class="col-span-6 sm:col-span-6">
                        <JetLabel for="company_name" value="会社名" />
                        <JetInput
                            id="company_name"
                            v-model="form.company_name"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="company_name"
                        />
                        <JetInputError :message="form.errors.company_name" class="mt-2" />
                    </div> -->

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel
                            for="phone"
                            value="電話番号（ハイフンなしで入力してください）"
                        />
                        <JetInput
                            id="phone"
                            v-model="form.phone"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="phone"
                            @change="form.validate('phone')"
                        />
                        <JetInputError
                            :message="form.errors.phone"
                            class="mt-2"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel for="date_of_birth" value="生年月日" />
                        <jetInput
                            id="date_of_birth"
                            v-model="form.date_of_birth"
                            type="date"
                            class="block w-full mt-1"
                            autocomplete="date_of_birth"
                            @change="form.validate('date_of_birth')"
                        />
                        <JetInputError
                            :message="form.errors.date_of_birth"
                            class="mt-2"
                        />
                    </div>

                    <JetSectionBorderForm />

                    <div class="col-span-6 sm:col-span-4">
                        <p>振込先の銀行口座情報を入力してください。</p>
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel for="bank_name" value="銀行名" />
                        <JetInput
                            id="bank_name"
                            v-model="form.bank_name"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="bank_name"
                        />
                        <JetInputError
                            :message="form.errors.bank_name"
                            class="mt-2"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel for="bank_branch_name" value="銀行支店名" />
                        <JetInput
                            id="bank_branch_name"
                            v-model="form.bank_branch_name"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="bank_branch_name"
                        />
                        <JetInputError
                            :message="form.errors.bank_branch_name"
                            class="mt-2"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel
                            for="bank_account_holder_type_code"
                            value="口座種別"
                        />
                        <select
                            id="bank_account_holder_type_code"
                            v-model="form.bank_account_holder_type_code"
                            class="border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full mt-1 p-2.5"
                            @keypress.enter.prevent
                        >
                            <option selected>選択して下さい</option>
                            <option
                                v-for="bankAccountHolderTypeOption in bankAccountHolderTypeOptions"
                                :key="bankAccountHolderTypeOption.code"
                                :value="bankAccountHolderTypeOption.code"
                            >
                                {{ bankAccountHolderTypeOption.name }}
                            </option>
                        </select>
                        <JetInputError
                            :message="form.errors.bank_account_holder_type_code"
                            class="mt-2"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel for="bank_account_number" value="口座番号" />
                        <JetInput
                            id="bank_account_number"
                            v-model="form.bank_account_number"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="bank_account_number"
                        />
                        <JetInputError
                            :message="form.errors.bank_account_number"
                            class="mt-2"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel
                            for="bank_account_holder_name"
                            value="口座名義"
                        />
                        <JetInput
                            id="bank_account_holder_name"
                            v-model="form.bank_account_holder_name"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="bank_account_holder_name"
                        />
                        <JetInputError
                            :message="form.errors.bank_account_holder_name"
                            class="mt-2"
                        />
                    </div>

                    <JetSectionBorderForm />

                    <div class="col-span-6 sm:col-span-6">
                        <JetLabel for="introducer_code" value="紹介者コード" />
                        <JetInput
                            id="introducer_code"
                            v-model="form.introducer_code"
                            type="text"
                            class="block w-full mt-1"
                            autocomplete="introducer_code"
                        />
                        <JetInputError
                            :message="form.errors.introducer_code"
                            class="mt-2"
                        />
                    </div>
                </template>

                <template #actions>
                    <JetActionMessage
                        :on="form.recentlySuccessful"
                        class="mr-3"
                    >
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
        </JetBarContainer>
    </AppLayout>
</template>
