<template>
  <div
    class="modal fade"
    id="interpolationModal"
    tabindex="-1"
    aria-labelledby="interpolationModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5
            class="modal-title text-black"
            id="interpolationModalLabel"
          >{{ $t('messages.Create_interpolation') }}</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="handleSubmit">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label" for="region_id">
                {{ $t('messages.Region') }}
                <span class="text-danger">*</span>
              </label>
              <select
                class="form-control select-modal-region"
                name="region_id"
                id="region_id"
                required
              >
                <option disabled selected>{{ $t('messages.Choose') }}</option>
                <option
                  v-for="region in regions"
                  :value="region.id"
                >{{ region.name }}</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label" for="year">
                {{ $t('messages.Год') }}
                <span class="text-danger">*</span>
              </label>
              <input
                id="year"
                required
                type="number"
                min="1900"
                :max="new Date().getFullYear()"
                name="year"
                class="form-control"
                :placeholder="$t('messages.Год')"
              />
            </div>
            <div class>
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  name="column_name"
                  id="inlineRadio1"
                  value="min"
                  checked
                />
                <label
                  class="form-check-label"
                  for="inlineRadio1"
                >{{ $t('messages.min') }}</label>
              </div>
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="radio"
                  name="column_name"
                  id="inlineRadio2"
                  value="max"
                />
                <label
                  class="form-check-label"
                  for="inlineRadio2"
                >{{ $t('messages.max') }}</label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="submit"
              class="btn btn-success"
            >{{ $t("messages.Выполнить") }}</button>
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              {{
                $t("messages.Close")
              }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';

const props = defineProps({
  regions: Array
});

// const { regions } = usePage();

function handleSubmit(event) {
  Inertia.post(route('waterlevel-create-interpolation'), Object.fromEntries(new FormData(event.target)))
}
</script>
