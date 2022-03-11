<script setup>
import useWells from '@/features/composables/useWells';
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import WellSelect from '../selects/WellSelect.vue';

const props = defineProps({
  exportRoute: String
})
const { t } = useI18n();
const { getSelectedWell } = useWells();
const currentYear = ref(new Date().getFullYear());

</script>

<template>
  <div
    class="modal fade"
    id="exportModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="importModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <form :action="route(exportRoute)" method="get" class="modal-content">
        <input type="hidden" name="well_id" :value="getSelectedWell.id" />
        <div class="modal-header">
          <h5
            class="modal-title"
            id="importModalLabel"
          >{{ t('messages.Экспорт') }}</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          >
            <i class="bi bi-x" />
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <WellSelect label-by="cadaster_number" required />
            </div>
            <div class="col">
              <input
                required
                type="number"
                min="1970"
                :max="currentYear"
                name="year1"
                class="form-control"
                :placeholder="t('messages.Год')"
              />
            </div>
            <div class="col">
              <input
                required
                type="number"
                min="1970"
                :max="currentYear"
                name="year2"
                class="form-control"
                :placeholder="t('messages.Год')"
              />
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            {{
              t('messages.Закрыть')
            }}
          </button>
          <button
            type="submit"
            class="btn btn-primary"
          >{{ t("messages.Сохранить") }}</button>
        </div>
      </form>
    </div>
  </div>
</template>
