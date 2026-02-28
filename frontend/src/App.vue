<template>
  <div class="layout">
    <Header :settings="resolvedSettings" />

    <main class="layout__main">
      <router-view />
    </main>

    <Footer :settings="resolvedSettings" />
  </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'
import { fetchSettings } from '@/js/siteContentApi'
import { applyThemeVariables, mergeSiteSettings } from '@/js/defaultSiteSettings'

const settings = ref(null)
const resolvedSettings = computed(() => mergeSiteSettings(settings.value || {}))

watch(
  resolvedSettings,
  (value) => {
    applyThemeVariables(value)
  },
  { immediate: true, deep: true },
)

onMounted(async () => {
  settings.value = await fetchSettings()
})
</script>
