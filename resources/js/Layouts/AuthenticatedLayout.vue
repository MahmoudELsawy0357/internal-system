<script setup>
import { ref, watchEffect, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import AppSidebar from '@/Components/AppSidebar.vue';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import LangToggle from '@/Components/LangToggle.vue';

const { t, locale } = useI18n();

// ── Theme ───────────────────────────────────────────────────────────
const savedTheme = localStorage.getItem('theme');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
const theme = ref(savedTheme ?? (prefersDark ? 'dark' : 'light'));

watchEffect(() => { document.documentElement.setAttribute('data-theme', theme.value); });
watchEffect(() => { document.documentElement.dir = locale.value === 'ar' ? 'rtl' : 'ltr'; });

const page = usePage();
const appName = computed(() => page.props.appName ?? page.props.app?.name ?? t('layout.appName'));
const sidebarOpen = ref(false);
</script>

<template>
    <div class="app-shell">

        <!-- Overlay (mobile) -->
        <div v-if="sidebarOpen" class="sidebar-overlay" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <div class="sidebar-wrapper" :class="{ 'sidebar-wrapper--open': sidebarOpen }">
            <AppSidebar :app-name="appName" @close="sidebarOpen = false" />
        </div>

        <!-- Main -->
        <div class="app-body">

            <!-- Floating toggles -->
            <div class="floating-toggles">
                <ThemeToggle v-model="theme" />
                <LangToggle />
            </div>

            <!-- Mobile topbar -->
            <header class="mobile-topbar">
                <button class="hamburger" @click="sidebarOpen = !sidebarOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <span class="mobile-topbar-title">{{ appName }}</span>
                <!-- Toggles inline in topbar on mobile -->
                <div class="topbar-toggles">
                    <ThemeToggle v-model="theme" />
                    <LangToggle />
                </div>
            </header>

            <!-- Page content -->
            <main class="app-main">
                <header class="page-header" v-if="$slots.header">
                    <slot name="header" />
                </header>
                <slot />
            </main>
        </div>

    </div>
</template>

<style scoped>
.app-shell {
    display: flex;
    min-height: 100vh;
    background: var(--bg-main);
    color: var(--text-main);
    font-family: 'Tajawal', system-ui, sans-serif;
}

/* Sidebar wrapper */
.sidebar-wrapper {
    flex-shrink: 0;
    position: sticky;
    top: 0;
    height: 100vh;
    z-index: 101;
    overflow: visible;
    transition: transform 0.3s ease;
}

/* Main */
.app-body {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    position: relative;
}

.app-main {
    flex: 1;
    padding: 1.75rem 2rem 3rem;
    width: 100%;
}

.page-header {
    border-bottom: 1px solid var(--border);
    padding: 1.25rem 0;
    margin-bottom: 1.5rem;
}

/* Floating toggles */
.floating-toggles {
    position: fixed;
    top: 1rem;
    inset-inline-end: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    z-index: 500;
    background: var(--bg-dropdown);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 0.35rem 0.5rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

/* Mobile */
.mobile-topbar {
    display: none;
}

.sidebar-overlay {
    display: none;
}

@media (max-width: 768px) {
    .sidebar-wrapper {
        position: fixed;
        inset-block: 0;
        inset-inline-start: 0;
        transform: translateX(-110%);
        height: 100%;
        z-index: 100;
    }

    [dir="rtl"] .sidebar-wrapper {
        transform: translateX(110%);
    }

    .sidebar-wrapper--open {
        transform: translateX(0) !important;
        box-shadow: 4px 0 32px rgba(0, 0, 0, 0.4);
    }

    .sidebar-overlay {
        display: block;
        position: fixed;
        inset: 0;
        z-index: 99;
        background: rgba(0, 0, 0, 0.5);
    }

    .mobile-topbar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: var(--bg-dropdown);
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        z-index: 90;
    }

    .hamburger {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--toggle-bg);
        border: 1px solid var(--toggle-border);
        color: var(--text-main);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hamburger svg {
        width: 18px;
        height: 18px;
    }

    .mobile-topbar-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--toggle-color);
        flex: 1;
    }

    .app-main {
        padding: 1.25rem 1rem 2.5rem;
    }

    .floating-toggles {
        display: none;
    }

    .topbar-toggles {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-inline-start: auto;
    }
}
</style>
