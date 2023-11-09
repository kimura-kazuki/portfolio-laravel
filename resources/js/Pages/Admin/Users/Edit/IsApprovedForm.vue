<script setup>
// import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import route from 'ziggy-js';

import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';

const props = defineProps({
    user: Object,
    isApprovedOptions: Object,
});

const form = useForm({
    _method: 'PUT',
    is_approved: props.user.is_approved,
});

const editUserIsApproved = () => {
    form.post(route('admin.users.update.is-approved', props.user.id), {
        errorBag: 'adminUserIsApprovedUpdate',
        preserveScroll: true,
        onSuccess: () => {
            // console.log('success');
        },
        onError: (errors) => {
            console.log(errors);
        },
    });
};
</script>

<template>
    <JetFormSection
        class="mt-10 sm:mt-0"
        @submitted="editUserIsApproved"
    >
        <template #title> 申請手続き </template>

        <template #description> アカウントの申請手続きをします。 </template>

        <template #form>
            <!-- 承認フラグ -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="is_approved" value="承認フラグ" />
                <select
                    id="is_approved"
                    v-model="form.is_approved"
                    class="w-full max-w-xs mt-1 select select-bordered"
                    @keypress.enter.prevent
                >
                    <option selected>選択して下さい</option>
                    <option
                        v-for="isApprovedOption in isApprovedOptions"
                        :key="isApprovedOption.value"
                        :value="isApprovedOption.value"
                    >
                        {{ isApprovedOption.name }}
                    </option>
                </select>
                <JetInputError
                    :message="form.errors.is_approved"
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
