<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const user = computed(() => usePage().props.auth.user);
</script>

<template>

    <Head :title="t('dashboard.pageTitle')" />

    <AuthenticatedLayout>
        <div class="dashboard">

            <!-- ── Welcome Banner ─────────────────────────────── -->
            <div class="welcome-banner">
                <div class="welcome-banner-info">
                    <p class="welcome-label">{{ t('dashboard.welcomeLabel') }}</p>
                    <h1 class="welcome-name">{{ user?.name ?? t('dashboard.defaultUser') }}</h1>
                    <p class="welcome-sub">{{ t('dashboard.welcomeSub') }}</p>
                </div>
                <div class="welcome-banner-badge">
                    <div class="welcome-avatar">{{ user?.name?.charAt(0)?.toUpperCase() ?? '?' }}</div>
                </div>
            </div>

            <!-- ── Stats Row ──────────────────────────────────── -->
            <div class="stats-grid">

                <div class="stat-card stat-card--primary">
                    <div class="stat-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-card-label">{{ t('dashboard.jibbleStatus') }}</p>
                        <h3 class="stat-card-value">{{ t('dashboard.notClockedIn') }}</h3>
                        <button class="stat-card-action">{{ t('dashboard.clockIn') }}</button>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon stat-card-icon--orange">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-card-label">{{ t('dashboard.jiraTasks') }}</p>
                        <h3 class="stat-card-value">12</h3>
                        <p class="stat-card-sub stat-card-sub--orange">{{ t('dashboard.jiraHigh') }}</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon stat-card-icon--purple">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-card-label">{{ t('dashboard.odooLeads') }}</p>
                        <h3 class="stat-card-value">3</h3>
                        <p class="stat-card-sub stat-card-sub--purple">{{ t('dashboard.odooNew') }}</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon stat-card-icon--indigo">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-card-label">{{ t('dashboard.discordActivity') }}</p>
                        <h3 class="stat-card-value">24</h3>
                        <p class="stat-card-sub stat-card-sub--indigo">{{ t('dashboard.discordUnread') }}</p>
                    </div>
                </div>

            </div>

            <!-- ── Main Content Grid ───────────────────────────── -->
            <div class="content-grid">

                <!-- Sprint Tasks -->
                <div class="content-card content-card--wide">
                    <div class="content-card-header">
                        <h2 class="content-card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                            </svg>
                            {{ t('dashboard.sprintTasks') }}
                        </h2>
                        <span class="content-card-badge">{{ t('dashboard.thisSprint') }}</span>
                    </div>
                    <div class="task-list">
                        <div v-for="i in 3" :key="i" class="task-item">
                            <div class="task-item-left">
                                <span class="task-id">PROJ-{{ 100 + i }}</span>
                                <p class="task-title">{{ t('dashboard.taskTitle') }}</p>
                            </div>
                            <span class="task-status task-status--progress">{{ t('dashboard.inProgress') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right column -->
                <div class="content-side">

                    <!-- Timesheet -->
                    <div class="content-card">
                        <div class="content-card-header">
                            <h2 class="content-card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                {{ t('dashboard.timesheetTitle') }}
                            </h2>
                        </div>
                        <div class="timesheet-body">
                            <p class="timesheet-clock">00:00:00</p>
                            <p class="timesheet-sub">{{ t('dashboard.timesheetSub') }}</p>
                        </div>
                    </div>

                    <!-- Discord -->
                    <div class="content-card content-card--accent">
                        <div class="content-card-header">
                            <h2 class="content-card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                </svg>
                                {{ t('dashboard.discordTitle') }}
                            </h2>
                        </div>
                        <p class="discord-msg">"{{ t('dashboard.discordMsg') }}"</p>
                    </div>

                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.dashboard {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.welcome-banner {
    background: linear-gradient(135deg, rgba(166, 124, 82, 0.12), rgba(166, 124, 82, 0.04));
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 1.75rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.welcome-label {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin: 0 0 0.2rem;
}

.welcome-name {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--toggle-color);
    margin: 0 0 0.35rem;
    line-height: 1.2;
}

.welcome-sub {
    font-size: 0.88rem;
    color: var(--text-muted);
    margin: 0;
}

.welcome-avatar {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: linear-gradient(135deg, #A67C52, #6B4E2E);
    color: #fff;
    font-size: 1.4rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(166, 124, 82, 0.4);
    flex-shrink: 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
    gap: 1rem;
}

.stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.25rem;
    display: flex;
    gap: 1rem;
    align-items: flex-start;
    transition: all 0.25s ease;
}

.stat-card:hover {
    background: var(--bg-card-hover);
    border-color: rgba(166, 124, 82, 0.35);
    transform: translateY(-3px);
    box-shadow: 0 10px 32px rgba(0, 0, 0, 0.15);
}

.stat-card--primary {
    background: linear-gradient(135deg, #A67C52, #6B4E2E);
    border-color: transparent;
    color: #fff;
}

.stat-card--primary:hover {
    background: linear-gradient(135deg, #B88D63, #7A5A35);
    border-color: transparent;
}

.stat-card-icon {
    width: 42px;
    height: 42px;
    border-radius: 11px;
    background: rgba(166, 124, 82, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--toggle-color);
    flex-shrink: 0;
}

.stat-card-icon svg {
    width: 22px;
    height: 22px;
}

.stat-card--primary .stat-card-icon {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
}

.stat-card-icon--orange {
    background: rgba(249, 115, 22, 0.12);
    color: #f97316;
}

.stat-card-icon--purple {
    background: rgba(168, 85, 247, 0.12);
    color: #a855f7;
}

.stat-card-icon--indigo {
    background: rgba(99, 102, 241, 0.12);
    color: #6366f1;
}

.stat-card-body {
    flex: 1;
    min-width: 0;
}

.stat-card-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--text-muted);
    margin: 0 0 0.3rem;
}

.stat-card--primary .stat-card-label {
    color: rgba(255, 255, 255, 0.75);
}

.stat-card-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text-main);
    margin: 0 0 0.5rem;
    line-height: 1.1;
}

.stat-card--primary .stat-card-value {
    color: #fff;
    font-size: 1.1rem;
}

.stat-card-sub {
    font-size: 0.78rem;
    font-weight: 600;
    margin: 0;
}

.stat-card-sub--orange {
    color: #f97316;
}

.stat-card-sub--purple {
    color: #a855f7;
}

.stat-card-sub--indigo {
    color: #6366f1;
}

.stat-card-action {
    margin-top: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 7px;
    padding: 0.3rem 0.75rem;
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
}

.stat-card-action:hover {
    background: rgba(255, 255, 255, 0.3);
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 1.25rem;
    align-items: start;
}

.content-side {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.content-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 1.5rem;
    transition: background 0.3s ease;
}

.content-card--accent {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(168, 85, 247, 0.05));
    border-color: rgba(99, 102, 241, 0.2);
}

.content-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border);
}

.content-card-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-main);
    margin: 0;
}

.content-card-title svg {
    width: 18px;
    height: 18px;
    color: var(--toggle-color);
}

.content-card-badge {
    font-size: 0.72rem;
    font-weight: 600;
    background: var(--toggle-bg);
    color: var(--toggle-color);
    border: 1px solid var(--toggle-border);
    border-radius: 6px;
    padding: 0.2rem 0.55rem;
}

.task-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.task-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 0.85rem 1rem;
    background: var(--bg-main);
    border: 1px solid var(--border);
    border-radius: 12px;
    transition: all 0.2s ease;
}

.task-item:hover {
    border-color: rgba(166, 124, 82, 0.35);
    background: var(--bg-card-hover);
}

.task-item-left {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.task-id {
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--toggle-color);
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.task-title {
    font-size: 0.88rem;
    color: var(--text-main);
    margin: 0;
    font-weight: 500;
}

.task-status {
    flex-shrink: 0;
    font-size: 0.72rem;
    font-weight: 700;
    border-radius: 6px;
    padding: 0.25rem 0.6rem;
}

.task-status--progress {
    background: rgba(51, 161, 253, 0.12);
    color: #33a1fd;
}

.timesheet-body {
    text-align: center;
    padding: 0.5rem 0;
}

.timesheet-clock {
    font-size: 2.2rem;
    font-family: 'Montserrat', 'Courier New', monospace;
    font-weight: 800;
    color: var(--toggle-color);
    margin: 0 0 0.4rem;
    letter-spacing: 0.05em;
}

.timesheet-sub {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin: 0;
}

.discord-msg {
    font-size: 0.9rem;
    color: #818cf8;
    font-style: italic;
    line-height: 1.7;
    margin: 0;
}

@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
    }

    .content-card--wide {
        order: 1;
    }

    .content-side {
        display: grid;
        grid-template-columns: 1fr 1fr;
        order: 2;
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }

    .content-side {
        grid-template-columns: 1fr;
    }

    .welcome-banner {
        padding: 1.25rem;
    }

    .welcome-name {
        font-size: 1.4rem;
    }
}
</style>