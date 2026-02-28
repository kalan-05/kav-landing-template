<template>
  <section class="pricing-section container" :id="$attrs.id || 'pricing'">
    <h2 class="pricing-section__title">{{ sectionTitle }}</h2>
    <div class="doctors__subtitle" :style="subtitleStyle"><h3>{{ sectionSubtitle }}</h3></div>

    <div class="doctors__team">
      <img class="doctors__team_img" :src="teamImageSrc" width="2200" height="1524" :alt="teamImageAlt" loading="lazy" decoding="async" />
      <div class="doctors__team_subtitle" :style="teamHeadingStyle"><h4>{{ teamHeadingLabel }}</h4></div>
      <div class="doctors__text_trait" :style="descriptionStyle"><p>{{ sectionDescription }}</p></div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';
import teamImageDefault from '@/assets/template/team-photo.svg';

const props = defineProps({
  title: { type: String, default: 'Команда' },
  description: { type: String, default: '' },
  doctors: { type: Array, default: () => [] },
  teamImage: { type: String, default: '' },
  meta: { type: Object, default: () => ({}) },
});

function normalizeAlignment(value, fallback = 'left') {
  const normalized = String(value || '').trim().toLowerCase();
  return ['left', 'center', 'right', 'justify'].includes(normalized) ? normalized : fallback;
}

function normalizeMeta(rawMeta) {
  if (!rawMeta || typeof rawMeta !== 'object') return {};
  if (Array.isArray(rawMeta)) {
    return rawMeta.reduce((acc, row) => {
      if (!row || typeof row !== 'object') return acc;
      const key = String(row.key ?? '').trim();
      if (!key) return acc;
      acc[key] = row.value ?? '';
      return acc;
    }, {});
  }
  return rawMeta;
}

const meta = computed(() => normalizeMeta(props.meta));
const sectionTitle = computed(() => props.title || 'Команда');
const sectionSubtitle = computed(() => String(meta.value.subtitle || '').trim() || 'КЛЮЧЕВЫЕ УЧАСТНИКИ');
const sectionDescription = computed(() => props.description || '');
const teamImageSrc = computed(() => props.teamImage || teamImageDefault);
const teamImageAlt = computed(() => String(meta.value.team_image_alt || '').trim() || 'Команда проекта');
const teamHeadingLabel = computed(() => String(meta.value.team_count_label || '').trim() || 'Ключевые участники');
const subtitleStyle = computed(() => ({ textAlign: normalizeAlignment(meta.value.subtitle_alignment, 'center') }));
const teamHeadingStyle = computed(() => ({ textAlign: normalizeAlignment(meta.value.team_heading_alignment, 'center') }));
const descriptionStyle = computed(() => ({ textAlign: normalizeAlignment(meta.value.content_alignment, 'center') }));
</script>