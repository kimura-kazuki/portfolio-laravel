<template>
    <div class="flex items-center justify-between w-full px-4 py-3 bg-white border-t sm:px-6">
        <div class="hidden lg:block">
            <p class="text-sm leading-5 text-gray-700">
                <span v-if="items.total" class="font-medium">{{ items.total }}</span> 件中
                <span>
                    <span class="font-medium">{{ items.from }}</span> 〜
                    <span class="font-medium">{{ items.to }}</span>
                </span>
                を表示
            </p>
        </div>

        <div class="flex flex-1 md:justify-between lg:justify-end">
            <inertia-link
                v-if="items.prev_page_url"
                :href="items.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700"
                preserve-scroll
            >前へ</inertia-link>

            <button v-else class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-300 bg-white border border-gray-200 rounded-md cursor-default" disabled>
                前へ
            </button>

            <inertia-link
                v-if="items.next_page_url"
                :href="items.next_page_url"
                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700"
                preserve-scroll
            >次へ</inertia-link>

            <button v-else class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-300 bg-white border border-gray-200 rounded-md cursor-default" disabled>
                次へ
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "JetBarSimplePagination",
    props: {
        items: Object,
    },
}
</script>
