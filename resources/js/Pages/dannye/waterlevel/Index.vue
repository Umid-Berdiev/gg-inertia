<script setup>
import { onMounted, provide, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import isEmpty from "lodash/isEmpty"
import useYear from '@/features/composables/useYear.js'
import useWells from '@/features/composables/useWells.js'
import { useToast } from "vue-toastification";

import InterpolationModal from "../InterpolationModal.vue";
import ImportModal from "@/Components/modals/ImportModal.vue";
import ExportModal from "@/Components/modals/ExportModal.vue";
import SearchForm from "../SearchForm.vue";
import { useI18n } from "vue-i18n";
import "vue-toastification/dist/index.css";
import Chart from 'chart.js/auto'
import { eachRight, map } from "lodash";

const { getSelectedWell, setSelectedWell } = useWells();
const { getSelectedYear, setSelectedYear } = useYear();

const props = defineProps({
  wells: Array,
  item: Object,
  regions: Array
});
const wellError = ref("");
const myChart = ref(null);
const toast = useToast();
// const showToast = () => toast.success("I'm a toast!");
const { t } = useI18n();
provide('wells', props.wells);
provide('wellError', wellError.value);

onMounted(async () => {
  const params = route().params;

  if (params.well_id) {
    const selectedWellFromQuery = props.wells.find(well => well.id === Number(params.well_id))
    await setSelectedWell(selectedWellFromQuery)
  }

  if (params.year) {
    await setSelectedYear(params.year)
  }

  if (params.well_id && params.year) {
    getObjDataForYearlyChart();
  }
});

function getRandomColor() {
  let letters = '0123456789ABCDEF'.split('');
  let color = '#';
  for (let i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

async function getObjDataForYearlyChart() {
  try {
    const res = await axios
      .get(route('waterlevel.diagramma'), {
        params: { well_id: getSelectedWell.value.id }
      })

    console.log(res.data);
    let diagrammaData = res.data;
    let ctx1 = document.getElementById('diagramma').getContext('2d');

    if (diagrammaData.result === 1) {
      if (myChart.value) myChart.value.destroy();

      const lastYear = new Date().getFullYear() - 1;
      const currentYear = new Date().getFullYear();
      const months = [];
      const values = [];
      diagrammaData.years.forEach(year => year.data?.forEach((element, elIndex, arr) => {
        if (elIndex == Math.round(arr.length / 2)) {
          months.push(t(`messages.${element.month}`) + ";" + year.year)
        } else months.push(t(`messages.${element.month}`))
        values.push(element.value)
      }));
      console.log('months: ', months);
      console.log('values: ', values);
      // console.log([...diagrammaData.years.map(year => year.data.map(item => item.value))]);
      myChart.value = new Chart(ctx1, {
        type: 'line',
        data: {
          labels: months,
          datasets: [{
            label: t('messages.12 месяцев'),
            fill: false,
            data: values,
            borderWidth: 3,
            // borderColor: getRandomColor(),
            scaleFontSize: 40,
            tension: 0.5
          }],
        },
        options: {
          responsive: true,
          tooltips: {
            mode: 'index',
            intersect: true,
          },
          plugins: {
            title: {
              display: true,
              text: t('messages.График уровня воды'),
            }
          },
          scales: {
            y: {
              ticks: {
                beginAtZero: false,
                // padding: 10
              },
              reverse: true
            },
            x: {
              ticks: {
                callback: function (label) {
                  let realLabel = this.getLabelForValue(label);
                  return realLabel;
                }
              }
            },
            xAxis2: {
              type: "category",
              grid: {
                drawOnChartArea: false, // only want the grid lines for one axis to show up
              },
              ticks: {
                callback: function (label) {
                  let realLabel = this.getLabelForValue(label);
                  let month = realLabel.split(";")[0];
                  let year = realLabel.split(";")[1];
                  if (year) {
                    return year;
                  } else {
                    return "";
                  }
                }
              }
            },
          },
        }
      });
    }
  } catch (error) {
    console.log('error in diagramm func: ', error);
    toast.error(error)
  }

}

async function handleAcceptAction() {
  const res = await axios.post(route('waterlevel.accept'), { year: getSelectedYear.value, well_id: getSelectedWell.value.id });
  props.item = await res.data.data;
  toast.success(t(res.data.message));
}

function handleSearch(event) {
  if (isEmpty(getSelectedWell.value)) {
    wellError.value = "This field is required!"
    return;
  }
  Inertia.visit(route('waterlevel'), {
    data: { well_id: getSelectedWell.value.id, year: getSelectedYear.value },
    only: ['item']
  })
}

function handleUpdateAction(event) {
  const values = Object.fromEntries(new FormData(event.target));
  // console.log('values in handle update func: ', values);
  Inertia.post(route('waterlevel.update', props.item.id),
    { ...values },
    {
      onSuccess: page => {
        toast.success(t("messages.successfully_updated"), {
          timeout: 3000
        });
        getObjDataForYearlyChart();
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
        >{{ t("messages.dynamic_changes_water_level") }}</h5>
      </div>
    </div>
    <div class="row justify-content-between" v-if="item">
      <div class="col-lg-auto">
        <p>
          {{
            `${t('messages.Изменение')}: ${item.user?.firstname} ${item.user?.lastname} | ${item.updated_at} | ${t('messages.статус')}: ${item.is_approve ? t('messages.Одобрен') : t('messages.Не одобрен')}`
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
          {{ t('messages.Импорт') }}
        </button>

        <button
          data-bs-toggle="modal"
          data-bs-target="#exportModal"
          class="btn btn-primary ms-3"
        >
          <i class="bi bi-download"></i>
          {{ t('Экспорт') }}
        </button>
      </div>
    </div>
    <div class="form-group pt-3" v-if="!isEmpty(item)">
      <div class="row justify-content-end">
        <div class="col-md-auto">
          <form
            v-if="$page.props.auth.user.roles.some(role => role.name === 'Administrator')"
            @submit.prevent="handleAcceptAction"
          >
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check2-all fa-lg"></i>
              {{ t('messages.Одобрить') }}
            </button>
          </form>
        </div>
        <div class="col-md-auto">
          <button
            class="btn btn-success text-white"
            type="submit"
            form="update-form"
          >{{ t('messages.Сохранить изменения') }}</button>
        </div>
      </div>

      <form class="form" id="update-form" @submit.prevent="handleUpdateAction">
        <div class="table-responsive">
          <table class="table table-sm table-bordered mt-3">
            <thead class="table-light">
              <tr class="text-center">
                <th>{{ t('messages.год') }}</th>
                <th>{{ t('messages.Янв') }}</th>
                <th>{{ t('messages.Фев') }}</th>
                <th>{{ t('messages.Мар') }}</th>
                <th>{{ t('messages.Апр') }}</th>
                <th>{{ t('messages.Май') }}</th>
                <th>{{ t('messages.Июн') }}</th>
                <th>{{ t('messages.Июл') }}</th>
                <th>{{ t('messages.Авг') }}</th>
                <th>{{ t('messages.Сен') }}</th>
                <th>{{ t('messages.Окт') }}</th>
                <th>{{ t('messages.Ноя') }}</th>
                <th>{{ t('messages.Дек') }}</th>
                <th>{{ t('messages.MIN') }}</th>
                <th>{{ t('messages.MAX') }}</th>
                <th>{{ t('messages.AVRG') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td
                  class="form-control form-control-sm text-end"
                  :class="{ 'bg-warning': item.is_approve }"
                >{{ item.year }}</td>
                <td class="p-0" :class="{ 'bg-warning': item.is_approve }">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="january"
                    :value="item.january"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="february"
                    :value="item.february"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="march"
                    :value="item.march"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="april"
                    :value="item.april"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="may"
                    :value="item.may"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="june"
                    :value="item.june"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="july"
                    :value="item.july"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="august"
                    :value="item.august"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="september"
                    :value="item.september"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="october"
                    :value="item.october"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="november"
                    :value="item.november"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm text-end"
                    :class="{ 'bg-warning': item.is_approve }"
                    name="december"
                    :value="item.december"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    disabled
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm disabled text-end"
                    :value="item.min"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    disabled
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm disabled text-end"
                    :value="item.max"
                  />
                </td>
                <td class="p-0">
                  <input
                    type="number"
                    disabled
                    min="0"
                    max="999"
                    step=".0001"
                    class="form-control form-control-sm disabled text-end"
                    :value="item.average"
                  />
                </td>
                <input type="hidden" name="year" :value="item.year" />
              </tr>
            </tbody>
          </table>
        </div>
      </form>
    </div>

    <div class="chart-container">
      <canvas id="diagramma" height="100"></canvas>
    </div>
  </div>

  <!-- Interpolation Modal -->
  <InterpolationModal :regions="regions" />

  <!-- import modal -->
  <ImportModal importUrl="waterlevel.import" templateUrl="waterlevel.template" />

  <!-- export modal -->
  <ExportModal export-route="waterlevel.export" />
</template>
