<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import LangToggle from '@/Components/LangToggle.vue';

const { locale } = useI18n();
const isAr = computed(() => locale.value === 'ar');

// ── Theme (local ref to bind :data-theme on wrapper) ──────────
const savedTheme = localStorage.getItem('theme');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
const theme = ref(savedTheme ?? (prefersDark ? 'dark' : 'light'));

// ── Toggles visibility ─────────────────────────────
const showPassword = ref(false);

defineProps({
    status: { type: String },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head :title="isAr ? 'تسجيل الدخول' : 'Log In'" />

    <div class="login-page" :dir="isAr ? 'rtl' : 'ltr'" :data-theme="theme">
        <!-- Background -->
        <div class="login-blob login-blob-1"></div>
        <div class="login-blob login-blob-2"></div>
        <div class="login-grid"></div>

        <!-- Top Controls -->
        <div class="login-controls">
            <ThemeToggle v-model="theme" />
            <LangToggle />
        </div>

        <!-- Login Card -->
        <div class="login-card">

            <!-- Logo -->
            <div class="login-logo">
                <Link :href="route('home')" v-if="$page.props.ziggy?.routes?.home">
                    <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="10" fill="url(#loginLogoGrad)" />
                        <path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" stroke="white" stroke-width="2" fill="none" />
                        <circle cx="20" cy="20" r="4" fill="white" />
                        <defs>
                            <linearGradient id="loginLogoGrad" x1="0" y1="0" x2="40" y2="40"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#A67C52" />
                                <stop offset="1" stop-color="#6B4E2E" />
                            </linearGradient>
                        </defs>
                    </svg>
                </Link>
                <a href="/" v-else>
                    <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="10" fill="url(#loginLogoGrad2)" />
                        <path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" stroke="white" stroke-width="2" fill="none" />
                        <circle cx="20" cy="20" r="4" fill="white" />
                        <defs>
                            <linearGradient id="loginLogoGrad2" x1="0" y1="0" x2="40" y2="40"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#A67C52" />
                                <stop offset="1" stop-color="#6B4E2E" />
                            </linearGradient>
                        </defs>
                    </svg>
                </a>
            </div>

            <!-- Header -->
            <h1 class="login-title">{{ isAr ? 'تسجيل الدخول' : 'Welcome Back' }}</h1>
            <p class="login-sub">{{ isAr ? 'أدخل بياناتك للوصول إلى النظام' : 'Sign in to your account to continue' }}
            </p>

            <!-- Status message -->
            <div v-if="status" class="login-status">{{ status }}</div>

            <!-- Form -->
            <form @submit.prevent="submit" class="login-form">

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        {{ isAr ? 'البريد الإلكتروني' : 'Email Address' }}
                    </label>
                    <div class="input-wrap">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                            <path
                                d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
                        </svg>
                        <input id="email" type="email" class="form-input" v-model="form.email"
                            :placeholder="isAr ? 'example@company.com' : 'example@company.com'" required autofocus
                            autocomplete="username" />
                    </div>
                    <p v-if="form.errors.email" class="form-error">{{ form.errors.email }}</p>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        {{ isAr ? 'كلمة المرور' : 'Password' }}
                    </label>
                    <div class="input-wrap">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 1a4.5 4.5 0 0 0-4.5 4.5V9H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2h-.5V5.5A4.5 4.5 0 0 0 10 1Zm3 8V5.5a3 3 0 1 0-6 0V9h6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <input id="password" :type="showPassword ? 'text' : 'password'" class="form-input"
                            v-model="form.password" :placeholder="isAr ? '••••••••' : '••••••••'" required
                            autocomplete="current-password" />
                        <button type="button" class="input-eye" @click="showPassword = !showPassword" tabindex="-1">
                            <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                <path fill-rule="evenodd"
                                    d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z"
                                    clip-rule="evenodd" />
                                <path
                                    d="m10.748 13.93 2.523 2.523a10.015 10.015 0 0 1-7.4-2.45l1.412-1.412a8.054 8.054 0 0 0 3.465 1.339ZM10 5.5a4.5 4.5 0 0 0-4.326 3.267L4.5 7.586A6 6 0 0 1 10 4a6 6 0 0 1 4.12 1.632l-1.174 1.174A4.5 4.5 0 0 0 10 5.5Z" />
                            </svg>
                        </button>
                    </div>
                    <p v-if="form.errors.password" class="form-error">{{ form.errors.password }}</p>
                </div>

                <!-- Remember -->
                <div class="form-row">
                    <label class="remember-label">
                        <input type="checkbox" v-model="form.remember" class="remember-check" />
                        <span>{{ isAr ? 'تذكرني' : 'Remember me' }}</span>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary btn-login" :disabled="form.processing"
                    :class="{ 'btn-loading': form.processing }">
                    <svg v-if="!form.processing" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" class="btn-icon">
                        <path fill-rule="evenodd"
                            d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-1.07a.75.75 0 1 0-1.004-1.115l-2.5 2.25a.75.75 0 0 0 0 1.115l2.5 2.25a.75.75 0 1 0 1.004-1.115L8.704 10.75h9.546A.75.75 0 0 0 19 10Z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg v-else class="spin-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    {{ form.processing ? (isAr ? 'جاري الدخول…' : 'Signing in…') : (isAr ? 'دخول' : 'Sign In') }}
                </button>
            </form>
        </div>

        <!-- Back to home -->
        <a href="/" class="login-home-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-6H2a1 1 0 0 1-.707-1.707l7-7Z"
                    clip-rule="evenodd" />
            </svg>
            {{ isAr ? 'العودة للرئيسية' : 'Back to Home' }}
        </a>
    </div>
</template>

<style>
/* ── Login Page Shell ─────────────────────────────── */
.login-page {
    min-height: 100vh;
    background: var(--bg-main, #1A1A1A);
    color: var(--text-main, #E0E0E0);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    font-family: 'Tajawal', 'Montserrat', system-ui, sans-serif;
    padding: 2rem 1rem;
}

/* ── Background ───────────────────────────────────── */
.login-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(90px);
    pointer-events: none;
    animation: blobFloat 8s ease-in-out infinite;
}

.login-blob-1 {
    width: 500px;
    height: 500px;
    background: rgba(166, 124, 82, 0.12);
    top: -150px;
    right: -100px;
}

.login-blob-2 {
    width: 380px;
    height: 380px;
    background: rgba(51, 161, 253, 0.08);
    bottom: -120px;
    left: -80px;
    animation-delay: -4s;
}

.login-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(166, 124, 82, 0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(166, 124, 82, 0.04) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
}

/* ── Top Controls ─────────────────────────────────── */
.login-controls {
    position: fixed;
    top: 1.25rem;
    right: 1.25rem;
    display: flex;
    gap: 0.6rem;
    z-index: 100;
}

[dir="rtl"] .login-controls {
    right: auto;
    left: 1.25rem;
}

/* ── Card ─────────────────────────────────────────── */
.login-card {
    position: relative;
    z-index: 1;
    background: var(--bg-card, rgba(255, 255, 255, 0.04));
    border: 1px solid var(--border, rgba(166, 124, 82, 0.18));
    border-radius: 24px;
    padding: 2.5rem 2.25rem;
    width: 100%;
    max-width: 420px;
    backdrop-filter: blur(20px);
    box-shadow: 0 24px 80px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(166, 124, 82, 0.08);
    transition: background 0.3s ease, border-color 0.3s ease;
}

/* ── Logo ─────────────────────────────────────────── */
.login-logo {
    display: flex;
    justify-content: center;
    margin-bottom: 1.75rem;
}

.login-logo a,
.login-logo svg {
    display: block;
}

.login-logo svg {
    width: 52px;
    height: 52px;
    filter: drop-shadow(0 4px 16px rgba(166, 124, 82, 0.45));
    transition: transform 0.2s ease;
}

.login-logo a:hover svg {
    transform: scale(1.06);
}

/* ── Header ───────────────────────────────────────── */
.login-title {
    font-size: 1.6rem;
    font-weight: 700;

    color: var(--text-main, #E0E0E0);
    margin: 0 0 0.35rem;
    text-align: center;
}

.login-sub {
    color: var(--text-muted, #9A9A9A);
    font-size: 0.9rem;
    text-align: center;
    margin: 0 0 1.75rem;
}

.login-status {
    background: rgba(51, 195, 120, 0.12);
    border: 1px solid rgba(51, 195, 120, 0.3);
    color: #4ade80;
    border-radius: 8px;
    padding: 0.6rem 1rem;
    font-size: 0.88rem;
    margin-bottom: 1.25rem;
    text-align: center;
}

/* ── Form ─────────────────────────────────────────── */
.login-form {
    display: flex;
    flex-direction: column;
    gap: 1.1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.form-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-muted, #9A9A9A);
    letter-spacing: 0.02em;
}

.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

/* stretch the input to fill the wrap */
.input-wrap .form-input {
    flex: 1;
}

.input-icon {
    position: absolute;
    width: 16px;
    height: 16px;
    color: var(--text-muted, #9A9A9A);
    pointer-events: none;
    z-index: 1;
}

[dir="ltr"] .input-icon {
    left: 0.9rem;
}

[dir="rtl"] .input-icon {
    right: 0.9rem;
}

/* padding: icon side + eye side */
[dir="ltr"] .input-wrap .form-input {
    padding: 0 2.6rem 0 2.5rem;
}

[dir="rtl"] .input-wrap .form-input {
    padding: 0 2.5rem 0 2.6rem;
}

/* email has no eye, only icon on start — shrink end padding */
[dir="ltr"] .input-wrap:not(:has(.input-eye)) .form-input {
    padding-right: 0.85rem;
}

[dir="rtl"] .input-wrap:not(:has(.input-eye)) .form-input {
    padding-left: 0.85rem;
}

.form-input {
    width: 100%;
    background: var(--bg-card, rgba(255, 255, 255, 0.04));
    border: 1px solid var(--border, rgba(166, 124, 82, 0.18));
    border-radius: 10px;
    color: var(--text-main, #E0E0E0);
    font-size: 0.93rem;
    height: 44px;
    outline: none;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

/* Override browser autofill blue background */
.form-input:-webkit-autofill,
.form-input:-webkit-autofill:hover,
.form-input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0 1000px var(--bg-card, #f5ede4) inset !important;
    -webkit-text-fill-color: var(--text-main, #2c1a0e) !important;
    border-color: var(--border, rgba(166, 124, 82, 0.18)) !important;
    transition: background-color 9999s ease-in-out 0s;
}

.form-input:focus {
    border-color: var(--primary, #A67C52);
    box-shadow: 0 0 0 3px rgba(166, 124, 82, 0.15);
}

.form-input::placeholder {
    color: var(--text-muted, #9A9A9A);
    opacity: 0.6;
}

.input-eye {
    position: absolute;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    color: var(--text-muted, #9A9A9A);
    display: flex;
    align-items: center;
    transition: color 0.2s;
}

[dir="ltr"] .input-eye {
    right: 0.9rem;
}

[dir="rtl"] .input-eye {
    left: 0.9rem;
}

.input-eye:hover {
    color: var(--toggle-color, #C4975A);
}

.input-eye svg {
    width: 18px;
    height: 18px;
}

.form-error {
    font-size: 0.8rem;
    color: #f87171;
    margin: 0;
}

/* ── Remember + Forgot row ────────────────────────── */
.form-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: -0.2rem;
}

.remember-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: var(--text-muted, #9A9A9A);
    cursor: pointer;
    user-select: none;
}

.remember-check {
    width: 16px;
    height: 16px;
    accent-color: var(--toggle-color, #C4975A) !important;
    cursor: pointer;
}

.remember-check:checked {
    accent-color: var(--toggle-color, #C4975A) !important;
    background-color: var(--toggle-color, #C4975A) !important;
}

.forgot-link {
    font-size: 0.82rem;
    color: var(--toggle-color, #C4975A);
    text-decoration: none;
    font-weight: 600;
    transition: opacity 0.2s;
}

.forgot-link:hover {
    opacity: 0.75;
}

/* ── Submit Button ────────────────────────────────── */
.btn-login {
    width: 100%;
    justify-content: center;
    margin-top: 0.5rem;
    font-size: 1rem;
    letter-spacing: 0.03em;
}

.btn-loading {
    opacity: 0.75;
    cursor: not-allowed;
}

.spin-icon {
    width: 18px;
    height: 18px;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* ── Light theme ──────────────────────────────────── */
[data-theme="light"] .login-blob-1 {
    background: rgba(139, 100, 65, 0.1);
}

[data-theme="light"] .login-blob-2 {
    background: rgba(26, 141, 232, 0.07);
}

[data-theme="light"] .login-card {
    box-shadow: 0 24px 80px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(139, 100, 65, 0.08);
}

/* ── Responsive ───────────────────────────────────── */
@media (max-width: 480px) {
    .login-card {
        padding: 2rem 1.25rem;
        border-radius: 18px;
    }

    .login-controls {
        top: 0.75rem;
        right: 0.75rem;
    }
}

/* ── Back to Home link ────────────────────────────── */
.login-home-link {
    position: absolute;
    bottom: 1.75rem;
    left: 50%;
    transform: translateX(-50%);
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.82rem;
    color: var(--text-muted, #9A9A9A);
    text-decoration: none;

    transition: color 0.2s ease;
    white-space: nowrap;
    z-index: 2;
}

.login-home-link svg {
    width: 14px;
    height: 14px;
}

.login-home-link:hover {
    color: var(--toggle-color, #C4975A);
}
</style>
