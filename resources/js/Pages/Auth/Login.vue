<template>
  <div class="login">
    <div class="left" style="background-image: url('/images/login__bc.jpg');">
      <img src="/images/logo__login.png" alt />
    </div>
    <div class="right">
      <form @submit.prevent="submit">
        <h1>{{ $t('messages.system_entry') }}</h1>
        <div class="form-group">
          <input
            id="user_email"
            type="email"
            class="form-control"
            :class="{ 'is-invalid': form.errors.user_email }"
            name="user_email"
            v-model="form.user_email"
            required
            :placeholder="$t('messages.Имя пользователя')"
          />
          <span
            v-if="form.errors.user_email"
            class="invalid-feedback"
          >{{ form.errors.user_email }}</span>
        </div>
        <div class="form-group passwordToggle">
          <input
            id="password"
            type="password"
            class="form-control"
            :class="{ 'is-invalid': form.errors.password }"
            name="password"
            v-model="form.password"
            required
            autocomplete="current-password"
            :placeholder="$t('messages.Пароль')"
          />
          <span id="toggle__lock" @click="togglePasswordVisible"></span>
          <span v-if="form.errors.password" class="invalid-feedback">
            <strong>{{ form.errors.password }}</strong>
          </span>
        </div>
        <button class="btn__blue" type="submit" :disabled="form.processing">
          <!-- <span
            v-if="loading"
            class="spinner-border spinner-border-sm text-light"
            role="status"
            aria-hidden="true"
          ></span>-->
          <span class="text-light">{{ $t('messages.Войти') }}</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';

export default {
  layout: GuestLayout
}
</script>

<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, ref } from 'vue';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  user_email: '',
  password: '',
});

const emailInput = ref({});
const passwordInput = ref({});
const loading = ref(false);

onMounted(() => {
  emailInput.value = document.getElementById('user_email')
  passwordInput.value = document.getElementById("password")
  if (emailInput.value) {
    emailInput.value.focus();
  } else {
    passwordInput.value.focus();
  }
});

const submit = async () => {
  form.clearErrors()
  loading.value = true
  form.post(route('login'), {
    onFinish: () => {
      form.reset('password')
    },
    // onSuccess: () => location.href = "/"
  });
  loading.value = false

};

const togglePasswordVisible = () => {
  passwordInput.value.type === "password" ? passwordInput.value.type = "text" : passwordInput.value.type = "password";
};
</script>

<style scoped>
button:disabled {
  cursor: not-allowed;
}
button:disabled:hover {
  background-color: unset;
}
</style>
