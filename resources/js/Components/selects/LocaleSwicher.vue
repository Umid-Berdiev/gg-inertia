<script setup>
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const i18n = useI18n();
const locales = usePage().props.value.locales
const setLocale = (event) => {
  Inertia.post(route('set.locale'), {
    lang: event.target.value
  })
};

</script>

<template>
  <select
    v-model="$i18n.locale"
    class="text-uppercase border-0 font-weight-bold text-primary local-select"
    @change="setLocale"
  >
    <option
      v-for="(locale, i) in locales"
      :key="`locale${i}`"
      :value="locale.language_prefix"
    >{{ locale.language_prefix }}</option>
  </select>
</template>

<style lang="scss" scoped>
select.local-select:focus-visible {
  outline-width: 0;
}
</style>
