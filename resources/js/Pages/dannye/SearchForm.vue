<script setup>
import { Inertia } from '@inertiajs/inertia';
import { computed, onUpdated, reactive, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import WellSelect from '@/Components/selects/WellSelect.vue';
import useYear from '@/features/composables/useYear.js'

const { t } = useI18n();
const { setSelectedYear, getSelectedYear } = useYear();
const selectedYear = computed({
  get: () => getSelectedYear.value,
  set: (val) => {
    setSelectedYear(val)
  }
});

</script>

<template>
  <div class="row g-3">
    <div class="col-sm-auto">
      <WellSelect label-by="number_auther" />
    </div>
    <div class="col-sm-auto">
      <WellSelect label-by="cadaster_number" />
    </div>
    <div class="col-sm-auto">
      <input
        required
        type="number"
        min="1900"
        :max="new Date().getFullYear()"
        name="year"
        v-model="selectedYear"
        class="form-control"
        :placeholder="t('messages.Год')"
      />
    </div>
    <div class="col-sm-auto">
      <button type="submit" class="btn btn-primary">{{ t('messages.Открыть') }}</button>
    </div>
    <div
      v-if="$page.url.startsWith('/dannye/waterlevel') && $page.props.auth.user.roles.some(role => role.name === 'Administrator')"
      class="col-sm-auto"
    >
      <!-- Button trigger interpolation modal -->
      <button
        type="button"
        class="btn btn-warning"
        data-bs-toggle="modal"
        data-bs-target="#interpolationModal"
        id="interpolation-modal-button"
      >{{ t("messages.Interpolation") }}</button>
    </div>
  </div>
</template>

