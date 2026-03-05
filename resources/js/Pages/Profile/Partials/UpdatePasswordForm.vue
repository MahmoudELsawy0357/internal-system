<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';

const { locale } = useI18n();
const isAr = computed(() => locale.value === 'ar');

const t = {
    title: { ar: 'تغيير كلمة المرور', en: 'Update Password' },
    desc: { ar: 'استخدم كلمة مرور طويلة وعشوائية للحفاظ على أمان حسابك.', en: 'Ensure your account is using a long, random password to stay secure.' },
    current: { ar: 'كلمة المرور الحالية', en: 'Current Password' },
    newPass: { ar: 'كلمة المرور الجديدة', en: 'New Password' },
    confirm: { ar: 'تأكيد كلمة المرور', en: 'Confirm Password' },
    save: { ar: 'تحديث كلمة المرور', en: 'Update Password' },
    saving: { ar: 'جاري الحفظ…', en: 'Saving…' },
    updated: { ar: 'تم التحديث', en: 'Updated' },
};

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <div class="section-header">
            <h2 class="section-title">{{ isAr ? t.title.ar : t.title.en }}</h2>
            <p class="section-desc">{{ isAr ? t.desc.ar : t.desc.en }}</p>
        </div>

        <form @submit.prevent="updatePassword" class="profile-form">

            <div class="form-group">
                <label for="current_password" class="form-label">{{ isAr ? t.current.ar : t.current.en }}</label>
                <input id="current_password" ref="currentPasswordInput" v-model="form.current_password" type="password"
                    class="form-input" autocomplete="current-password" />
                <p v-if="form.errors.current_password" class="form-error">{{ form.errors.current_password }}</p>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ isAr ? t.newPass.ar : t.newPass.en }}</label>
                <input id="password" ref="passwordInput" v-model="form.password" type="password" class="form-input"
                    autocomplete="new-password" />
                <p v-if="form.errors.password" class="form-error">{{ form.errors.password }}</p>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">{{ isAr ? t.confirm.ar : t.confirm.en }}</label>
                <input id="password_confirmation" v-model="form.password_confirmation" type="password"
                    class="form-input" autocomplete="new-password" />
                <p v-if="form.errors.password_confirmation" class="form-error">{{ form.errors.password_confirmation }}
                </p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" :disabled="form.processing">
                    <svg v-if="form.processing" class="spin-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    {{ form.processing ? (isAr ? t.saving.ar : t.saving.en) : (isAr ? t.save.ar : t.save.en) }}
                </button>
                <Transition>
                    <span v-if="form.recentlySuccessful" class="save-success">✓ {{ isAr ? t.updated.ar : t.updated.en
                        }}</span>
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
