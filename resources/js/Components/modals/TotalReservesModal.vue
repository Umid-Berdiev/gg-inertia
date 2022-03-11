<template>
  <div
    class="modal fade"
    id="totalReservesModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="GWTotalReservesAddModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="GWTotalReservesAddModalLabel">
            {{ $t('messages.Всего общий cуммарный отбор запасов ПВ по областям') }} /
            <br />
            {{ $t('messages.Количество эксплуатационных скважин') }}
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-0">
          <form id="modal-form" @submit.prevent="saveFormData">
            <table id="modal-table" class="table table-sm table-hover">
              <tbody>
                <tr>
                  <th class="text-right w-50">{{ $t('messages.Год') }}</th>
                  <td colspan="2">
                    <input
                      id="year1"
                      type="number"
                      name="years"
                      v-model="year"
                      @change="getData"
                      required
                      min="1900"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Республика Каракалпакстан') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][karakalpak]"
                      v-model="formData.firstData.karakalpak"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][karakalpak]"
                      v-model="formData.secondData.karakalpak"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Андижанская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][andijan]"
                      v-model="formData.firstData.andijan"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][andijan]"
                      v-model="formData.secondData.andijan"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Бухарская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][buhara]"
                      v-model="formData.firstData.buhara"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][buhara]"
                      v-model="formData.secondData.buhara"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Джизакская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][djizak]"
                      v-model="formData.firstData.djizak"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][djizak]"
                      v-model="formData.secondData.djizak"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Кашкадарьинская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][kashkadarya]"
                      v-model="formData.firstData.kashkadarya"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][kashkadarya]"
                      v-model="formData.secondData.kashkadarya"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Навоийская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][navai]"
                      v-model="formData.firstData.navai"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][navai]"
                      v-model="formData.secondData.navai"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Наманганская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][namangan]"
                      v-model="formData.firstData.namangan"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][namangan]"
                      v-model="formData.secondData.namangan"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Самаркандская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][samarkand]"
                      v-model="formData.firstData.samarkand"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][samarkand]"
                      v-model="formData.secondData.samarkand"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Сурхандарьинская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][surhandarya]"
                      v-model="formData.firstData.surhandarya"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][surhandarya]"
                      v-model="formData.secondData.surhandarya"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Сырдарьинская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][sirdarya]"
                      v-model="formData.firstData.sirdarya"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][sirdarya]"
                      v-model="formData.secondData.sirdarya"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Ташкентская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][tashkent]"
                      v-model="formData.firstData.tashkent"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][tashkent]"
                      v-model="formData.secondData.tashkent"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Ферганская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][fergana]"
                      v-model="formData.firstData.fergana"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][fergana]"
                      v-model="formData.secondData.fergana"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
                <tr>
                  <th
                    class="text-right w-50"
                  >{{ $t('messages.Хорезмская область') }}</th>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[0][xorezm]"
                      v-model="formData.firstData.xorezm"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0.01"
                      max="99999.99"
                      min="0"
                      name="years[1][xorezm]"
                      v-model="formData.secondData.xorezm"
                      class="form-control form-control-sm bg-light rounded-lg w-auto"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
        <div class="modal-footer justify-content-center">
          <button
            type="button"
            class="btn btn-secondary btn-sm rounded-lg px-5"
            data-bs-dismiss="modal"
          >
            {{
            $t('messages.Закрыть')
            }}
          </button>
          <button
            type="submit"
            form="modal-form"
            class="btn btn-primary btn-sm rounded-lg px-5"
          >
            {{
            $t('messages.Сохранить')
            }}
          </button>
          <button
            type="button"
            class="btn btn-success text-white rounded-lg px-5"
            data-bs-dismiss="modal"
            @click="changeDiagrammaData"
          >{{ $t('messages.Показать график') }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
  grandwaterTotalReserve: Object,
  numberProductionWells: Object,
});

const formData = ref({
  firstData: {
    karakalpak: null,
    andijan: null,
    buhara: null,
    djizak: null,
    kashkadarya: null,
    navai: null,
    namangan: null,
    samarkand: null,
    surhandarya: null,
    sirdarya: null,
    tashkent: null,
    fergana: null,
    xorezm: null
  },
  secondData: {
    karakalpak: null,
    andijan: null,
    buhara: null,
    djizak: null,
    kashkadarya: null,
    navai: null,
    namangan: null,
    samarkand: null,
    surhandarya: null,
    sirdarya: null,
    tashkent: null,
    fergana: null,
    xorezm: null
  }
});
const year = ref((new Date().getFullYear()) - 1);

onMounted(() => {
  year.value = !_.isEmpty(props.grandwaterTotalReserve) ? props.grandwaterTotalReserve.year : !_.isEmpty(props.numberProductionWells) ? props.numberProductionWells.year : ((new Date()).getFullYear() - 1);
  formData.value = {
    firstData: props.grandwaterTotalReserve ?? {},
    secondData: props.numberProductionWells ?? {}
  };
});

function getData() {
  axios
    .get(route('gw_total_reserves'), {
      params: {
        year: year.value,
      }
    })
    .then(response => {
      if (response.data) {
        formData.value.firstData = { ...response.data.groundwaterTotalReserve } ?? {};
        formData.value.secondData = { ...response.data.numberProductionWells } ?? {};
      }
    })
    .catch(error => console.log(error));
}

function changeDiagrammaData() {
  axios.get(route('gw_total_reserves'), {
    params: {
      year: year.value,
    }
  })
    .then(response => {
      if (response.data) {
        let res = [response.data.groundwaterTotalReserve, response.data.numberProductionWells];
        main.myChart2.data.datasets.forEach((dataset, index) => {
          if (!_.isEmpty(res[index])) {
            dataset.label = index === 1 ?
              $t('messages.Количество эксплуатационных скважин за') + res[index].year + $t('messages.год') :
              $t('messages.Суммарный отбор за') + res[index].year + $t('messages.год');
            dataset.data = [
              parseFloat(res[index]['karakalpak']).toFixed(2),
              parseFloat(res[index]['andijan']).toFixed(2),
              parseFloat(res[index]['buhara']).toFixed(2),
              parseFloat(res[index]['djizak']).toFixed(2),
              parseFloat(res[index]['kashkadarya']).toFixed(2),
              parseFloat(res[index]['navai']).toFixed(2),
              parseFloat(res[index]['namangan']).toFixed(2),
              parseFloat(res[index]['samarkand']).toFixed(2),
              parseFloat(res[index]['surhandarya']).toFixed(2),
              parseFloat(res[index]['sirdarya']).toFixed(2),
              parseFloat(res[index]['tashkent']).toFixed(2),
              parseFloat(res[index]['fergana']).toFixed(2),
              parseFloat(res[index]['xorezm']).toFixed(2)
            ];
          } else {
            dataset.label = index === 1 ?
              $t('messages.Количество эксплуатационных скважин за') + year.value + $t('messages.год') :
              $t('messages.Суммарный отбор за') + year.value + $t('messages.год');
            dataset.data = [];
          }
        });
        main.myChart2.update();
        main.getChart2Total(res);
      }
    })
    .catch(error => console.log(error));
}

async function saveFormData() {
  try {
    formData.value.firstData.year = year.value;
    formData.value.secondData.year = year.value;
    const res = await axios.post(route('gw_total_reserves.add'), formData.value);
    alert($t('messages.Saved successfully'));
  } catch (error) {
    const message =
      (error.response &&
        error.response.data &&
        error.response.data.message) ||
      error.message ||
      error.toString();
    alert(message);
  }
}
</script>
