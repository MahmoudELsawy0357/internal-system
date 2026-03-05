<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { ref } from 'vue';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import LangToggle from '@/Components/LangToggle.vue';

defineProps({
    canLogin: { type: Boolean },
    canRegister: { type: Boolean },
    laravelVersion: { type: String, required: true },
    phpVersion: { type: String, required: true },
});

const { t, locale } = useI18n();

// ── Theme ──────────────────────────────────────
const savedTheme = localStorage.getItem('theme');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
const theme = ref(savedTheme ?? (prefersDark ? 'dark' : 'light'));
// ──────────────────────────────────────────────
</script>

<template>

    <Head :title="$t('hero.title')" />

    <div class="welcome-page" :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'" :data-theme="theme">
        <!-- Background decorations -->
        <div class="bg-decoration bg-decoration-1"></div>
        <div class="bg-decoration bg-decoration-2"></div>
        <div class="bg-decoration bg-decoration-3"></div>

        <!-- Header / Navbar -->
        <header class="navbar">
            <div class="navbar-inner">
                <!-- Logo -->
                <div class="logo-area">
                    <!--
                        TODO: استبدل الـ SVG ده بلوجو الشركة الحقيقي
                        مثال: <img src="/images/logo.png" alt="شعار الشركة" style="height:40px;" />
                    -->
                    <div class="logo-placeholder">
                        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="40" height="40" rx="10" fill="url(#logoGrad)" />
                            <path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" stroke="white" stroke-width="2" fill="none" />
                            <circle cx="20" cy="20" r="4" fill="white" />
                            <defs>
                                <linearGradient id="logoGrad" x1="0" y1="0" x2="40" y2="40"
                                    gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#A67C52" />
                                    <stop offset="1" stop-color="#6B4E2E" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <span class="logo-text">{{ $t('company.name') }}</span>
                    </div>
                </div>

                <div class="navbar-end">
                    <!-- Theme Toggle -->
                    <ThemeToggle v-model="theme" />

                    <!-- Language Toggle -->
                    <LangToggle />

                    <!-- Login Button -->
                    <nav v-if="canLogin">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="btn-icon">
                                <path fill-rule="evenodd"
                                    d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-1.07a.75.75 0 1 0-1.004-1.115l-2.5 2.25a.75.75 0 0 0 0 1.115l2.5 2.25a.75.75 0 1 0 1.004-1.115L8.704 10.75h9.546A.75.75 0 0 0 19 10Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $t('nav.dashboard') }}
                        </Link>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="main-content">
            <section class="hero-section">
                <div class="hero-logo">
                    <div class="hero-logo-ring">
                        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="80" height="80" rx="20" fill="url(#heroLogoGrad)" />
                            <path d="M40 16L60 28V52L40 64L20 52V28L40 16Z" stroke="white" stroke-width="3"
                                fill="none" />
                            <circle cx="40" cy="40" r="8" fill="white" />
                            <defs>
                                <linearGradient id="heroLogoGrad" x1="0" y1="0" x2="80" y2="80"
                                    gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#A67C52" />
                                    <stop offset="1" stop-color="#6B4E2E" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>

                <h1 class="hero-title">{{ $t('hero.title') }}</h1>
                <p class="hero-subtitle">{{ $t('hero.subtitle') }}</p>

                <div class="hero-actions">
                    <Link v-if="canLogin && !$page.props.auth.user" :href="route('login')"
                        class="btn btn-primary btn-large">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="btn-icon">
                            <path fill-rule="evenodd"
                                d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-1.07a.75.75 0 1 0-1.004-1.115l-2.5 2.25a.75.75 0 0 0 0 1.115l2.5 2.25a.75.75 0 1 0 1.004-1.115L8.704 10.75h9.546A.75.75 0 0 0 19 10Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $t('hero.loginBtn') }}
                    </Link>
                    <Link v-if="canLogin && $page.props.auth.user" :href="route('dashboard')"
                        class="btn btn-primary btn-large">
                        {{ $t('hero.dashboardBtn') }}
                    </Link>
                    <!--
                        TODO: أضف رابط موقع الشركة هنا لو موجود
                        <a href="https://yourcompany.com" target="_blank" class="btn btn-outline btn-large">{{ $t('hero.companyWebsite') }}</a>
                    -->
                </div>
            </section>

            <!-- Features -->
            <section class="features-section">
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                        <h3>{{ $t('features.employees.title') }}</h3>
                        <p>{{ $t('features.employees.desc') }}</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        </div>
                        <h3>{{ $t('features.leaves.title') }}</h3>
                        <p>{{ $t('features.leaves.desc') }}</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                        </div>
                        <h3>{{ $t('features.reports.title') }}</h3>
                        <p>{{ $t('features.reports.desc') }}</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                            </svg>
                        </div>
                        <h3>{{ $t('features.security.title') }}</h3>
                        <p>{{ $t('features.security.desc') }}</p>
                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section class="about-section">
                <div class="about-card">
                    <div class="about-content">
                        <h2 class="about-title">{{ $t('about.title') }}</h2>
                        <!-- TODO: استبدل الوصف ده بوصف الشركة الحقيقي في locales/ar.js و locales/en.js -->
                        <p class="about-text">{{ $t('about.text') }}</p>
                        <!--
                            TODO: أضف رابط الموقع عند توفره:
                            <a href="https://yourcompany.com" target="_blank" rel="noopener noreferrer" class="about-link">
                                {{ $t('about.visitWebsite') }}
                            </a>
                        -->
                    </div>
                    <div class="about-divider"></div>
                    <div class="about-stats">
                        <div class="stat">
                            <span class="stat-icon">🔒</span>
                            <span class="stat-label">{{ $t('about.secured') }}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-icon">⚡</span>
                            <span class="stat-label">{{ $t('about.fast') }}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-icon">📱</span>
                            <span class="stat-label">{{ $t('about.responsive') }}</span>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; {{ new Date().getFullYear() }} {{ $t('company.name') }} — {{ $t('footer.rights') }}</p>
            <p class="footer-sub">{{ $t('footer.support') }}</p>
        </footer>
    </div>
</template>

<style>
/* ============================================================
   Welcome Page — Page-specific styles only.
   Global design system (vars, fonts, buttons, cards…) → app.css
   ============================================================ */

/* ── Page Shell ─────────────────────────────────────────────── */
.welcome-page {
    min-height: 100vh;
    background: var(--bg-main);
    color: var(--text-main);
    font-family: 'Tajawal', 'Montserrat', system-ui, sans-serif;
    position: relative;
    overflow-x: hidden;
    transition: background 0.3s ease, color 0.3s ease;
}

/* ── Background Decorations ─────────────────────────────────── */
.bg-decoration {
    position: fixed;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    z-index: 0;
}

.bg-decoration-1 {
    width: 500px;
    height: 500px;
    background: #A67C52;
    opacity: var(--deco1-opacity);
    top: -200px;
    right: -100px;
}

.bg-decoration-2 {
    width: 400px;
    height: 400px;
    background: #33A1FD;
    opacity: var(--deco2-opacity);
    bottom: -100px;
    left: -100px;
}

.bg-decoration-3 {
    width: 300px;
    height: 300px;
    background: #A67C52;
    opacity: var(--deco3-opacity);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* ── Main Content ───────────────────────────────────────────── */
.main-content {
    position: relative;
    z-index: 1;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem 4rem;
}

/* ── Hero ───────────────────────────────────────────────────── */
.hero-section {
    text-align: center;
    padding: 6rem 1rem 4rem;
}

.hero-logo {
    margin-bottom: 2rem;
    display: flex;
    justify-content: center;
}

.hero-logo-ring {
    width: 100px;
    height: 100px;
    position: relative;
}

.hero-logo-ring svg {
    width: 100%;
    height: 100%;
    filter: drop-shadow(0 0 30px var(--toggle-color));
}

.hero-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    color: var(--toggle-color);
    margin: 0 0 1rem;
    line-height: 1.2;
}

.hero-subtitle {
    color: var(--text-muted);
    font-size: 1.2rem;
    margin: 0 0 2.5rem;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* ── Features ───────────────────────────────────────────────── */
.features-section {
    padding: 2rem 0 4rem;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.25rem;
}

.feature-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.75rem;
    transition: all 0.3s ease;
}

.feature-card:hover {
    background: var(--bg-card-hover);
    border-color: rgba(166, 124, 82, 0.4);
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(166, 124, 82, 0.12);
}

.feature-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, rgba(166, 124, 82, 0.15), rgba(51, 161, 253, 0.1));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    color: var(--toggle-color);
}

.feature-icon svg {
    width: 26px;
    height: 26px;
}

.feature-card h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-main);
    margin: 0 0 0.6rem;
}

.feature-card p {
    color: var(--text-muted);
    font-size: 0.9rem;
    line-height: 1.7;
    margin: 0;
}

/* ── About ──────────────────────────────────────────────────── */
.about-section {
    padding: 0 0 2rem;
}

.about-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 2.5rem;
    display: flex;
    gap: 2rem;
    align-items: center;
    flex-wrap: wrap;
}

.about-content {
    flex: 1;
    min-width: 260px;
}

.about-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--text-main);
    margin: 0 0 1rem;
}

.about-text {
    color: var(--text-muted);
    line-height: 1.9;
    font-size: 0.97rem;
    margin: 0 0 1.25rem;
}

.about-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--toggle-color);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
}

.about-link:hover {
    color: var(--text-main);
    gap: 0.75rem;
}

.link-icon {
    width: 18px;
    height: 18px;
}

.about-divider {
    width: 1px;
    height: 120px;
    background: var(--border);
    flex-shrink: 0;
}

.about-stats {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    min-width: 180px;
}

.stat {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.stat-icon {
    font-size: 1.4rem;
    width: 36px;
    text-align: center;
}

.stat-label {
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
}

/* ── Footer ─────────────────────────────────────────────────── */
.footer {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 2rem;
    border-top: 1px solid var(--border);
    color: var(--text-muted);
    font-size: 0.85rem;
}

.footer p {
    margin: 0.25rem 0;
}

.footer-sub {
    font-size: 0.78rem;
    opacity: 0.6;
}

/* ── Responsive ─────────────────────────────────────────────── */
@media (max-width: 768px) {
    .navbar {
        padding: 0 1rem;
    }

    .main-content {
        padding: 0 1rem 3rem;
    }

    .hero-section {
        padding: 4rem 0.5rem 3rem;
    }

    .about-card {
        flex-direction: column;
    }

    .about-divider {
        width: 100%;
        height: 1px;
    }

    .about-stats {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 1rem;
    }
}
</style>