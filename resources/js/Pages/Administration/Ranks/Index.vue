<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { t } = useI18n();

const props = defineProps({
    ranks: { type: Array, default: () => [] },
});

const search = ref('');
const filtered = computed(() =>
    props.ranks.filter(r => r.name.toLowerCase().includes(search.value.toLowerCase()))
);
</script>

<template>

    <Head :title="t('ranks.title')" />
    <AuthenticatedLayout>
        <template #header>
            <nav class="breadcrumb">
                <a :href="route('dashboard')" class="bc-link">{{ t('layout.navDashboard') }}</a>
                <span class="bc-sep">/</span>
                <a :href="route('administration')" class="bc-link">{{ t('layout.admin') }}</a>
                <span class="bc-sep">/</span>
                <span class="bc-current">{{ t('ranks.title') }}</span>
            </nav>
        </template>

        <div class="ranks-page">
            <div class="top-bar">
                <h1 class="page-title">{{ t('ranks.title') }}</h1>
                <div class="top-bar-actions">
                    <div class="search-wrap">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input v-model="search" type="text" class="search-input" :placeholder="t('ranks.search')" />
                    </div>
                    <a :href="route('ranks.create')" class="btn-create">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                        {{ t('ranks.create') }}
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ t('ranks.name') }}</th>
                                <th>{{ t('ranks.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="filtered.length === 0">
                                <td colspan="3" class="empty-row">{{ t('ranks.noResults') }}</td>
                            </tr>
                            <tr v-for="rank in filtered" :key="rank.id">
                                <td class="td-id">{{ rank.id }}</td>
                                <td>{{ rank.name }}</td>
                                <td class="td-actions">
                                    <a :href="route('ranks.edit', rank.id)" class="action-btn"
                                        :title="t('ranks.editAction')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="table-count">
                    {{ t('ranks.showing') }} {{ filtered.length }} {{ t('ranks.of') }} {{ ranks.length }} {{
                        t('ranks.entries')
                    }}
                </p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.ranks-page {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
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

.top-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.page-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--text-main);
}

.top-bar-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.search-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    inset-inline-start: 0.7rem;
    width: 16px;
    height: 16px;
    color: var(--text-muted);
    pointer-events: none;
}

.search-input {
    height: 38px;
    padding: 0 0.9rem 0 2.2rem;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text-main);
    font-size: 0.875rem;
    font-family: inherit;
    outline: none;
    width: 200px;
    transition: border-color 0.18s;
}

[dir="rtl"] .search-input {
    padding: 0 2.2rem 0 0.9rem;
}

.search-input:focus {
    border-color: var(--toggle-color);
}

.search-input::placeholder {
    color: var(--text-muted);
    opacity: 0.6;
}

.btn-create {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    height: 38px;
    padding: 0 1.1rem;
    background: var(--toggle-color);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: opacity 0.18s;
    text-decoration: none;
}

.btn-create:hover {
    opacity: 0.88;
}

.btn-create svg {
    width: 16px;
    height: 16px;
}

.card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
}

.table-wrap {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

.data-table th {
    text-align: start;
    color: var(--text-muted);
    font-weight: 600;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    padding: 0.5rem 1rem;
    border-bottom: 1px solid var(--border);
}

.data-table td {
    padding: 0.85rem 1rem;
    color: var(--text-main);
    border-bottom: 1px solid var(--border);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.data-table tbody tr:hover td {
    background: rgba(166, 124, 82, 0.04);
}

.td-id {
    color: var(--text-muted);
    width: 3rem;
}

.td-actions {
    width: 6rem;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: var(--toggle-bg);
    border: 1px solid var(--border);
    color: var(--text-muted);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
    text-decoration: none;
    margin: auto;
}

.action-btn:hover {
    color: var(--toggle-color);
    border-color: var(--toggle-color);
}

.action-btn svg {
    width: 15px;
    height: 15px;
}

.empty-row {
    text-align: center;
    color: var(--text-muted);
    padding: 2rem !important;
}

.table-count {
    margin-top: 0.75rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}
</style>
