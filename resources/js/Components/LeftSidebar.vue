<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { usePage } from '@inertiajs/inertia-vue3'

const dannycount1 = usePage().props.value.dannycount1
const dannycount2 = usePage().props.value.dannycount2
const dannycount3 = usePage().props.value.dannycount3
const reestr1 = usePage().props.value.reestr1
const reestr2 = usePage().props.value.reestr2
const reestr3 = usePage().props.value.reestr3
const reestr4 = usePage().props.value.reestr4
const reestr5 = usePage().props.value.reestr5

function toggleSidebar() {
  const header = document.getElementById("header");
  const sidebar = document.getElementById("sidebar");
  const arrowBar = document.getElementById('arrowBar');
  const content = document.getElementById("main-content");
  const toggleBtnWrapper = document.getElementById("toggleBtnWrapper");

  if (arrowBar.classList.contains('bi-arrow-bar-left')) {
    toggleBtnWrapper.classList.remove('justify-content-between')
    toggleBtnWrapper.classList.add('justify-content-center')
    arrowBar.classList.remove('bi-arrow-bar-left')
    arrowBar.classList.add('bi-arrow-bar-right')
    sidebar.classList.remove('col-md-4', 'col-lg-3', 'col-xl-2')
    sidebar.classList.add('col-auto')
    sidebar.querySelectorAll('.accordion-button').forEach(item => {
      item.classList.add("hidden");
    })
    sidebar.querySelectorAll('.collapse-text').forEach(item => {
      item.classList.add("d-none")
    })
    sidebar.querySelectorAll(".collapse").forEach(item => {
      item.classList.add('d-none')
    })
    content.classList.remove('col-md-8', 'col-lg-9', 'col-xl-10', 'ms-auto')
    content.style.setProperty('margin-left', sidebar.offsetWidth + 'px')
    content.style.setProperty('max-width', `calc(100% - ${sidebar.offsetWidth}px)`)
  } else {
    toggleBtnWrapper.classList.remove('justify-content-center')
    toggleBtnWrapper.classList.add('justify-content-between')
    arrowBar.classList.remove('bi-arrow-bar-right')
    arrowBar.classList.add('bi-arrow-bar-left')
    sidebar.classList.remove('col-auto')
    sidebar.classList.add('col-md-4', 'col-lg-3', 'col-xl-2')
    sidebar.querySelectorAll('.accordion-button').forEach(item => {
      item.classList.remove("hidden");
    })
    sidebar.querySelectorAll('.collapse-text').forEach(item => {
      item.classList.remove("d-none")
    })
    sidebar.querySelectorAll(".collapse").forEach(item => {
      item.classList.remove('d-none')
    })
    content.style.setProperty('margin-left', 'auto')
    content.classList.add('col-md-8', 'col-lg-9', 'col-xl-10', 'ms-auto')
  }

  if (window.location.pathname === "/map" || window.location.pathname === "/media") {
    let mapContent = document.getElementById("mapid");
    mapContent.style.setProperty("height", `calc(100vh - ${header.offsetHeight}px)`)
    mapContent.style.setProperty("width", `calc(100vw - ${sidebar.offsetWidth}px - 35px)`)
  }
}
</script>

<template>
  <div id="sidebar" class="col-md-4 col-lg-3 col-xl-2 bg-light h-100 pt-4">
    <div id="toggleBtnWrapper" class="d-flex justify-content-between">
      <Link href="/" class="logo collapse-text">
        <span>{{ $t('messages.state_unitary_enterprise') }}</span>
        <h5>{{ $t('messages.uzbekhydrogeology') }}</h5>
      </Link>
      <button class="btn p-0 text-primary mt-2 mb-3" @click="toggleSidebar">
        <i id="arrowBar" class="bi bi-arrow-bar-left h4"></i>
      </button>
    </div>
    <div id="sidebar-sticky">
      <nav
        v-if="!$page.url.startsWith('/admin')"
        class="navbar flex-column px-0"
      >
        <Link class="nav-link shadow-sm" :href="route('dashboard')">
          <div class="d-flex justify-content-start align-items-center gap-3">
            <span class="bi bi-tv"></span>
            <span class="collapse-text">{{ $t("messages.Дашборд") }}</span>
            <span
              class="collapse-text badge badge-pill badge-primary ms-auto"
            >{{ dannycount1 + dannycount2 + dannycount3 }}</span>
          </div>
        </Link>

        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item bg-transparent border-0">
            <button
              class="accordion-header accordion-button nav-link shadow-sm px-3 py-2"
              :class="{ 'active': $page.url.startsWith('/dannye'), 'collapsed': !$page.url.startsWith('/dannye') }"
              id="flush-headingOne"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#flush-collapseOne"
              aria-expanded="false"
              aria-controls="flush-collapseOne"
            >
              <div
                class="d-flex justify-content-start align-items-center gap-3"
              >
                <span class="bi bi-flag"></span>
                <span class="collapse-text">{{ $t("messages.Данные") }}</span>
              </div>
            </button>
            <div
              id="flush-collapseOne"
              class="accordion-collapse collapse"
              :class="{ 'show': $page.url.startsWith('/dannye') }"
              aria-labelledby="flush-headingOne"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <Link
                  class="nav-link shadow-sm pl-5"
                  :class="{ active: $page.url.startsWith('/dannye/waterlevel') }"
                  :href="route('waterlevel')"
                >{{ $t("messages.Уровень") }}</Link>
                <Link
                  class="nav-link shadow-sm pl-5"
                  :class="{ active: $page.url.startsWith('/dannye/chemical-composition') }"
                  :href="route('chemical-composition')"
                >{{ $t("messages.Химический состав") }}</Link>
              </div>
            </div>
          </div>
          <div class="accordion-item bg-transparent border-0">
            <button
              class="accordion-header accordion-button collapsed nav-link shadow-sm px-3 py-2"
              id="flush-headingTwo"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#flush-collapseTwo"
              aria-expanded="false"
              aria-controls="flush-collapseTwo"
            >
              <div
                class="d-flex justify-content-start align-items-center gap-3"
              >
                <span class="bi bi-briefcase"></span>
                <span class="collapse-text">{{ $t("messages.Реестры") }}</span>
                <span
                  class="collapse-text badge badge-pill badge-primary ms-auto mr-3"
                >{{ reestr1 + reestr2 + reestr3 + reestr4 + reestr5 }}</span>
              </div>
            </button>
            <div
              id="flush-collapseTwo"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingTwo"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('place_births.index')"
                >
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <span>{{ $t("messages.Месторождения подземных вод") }}</span>
                    <span
                      v-if="reestr1 != 0"
                      class="collapse-text badge badge-pill badge-primary"
                    >{{ reestr1 }}</span>
                  </div>
                </Link>
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('approved_plots.index')"
                >
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <span>{{ $t("messages.Утвержденные участки") }}</span>
                    <span
                      v-if="reestr2 != 0"
                      class="collapse-text badge badge-pill badge-primary"
                    >{{ reestr2 }}</span>
                  </div>
                </Link>
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('water_intakes.index')"
                >
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <span>{{ $t("messages.Водозаборы") }}</span>
                    <span
                      v-if="reestr3 != 0"
                      class="collapse-text badge badge-pill badge-primary"
                    >{{ reestr3 }}</span>
                  </div>
                </Link>
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('wells.index')"
                >
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <span>{{ $t("messages.Скважины") }}</span>
                    <span
                      v-if="reestr4 != 0"
                      class="collapse-text badge badge-pill badge-primary"
                    >{{ reestr4 }}</span>
                  </div>
                </Link>
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('mineral_waters.index')"
                >
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <span>{{ $t("messages.Минеральные воды") }}</span>
                    <span
                      v-if="reestr5 != 0"
                      class="collapse-text badge badge-pill badge-primary"
                    >{{ reestr5 }}</span>
                  </div>
                </Link>
              </div>
            </div>
          </div>
          <div class="accordion-item bg-transparent border-0">
            <button
              class="accordion-header accordion-button collapsed nav-link shadow-sm px-3 py-2"
              id="flush-headingThree"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#flush-collapseThree"
              aria-expanded="false"
              aria-controls="flush-collapseThree"
            >
              <div
                class="d-flex justify-content-start align-items-center gap-3"
              >
                <span class="bi bi-download"></span>
                <span class="collapse-text">{{ $t("messages.Отчеты") }}</span>
              </div>
            </button>
            <div
              id="flush-collapseThree"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingThree"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('reports.print')"
                >{{ $t("messages.Печатный отчеты") }}</Link>
              </div>
            </div>
          </div>
          <div class="accordion-item bg-transparent border-0">
            <button
              class="accordion-header accordion-button collapsed nav-link shadow-sm px-3 py-2"
              id="flush-headingFour"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#flush-collapseFour"
              aria-expanded="false"
              aria-controls="flush-collapseFour"
            >
              <div
                class="d-flex justify-content-start align-items-center gap-3"
              >
                <span class="bi bi-journal"></span>
                <span class="collapse-text">{{ $t("messages.Справочники") }}</span>
              </div>
            </button>
            <div
              id="flush-collapseFour"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingFour"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('pools.index')"
                >{{ $t("messages.Бассейны") }}</Link>
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('intendeds.index')"
                >{{ $t("messages.Целевое использование") }}</Link>
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('well_types.index')"
                >{{ $t("messages.Тип скважин") }}</Link>
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('water_use_types.index')"
                >{{ $t("messages.Вид использования воды") }}</Link>
                <Link
                  class="nav-link shadow-sm pl-5"
                  :href="route('water_intake_types.index')"
                >{{ $t("messages.Тип водозабора") }}</Link>
              </div>
            </div>
          </div>
        </div>

        <Link class="nav-link shadow-sm" :href="route('divers.index')">
          <div class="d-flex justify-content-start align-items-center gap-3">
            <span class="bi bi-cpu"></span>
            <span class="collapse-text">{{ $t("messages.Дайверы") }}</span>
          </div>
        </Link>

        <Link class="nav-link shadow-sm" :href="route('media-gallery')">
          <div class="d-flex justify-content-start align-items-center gap-3">
            <span class="bi bi-images"></span>
            <span class="collapse-text">{{ $t("messages.Медиа") }}</span>
          </div>
        </Link>
        <Link class="nav-link shadow-sm" :href="route('media2')">
          <div class="d-flex justify-content-start align-items-center gap-3">
            <span class="bi bi-images"></span>
            <span class="collapse-text">{{ $t("messages.Карта мониторинг") }}</span>
          </div>
        </Link>

        <Link class="nav-link shadow-sm" :href="route('contacts.index')">
          <div class="d-flex justify-content-start align-items-center gap-3">
            <span class="bi bi-people"></span>
            <span class="collapse-text">{{ $t("messages.Контакты") }}</span>
          </div>
        </Link>
      </nav>
      <nav v-else class="navbar flex-column px-0">
        <Link
          id="users"
          class="nav-link shadow-sm"
          :href="route('users.index')"
        >
          <span class="bi bi-people"></span>
          <span class="collapse-text">{{ $t("messages.Пользователи") }}</span>
        </Link>

        <!-- tarjimalar bo'limi -->
        <div class="accordion">
          <Link
            class="accordion-header nav-link shadow-sm"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseLink4"
          >
            <div class="d-flex justify-content-start align-items-center gap-3">
              <span class="bi bi-translate"></span>
              <span class="collapse-text">{{ $t("messages.Переводы") }}</span>
            </div>
          </Link>
          <div id="collapseLink4" class="collapse">
            <Link
              class="nav-link shadow-sm pl-5"
              :href="route('languages.index')"
            >{{ $t("messages.Языки") }}</Link>
            <Link
              class="nav-link shadow-sm pl-5"
              :href="route('terms.index')"
            >{{ $t("messages.Термины") }}</Link>
          </div>
        </div>
      </nav>
    </div>
  </div>
</template>
