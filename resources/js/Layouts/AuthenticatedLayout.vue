<template>
  <div class="container-fluid">
    <div class="row">
      <LeftSidebar />
      <div id="main-content" class="col-md-8 col-lg-9 col-xl-10 ms-auto px-0">
        <TheHeader />
        <main class="px-3">
          <slot />
        </main>
      </div>
    </div>
  </div>

  <ShowLogsModal />
</template>

<script setup>
import TheHeader from '@/Components/TheHeader.vue';
import LeftSidebar from '@/Components/LeftSidebar.vue';
import ShowLogsModal from '@/Components/modals/ShowLogsModal.vue';
import { useI18n } from 'vue-i18n';
import { onMounted } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const i18n = useI18n();
const currentLocale = usePage().props.value.auth.user.lang_prefix
i18n.locale.value = currentLocale;
onMounted(() => {
  //
});
</script>

<!-- <style scoped>
@import "/css/layout.css";
@import "/css/style.css";
@import "/css/fileinput.min.css";
</style> -->
