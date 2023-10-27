<template>
    <div class="flex flex-col overflow-x-auto overflow-y-hidden" id="jet-bar-table-wrap">
        <div class="-my-2 sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th v-for="(header, index) in headers" :key="index" scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ header }}

                                <!-- <button type="button" class="inline-flex items-center rounded cursor-pointer focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600" dusk="sort-id" aria-sort="none">
                                    <span class="inline-flex tracking-wide text-gray-500 uppercase text-xxs">
                                        {{ header }}
                                    </span>
                                    <svg class="flex-shrink-0 ml-2" xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14">
                                        <path class="fill-gray-300 dark:fill-gray-500" d="M1.70710678 4.70710678c-.39052429.39052429-1.02368927.39052429-1.41421356 0-.3905243-.39052429-.3905243-1.02368927 0-1.41421356l3-3c.39052429-.3905243 1.02368927-.3905243 1.41421356 0l3 3c.39052429.39052429.39052429 1.02368927 0 1.41421356-.39052429.39052429-1.02368927.39052429-1.41421356 0L4 2.41421356 1.70710678 4.70710678z"></path>
                                        <path class="fill-gray-300 dark:fill-gray-500" d="M6.29289322 9.29289322c.39052429-.39052429 1.02368927-.39052429 1.41421356 0 .39052429.39052429.39052429 1.02368928 0 1.41421358l-3 3c-.39052429.3905243-1.02368927.3905243-1.41421356 0l-3-3c-.3905243-.3905243-.3905243-1.02368929 0-1.41421358.3905243-.39052429 1.02368927-.39052429 1.41421356 0L4 11.5857864l2.29289322-2.29289318z"></path>
                                    </svg>
                                </button> -->

                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <slot />
                        </tbody>
                    </table>

                    <slot name="pagination" />

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "JetBarTable",
    data() {
        return {
            items: 3,
        }
    },
    props: {
        headers: {
            type: Array,
            required: true
        },
    }
}
</script>
<style>
@media (min-width: 1024px) {
    #jet-bar-table-wrap {
        width: calc(95vw - 16rem);
        max-width: 100%;
    }
}
</style>
