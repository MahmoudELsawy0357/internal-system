<script setup>
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import LangToggle from '@/Components/LangToggle.vue';

const { locale } = useI18n();
const isAr = computed(() => locale.value === 'ar');

// ── Theme (local ref to bind :data-theme on wrapper) ─────────────
const savedTheme = localStorage.getItem('theme');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
const theme = ref(savedTheme ?? (prefersDark ? 'dark' : 'light'));

const props = defineProps({ status: Number });

const title = computed(() => {
    const ar = isAr.value;
    if (props.status === 404) return ar ? 'الصفحة غير موجودة' : 'Page Not Found';
    if (props.status === 403) return ar ? 'غير مصرح لك' : 'Forbidden';
    if (props.status === 500) return ar ? 'خطأ في الخادم' : 'Server Error';
    if (props.status === 503) return ar ? 'الخدمة غير متاحة' : 'Service Unavailable';
    return ar ? 'حدث خطأ' : 'An Error Occurred';
});

const description = computed(() => {
    const ar = isAr.value;
    if (props.status === 404) return ar
        ? 'الصفحة اللي بتدور عليها مش موجودة أو اتنقلت لمكان تاني.'
        : "The page you're looking for doesn't exist or has been moved.";
    if (props.status === 403) return ar
        ? 'مش عندك صلاحية للوصول لهذه الصفحة.'
        : "You don't have permission to access this page.";
    if (props.status === 500) return ar
        ? 'حصل خطأ في الخادم. الفريق التقني عارف وبيشتغل على الموضوع.'
        : "Something went wrong on our end. We're working on it.";
    if (props.status === 503) return ar
        ? 'الخدمة في صيانة دلوقتي. هنرجع قريباً.'
        : "We're down for maintenance. Be right back.";
    return ar ? 'حدث خطأ غير متوقع.' : 'An unexpected error occurred.';
});

function goHome() { window.location.href = '/'; }
function goBack() { window.history.back(); }
</script>

<template>
    <div class="error-page" :dir="isAr ? 'rtl' : 'ltr'" :data-theme="theme">
        <!-- Background -->
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="grid-overlay"></div>

        <!-- Top-corner toggles -->
        <div class="error-controls">
            <ThemeToggle v-model="theme" />
            <LangToggle />
        </div>

        <!-- Main content -->
        <div class="error-content">
            <!-- Logo -->
            <div class="error-logo">
                <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="40" height="40" rx="10" fill="url(#errLogoGrad)" />
                    <path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" stroke="white" stroke-width="2" fill="none" />
                    <circle cx="20" cy="20" r="4" fill="white" />
                    <defs>
                        <linearGradient id="errLogoGrad" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#A67C52" />
                            <stop offset="1" stop-color="#6B4E2E" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <!-- Error Code -->
            <div class="error-code-wrap">
                <span class="error-code">{{ status }}</span>
                <div class="error-code-glow"></div>
            </div>

            <!-- Divider -->
            <div class="error-divider"></div>

            <!-- Title & Description -->
            <h1 class="error-title">{{ title }}</h1>
            <p class="error-desc">{{ description }}</p>

            <!-- Actions -->
            <div class="error-actions">
                <button class="btn btn-primary" @click="goHome">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="btn-icon">
                        <path fill-rule="evenodd"
                            d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-6H2a1 1 0 0 1-.707-1.707l7-7Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ isAr ? 'الصفحة الرئيسية' : 'Back to Home' }}
                </button>
                <button class="btn btn-outline" @click="goBack">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="btn-icon">
                        <path fill-rule="evenodd"
                            d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ isAr ? 'رجوع' : 'Go Back' }}
                </button>
            </div>
        </div>
    </div>
</template>

<style>
.error-page {
    min-height: 100vh;
    background: var(--bg-main, #1A1A1A);
    color: var(--text-main, #E0E0E0);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    font-family: 'Tajawal', 'Montserrat', system-ui, sans-serif;
}

/* ── Top Controls ─────────────────────────────────── */
.error-controls {
    position: fixed;
    top: 1.25rem;
    right: 1.25rem;
    display: flex;
    gap: 0.6rem;
    z-index: 100;
}

[dir="rtl"] .error-controls {
    right: auto;
    left: 1.25rem;
}

/* ── Background ───────────────────────────────────── */
.blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(90px);
    pointer-events: none;
    animation: blobFloat 8s ease-in-out infinite;
}

.blob-1 {
    width: 500px;
    height: 500px;
    background: rgba(166, 124, 82, 0.12);
    top: -150px;
    right: -100px;
}

.blob-2 {
    width: 400px;
    height: 400px;
    background: rgba(51, 161, 253, 0.08);
    bottom: -120px;
    left: -80px;
    animation-delay: -4s;
}

.grid-overlay {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(166, 124, 82, 0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(166, 124, 82, 0.04) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
}

/* ── Content ──────────────────────────────────────── */
.error-content {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 3rem 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 560px;
    width: 100%;
}

.error-logo {
    margin-bottom: 2rem;
}

.error-logo svg {
    width: 56px;
    height: 56px;
    filter: drop-shadow(0 4px 18px rgba(166, 124, 82, 0.45));
}

.error-code-wrap {
    position: relative;
    margin-bottom: 1.5rem;
}

.error-code {
    font-size: clamp(7rem, 18vw, 11rem);
    font-weight: 800;
    font-family: 'Montserrat', sans-serif;
    letter-spacing: -0.04em;
    line-height: 1;
    background: linear-gradient(135deg, var(--toggle-color, #C4975A) 20%, rgba(166, 124, 82, 0.4) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: block;
    position: relative;
    z-index: 1;
}

.error-code-glow {
    position: absolute;
    inset: -20px;
    background: radial-gradient(ellipse at center, rgba(166, 124, 82, 0.18) 0%, transparent 70%);
    pointer-events: none;
    z-index: 0;
}

.error-divider {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--toggle-color, #C4975A), transparent);
    border-radius: 99px;
    margin: 0 auto 1.75rem;
}

.error-title {
    font-size: clamp(1.4rem, 4vw, 2rem);
    font-weight: 700;
    color: var(--text-main, #E0E0E0);
    margin: 0 0 0.75rem;

}

.error-desc {
    color: var(--text-muted, #9A9A9A);
    font-size: 1rem;
    line-height: 1.8;
    margin: 0 0 2.5rem;
    max-width: 400px;
}

.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* ── Animations ───────────────────────────────────── */
@keyframes blobFloat {

    0%,
    100% {
        transform: translate(0, 0) scale(1);
    }

    33% {
        transform: translate(20px, -20px) scale(1.05);
    }

    66% {
        transform: translate(-10px, 15px) scale(0.97);
    }
}

[data-theme="light"] .blob-1 {
    background: rgba(139, 100, 65, 0.1);
}

[data-theme="light"] .blob-2 {
    background: rgba(26, 141, 232, 0.07);
}

@media (max-width: 480px) {
    .error-controls {
        top: 0.75rem;
        right: 0.75rem;
    }

    .error-content {
        padding: 2rem 1.25rem;
    }

    .error-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .error-actions .btn {
        justify-content: center;
    }
}
</style>
