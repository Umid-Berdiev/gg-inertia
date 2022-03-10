<template>
  <div
    class="success_message alert alert-success text-center mb-0"
  >{{ success }}</div>
  <div class="alert alert-warning text-center mb-0 py-2">{{ warning }}</div>
  <div class="alert alert-danger">
    <p>{{ $t('messages.Ошибки:') }}</p>
    <p v-for="error in errors.all">{{ error }}</p>
  </div>
  <div class="alert alert-danger text-center mb-0">
    <p>{{ $t('messages.Ошибки:') }}</p>
    <ul class="list-group list-group-flush">
      <template v-for="failure in failures">
        <li
          v-if="failure.attribute === 'year'"
          class="list-group-item list-group-item-danger"
        >
          {{ 'Ошибка в строке: ' + failure.row + ', в столбике: "' + failure.attribute + '"' }}
          <br />
          {{ $t('messages.Год должен быть минимум 1900 и максимум этот год') }}
        </li>
        <li
          v-if="failure.attribute === 'cadaster_number'"
          class="list-group-item list-group-item-danger"
        >
          {{ 'Ошибка в строке: ' + failure.row + ', в столбике: "' + failure.attribute + '"' }}
          <br />
          {{ $t('messages.Проверте кадастрового номера свкажины') }}
        </li>
      </template>
    </ul>
  </div>
</template>

<script setup>
const props = defineProps({
  success: String,
  warning: String,
  errors: Object,
  failures: Object
});
</script>
