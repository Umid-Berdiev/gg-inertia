<template>
  <div id="main" class="py-3 mb-5">
    <div class="container-fluid" id="dashboardFirstBlock">
      <div class="row row-cols-2 row-cols-lg-3 row-cols-xl-5">
        <div class="col px-4">
          <div class="row no-gutters shadow px-3 rounded-lg h-100">
            <div
              class="col-md-3 col-lg-4 text-center align-self-center p-2 rounded-lg"
              style="background: rgba(0, 60, 255, 0.1);"
            >
              <img src="/icons/des1.svg" alt="des1" />
            </div>
            <div class="col-md-9 col-lg-8 p-3">
              <a
                :href="route('place_births.index')"
                class="text-decoration-none"
              >
                <h2>{{ pb }}</h2>
                <div>{{ $t('messages.Месторождения ПВ') }}</div>
              </a>
            </div>
          </div>
        </div>
        <div class="col px-4">
          <div class="row no-gutters shadow px-3 rounded-lg h-100">
            <div
              class="col-md-3 col-lg-4 text-center align-self-center p-2 rounded-lg"
              style="background: rgba(30, 233, 182, 0.1);"
            >
              <img src="/icons/des2.svg" alt="des2" />
            </div>
            <div class="col-md-9 col-lg-8 p-3">
              <a
                :href="route('approved_plots.index')"
                class="text-decoration-none"
              >
                <h2>{{ approved_plots }}</h2>
                <div>{{ $t('messages.Разведанные участки ПВ') }}</div>
              </a>
            </div>
          </div>
        </div>
        <div class="col px-4">
          <div class="row no-gutters shadow px-3 rounded-lg h-100">
            <div
              class="col-md-3 col-lg-4 text-center align-self-center p-2 rounded-lg"
              style="background: rgba(255, 110, 1, 0.1);"
            >
              <img src="/icons/des5.svg" alt="des5" />
            </div>
            <div class="col-md-9 col-lg-8 p-3">
              <a
                :href="route('mineral_waters.index')"
                class="text-decoration-none"
              >
                <h2>{{ mineral_waters }}</h2>
                <div>{{ $t('messages.Разведанные участки МВ') }}</div>
              </a>
            </div>
          </div>
        </div>
        <div class="col px-4">
          <div class="row no-gutters shadow px-3 rounded-lg h-100">
            <div
              class="col-md-3 col-lg-4 text-center align-self-center p-2 rounded-lg"
              style="background: rgba(175, 82, 222, 0.1);"
            >
              <img src="/icons/des3.svg" alt="des3" />
            </div>
            <div class="col-md-9 col-lg-8 p-3">
              <a
                :href="route('water_intakes.index')"
                class="text-decoration-none"
              >
                <h2>{{ wi }}</h2>
                <div>{{ $t('messages.Водозаборы') }}</div>
              </a>
            </div>
          </div>
        </div>
        <div class="col px-4">
          <div class="row no-gutters shadow px-3 rounded-lg h-100">
            <div
              class="col-md-3 col-lg-4 text-center align-self-center p-2 rounded-lg"
              style="background: rgba(52, 199, 89, 0.1);"
            >
              <img src="/icons/des4.svg" alt="des4" />
            </div>
            <div class="col-md-9 col-lg-8 p-3">
              <a :href="route('wells.index')" class="text-decoration-none">
                <h2>{{ wellsData.length }}</h2>
                <div>{{ $t('messages.Скважины') }}</div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br />
    <div class="container-fluid">
      <div class="row" id="first-section">
        <div class="col-lg-12 col-xl-6 mb-3 py-3 bg-light">
          <canvas id="myChart1" height="250"></canvas>
          <hr />
          <div class="row no-gutters">
            <span>
              {{ $t('messages.Всего прогнозные ресурсы подземных вод по Республике Узбекистан') }}:
              63986.53
            </span>
            <br />
            <span>{{ $t('messages.Всего с минерализацией до 1 г/л по Республике Узбекистан') }}: 25822.05</span>
          </div>
        </div>
        <div class="col-lg-12 col-xl-6 mb-3 py-3">
          <canvas id="myChart2" height="250"></canvas>
          <hr />
          <div class="row no-gutters justify-content-between">
            <div class="col-auto">
              <span>
                <p
                  class="m-0"
                >{{ $t('messages.Всего эксплуатационные скважины') }}: {{ chart2Total2 }}</p>
                <p
                  class="m-0"
                >{{ $t('messages.Всего суммарный отбор') }}: {{ chart2Total1 }}</p>
              </span>
            </div>
            <div class="col-auto">
              <button
                v-if="$page.props.auth.user.roles?.some(role => role.name === 'Administrator')"
                data-bs-toggle="modal"
                data-bs-target="#totalReservesModal"
                class="btn btn-primary"
              >
                <i class="bi bi-pencil"></i>
                {{ $t('messages.Изменить') }}
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="row pt-3 mt-5" id="second-section">
        <div class="col-lg-12 col-xl-6 mb-3 py-3">
          <canvas id="myChart3" height="250"></canvas>
          <hr />
          <div>
            <span>{{ $t('messages.Всего наблюдательных скважин') }}: {{ chart3Total }}</span>
            <br />
            <span>{{ $t('messages.Всего наблюдательных скважин с дайвером') }}: {{ chart3TotalWithDiver }}</span>
          </div>
        </div>
        <div class="col-lg-12 col-xl-6 mb-3 py-3 bg-light">
          <canvas id="myChart4" height="250"></canvas>
          <hr />
          <div class="row justify-content-end align-items-center">
            <label
              class="col-auto mr-2"
              for="inputYear1"
            >{{ $t('messages.От') }}</label>
            <div class="col-auto">
              <input
                required
                min="1970"
                :max="new Date().getFullYear()"
                id="inputYear1"
                class="col-auto form-control"
                type="number"
                v-model="yearStart"
              />
            </div>

            <label
              class="col-auto mr-2"
              for="inputYear2"
            >{{ $t('messages.До') }}</label>
            <div class="col-auto">
              <input
                required
                min="1970"
                :max="new Date().getFullYear()"
                id="inputYear2"
                class="col-auto form-control"
                type="number"
                v-model="yearFinish"
              />
            </div>
            <button
              type="submit"
              :disabled="!validateYears"
              class="col-auto btn btn-info"
              @click="fetchChart4DataByInterval"
            >{{ $t('messages.Применить') }}</button>
          </div>
        </div>
      </div>
    </div>
    <br />
  </div>

  <TotalReservesModal
    :grandwaterTotalReserve="groundwaterTotalReserve"
    :numberProductionWells="numberProductionWells"
  />
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { useI18n } from "vue-i18n";
import Chart from 'chart.js/auto'
import ChartDataLabels from 'chartjs-plugin-datalabels'
import TotalReservesModal from '../Components/modals/TotalReservesModal.vue'

Chart.register(ChartDataLabels);

const { t } = useI18n();
const props = defineProps({
  pb: Number,
  wi: Number,
  approved_plots: Number,
  mineral_waters: Number,
  wellsData: Array,
  wellsDataWithDiver: Array,
  groundwaterTotalReserve: Object,
  numberProductionWells: Object
});

const chart2Total1 = ref(0)
const chart2Total2 = ref(0)
const chart3Total = ref(0)
const chart3TotalWithDiver = ref(0)
const chart4Total1 = ref(0)
const chart4Total2 = ref(0)
const ctx1 = ref(null)
const ctx3 = ref(null)
const ctx2 = ref(null)
const ctx4 = ref(null)
const myChart1 = ref({})
const myChart2 = ref({})
const myChart3 = ref({})
const myChart4 = ref(null)
const yearStart = ref(null)
const yearFinish = ref(null)
const chart4Data = ref([])
const year = ref((new Date()).getFullYear() - 1)

const validateYears = computed(() => {
  return yearStart && yearFinish && yearStart >= 1970 && yearFinish >= 1970 && yearStart <= (new Date()).getFullYear() && yearFinish <= (new Date()).getFullYear()
});

onMounted(() => {
  getChart2Total([props.groundwaterTotalReserve, props.numberProductionWells]);
  getChart3Total();
  getChart3TotalWithDiver();
  fetchChart4DataByInterval();
  year.value = !_.isEmpty(props.groundwaterTotalReserve) ? props.groundwaterTotalReserve.year : !_.isEmpty(props.numberProductionWells) ? props.numberProductionWells.year : ((new Date()).getFullYear() - 1);

  ctx1.value = document.getElementById('myChart1').getContext('2d');
  myChart1.value = new Chart(ctx1.value, {
    type: 'bar',
    data: {
      labels: [
        t('messages.Р. Каракалпакстан'),
        t('messages.Андижанская'),
        t('messages.Бухарская'),
        t('messages.Джизакская'),
        t('messages.Кашкадарьинская'),
        t('messages.Навоийская'),
        t('messages.Наманганская'),
        t('messages.Самаркандская'),
        t('messages.Сурхандарьинская'),
        t('messages.Сырдарьинская'),
        t('messages.Ташкентская'),
        t('messages.Ферганская'),
        t('messages.Хорезмская')
      ],
      datasets: [{
        label: t('messages.Всего прогнозные ресурсы подземных вод'),
        data: [
          5621.18,
          5242.75,
          2574.72,
          938.3,
          1721.95,
          1166.4,
          7653.31,
          3672,
          4015.87,
          6445.44,
          9285.84,
          9446.98,
          6201.79,
        ],
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
      },
      {
        label: t('messages.В т. ч. с минерализацией до 1 г/л'),
        data: [,
          3184.7,
          64.8,
          632.45,
          1348.7,
          72.58,
          3312.58,
          3547.58,
          3373.75,
          639.36,
          7375.19,
          2270.59,
        ],
        backgroundColor: 'rgba(255, 159, 64, 0.2)',
        borderColor: 'rgba(255, 159, 64, 1)',
        borderWidth: 1,
        hidden: true
      }
      ]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: t('messages.Прогнозные ресурсы подземных вод по областям Республики Узбекистан, (тыс.м3/сут)')
        },
        datalabels: {
          align: 'end',
          rotation: -90
        }
      },
      scales: {
        y: {
          ticks: {
            beginAtZero: true
          }
        }
      }
    }
  });

  ctx2.value = document.getElementById('myChart2').getContext('2d');
  myChart2.value = new Chart(ctx2.value, {
    type: 'bar',
    showTooltips: false,
    data: {
      labels: [
        t('messages.Р. Каракалпакстан'),
        t('messages.Андижанская'),
        t('messages.Бухарская'),
        t('messages.Джизакская'),
        t('messages.Кашкадарьинская'),
        t('messages.Навоийская'),
        t('messages.Наманганская'),
        t('messages.Самаркандская'),
        t('messages.Сурхандарьинская'),
        t('messages.Сырдарьинская'),
        t('messages.Ташкентская'),
        t('messages.Ферганская'),
        t('messages.Хорезмская')
      ],
      datasets: [props.groundwaterTotalReserve, props.numberProductionWells].map((item, index) => {
        console.log('item: ', item);
        return {
          label: index === 1 ?
            t('messages.Количество эксплуатационных скважин за') + year.value + t('messages.год') :
            t('messages.Суммарный отбор за') + year.value + t('messages.год'),
          data: [
            parseFloat(item.karakalpak).toFixed(2),
            parseFloat(item.andijan).toFixed(2),
            parseFloat(item.buhara).toFixed(2),
            parseFloat(item.djizak).toFixed(2),
            parseFloat(item.kashkadarya).toFixed(2),
            parseFloat(item.navai).toFixed(2),
            parseFloat(item.namangan).toFixed(2),
            parseFloat(item.samarkand).toFixed(2),
            parseFloat(item.surhandarya).toFixed(2),
            parseFloat(item.sirdarya).toFixed(2),
            parseFloat(item.tashkent).toFixed(2),
            parseFloat(item.fergana).toFixed(2),
            parseFloat(item.xorezm).toFixed(2)
          ],
          backgroundColor: index === 1 ? 'rgba(255, 159, 64, 0.2)' : 'rgba(54, 162, 235, 0.2)',
          borderColor: index === 1 ? 'rgba(255, 159, 64, 1)' : 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }
      })
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: t('messages.Суммарный отбор подземных вод по областям (тыс.м3/сут)')
        },
        datalabels: {
          align: 'end',
          // anchor: 'end',
          // offset: 5,
          rotation: -90
        }
      },
      scales: {
        y: {
          ticks: {
            beginAtZero: true
          }
        }
      }
    }
  });

  ctx3.value = document.getElementById('myChart3').getContext('2d');
  myChart3.value = new Chart(ctx3.value, {
    type: 'bar',
    data: {
      labels: [
        t('messages.Р. Каракалпакстан'),
        t('messages.Андижанская'),
        t('messages.Бухарская'),
        t('messages.Джизакская'),
        t('messages.Кашкадарьинская'),
        t('messages.Навоийская'),
        t('messages.Наманганская'),
        t('messages.Самаркандская'),
        t('messages.Сурхандарьинская'),
        t('messages.Сырдарьинская'),
        t('messages.Ташкентская'),
        t('messages.Ферганская'),
        t('messages.Хорезмская')
      ],
      datasets: [{
        label: t('messages.Количество скважин, штук'),
        data: [
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1735))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1703))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1706))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1708))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1710))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1712))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1714))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1718))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1722))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1724))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1727 || attr.uz_region.regionid == 1726))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1730))
            .length,
          props.wellsData.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1733))
            .length
        ],
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
      },
      {
        label: t('messages.Количество скважин с дайвером, штук'),
        data: [
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1735))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1703))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1706))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1708))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1710))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1712))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1714))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1718))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1722))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1724))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1727 || attr.uz_region.regionid == 1726))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1730))
            .length,
          props.wellsDataWithDiver.filter(item => item.well_attrs.some(attr => attr.uz_region && attr.uz_region.regionid == 1733))
            .length
        ],
        backgroundColor: 'rgba(235, 162, 54, 0.2)',
        borderColor: 'rgba(235, 162, 54, 1)',
        borderWidth: 1,
        hidden: true
      }
      ]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: t('messages.Количество мониторинговых скважин по Республике')
        },
        datalabels: {
          // color: '#36A2EB',
          align: 'end',
          anchor: 'end',
          offset: 5
        }
      },
      scales: {
        y: {
          ticks: {
            beginAtZero: true
          }
        }
      }
    }
  });
});

function getChart2Total(arr) {
  let filteredArr1 = [];
  let filteredArr2 = [];

  if (arr[0]) {
    for (let propName in arr[0]) {
      if (propName != 'id' && propName != 'year' && propName != 'created_at' && propName != 'updated_at') {
        if (arr[0][propName] != null || arr[0][propName] != undefined) {
          filteredArr1.push(arr[0][propName]);
        }
      }
    }
  }

  if (arr[1]) {
    for (let propName in arr[1]) {
      if (propName != 'id' && propName != 'year' && propName != 'created_at' && propName != 'updated_at') {
        if (arr[1][propName] != null || arr[1][propName] != undefined) {
          filteredArr2.push(arr[1][propName]);
        }
      }
    }
  }

  if (filteredArr1.length > 0) {
    console.log('filteredArr1: ', filteredArr1);
    chart2Total1.value = filteredArr1.reduce((acc, cur) => acc + parseFloat(cur), 0).toFixed(2);
  }

  if (filteredArr2.length > 0) {
    console.log('filteredArr2: ', filteredArr2);
    chart2Total2.value = filteredArr2.reduce((acc, cur) => acc + parseFloat(cur), 0).toFixed(2);
  }
}

function getChart3Total() {
  let sum = props.wellsData.length;
  chart3Total.value = sum;
}

function getChart3TotalWithDiver() {
  let sum = props.wellsDataWithDiver.length;
  chart3TotalWithDiver.value = sum;
}

function fetchChart4DataByInterval() {
  axios
    .get(route('get_chart4_data_by_interval'), {
      params: {
        year_start: yearStart.value,
        year_finish: yearFinish.value
      }
    })
    .then(res => {
      myChart4Func(res);
    })
}

function myChart4Func(res) {
  ctx4.value = document.getElementById('myChart4').getContext('2d');
  if (myChart4.value) myChart4.value.destroy();

  myChart4.value = new Chart(ctx4.value, {
    type: 'bar',
    data: {
      labels: [
        ...res.data.map(year => year.year)
      ],
      datasets: [{
        label: t('messages.Суммарный отбор за год'),
        data: [
          ...res.data.map(year => year.sum)
        ],
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
      }]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: t('messages.Суммарный отбор подземных вод по годам (тыс.м3/сут)')
        },
        datalabels: {
          align: 'end',
          anchor: 'center',
          rotation: -90
        }
      },
      scales: {
        y: {
          ticks: {
            beginAtZero: true
          }
        }
      }
    }
  });
}
</script>

