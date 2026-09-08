<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const email = ref("");
const password = ref("");

const error = ref("");
const success = ref("");

const API_URL = "http://localhost/JAKALTSHA/backend/routes";

async function login() {
    error.value = "";
    success.value = "";

    if (!email.value || !password.value) {
        error.value = "Please enter your email and password.";
        return;
    }

    try {
        const response = await fetch(
            `${API_URL}/auth.php?action=login`,
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({
                    email: email.value,
                    password: password.value
                })
            }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.error || "Login failed"
            );
        }

        // Save logged-in user
        localStorage.setItem(
            "user",
            JSON.stringify(data.user)
        );

        success.value = "Login successful!";

        // Continue to checkout if checkout data exists
        const checkoutData =
            localStorage.getItem("checkoutData");

        if (checkoutData) {
            router.push("/checkout");
        } else {
            router.push("/");
        }

    } catch (err) {
        error.value = err.message;
        console.error(err);
    }
}
</script>

<template>
    <main class="login-page">

        <!-- Header -->

        <section class="login-header">

            <p class="eyebrow">JAKALTSHA</p>

            <h1>Login</h1>

            <p>
                Sign in to continue with your JAKALTSHA account.
            </p>

        </section>

        <!-- Login Form -->

        <section class="login-section">

            <form
                class="login-form"
                @submit.prevent="login"
            >

                <h2>Welcome Back</h2>

                <div
                    v-if="error"
                    class="error"
                >
                    {{ error }}
                </div>

                <div
                    v-if="success"
                    class="success"
                >
                    {{ success }}
                </div>

                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        id="email"
                        v-model="email"
                        type="email"
                        placeholder="you@example.com"
                    >

                </div>

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        id="password"
                        v-model="password"
                        type="password"
                        placeholder="Your password"
                    >

                </div>

                <button
                    type="submit"
                    class="login-button"
                >
                    Login
                </button>

                <p class="register-text">

                    Don't have an account?

                    <RouterLink to="/register">
                        Create one
                    </RouterLink>

                </p>

            </form>

        </section>

    </main>
</template>

<style scoped>

.login-page {
    min-height: 100vh;
}

/* Header */

.login-header {
    padding: 70px 8%;
    background: #f2f2f2;
}

.eyebrow {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 3px;
    margin-bottom: 10px;
}

.login-header h1 {
    font-size: 64px;
    margin: 0 0 15px;
}

.login-header p {
    font-size: 18px;
}

/* Login */

.login-section {
    max-width: 500px;
    margin: 0 auto;
    padding: 70px 24px;
}

.login-form {
    border: 1px solid #ddd;
    padding: 35px;
}

.login-form h2 {
    margin-top: 0;
    margin-bottom: 30px;
    font-size: 28px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    box-sizing: border-box;
    padding: 12px;
    border: 1px solid #ccc;
    font-size: 16px;
}

.login-button {
    width: 100%;
    padding: 14px;
    background: #111;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.login-button:hover {
    background: #333;
}

.register-text {
    text-align: center;
    margin-top: 25px;
    color: #666;
}

.register-text a {
    color: #111;
    font-weight: bold;
}

/* Messages */

.error {
    padding: 12px;
    margin-bottom: 20px;
    background: #fff0f0;
    color: #b00020;
}

.success {
    padding: 12px;
    margin-bottom: 20px;
    background: #f0fff0;
    color: #176b17;
}

/* Responsive */

@media (max-width: 600px) {

    .login-header h1 {
        font-size: 48px;
    }

    .login-form {
        padding: 25px;
    }

}

</style>