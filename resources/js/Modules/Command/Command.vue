<template>
    <div class="flex-1 w-full mr-4 md:w-auto md:flex-none" @click="isOpenDialog = true">
        <button class="relative flex items-center justify-start w-full h-10 px-4 py-2 text-sm font-medium transition-colors border rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input bg-background text-muted-foreground sm:pr-12 md:w-40 lg:w-64">
            <span class="hidden text-gray-400 lg:inline-flex">検索...</span>
            <span class="inline-flex text-gray-400 lg:hidden">検索...</span>
            <kbd class="pointer-events-none absolute right-[9px] top-[9px] hidden h-5 select-none items-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium opacity-100 sm:flex">
                <span class="text-xs">⌘</span>K
            </kbd>
        </button>
    </div>

    <Self :visible="isOpenDialog" @dialog="handleOpenDialog"  @select="handleChangeDialog" />
    <component :is="currentDialog" v-if="isOpenThemeDialog" />
</template>

<script lang="ts" setup>
import { ref, watch, computed } from 'vue'
import { useMagicKeys, onClickOutside } from '@vueuse/core'

import { isDark, toggleDarkmode } from './composables/useDarkmode'
import Linear from './command/Linear.vue'
import Vercel from './command/vercel/Vercel.vue'
import Raycast from './command/raycast/Raycast.vue'
import Self from './command/Self.vue'
import Logo from './icons/Logo.vue'
import SunIcon from './icons/SunIcon.vue'
import MoonIcon from './icons/MoonIcon.vue'

const isOpenDialog = ref(false)
const isOpenThemeDialog = ref(false)
const selectedView = ref('')
// const target = ref(null)
const currentDialog = computed(() => {
  if (selectedView.value === 'Linear') return Linear
  if (selectedView.value === 'Vercel') return Vercel
  if (selectedView.value === 'Raycast') return Raycast
})

const keys = useMagicKeys()
const CmdK = keys['Meta+K']
const Escape = keys['Escape']

const handleChangeDialog = (view = 'self') => {
  const isSelf = view === 'self'
  selectedView.value = view
  isOpenDialog.value = isSelf
  isOpenThemeDialog.value = !isSelf
}
const handleOpenDialog = (value) => {
  if(value){
    isOpenDialog.value = true
  }
  else{
    isOpenDialog.value = false
  }
}

watch(CmdK, (v) => {
  if (v) {
    console.log('Meta + K has been pressed')
    isOpenDialog.value = true
  }
})
watch(Escape, (v) => {
  if (v) {
    console.log('Escape has been pressed')
    isOpenDialog.value = false
    isOpenThemeDialog.value = false
  }
})
// onClickOutside(target, (event) => {
//   console.log('Clicked the outside element of Command K Palette')
//   isOpenDialog.value = false
// })
</script>

<style>
/* @import './assets/css/global.css'; */
</style>
