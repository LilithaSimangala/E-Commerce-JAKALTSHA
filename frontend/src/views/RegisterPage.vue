<script setup>
import { ref } from "vue";

const name = ref("");
const email = ref("");
const password = ref("");
const confirmation = ref("");
const error = ref("");
const success = ref("");
const loading = ref(false);

async function register() {
    error.value = "";
    success.value = "";
    if (password.value !== confirmation.value) {
        error.value = "Your passwords do not match.";
        return;
    }

    loading.value = true;
    try {
        const response = await fetch("/api/auth.php?action=register", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                name: name.value.trim(),
                email: email.value.trim(),
                password: password.value,
            }),
        });
        const data = await response.json();
        if (!response.ok || data.error) {
            throw new Error(data.error || "Registration failed. Please try again.");
        }
        success.value = "Registration successful. You can now log in.";
        name.value = "";
        email.value = "";
        password.value = "";
        confirmation.value = "";
    } catch (err) {
        error.value = err.message || "Could not connect to the server.";
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <main class="register-page">
        <section class="register-header">
            <p class="eyebrow">JAKALTSHA</p>
            <h1>Create an account</h1>
            <p>Register to continue with the JAKALTSHA demo store.</p>
        </section>
        <section class="register-section">
            <form class="register-form" @submit.prevent="register">
                <h2>Join JAKALTSHA</h2>
                <p v-if="error" class="error" role="alert">{{ error }}</p>
                <p v-if="success" class="success" role="status">{{ success }}</p>
                <div class="form-group">
                    <label for="register-name">Full name</label>
                    <input id="register-name" v-model="name" type="text" autocomplete="name" required>
                </div>
                <div class="form-group">
                    <label for="register-email">Email address</label>
                    <input id="register-email" v-model="email" type="email" autocomplete="email" required>
                </div>
                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input id="register-password" v-model="password" type="password" autocomplete="new-password" minlength="8" required>
                </div>
                <div class="form-group">
                    <label for="register-confirmation">Confirm password</label>
                    <input id="register-confirmation" v-model="confirmation" type="password" autocomplete="new-password" minlength="8" required>
                </div>
                <button class="register-button" type="submit" :disabled="loading">
                    {{ loading ? "Creating account…" : "Create account" }}
                </button>
                <p class="login-text">Already registered? <RouterLink to="/login">Log in</RouterLink></p>
            </form>
        </section>
    </main>
</template>

<style scoped>
.register-page { min-height: 100vh; }
.register-header { padding: 70px 8%; background: #f2f2f2; }
.eyebrow { margin-bottom: 10px; font-size: 13px; font-weight: bold; letter-spacing: 3px; }
.register-header h1 { margin: 0 0 15px; font-size: 56px; }
.register-header p { font-size: 18px; }
.register-section { max-width: 500px; margin: 0 auto; padding: 70px 24px; }
.register-form { border: 1px solid #ddd; padding: 35px; }
.register-form h2 { margin: 0 0 30px; font-size: 28px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-weight: bold; }
.form-group input { box-sizing: border-box; width: 100%; padding: 12px; border: 1px solid #ccc; font-size: 16px; }
.register-button { width: 100%; padding: 14px; border: 0; background: #111; color: white; cursor: pointer; font-size: 16px; }
.register-button:hover { background: #333; }
.register-button:disabled { cursor: wait; opacity: .7; }
.login-text { margin-top: 25px; color: #666; text-align: center; }
.login-text a { color: #111; font-weight: bold; }
.error, .success { margin-bottom: 20px; padding: 12px; }
.error { background: #fff0f0; color: #b00020; }
.success { background: #f0fff0; color: #176b17; }
@media (max-width: 600px) { .register-header h1 { font-size: 42px; } .register-form { padding: 25px; } }
</style>