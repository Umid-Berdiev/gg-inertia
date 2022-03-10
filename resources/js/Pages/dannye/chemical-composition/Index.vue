<script setup>
import { onMounted, onUpdated, provide, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import isEmpty from "lodash/isEmpty"
import useYear from '@/features/composables/useYear.js'
import useWells from '@/features/composables/useWells.js'

import ImportModal from "@/Components/modals/ImportModal.vue";
import SearchForm from "../SearchForm.vue";

const { getSelectedWell, setSelectedWell } = useWells();
const { getSelectedYear, setSelectedYear } = useYear();
const props = defineProps({
  wells: Array,
  elements: Array,
  roman_months: Array,
  items: Array,
});

const wellError = ref("");

provide('wells', props.wells);
provide('wellError', wellError.value);

onMounted(() => {
  const params = route().params;

  if (params.well_id) {
    const selectedWellFromQuery = props.wells.find(well => well.id === Number(params.well_id))
    console.log('selectedWellFromQuery: ', selectedWellFromQuery);
    setSelectedWell(selectedWellFromQuery)
  }

  if (params.year) {
    setSelectedYear(params.year)
  }
  // getObjDataForYearlyChart();
});

function handleSearch(event) {
  if (isEmpty(getSelectedWell.value)) {
    wellError.value = "This field is required!"
    return;
  }
  Inertia.visit(route('chemical-composition'), {
    data: { well_id: getSelectedWell.value.id, year: getSelectedYear.value },
    only: ['items']
  })
}

function getQuarter(month) {
  switch (month) {
    case "III":
      return "I"
      break;
    case "VI":
      return "II"
      break;
    case "IX":
      return "III"
      break;
    case "XII":
      return "IV"
      break;
  }
}

function handleUpdateAction(event) {
  const values = Object.fromEntries(new FormData(event.target));
  // console.log('values in handle update func: ', values);
  Inertia.post(route('chemical-composition.update', props.item.id),
    { ...values },
    {
      onSuccess: page => {
        toast.success(t("messages.successfully_updated"), {
          timeout: 3000
        });
      }
    }
  )
}
</script>

<template>
  <div class="container-fluid pt-3">
    <div class="row">
      <div class="col-sm-auto">
        <h5
          class="ml-3 mb-3 font-weight-bold text-primary"
        >{{ $t("messages.dynamic_changes_water_level") }}</h5>
      </div>
    </div>
    <div class="row justify-content-between" v-if="!isEmpty(items)">
      <div class="col-lg-auto">
        <p>
          {{
            `${t('messages.Изменение')}: ${items[0]['user']?.firstname} ${items[0]['user']?.lastname} | ${items[0]['updated_at']} | ${t('messages.статус')}: ${items[0]['is_approve'] ? t('messages.Одобрен') : t('messages.Не одобрен')}`
          }}
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-9">
        <form @submit.prevent="handleSearch">
          <SearchForm :wells="wells" :well-error="wellError" />
        </form>
      </div>
      <div class="col-sm-auto ms-auto">
        <button
          data-bs-toggle="modal"
          data-bs-target="#importModal"
          class="btn btn-primary"
        >
          <i class="bi bi-upload"></i>
          {{ $t('messages.Импорт') }}
        </button>

        <button
          data-bs-toggle="modal"
          data-bs-target="#exportModal"
          class="btn btn-primary ms-3"
        >
          <i class="bi bi-download"></i>
          {{ $t('Экспорт') }}
        </button>
      </div>
    </div>
    <div class="form-group pt-3" v-if="!isEmpty(items)">
      <div class="row justify-content-end">
        <div class="col-md-auto">
          <form
            v-if="$page.props.auth.user.roles.some(role => role.name === 'Administrator')"
            @submit="handleAcceptAction"
          >
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check2-all fa-lg"></i>
              {{ $t('messages.Одобрить') }}
            </button>
          </form>
        </div>
        <div class="col-md-auto">
          <button
            class="btn btn-success"
            type="submit"
            form="update-form"
          >{{ $t('messages.Сохранитьизменения') }}</button>
        </div>
      </div>

      <form v-if="!isEmpty(items)" id="form1" @submit.prevent="handleUpdate">
        <div class="table-responsive">
          <table class="table table-sm table-bordered mt-3">
            <thead>
              <tr class="text-center">
                <th>{{ $t('messages.Хим.состав') }}</th>
                <th>{{ $t('messages.Жесткость') }}</th>
                <th>рН</th>
                <th>{{ $t('messages.Сухой остаток') }}</th>
                <th>
                  CO
                  <sub>2</sub>
                </th>
                <th>
                  H
                  <sub>2</sub>S
                </th>
                <th>
                  SiO
                  <sub>2</sub>
                </th>
                <th>
                  CO
                  <sub>3</sub>
                </th>
                <th>
                  HCO
                  <sub>3</sub>
                </th>
                <th>CI</th>
                <th>
                  SO
                  <sub>4</sub>
                </th>
                <th>
                  NO
                  <sub>3</sub>
                </th>
                <th>
                  NO
                  <sub>2</sub>
                </th>
                <th>Ca</th>
                <th>Mg</th>
                <th>Na+K</th>
                <th>Na</th>
                <th>K</th>
                <th>
                  Fe
                  <sub>2</sub>
                </th>
                <th>
                  Fe
                  <sub>3</sub>
                </th>
                <th>
                  NH
                  <sub>4</sub>
                </th>
                <th>{{ $t('messages.Окисляемость') }}</th>
                <th>F - {{ $t('messages.фтор') }}</th>
              </tr>
              <tr class="text-center">
                <th>{{ $t('messages.По ГОСТу') }}</th>
                <th>1,00 - 200,00 {{ $t('messages.мг-экв/л') }} (10,0)</th>
                <th>2-12</th>
                <th>
                  0,10 - 300 {{ $t('messages.мг/л') }}
                  <br />(1500)
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>250-350</th>
                <th>400-500</th>
                <th>45 {{ $t('messages.мг/л') }}</th>
                <th>3 {{ $t('messages.мг/л') }}</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>0,3 {{ $t('messages.мг/л') }}</th>
                <th>0,3 {{ $t('messages.мг/л') }}</th>
                <th>1 {{ $t('messages.мг/л') }}</th>
                <th></th>
                <th>0,70 {{ $t('messages.мг/л') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="month in roman_months">
                <td class="align-middle bg-light">{{ getQuarter(month) }}</td>
                <td class="p-0" v-for="el in elements">
                  <template v-for="item in items">
                    <input
                      v-if="item.month.trim() == month"
                      type="text"
                      maxlength="7"
                      class="form-control form-control-sm"
                      :class="{
                        'alert-danger': ((item[el] < 1 || item[el] > 200) && item[el] != 0 && el === 'hardness') ||
                          ((item[el] < 2 || item[el] > 12) && item[el] != 0 && el === 'pH') ||
                          ((item[el] < 0.10 || item[el] > 300) && item[el] != 0 && el === 'dry_residue') ||
                          ((item[el] < 250 || item[el] > 350) && item[el] != 0 && el === 'CI') ||
                          ((item[el] < 400 || item[el] > 500) && item[el] != 0 && el === 'SO4')
                      }"
                      :name="`datas[${month}][${el}]`"
                      :value="item[el]"
                    />
                  </template>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </form>
    </div>

    <div class="chart-container">
      <canvas id="yearly" height="100"></canvas>
    </div>
  </div>

  <!-- import modal -->
  <ImportModal
    importUrl="chemical-composition.import"
    templateUrl="chemical-composition.template"
  />

  <!-- export modal -->
  <ExportModal export-route="chemical-composition.export" />
</template>

<style scoped type="text/css">
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type="number"] {
  -moz-appearance: textfield;
}
</style>
