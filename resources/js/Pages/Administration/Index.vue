<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { t } = useI18n();

const props = defineProps({
    stats: { type: Object, default: () => ({ employees: { count: 0, new: 0 } }) },
});

const recentRequests = [
    { name: 'Ahmed Hassan', email: 'ahmed@company.com', phone: '010-0000-0001', role: 'مهندس' },
    { name: 'Sara Mohamed', email: 'sara@company.com', phone: '010-0000-0002', role: 'محاسب' },
    { name: 'Omar Khalil', email: 'omar@company.com', phone: '010-0000-0003', role: 'مصمم' },
    { name: 'Nour Ibrahim', email: 'nour@company.com', phone: '010-0000-0004', role: 'مطور' },
];

const chartData = [
    { label: 'جديد', value: 25, color: '#A67C52' },
    { label: 'في الانتظار', value: 25, color: '#C4975A' },
    { label: 'تم الانتهاء', value: 25, color: '#D4B896' },
    { label: 'تم الإلغاء', value: 25, color: '#E8D5BA' },
];

const svgPie = computed(() => {
    let startAngle = -90;
    return chartData.map(seg => {
        const angle = (seg.value / 100) * 360;
        const r = 70, cx = 80, cy = 80;
        const start = polar(cx, cy, r, startAngle);
        const end = polar(cx, cy, r, startAngle + angle);
        const large = angle > 180 ? 1 : 0;
        const d = `M${cx},${cy} L${start.x},${start.y} A${r},${r} 0 ${large} 1 ${end.x},${end.y} Z`;
        startAngle += angle;
        return { ...seg, d };
    });
});

function polar(cx, cy, r, deg) {
    const rad = (deg * Math.PI) / 180;
    return { x: +(cx + r * Math.cos(rad)).toFixed(2), y: +(cy + r * Math.sin(rad)).toFixed(2) };
}
</script>

<template>

    <Head :title="t('layout.admin')" />
    <AuthenticatedLayout>
        <template #header>
            <div class="page-header-inner">
                <nav class="breadcrumb">
                    <a :href="route('dashboard')" class="bc-link">{{ t('layout.navDashboard') }}</a>
                    <span class="bc-sep">/</span>
                    <span class="bc-current">{{ t('layout.admin') }}</span>
                </nav>
            </div>
        </template>

        <div class="admin-page">
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-info">
                        <p class="stat-label">{{ t('layout.employees') }}</p>
                        <h2 class="stat-value">{{ stats.employees.count }}</h2>
                        <p class="stat-sub">
                            <span class="stat-badge">+{{ stats.employees.new }}</span>
                            {{ t('layout.sinceLastMonth') }}
                        </p>
                    </div>
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="content-grid">
                <div class="card">
                    <h3 class="card-title">{{ t('layout.recentRequests') }}</h3>
                    <div class="table-wrap">
                        <table class="req-table">
                            <thead>
                                <tr>
                                    <th>{{ t('ranks.name') }}</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="req in recentRequests" :key="req.email">
                                    <td>{{ req.name }}</td>
                                    <td>{{ req.email }}</td>
                                    <td>{{ req.phone }}</td>
                                    <td>{{ req.role }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card chart-card">
                    <h3 class="card-title">{{ t('layout.requestsChart') }}</h3>
                    <div class="chart-body">
                        <svg viewBox="0 0 160 160" class="pie-svg">
                            <path v-for="seg in svgPie" :key="seg.label" :d="seg.d" :fill="seg.color"
                                stroke="var(--bg-card)" stroke-width="2" />
                        </svg>
                        <div class="chart-legend">
                            <div v-for="seg in chartData" :key="seg.label" class="legend-item">
                                <span class="legend-dot" :style="{ background: seg.color }"></span>
                                <span class="legend-label">{{ seg.label }}</span>
                                <span class="legend-val">{{ seg.value }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="chart-tabs">
                        <button class="chart-tab chart-tab--active">{{ t('layout.requests') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.admin-page {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.page-header-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.88rem;
    color: var(--text-muted);
}

.bc-link {
    color: var(--text-muted);
    text-decoration: none;
}

.bc-link:hover {
    color: var(--toggle-color);
}

.bc-sep {
    opacity: 0.4;
}

.bc-current {
    color: var(--text-main);
    font-weight: 500;
}

.stats-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    min-width: 220px;
    flex: 1;
    max-width: 320px;
}

.stat-label {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-main);
    line-height: 1;
    margin-bottom: 0.4rem;
}

.stat-sub {
    font-size: 0.78rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.stat-badge {
    background: rgba(74, 222, 128, 0.15);
    color: #4ade80;
    border-radius: 6px;
    padding: 0.1rem 0.4rem;
    font-weight: 700;
    font-size: 0.75rem;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--toggle-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon svg {
    width: 26px;
    height: 26px;
    color: var(--toggle-color);
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 1.25rem;
}

@media (max-width: 900px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

.card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
}

.card-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 1rem;
}

.table-wrap {
    overflow-x: auto;
}

.req-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
}

.req-table th {
    text-align: start;
    color: var(--text-muted);
    font-weight: 600;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    padding: 0.5rem 0.75rem;
    border-bottom: 1px solid var(--border);
}

.req-table td {
    padding: 0.75rem 0.75rem;
    color: var(--text-main);
    border-bottom: 1px solid var(--border);
}

.req-table tbody tr:last-child td {
    border-bottom: none;
}

.req-table tbody tr:hover td {
    background: rgba(255, 255, 255, 0.03);
}

.chart-card {
    display: flex;
    flex-direction: column;
}

.chart-body {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    flex-wrap: wrap;
}

.pie-svg {
    width: 140px;
    height: 140px;
    flex-shrink: 0;
}

.chart-legend {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    flex: 1;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.82rem;
}

.legend-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}

.legend-label {
    flex: 1;
    color: var(--text-muted);
}

.legend-val {
    font-weight: 700;
    color: var(--text-main);
}

.chart-tabs {
    margin-top: 1rem;
    display: flex;
    gap: 0.5rem;
}

.chart-tab {
    padding: 0.4rem 1rem;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 600;
    background: none;
    border: 1px solid var(--border);
    color: var(--text-muted);
    cursor: pointer;
    transition: all 0.15s;
}

.chart-tab--active {
    background: var(--text-main);
    color: var(--bg-main);
    border-color: var(--text-main);
}
</style>
