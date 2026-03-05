<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
    mustVerifyEmail: { type: Boolean },
    status: { type: String },
});
</script>

<template>

    <Head :title="t('profile.pageTitle')" />

    <AuthenticatedLayout>
        <div class="profile-page">

            <div class="profile-header">
                <h1 class="profile-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                    </svg>
                    {{ t('profile.pageTitle') }}
                </h1>
                <p class="profile-subtitle">{{ t('profile.pageSubtitle') }}</p>
            </div>

            <div class="profile-cards">
                <div class="profile-card">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
                </div>
                <div class="profile-card">
                    <UpdatePasswordForm />
                </div>
                <div class="profile-card profile-card--danger">
                    <DeleteUserForm />
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.profile-page {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.profile-header {
    margin-bottom: 0.25rem;
}

.profile-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--toggle-color);
    margin: 0 0 0.35rem;
}

.profile-title svg {
    width: 22px;
    height: 22px;
}

.profile-subtitle {
    font-size: 0.88rem;
    color: var(--text-muted);
    margin: 0;
}

.profile-cards {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 1.25rem;
}

.profile-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    flex: 1 1 340px;
    /* grow/shrink freely, collapse to full width below 340px */
    min-width: 0;
    border-radius: 18px;
    padding: 1.75rem 2rem;
    transition: background 0.3s ease;
}

.profile-card--danger {
    flex-basis: 100%;
    border-color: rgba(248, 113, 113, 0.2);
    background: rgba(248, 113, 113, 0.03);
}
</style>
