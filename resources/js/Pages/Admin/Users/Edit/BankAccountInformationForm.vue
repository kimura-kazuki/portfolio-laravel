<script setup>
// import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
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
    userBank: Object,
    bankAccountHolderTypeCodeOptions: Object,
});

const form = useForm({
    _method: 'PUT',

    bank_name: props.userBank?.bank_name,
    bank_branch_name: props.userBank?.bank_branch_name,
    bank_account_holder_type_code:
        props.userBank?.bank_account_holder_type_code,
    bank_account_number: props.userBank?.bank_account_number,
    bank_account_holder_name: props.userBank?.bank_account_holder_name,
});

const editUserBankAccount = () => {
    form.post(route('admin.users.update.bank-account', props.user.id), {
        errorBag: 'adminUserBankAccountUpdate',
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
            notify(
                {
                    group: 'error',
                    title: 'Error',
                    text: errors.message,
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
        @submitted="editUserBankAccount"
    >
        <template #title> 銀行口座情報 </template>

        <template #description> 銀行口座情報を編集します。 </template>

        <template #form>
            <!-- 銀行名 -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="bank_name" value="銀行名" />
                <JetInput
                    id="bank_name"
                    v-model="form.bank_name"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="bank_name"
                />
                <JetInputError :message="form.errors.bank_name" class="mt-2" />
            </div>

            <!-- 銀行支店名 -->
            <div class="col-span-6 sm:col-span-4">
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

            <!-- 口座種別 -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel
                    for="bank_account_holder_type_code"
                    value="口座種別"
                />
                <select
                    id="bank_account_holder_type_code"
                    v-model="form.bank_account_holder_type_code"
                    class="w-full max-w-xs mt-1 select select-bordered"
                    @keypress.enter.prevent
                >
                    <option selected>選択して下さい</option>
                    <option
                        v-for="bankAccountHolderTypeCodeOption in bankAccountHolderTypeCodeOptions"
                        :key="bankAccountHolderTypeCodeOption.value"
                        :value="bankAccountHolderTypeCodeOption.value"
                    >
                        {{ bankAccountHolderTypeCodeOption.name }}
                    </option>
                </select>
                <JetInputError
                    :message="form.errors.bank_account_holder_type_code"
                    class="mt-2"
                />
            </div>

            <!-- 口座番号 -->
            <div class="col-span-6 sm:col-span-4">
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

            <!-- 口座名義 -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="bank_account_holder_name" value="口座名義" />
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
