<template>
  <div
    class="modal fade"
    id="logsModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="logsModalTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5
            class="modal-title"
            id="logsModalTitle"
          >{{ $t('messages.Просмотр изменений') }}</h5>
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
          <table class="table table-sm table-hover mt-3">
            <thead>
              <tr class="bg-light">
                <th scope="col">{{ $t('messages.Форма') }}</th>
                <th scope="col">{{ $t('messages.Ползователь') }}</th>
                <th scope="col">{{ $t('messages.Дата изм.') }}</th>
                <th scope="col">{{ $t('messages.Объект №') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="uv in changesLog.urevenvodys">
                <td scope="col">{{ $t('messages.Уровен воды') }}</td>
                <td
                  scope="col"
                  v-text="uv.user ? uv.user.firstname + ' ' + uv.user.lastname : ''"
                ></td>
                <td scope="col" v-text="formatDatetime(uv.updated_at)"></td>
                <td scope="col">
                  <a
                    class="btn btn-outline-primary btn-sm rounded-lg btn-block"
                    target="blank"
                    v-text="uv.well.cadaster_number"
                    :href="'/dannye/waterlevel/?id=' + uv.id + '&skvajina_id=' + uv.skvajina_id + '&year=' + uv.year"
                  ></a>
                </td>
              </tr>

              <tr v-for="  xs in changesLog.ximsostav">
                <td scope="col">{{ $t('messages.Химический состав воды') }}</td>
                <td
                  scope="col"
                  v-text="xs.user ? xs.user.firstname + ' ' + xs.user.lastname : ''"
                ></td>
                <td scope="col" v-text="formatDatetime(xs.updated_at)"></td>
                <td scope="col">
                  <a
                    class="btn btn-outline-primary btn-sm rounded-lg btn-block"
                    target="blank"
                    v-text="xs.well.cadaster_number"
                    :href="'/dannye/chemical-composition/?skvajina_id=' + xs.skvajina_id + '&year=' + xs.year"
                  ></a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-sm btn-primary ms-auto"
            data-bs-dismiss="modal"
          >{{ $t('messages.close') }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

const changesLog = ref({});
onMounted(async () => {
  await fetch(route('get-changes-log'))
    .then(res => {
      changesLog.value = res.json()
    })
    .catch(err => alert('Error by logs: ' + err))
});
</script>
