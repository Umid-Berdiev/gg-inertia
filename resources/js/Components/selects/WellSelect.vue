<script setup>
import useWells from '@/features/composables/useWells.js'
import { computed, inject } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const { setSelectedWell, getSelectedWell } = useWells();
const props = defineProps({
  labelBy: String
});
const selectedWell = computed({
  get: () => getSelectedWell.value,
  set: (val) => {
    setSelectedWell(val)
  }
});
const wells = inject('wells');
const wellError = inject('wellError');

</script>

<template>
  <VueSelect
    searchable
    class="p-1"
    v-model="selectedWell"
    :options="wells"
    :label-by="labelBy"
    close-on-select
    :placeholder="t('messages.Авторский номер')"
  />
  <div class="is-invalid text-danger">{{ wellError }}</div>
</template>
