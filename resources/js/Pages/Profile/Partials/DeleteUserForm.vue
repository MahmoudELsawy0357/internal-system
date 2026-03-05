<script setup>
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);
const form = useForm({ password: '' });

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section>
        <div class="section-header">
            <h2 class="section-title section-title--danger">{{ t('profile.delete.title') }}</h2>
            <p class="section-desc">{{ t('profile.delete.desc') }}</p>
        </div>

        <button class="btn-danger" @click="confirmUserDeletion">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 3.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                    clip-rule="evenodd" />
            </svg>
            {{ t('profile.delete.btn') }}
        </button>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="modal-body">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="modal-title">{{ t('profile.delete.modalTitle') }}</h2>
                <p class="modal-desc">{{ t('profile.delete.modalDesc') }}</p>

                <div class="form-group">
                    <label for="delete_password" class="form-label">{{ t('profile.delete.password') }}</label>
                    <input id="delete_password" ref="passwordInput" v-model="form.password" type="password"
                        class="form-input" placeholder="••••••••" @keyup.enter="deleteUser" />
                    <p v-if="form.errors.password" class="form-error">{{ form.errors.password }}</p>
                </div>

                <div class="modal-actions">
                    <button class="btn btn-outline" @click="closeModal">{{ t('common.cancel') }}</button>
                    <button class="btn-danger" :class="{ 'btn-disabled': form.processing }" :disabled="form.processing"
                        @click="deleteUser">
                        {{ form.processing ? t('profile.delete.deleting') : t('profile.delete.confirm') }}
                    </button>
                </div>
            </div>
        </Modal>
    </section>
</template>

<style scoped>
.section-header {
    margin-bottom: 1.25rem;
}

.section-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text-main);
    margin: 0 0 0.35rem;
}

.section-title--danger {
    color: #f87171;
}

.section-desc {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.6;
}

.btn-danger {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    height: 38px;
    padding: 0 1.25rem;
    background: rgba(248, 113, 113, 0.1);
    color: #f87171;
    border: 1px solid rgba(248, 113, 113, 0.3);
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-danger svg {
    width: 16px;
    height: 16px;
}

.btn-danger:hover {
    background: rgba(248, 113, 113, 0.18);
    border-color: rgba(248, 113, 113, 0.5);
}

.btn-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.modal-body {
    background: var(--bg-card);
    border-radius: 18px;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.modal-icon {
    width: 48px;
    height: 48px;
    background: rgba(248, 113, 113, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f87171;
}

.modal-icon svg {
    width: 26px;
    height: 26px;
}

.modal-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text-main);
    margin: 0;
}

.modal-desc {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.6;
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
    border-color: #f87171;
    box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.15);
}

.form-error {
    font-size: 0.8rem;
    color: #f87171;
    margin: 0;
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding-top: 0.5rem;
}
</style>
