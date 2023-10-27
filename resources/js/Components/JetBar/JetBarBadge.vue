<template>
    <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full" :class="badgeColors">{{ text }}</span>
</template>

<script>
export default {
    name: "JetBarBadge",
    props: {
        text: {
            type: String,
            required: true
        },
        type: {
            type: String,
            default: 'info',
            validator: (value) => {
                return ['info', 'success', 'warning', 'danger'].includes(value);
            }
        }
    },
    computed: {
        badgeColors(){
            const colors = {
                "info":"bg-blue-100 text-blue-800 px-3 py-0.5",
                "success": "bg-green-100 text-green-800 px-3 py-0.5",
                "warning":"bg-yellow-100 text-yellow-800 px-3 py-0.5",
                "danger":"bg-red-100 text-red-800 px-3 py-0.5",
                "normal":"bg-gray-100 text-gray-800 px-3 py-0.5",

                "orange":"bg-orange-100 text-orange-800 px-3 py-0.5",
                "amber":"bg-amber-100 text-amber-800 px-3 py-0.5",
                "lime":"bg-lime-100 text-lime-800 px-3 py-0.5",
                "teal":"bg-teal-100 text-teal-800 px-3 py-0.5",
                "sky":"bg-sky-100 text-sky-800 px-3 py-0.5",
                "indigo":"bg-indigo-100 text-indigo-800 px-3 py-0.5",
                "pink":"bg-pink-100 text-pink-800 px-3 py-0.5",
                "rose":"bg-rose-100 text-rose-800 px-3 py-0.5",

                "info-outline": "border border-current px-3 py-0.5 uppercase tracking-wide text-blue-500",
                "success-outline": "border border-current px-3 py-0.5 uppercase tracking-wide text-green-500",
                "warning-outline": "border border-current px-3 py-0.5 uppercase tracking-wide text-yellow-500",
                "danger-outline": "border border-current px-3 py-0.5 uppercase tracking-wide text-red-500",
                "normal-outline": "border border-current px-3 py-0.5 uppercase tracking-wide text-gray-500",
            }
            return colors[this.type];
        }
    }
}
</script>
