<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import SidebarNavItem from '@/Components/SidebarNavItem.vue';

const { t } = useI18n();

defineProps({ appName: { type: String, default: '' } });
const emit = defineEmits(['close']);

const collapsed = ref(false);

// Auto-expand when screen goes mobile
const onResize = () => { if (window.innerWidth <= 768) collapsed.value = false; };
onMounted(() => window.addEventListener('resize', onResize));
onUnmounted(() => window.removeEventListener('resize', onResize));

const openKey = ref(null);
const toggle = (key) => {
    if (collapsed.value) { collapsed.value = false; }
    openKey.value = openKey.value === key ? null : key;
};

const navItems = computed(() => [
    {
        key: 'admin', label: t('layout.admin'), icon: 'settings',
        href: route('administration'),
        children: [
            { label: t('layout.ranks'), href: route('ranks') },
            { label: t('layout.accounts'), href: '#', disabled: true },
        ],
    },
    {
        key: 'departments', label: t('layout.departments'), icon: 'grid',
        children: [
            { label: t('layout.departments'), href: '#' },
            { label: t('layout.newDepartment'), href: '#' },
        ],
    },
    {
        key: 'jobs', label: t('layout.jobs'), icon: 'briefcase',
        children: [
            { label: t('layout.jobs'), href: '#' },
            { label: t('layout.newJob'), href: '#' },
        ],
    },
    {
        key: 'employees', label: t('layout.employees'), icon: 'users',
        children: [
            { label: t('layout.employees'), href: '#' },
            { label: t('layout.newEmployee'), href: '#' },
        ],
    },
    {
        key: 'contracts', label: t('layout.contracts'), icon: 'document',
        children: [
            { label: t('layout.companyAssets'), href: '#' },
            { label: t('layout.contracts'), href: '#', disabled: true },
        ],
    },
    {
        key: 'leaves', label: t('layout.leaves'), icon: 'calendar',
        children: [
            { label: t('layout.leaves'), href: '#' },
            { label: t('layout.newLeave'), href: '#' },
        ],
    },
    {
        key: 'attendance', label: t('layout.attendance'), icon: 'clock',
        children: [
            { label: t('layout.attendanceLogs'), href: '#' },
        ],
    },
    {
        key: 'permissions', label: t('layout.permissions'), icon: 'users',
        children: [
            { label: t('layout.permissions'), href: '#' },
        ],
    },
    {
        key: 'blogs', label: t('layout.blogs'), icon: 'newspaper',
        children: [
            { label: t('layout.blogs'), href: '#' },
            { label: t('layout.newBlog'), href: '#' },
        ],
    },
    {
        key: 'influencers', label: t('layout.influencers'), icon: 'star',
        children: [
            { label: t('layout.influencers'), href: '#' },
        ],
    },
]);
</script>

<template>
    <div class="sidebar-wrap">

        <!-- Collapse toggle — outside aside so it doesn't scroll -->
        <button class="collapse-btn" @click="collapsed = !collapsed" :title="collapsed ? 'Expand' : 'Collapse'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="collapse-icon"
                :class="{ 'collapse-icon--flipped': collapsed }">
                <path fill-rule="evenodd"
                    d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"
                    clip-rule="evenodd" />
            </svg>
        </button>

        <aside class="sidebar" :class="{ 'sidebar--collapsed': collapsed }">

            <!-- Logo -->
            <div class="sidebar-logo">
                <Link :href="route('dashboard')" class="logo-link">
                    <svg viewBox="0 0 40 40" fill="none" class="logo-svg">
                        <rect width="40" height="40" rx="10" fill="url(#sideLogoGrad)" />
                        <path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" stroke="white" stroke-width="2" fill="none" />
                        <circle cx="20" cy="20" r="4" fill="white" />
                        <defs>
                            <linearGradient id="sideLogoGrad" x1="0" y1="0" x2="40" y2="40"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#A67C52" />
                                <stop offset="1" stop-color="#6B4E2E" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <span class="logo-text">{{ appName }}</span>
                </Link>
            </div>

            <!-- Nav -->
            <nav class="sidebar-nav">
                <!-- Home & Profile quick links -->
                <Link :href="route('dashboard')" class="nav-direct"
                    :class="{ 'nav-direct--active': route().current('dashboard') }" @click="emit('close')">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </span>
                    <span class="nav-label">{{ t('layout.navDashboard') }}</span>
                </Link>
                <Link :href="route('profile.edit')" class="nav-direct"
                    :class="{ 'nav-direct--active': route().current('profile.edit') }" @click="emit('close')">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </span>
                    <span class="nav-label">{{ t('layout.profile') }}</span>
                </Link>

                <div class="nav-divider"></div>

                <!-- Accordion items -->
                <SidebarNavItem v-for="item in navItems" :key="item.key" :item="item"
                    :is-open="!collapsed && openKey === item.key" :collapsed="collapsed" @toggle="toggle"
                    @child-click="emit('close')" />
            </nav>

            <div class="sidebar-spacer"></div>

            <!-- Logout -->
            <div class="sidebar-footer">
                <Link :href="route('logout')" method="post" as="button" class="nav-logout">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                    </span>
                    <span class="nav-label">{{ t('layout.logout') }}</span>
                </Link>
            </div>
        </aside>
    </div>
</template>

<style scoped>
/* ── Outer wrapper (non-scrolling) ───────────────────────────── */
.sidebar-wrap {
    position: relative;
    display: flex;
    height: 100%;
    flex-shrink: 0;
}

/* ── Sidebar ──────────────────────────────────────────────────── */
.sidebar {
    width: 230px;
    flex-shrink: 0;
    background: var(--bg-dropdown);
    border-inline-end: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: none;
    transition: width 0.28s ease;
    position: relative;
}

.sidebar::-webkit-scrollbar {
    display: none;
}

/* Collapsed state */
.sidebar--collapsed {
    width: 62px;
}

.sidebar--collapsed .logo-text,
.sidebar--collapsed .nav-label {
    display: none;
}

.sidebar--collapsed .sidebar-logo {
    padding: 1.25rem 0.75rem 1rem;
}

.sidebar--collapsed .logo-link {
    justify-content: center;
}

.sidebar--collapsed .nav-direct {
    justify-content: center;
    padding: 0.7rem;
}

.sidebar--collapsed .nav-logout {
    justify-content: center;
    padding: 0.7rem;
}

.sidebar--collapsed .nav-divider {
    margin: 0.4rem 0.5rem;
}

/* ── Collapse Button ────────────────────────────────────────── */
.collapse-btn {
    position: absolute;
    top: 24%;
    transform: translateY(-24%);
    inset-inline-end: -13px;
    z-index: 200;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: var(--bg-dropdown);
    border: 1px solid var(--border);
    color: var(--text-muted);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.18s, background 0.18s;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}

.collapse-btn:hover {
    color: var(--toggle-color);
    background: var(--toggle-bg);
}

.collapse-icon {
    width: 14px;
    height: 14px;
    transition: transform 0.28s ease;
}

/* In RTL the chevron already points right (toward the border), flip when collapsed */
[dir="rtl"] .collapse-icon {
    transform: rotate(180deg);
}

[dir="rtl"] .collapse-icon--flipped {
    transform: rotate(0deg);
}

[dir="ltr"] .collapse-icon {
    transform: rotate(180deg);
}

[dir="ltr"] .collapse-icon--flipped {
    transform: rotate(0deg);
}

/* ── Logo ───────────────────────────────────────────────────── */
.sidebar-logo {
    padding: 1.25rem 1.25rem 1rem;
}

.logo-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.65rem;
    text-decoration: none;
}

.logo-svg {
    width: 36px;
    height: 36px;
    flex-shrink: 0;
}

.logo-text {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--toggle-color);
    white-space: nowrap;
    overflow: hidden;
    transition: opacity 0.2s;
}

/* ── Nav ────────────────────────────────────────────────────── */
.sidebar-nav {
    display: flex;
    flex-direction: column;
    padding: 0.5rem 0.75rem;
    gap: 0.2rem;
}

.sidebar--collapsed .sidebar-nav {
    padding: 0.5rem 0.5rem;
}

.nav-direct {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.7rem 0.85rem;
    border-radius: 10px;
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.18s ease;
    white-space: nowrap;
}

.nav-direct:hover {
    color: var(--text-main);
    background: rgba(255, 255, 255, 0.05);
}

.nav-direct--active {
    color: var(--toggle-color);
    background: var(--toggle-bg);
    font-weight: 700;
}

.nav-divider {
    height: 1px;
    background: var(--border);
    margin: 0.4rem 0.25rem 0.5rem;
}

/* ── Spacer & Footer ────────────────────────────────────────── */
.sidebar-spacer {
    flex: 1;
}

.sidebar-footer {
    padding: 0.5rem 0.75rem 1rem;
    border-top: 1px solid var(--border);
}

.sidebar--collapsed .sidebar-footer {
    padding: 0.5rem 0.5rem 1rem;
}

.nav-logout {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    width: 100%;
    padding: 0.7rem 0.85rem;
    border-radius: 10px;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
    font-family: inherit;
    transition: all 0.18s ease;
    text-decoration: none;
    white-space: nowrap;
}

.nav-logout:hover {
    color: #f87171;
    background: rgba(248, 113, 113, 0.08);
}

.nav-icon {
    width: 22px;
    height: 22px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-icon svg {
    width: 20px;
    height: 20px;
}

@media (max-width: 768px) {
    .collapse-btn {
        display: none;
    }
}
</style>
