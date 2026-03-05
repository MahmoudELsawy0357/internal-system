<script setup>
import { computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { t } = useI18n();

const props = defineProps({
    rank: { type: Object, required: true },
});

const modules = [
    { key: 'accounts', labelKey: 'ranks.modules.accounts', perms: [{ key: 'accounts_view', pk: 'view' }, { key: 'accounts_add', pk: 'add' }, { key: 'accounts_edit', pk: 'edit' }, { key: 'accounts_delete', pk: 'delete' }] },
    { key: 'departments', labelKey: 'ranks.modules.departments', perms: [{ key: 'dept_view', pk: 'view' }, { key: 'dept_add', pk: 'add' }, { key: 'dept_edit', pk: 'edit' }, { key: 'dept_delete', pk: 'delete' }] },
    { key: 'jobs', labelKey: 'ranks.modules.jobs', perms: [{ key: 'jobs_view', pk: 'view' }, { key: 'jobs_add', pk: 'add' }, { key: 'jobs_edit', pk: 'edit' }, { key: 'jobs_delete', pk: 'delete' }] },
    { key: 'employees', labelKey: 'ranks.modules.employees', perms: [{ key: 'emp_view', pk: 'view' }, { key: 'emp_add', pk: 'add' }, { key: 'emp_edit', pk: 'edit' }, { key: 'emp_delete', pk: 'delete' }] },
    { key: 'leaves', labelKey: 'ranks.modules.leaves', perms: [{ key: 'leaves_view', pk: 'view' }, { key: 'leaves_add', pk: 'add' }, { key: 'leaves_edit', pk: 'edit' }, { key: 'leaves_delete', pk: 'delete' }] },
    { key: 'attendance', labelKey: 'ranks.modules.attendance', perms: [{ key: 'att_view', pk: 'view' }, { key: 'att_add', pk: 'add' }, { key: 'att_edit', pk: 'edit' }, { key: 'att_delete', pk: 'delete' }] },
];

const form = useForm({
    name: props.rank.name ?? '',
    permissions: props.rank.permissions ?? [],
});

function toggleModule(mod) {
    const keys = mod.perms.map(p => p.key);
    const all = keys.every(k => form.permissions.includes(k));
    form.permissions = all ? form.permissions.filter(k => !keys.includes(k)) : [...new Set([...form.permissions, ...keys])];
}

function moduleAllSelected(mod) { return mod.perms.every(p => form.permissions.includes(p.key)); }
function modulePartialSelected(mod) { return mod.perms.some(p => form.permissions.includes(p.key)) && !moduleAllSelected(mod); }

const allKeys = modules.flatMap(m => m.perms.map(p => p.key));
const allSelected = computed(() => allKeys.every(k => form.permissions.includes(k)));
function toggleAll() { form.permissions = allSelected.value ? [] : [...allKeys]; }

function submit() { form.patch(route('ranks.update', props.rank.id)); }
</script>

<template>

    <Head :title="t('ranks.edit')" />
    <AuthenticatedLayout>
        <template #header>
            <nav class="breadcrumb">
                <a :href="route('dashboard')" class="bc-link">{{ t('layout.navDashboard') }}</a>
                <span class="bc-sep">/</span>
                <a :href="route('administration')" class="bc-link">{{ t('layout.admin') }}</a>
                <span class="bc-sep">/</span>
                <a :href="route('ranks')" class="bc-link">{{ t('ranks.title') }}</a>
                <span class="bc-sep">/</span>
                <span class="bc-current">{{ t('ranks.edit') }}</span>
            </nav>
        </template>

        <div class="create-page">
            <h1 class="page-title">{{ t('ranks.edit') }}</h1>
            <form @submit.prevent="submit" class="rank-form">
                <div class="field-group">
                    <label class="field-label">{{ t('ranks.name') }}</label>
                    <input v-model="form.name" type="text" class="field-input" :placeholder="t('ranks.namePlaceholder')"
                        required />
                    <p v-if="form.errors.name" class="field-error">{{ form.errors.name }}</p>
                </div>
                <div class="select-all-row">
                    <label class="check-label">
                        <input type="checkbox" class="check" :checked="allSelected" @change="toggleAll" />
                        <span>{{ t('ranks.selectAll') }}</span>
                    </label>
                </div>
                <div class="perms-grid">
                    <div v-for="mod in modules" :key="mod.key" class="perm-card">
                        <label class="perm-module-header check-label">
                            <input type="checkbox" class="check" :checked="moduleAllSelected(mod)"
                                :indeterminate="modulePartialSelected(mod)" @change="toggleModule(mod)" />
                            <span class="perm-module-title">{{ t(mod.labelKey) }}</span>
                        </label>
                        <div class="perm-divider"></div>
                        <label v-for="perm in mod.perms" :key="perm.key" class="check-label perm-item">
                            <input type="checkbox" class="check" :value="perm.key" v-model="form.permissions" />
                            <span>{{ t('ranks.perms.' + perm.pk) }}</span>
                        </label>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-save" :disabled="form.processing">
                        <svg v-if="form.processing" class="spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25" />
                            <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
                                class="opacity-75" />
                        </svg>
                        <span v-if="form.processing">{{ t('ranks.saving') }}</span>
                        <span v-else>{{ t('ranks.saveChanges') }}</span>
                    </button>
                    <a :href="route('ranks')" class="btn-cancel">{{ t('ranks.cancel') }}</a>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.create-page {
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

.page-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--text-main);
}

.rank-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.field-group {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.field-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-muted);
}

.field-input {
    height: 42px;
    padding: 0 0.9rem;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text-main);
    font-size: 0.9rem;
    font-family: inherit;
    outline: none;
    transition: border-color 0.18s;
    max-width: 340px;
}

.field-input:focus {
    border-color: var(--toggle-color);
}

.field-error {
    font-size: 0.8rem;
    color: #f87171;
}

.select-all-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 0;
    border-bottom: 1px solid var(--border);
}

.check-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: var(--text-main);
    user-select: none;
}

.check {
    width: 16px;
    height: 16px;
    accent-color: var(--toggle-color);
    cursor: pointer;
    flex-shrink: 0;
}

.perms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 1rem;
}

.perm-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1rem 1.1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    min-width: 360px;
}

.perm-module-header {
    font-weight: 700;
    font-size: 0.875rem;
}

.perm-module-title {
    color: var(--toggle-color);
}

.perm-divider {
    height: 1px;
    background: var(--border);
    margin: 0.25rem 0;
}

.perm-item {
    color: var(--text-muted);
    font-size: 0.85rem;
}

.perm-item:hover {
    color: var(--text-main);
}

.form-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-top: 0.5rem;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    height: 40px;
    padding: 0 1.5rem;
    background: var(--toggle-color);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    transition: opacity 0.18s;
}

.btn-save:hover:not(:disabled) {
    opacity: 0.85;
}

.btn-save:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-cancel {
    height: 40px;
    padding: 0 1.25rem;
    display: inline-flex;
    align-items: center;
    background: none;
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text-muted);
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.15s;
}

.btn-cancel:hover {
    color: var(--text-main);
    border-color: var(--text-muted);
}

.spin {
    width: 16px;
    height: 16px;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
