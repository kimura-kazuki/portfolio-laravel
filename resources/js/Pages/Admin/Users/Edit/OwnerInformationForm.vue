<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { notify } from "notiwind"

import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetTextarea from '@/Jetstream/Textarea.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import JetSectionBorder from '@/Jetstream/SectionBorder.vue';
import JetSectionBorderForm from '@/Jetstream/SectionBorderForm.vue';

import JetBarContainer from "@/Components/JetBar/JetBarContainer.vue";
import JetBarAlert from "@/Components/JetBar/JetBarAlert.vue";
import JetBarStatsContainer from "@/Components/JetBar/JetBarStatsContainer.vue";
import JetBarStatCard from "@/Components/JetBar/JetBarStatCard.vue";
import JetBarTable from "@/Components/JetBar/JetBarTable.vue";
import JetBarTableData from "@/Components/JetBar/JetBarTableData.vue";
import JetBarBadge from "@/Components/JetBar/JetBarBadge.vue";
import JetBarIcon from "@/Components/JetBar/JetBarIcon.vue";
import { isIntegerKey } from '@vue/shared';

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',

    earned_number: props.user.owner_information?.earned_number,
    points: props.user.owner_information?.points,
    right: props.user.owner_information?.right,
});

const editUserBankAccount = () => {
    form.post(route('admin.users.update.owner-information', props.user.id), {
        errorBag: 'adminOwnerInformationUpdate',
        preserveScroll: true,
        onSuccess: (page) => {
            notify({
                group: "success",
                title: "Success",
                text: page.props.flash.message,
            }, 5000);
        },
        onError: (errors) => {
            notify({
                group: "error",
                title: "Error",
                text: errors.message,
            }, 5000);
        },
    });
};
</script>

<template>
    <JetFormSection @submitted="editUserBankAccount" class="mt-10 sm:mt-0">
        <template #title>
            オーナー情報
        </template>

        <template #description>
            オーナー情報を編集します。
        </template>

        <template #form>
            <!-- 獲得口数 -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="earned_number" value="獲得口数" />
                <JetInput
                    id="earned_number"
                    v-model="form.earned_number"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="earned_number"
                />
                <JetInputError :message="form.errors.earned_number" class="mt-2" />
            </div>

            <!-- 獲得ポイント -->
            <!-- <div class="col-span-6 sm:col-span-4">
                <JetLabel for="points" value="獲得ポイント" />
                <JetInput
                    id="points"
                    v-model="form.points"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="points"
                />
                <JetInputError :message="form.errors.points" class="mt-2" />
            </div> -->

            <!-- 権利の表記 -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="right" value="権利の表記" />
                <JetInput
                    id="right"
                    v-model="form.right"
                    type="text"
                    class="block w-full mt-1"
                    autocomplete="right"
                />
                <JetInputError :message="form.errors.right" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                {{ $t('Saved.') }}
            </JetActionMessage>

            <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ $t('Save') }}
            </JetButton>
        </template>
    </JetFormSection>
</template>

<style>
</style>
