<script setup>
import { computed, onMounted, ref } from 'vue';
import { useHead } from '@unhead/vue';

import HeroSection from '@/components/sections/HeroSection.vue';
import AboutSection from '@/components/sections/AboutSection.vue';
import ServicesSection from '@/components/sections/ServicesSection.vue';
import PricingSection from '@/components/sections/PricingSection.vue';
import GallerySection from '@/components/sections/GallerySection.vue';
import ReviewsSection from '@/components/sections/ReviewsSection.vue';
import ContactSection from '@/components/sections/ContactSection.vue';
import MapSection from '@/components/sections/MapSection.vue';

import heroCover from '@/assets/template/hero-cover.svg';
import { fetchSiteContent } from '@/js/siteContentApi';
import { mergeSiteSettings } from '@/js/defaultSiteSettings';

const settings = ref(null);
const blocks = ref([]);
const doctors = ref([]);
const services = ref([]);
const galleryItems = ref([]);

const fallbackBlocks = [
  { key: 'hero', title: 'Современный сервис', content: 'с управляемым контентом', is_enabled: true, sort_order: 10, meta: { section_id: 'hero' } },
  { key: 'about', title: 'О проекте', content: '', is_enabled: true, sort_order: 20, meta: { section_id: 'about' } },
  { key: 'services', title: 'Предложения', content: '', is_enabled: true, sort_order: 30, meta: { section_id: 'services' } },
  { key: 'doctors', title: 'Команда', content: '', is_enabled: true, sort_order: 40, meta: { section_id: 'pricing' } },
  { key: 'gallery', title: 'Галерея', content: '', is_enabled: true, sort_order: 50, meta: { section_id: 'gallery' } },
  { key: 'reviews', title: 'Отзывы', content: '', is_enabled: true, sort_order: 60, meta: { section_id: 'reviews' } },
  { key: 'contact', title: 'Контакты', content: '', is_enabled: true, sort_order: 70, meta: { section_id: 'contact' } },
  { key: 'map', title: 'Как нас найти', content: 'Контактная информация', is_enabled: true, sort_order: 80, meta: { section_id: 'map-section' } },
];

const sectionRegistry = {
  hero: { component: HeroSection, defaultId: 'hero' },
  about: { component: AboutSection, defaultId: 'about' },
  services: { component: ServicesSection, defaultId: 'services' },
  doctors: { component: PricingSection, defaultId: 'pricing' },
  gallery: { component: GallerySection, defaultId: 'gallery' },
  reviews: { component: ReviewsSection, defaultId: 'reviews' },
  contact: { component: ContactSection, defaultId: 'contact' },
  map: { component: MapSection, defaultId: 'map-section' },
};

function normalizeBlockMeta(rawMeta) {
  if (!rawMeta) return {};
  if (typeof rawMeta === 'string') {
    try {
      const parsed = JSON.parse(rawMeta);
      return parsed && typeof parsed === 'object' ? parsed : {};
    } catch {
      return {};
    }
  }
  if (Array.isArray(rawMeta)) {
    return rawMeta.reduce((acc, row) => {
      if (!row || typeof row !== 'object') return acc;
      const key = String(row.key ?? row.name ?? '').trim();
      if (!key) return acc;
      acc[key] = row.value ?? row.val ?? '';
      return acc;
    }, {});
  }
  return typeof rawMeta === 'object' ? rawMeta : {};
}

function getBlockMeta(block) {
  return normalizeBlockMeta(block?.meta);
}

const effectiveSettings = computed(() => mergeSiteSettings(settings.value || {}));

const normalizedBlocks = computed(() => {
  const source = Array.isArray(blocks.value) && blocks.value.length > 0 ? blocks.value : fallbackBlocks;
  return source.filter((block) => block && sectionRegistry[block.key]).sort((a, b) => (Number(a.sort_order) || 0) - (Number(b.sort_order) || 0));
});

function resolveSectionId(block) {
  const key = block?.key;
  const registry = key ? sectionRegistry[key] : null;
  const meta = getBlockMeta(block);
  const fromMeta = meta.section_id;
  if (typeof fromMeta === 'string' && fromMeta.trim() !== '') return fromMeta.trim();
  return registry?.defaultId || key || 'section';
}

function resolveSectionProps(block) {
  const key = block.key;
  const meta = getBlockMeta(block);

  switch (key) {
    case 'hero':
      return { subtitle: block.title || 'Современный сервис', title: block.content || 'с управляемым контентом', backgroundImage: effectiveSettings.value.media.hero_image_url || heroCover, meta };
    case 'about':
      return { title: block.title || 'О проекте', content: block.content || '', meta };
    case 'services':
      return { title: block.title || 'Предложения', description: block.content || '', items: services.value, meta };
    case 'doctors':
      return { title: block.title || 'Команда', description: block.content || '', doctors: doctors.value, teamImage: effectiveSettings.value.media.team_image_url || '', meta };
    case 'gallery':
      return { title: block.title || 'Галерея', items: galleryItems.value, meta };
    case 'reviews':
      return { title: block.title || 'Отзывы', doctors: doctors.value, meta };
    case 'contact':
      return { title: block.title || 'Контакты', settings: effectiveSettings.value, meta };
    case 'map':
      return { title: block.title || 'Как нас найти', subtitle: meta.subtitle || block.content || 'Контактная информация', settings: effectiveSettings.value, meta };
    default:
      return {};
  }
}

const sectionsToRender = computed(() => normalizedBlocks.value.filter((block) => block.is_enabled !== false).map((block) => ({ key: block.key, component: sectionRegistry[block.key].component, id: resolveSectionId(block), props: resolveSectionProps(block) })));

const envSiteUrl = String(import.meta.env.VITE_SITE_URL || '').trim();
const canonicalBaseUrl = computed(() => {
  const candidate = envSiteUrl || (typeof window !== 'undefined' ? window.location.origin : '');
  return candidate.replace(/\/$/, '');
});
const canonicalUrl = computed(() => (canonicalBaseUrl.value ? `${canonicalBaseUrl.value}/` : ''));
const sameAs = computed(() => Object.values(effectiveSettings.value.social || {}).filter(Boolean));
const seoKeywords = computed(() => Array.isArray(effectiveSettings.value.seo.keywords) ? effectiveSettings.value.seo.keywords.join(', ') : String(effectiveSettings.value.seo.keywords || ''));
const ogImageUrl = computed(() => effectiveSettings.value.og_image_url || effectiveSettings.value.media.hero_image_url || heroCover);

const organizationSchema = computed(() => ({
  '@context': 'https://schema.org',
  '@type': 'Organization',
  name: effectiveSettings.value.site_name || 'Экспертный проект',
  description: effectiveSettings.value.seo.description,
  url: canonicalUrl.value,
  image: ogImageUrl.value,
  telephone: effectiveSettings.value.phones?.[0] || '',
  email: effectiveSettings.value.email,
  address: {
    '@type': 'PostalAddress',
    streetAddress: effectiveSettings.value.address_main,
    addressCountry: 'RU',
  },
  geo: {
    '@type': 'GeoCoordinates',
    latitude: effectiveSettings.value.map.lat,
    longitude: effectiveSettings.value.map.lng,
  },
  openingHours: effectiveSettings.value.worktime_main,
  sameAs: sameAs.value,
}));

useHead(() => ({
  title: effectiveSettings.value.seo.title,
  meta: [
    { name: 'description', content: effectiveSettings.value.seo.description },
    { name: 'keywords', content: seoKeywords.value },
    { name: 'robots', content: 'index, follow' },
    { property: 'og:title', content: effectiveSettings.value.seo.title },
    { property: 'og:description', content: effectiveSettings.value.seo.description },
    { property: 'og:type', content: 'website' },
    { property: 'og:url', content: canonicalUrl.value },
    { property: 'og:image', content: ogImageUrl.value },
    { name: 'twitter:card', content: 'summary_large_image' },
    { name: 'twitter:title', content: effectiveSettings.value.seo.title },
    { name: 'twitter:description', content: effectiveSettings.value.seo.description },
    { name: 'twitter:image', content: ogImageUrl.value },
  ],
  link: canonicalUrl.value ? [
    { rel: 'canonical', href: canonicalUrl.value },
    { rel: 'alternate', hreflang: 'ru-RU', href: canonicalUrl.value },
    { rel: 'alternate', hreflang: 'x-default', href: canonicalUrl.value },
  ] : [],
  script: [{ type: 'application/ld+json', children: JSON.stringify(organizationSchema.value) }],
}));

onMounted(async () => {
  const content = await fetchSiteContent();
  settings.value = content.settings;
  blocks.value = Array.isArray(content.blocks) ? content.blocks : [];
  doctors.value = Array.isArray(content.doctors) ? content.doctors : [];
  services.value = Array.isArray(content.services) ? content.services : [];
  galleryItems.value = Array.isArray(content.gallery) ? content.gallery : [];
});
</script>

<template>
  <component :is="section.component" v-for="section in sectionsToRender" :key="section.key" :id="section.id" v-bind="section.props" />
</template>