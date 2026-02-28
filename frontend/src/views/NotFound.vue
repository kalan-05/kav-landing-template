<script setup>
import { useHead } from '@unhead/vue';

useHead({
  title: '404 - Страница не найдена | KAV Landing Template',
  meta: [
    { name: 'robots', content: 'noindex, nofollow, noarchive' },
  ],
  link: [
    { rel: 'canonical', href: 'https://example.com/' },
  ],
});
</script>

<template>
  <section class="container notfound">
    <h1>404 - Страница не найдена</h1>
  </section>
</template>