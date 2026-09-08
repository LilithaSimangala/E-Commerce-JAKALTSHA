<script setup>
import { computed, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const cart = ref(
    JSON.parse(localStorage.getItem("cart")) || []
);

const name = ref("");
const email = ref("");
const address = ref("");
const city = ref("");
const postalCode = ref("");

const error = ref("");

const total = computed(() => {
    return cart.value.reduce(
        (sum, item) => sum + item.price * item.quantity,
        0
    );
});

function continueToPayment() {

    error.value = "";

    if (cart.value.length === 0) {
        error.value = "Your cart is empty.";
        return;
    }

    if (
        !name.value ||
        !email.value ||
        !address.value ||
        !city.value ||
        !postalCode.value
    ) {
        error.value = "Please complete all checkout details.";
        return;
    }

    const checkoutData = {
        name: name.value,
        email: email.value,
        address: address.value,
        city: city.value,
        postalCode: postalCode.value,
        total: total.value
    };

    localStorage.setItem(
        "checkoutData",
        JSON.stringify(checkoutData)
    );

    const user = localStorage.getItem("user");

if (user) {
    router.push("/payment");
} else {
    router.push("/login");
}
}
</script>

<template>
    <main class="checkout-page">

        <!-- Header -->

        <section class="checkout-header">

            <p class="eyebrow">JAKALTSHA</p>

            <h1>Checkout</h1>

            <p>
                Enter your details before completing your order.
            </p>

        </section>

        <!-- Checkout -->

        <section class="checkout-section">

            <div v-if="error" class="error">
                {{ error }}
            </div>

            <div class="checkout-layout">

                <!-- Customer Details -->

                <form
                    class="checkout-form"
                    @submit.prevent="continueToPayment"
                >

                    <h2>Customer Details</h2>

                    <div class="form-group">

                        <label for="name">
                            Full Name
                        </label>

                        <input
                            id="name"
                            v-model="name"
                            type="text"
                            placeholder="Your full name"
                        >

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

                    <h2>Delivery Details</h2>

                    <div class="form-group">

                        <label for="address">
                            Address
                        </label>

                        <input
                            id="address"
                            v-model="address"
                            type="text"
                            placeholder="Street address"
                        >

                    </div>

                    <div class="form-row">

                        <div class="form-group">

                            <label for="city">
                                City
                            </label>

                            <input
                                id="city"
                                v-model="city"
                                type="text"
                                placeholder="City"
                            >

                        </div>

                        <div class="form-group">

                            <label for="postalCode">
                                Postal Code
                            </label>

                            <input
                                id="postalCode"
                                v-model="postalCode"
                                type="text"
                                placeholder="Postal code"
                            >

                        </div>

                    </div>

                    <button
                        type="submit"
                        class="continue-button"
                    >
                        Continue
                    </button>

                </form>

                <!-- Order Summary -->

                <aside class="order-summary">

                    <h2>Order Summary</h2>

                    <div
                        v-for="item in cart"
                        :key="item.id"
                        class="summary-item"
                    >

                        <span>
                            {{ item.name }} × {{ item.quantity }}
                        </span>

                        <span>
                            R{{ (item.price * item.quantity).toFixed(2) }}
                        </span>

                    </div>

                    <div class="summary-total">

                        <strong>Total</strong>

                        <strong>
                            R{{ total.toFixed(2) }}
                        </strong>

                    </div>

                </aside>

            </div>

        </section>

    </main>
</template>

<style scoped>

.checkout-page {
    min-height: 100vh;
}

/* Header */

.checkout-header {
    padding: 70px 8%;
    background: #f2f2f2;
}

.eyebrow {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 3px;
    margin-bottom: 10px;
}

.checkout-header h1 {
    font-size: 64px;
    margin: 0 0 15px;
}

.checkout-header p {
    font-size: 18px;
}

/* Section */

.checkout-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 70px 24px;
}

.checkout-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 60px;
}

/* Form */

.checkout-form {
    border: 1px solid #ddd;
    padding: 30px;
}

.checkout-form h2 {
    margin: 0 0 25px;
}

.checkout-form h2:not(:first-child) {
    margin-top: 35px;
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

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.continue-button {
    width: 100%;
    padding: 14px;
    background: #111;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
}

.continue-button:hover {
    background: #333;
}

/* Summary */

.order-summary {
    height: fit-content;
    border: 1px solid #ddd;
    padding: 25px;
}

.order-summary h2 {
    margin-top: 0;
    margin-bottom: 25px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #ddd;
    font-size: 20px;
}

/* Error */

.error {
    margin-bottom: 25px;
    padding: 15px;
    background: #fff0f0;
    color: #b00020;
}

/* Responsive */

@media (max-width: 850px) {

    .checkout-layout {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 600px) {

    .checkout-header h1 {
        font-size: 48px;
    }

    .checkout-form {
        padding: 20px;
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }

}

</style>