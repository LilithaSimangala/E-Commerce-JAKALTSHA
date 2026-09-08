<script setup>
import { computed, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const cart = ref(
    JSON.parse(localStorage.getItem("cart")) || []
);

const checkoutData = JSON.parse(
    localStorage.getItem("checkoutData")
);

const paymentMethod = ref("card");
const error = ref("");
const processing = ref(false);

const total = computed(() => {
    return cart.value.reduce(
        (sum, item) => sum + item.price * item.quantity,
        0
    );
});

async function completePayment() {

    error.value = "";

    if (cart.value.length === 0) {
        error.value = "Your cart is empty.";
        return;
    }

    if (!checkoutData) {
        error.value = "Checkout information is missing.";
        return;
    }

    const user = JSON.parse(
        localStorage.getItem("user")
    );

    if (!user) {
        router.push("/login");
        return;
    }

    processing.value = true;

    try {

        const response = await fetch(
            "http://localhost/JAKALTSHA/backend/routes/orders.php",
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({
                    user_id: user.id,
                    items: cart.value.map(item => ({
                        product_id: item.id,
                        quantity: item.quantity
                    }))
                })
            }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.error || "Failed to create order."
            );
        }

        localStorage.removeItem("cart");
        localStorage.removeItem("checkoutData");

        router.push(
            `/order-confirmation/${data.order_id}`
        );

    } catch (err) {

        error.value = err.message;
        console.error(err);

    } finally {

        processing.value = false;

    }
}
</script>

<template>

    <main class="payment-page">

        <section class="payment-header">

            <p class="eyebrow">JAKALTSHA</p>

            <h1>Payment</h1>

            <p>
                Complete your simulated payment to place your order.
            </p>

        </section>

        <section class="payment-section">

            <div class="payment-form">

                <h2>Payment Method</h2>

                <div
                    v-if="error"
                    class="error"
                >
                    {{ error }}
                </div>

                <label class="payment-option">

                    <input
                        v-model="paymentMethod"
                        type="radio"
                        value="card"
                    >

                    Simulated Card Payment

                </label>

                <div class="fake-card">

                    <label>
                        Card Number
                    </label>

                    <input
                        type="text"
                        value="4242 4242 4242 4242"
                        disabled
                    >

                    <div class="card-row">

                        <div>
                            <label>Expiry</label>

                            <input
                                type="text"
                                value="12/30"
                                disabled
                            >
                        </div>

                        <div>
                            <label>CVV</label>

                            <input
                                type="text"
                                value="123"
                                disabled
                            >
                        </div>

                    </div>

                </div>

                <button
                    class="payment-button"
                    :disabled="processing"
                    @click="completePayment"
                >
                    {{ processing ? "Processing..." : `Pay R${total.toFixed(2)}` }}
                </button>

            </div>

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

        </section>

    </main>

</template>

<style scoped>

.payment-page {
    min-height: 100vh;
}

.payment-header {
    padding: 70px 8%;
    background: #f2f2f2;
}

.eyebrow {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 3px;
}

.payment-header h1 {
    font-size: 64px;
    margin: 0 0 15px;
}

.payment-header p {
    font-size: 18px;
}

.payment-section {
    max-width: 1100px;
    margin: 0 auto;
    padding: 70px 24px;

    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 50px;
}

.payment-form,
.order-summary {
    border: 1px solid #ddd;
    padding: 30px;
}

.payment-form h2,
.order-summary h2 {
    margin-top: 0;
}

.payment-option {
    display: block;
    margin: 25px 0;
}

.fake-card {
    padding: 20px;
    background: #f5f5f5;
    margin-bottom: 25px;
}

.fake-card label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}

.fake-card input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

.card-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.payment-button {
    width: 100%;
    padding: 14px;
    background: #111;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.payment-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.summary-item,
.summary-total {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    padding: 12px 0;
}

.summary-total {
    border-top: 1px solid #ddd;
    margin-top: 15px;
    padding-top: 20px;
}

.error {
    color: #b00020;
    margin-bottom: 20px;
}

@media (max-width: 800px) {

    .payment-section {
        grid-template-columns: 1fr;
    }

    .payment-header h1 {
        font-size: 48px;
    }

}

</style>