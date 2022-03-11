<script setup>
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  importUrl: String,
  templateUrl: String
});

function handleSubmit(event) {
  Inertia.post(route(props.importUrl), Object.fromEntries(new FormData(event.target)))
}
</script>

<template>
  <div
    class="modal fade"
    id="importModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="importModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <form
        @submit.prevent="handleSubmit"
        enctype="multipart/form-data"
        class="modal-content"
      >
        <div class="modal-header bg-light">
          <h4
            class="modal-title"
            id="importModalLabel"
          >{{ $t('messages.Импорт') }}</h4>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="custom-file">
            <!-- <label
              class="custom-file-label"
              for="customFile"
              data-bs-browse="{{ $t('messages.Browse') }}"
            >{{ $t('messages.Выбрать файл') }}</label>-->
            <input
              type="file"
              required
              name="select_file"
              class="form-control rounded-lg"
              id="customFile"
            />
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <a
            v-if="templateUrl"
            class="btn btn-success text-white"
            :href="route(templateUrl)"
          >
            <i class="bi bi-download"></i>
            {{ $t('messages.Скачать шаблон') }}
          </a>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >{{ $t('messages.Закрыть') }}</button>
          <button
            type="submit"
            class="btn btn-primary"
          >{{ $t("messages.Сохранить") }}</button>
        </div>
      </form>
    </div>
  </div>
</template>

