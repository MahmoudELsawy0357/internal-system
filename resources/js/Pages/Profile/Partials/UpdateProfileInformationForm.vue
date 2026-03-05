<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
    mustVerifyEmail: { type: Boolean },
    status: { type: String },
});

const user = usePage().props.auth.user;
const form = useForm({ name: user.name });
</script>

<template>
    <section>
        <div class="section-header">
            <h2 class="section-title">{{ t('profile.info.title') }}</h2>
            <p class="section-desc">{{ t('profile.info.desc') }}</p>
        </div>

        <form @submit.prevent="form.patch(route('profile.update'))" class="profile-form">

            <div class="form-group">
                <label for="name" class="form-label">{{ t('profile.info.name') }}</label>
                <input id="name" type="text" class="form-input" v-model="form.name" required autofocus
                    autocomplete="name" />
                <p v-if="form.errors.name" class="form-error">{{ form.errors.name }}</p>
            </div>

            <div class="form-group">
                <label for="username" class="form-label">{{ t('profile.info.username') }}</label>
                <div class="input-prefix-wrap">
                    <span class="input-prefix">@</span>
                    <input id="username" type="text" class="form-input form-input--readonly form-input--prefixed"
                        :value="user.username" disabled />
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">{{ t('profile.info.email') }}</label>
                <input id="email" type="email" class="form-input form-input--readonly" :value="user.email" disabled
                    autocomplete="username" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null" class="verify-notice">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                        clip-rule="evenodd" />
                </svg>
                <span>
                    {{ t('profile.email.unverified') }}
                    <Link :href="route('verification.send')" method="post" as="button" class="verify-link">
                        {{ t('profile.email.resend') }}
                    </Link>
                </span>
                <div v-show="status === 'verification-link-sent'" class="verify-sent">
                    {{ t('profile.email.sent') }}
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" :disabled="form.processing">
                    <svg v-if="form.processing" class="spin-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    {{ form.processing ? t('common.saving') : t('common.save') }}
                </button>
                <Transition>
                    <span v-if="form.recentlySuccessful" class="save-success">✓ {{ t('common.saved') }}</span>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style scoped>
.section-header {
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text-main);
    margin: 0 0 0.35rem;
}

.section-desc {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.6;
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 1.1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}

.form-label {
    font-size: 0.83rem;
    font-weight: 600;
    color: var(--text-muted);
    letter-spacing: 0.02em;
}

.form-input {
    width: 100%;
    background: var(--bg-main);
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text-main);
    font-size: 0.93rem;
    height: 42px;
    padding: 0 0.9rem;
    outline: none;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.form-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(166, 124, 82, 0.15);
}

.form-error {
    font-size: 0.8rem;
    color: #f87171;
    margin: 0;
}

.form-input--readonly {
    opacity: 0.6;
    cursor: not-allowed;
    background: var(--bg-main, rgba(0, 0, 0, 0.05));
}

/* @ prefix wrapper */
.input-prefix-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.input-prefix {
    position: absolute;
    inset-inline-start: 0.85rem;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--toggle-color);
    pointer-events: none;
    user-select: none;
}

.form-input--prefixed {
    padding-inline-start: 2rem;
}

.verify-notice {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    background: rgba(251, 191, 36, 0.08);
    border: 1px solid rgba(251, 191, 36, 0.25);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.85rem;
    color: var(--text-main);
    flex-wrap: wrap;
}

.verify-notice svg {
    width: 16px;
    height: 16px;
    color: #fbbf24;
    flex-shrink: 0;
    margin-top: 1px;
}

.verify-link {
    color: var(--toggle-color);
    font-weight: 600;
    background: none;
    border: none;
    cursor: pointer;
    text-decoration: underline;
    padding: 0;
    font-size: inherit;
}

.verify-sent {
    width: 100%;
    font-size: 0.8rem;
    color: #4ade80;
    margin-top: 0.3rem;
}

.form-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding-top: 0.5rem;
}

.save-success {
    font-size: 0.85rem;
    color: #4ade80;
    font-weight: 600;
}

.spin-icon {
    width: 16px;
    height: 16px;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
