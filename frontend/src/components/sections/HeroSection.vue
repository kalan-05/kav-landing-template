<template>
  <section class="hero" :id="$attrs.id || 'hero'" :style="{ '--hero': `url('${heroBackground}')` }" aria-label="Первый экран">
    <div class="container hero__inner">
      <div class="hero__content">
        <h2 class="hero__subtitle">{{ sectionSubtitle }}</h2>
        <h1 class="hero__title">{{ sectionTitle }}</h1>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';
import heroImg from '@/assets/template/hero-cover.svg';

const props = defineProps({
  subtitle: { type: String, default: '' },
  title: { type: String, default: '' },
  backgroundImage: { type: String, default: '' },
  meta: { type: Object, default: () => ({}) },
});

const sectionSubtitle = computed(() => props.subtitle || 'Современный сервис');
const sectionTitle = computed(() => props.title || 'с управляемым контентом');
const heroBackground = computed(() => props.backgroundImage || heroImg);
</script>