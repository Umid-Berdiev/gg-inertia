require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import i18n from "@/plugins/i18n";
import VueSelect from "vue-next-select";
import "bootstrap";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
// import { useToast } from "vue-toastification";

// styles
import "vue-next-select/dist/index.min.css";
import "./Styles/custom.scss";
// import "/css/fileinput.min.css";
// import "/css/layout.scss";
// import "/css/style.css";

const appName =
  window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

// const toast = useToast();

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => {
    const page = require(`./Pages/${name}.vue`).default;
    page.layout ??= AuthenticatedLayout;
    return page;
  },
  setup({ el, app, props, plugin }) {
    return createApp({ render: () => h(app, props) })
      .use(plugin)
      .use(i18n)
      .use(Toast)
      .mixin({ methods: { route }, components: { VueSelect } })
      .mount(el);
  },
});
InertiaProgress.init({ color: "orange" });
