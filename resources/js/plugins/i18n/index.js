import { createI18n } from "vue-i18n";
import en from "./locales/en";
import ru from "./locales/ru";
import uz from "./locales/uz";

export default createI18n({
  locale: "ru", // set locale
  fallbackLocale: "ru", // set fallback locale
  messages: { en, uz, ru }, // set locale messages
  // If you need to specify other options, you can set other options
  // ...
});
