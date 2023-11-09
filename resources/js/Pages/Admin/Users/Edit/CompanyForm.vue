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

const props = defineProps({
    user: Object,
    userCompany: Object,
});

const form = useForm({
    _method: 'PUT',
    company_id: props.userCompany?.company_id,
    company_name: props.userCompany?.company_name,
    representative: props.userCompany?.representative,
    address: props.userCompany?.address,
    phone: props.userCompany?.phone,
});

const editUserCompany = () => {
    form.post(route('admin.users.update.company', props.user.id), {
        errorBag: 'adminUserCompanyUpdate',
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
        @submitted="editUserCompany"
    >
        <template #title> 会社情報 </template>

        <template #description> 会社情報を編集します。 </template>

        <template #form>
            <!-- 会社名 -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="company_name" value="会社名" />
                <JetInput
                    id="company_name"
                    v-model="form.company_name"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="company_name"
                />
                <JetInputError
                    :message="form.errors.company_name"
                    class="mt-2"
                />
            </div>

            <!-- 代表者名 -->
            <div class="col-span-6 sm:col-span-6">
                <JetLabel for="representative" value="代表者名" />
                <JetInput
                    id="representative"
                    v-model="form.representative"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="representative"
                />
                <JetInputError
                    :message="form.errors.representative"
                    class="mt-2"
                />
            </div>

            <!-- 住所 -->
            <div class="col-span-6 sm:col-span-6">
                <JetLabel for="address" value="住所" />
                <JetInput
                    id="address"
                    v-model="form.address"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="address"
                />
                <JetInputError :message="form.errors.address" class="mt-2" />
            </div>

            <!-- Phone -->
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
                />
                <JetInputError :message="form.errors.phone" class="mt-2" />
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
