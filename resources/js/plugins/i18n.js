import { createI18n } from "vue-i18n";
import ar from "../locales/ar.js";
import en from "../locales/en.js";

// اكتشاف اللغة: لو المتصفح عربي يبدأ عربي، غير كده إنجليزي
const savedLocale = localStorage.getItem("locale");
const browserLocale = navigator.language?.startsWith("ar") ? "ar" : "en";
const defaultLocale = savedLocale || browserLocale;

const i18n = createI18n({
    legacy: false, // Composition API mode
    locale: defaultLocale,
    fallbackLocale: "en",
    messages: { ar, en },
});

export default i18n;
