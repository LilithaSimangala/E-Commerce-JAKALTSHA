<script setup>
import { onMounted, ref } from "vue";
import { useRoute, useRouter, RouterLink } from "vue-router";

const route = useRoute();
const router = useRouter();

const order = ref(null);
const error = ref("");
const loading = ref(true);

const API_URL = "http://localhost/JAKALTSHA/backend/routes";

onMounted(async () => {
    try {
        const user = JSON.parse(
    localStorage.getItem("user")
);

if (!user) {
    router.push("/login");
    return;
}

const response = await fetch(
    `${API_URL}/orders.php?id=${route.params.id}&user_id=${user.id}`
);

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.error || "Failed to load order."
            );
        }

        order.value = data;

    } catch (err) {

        error.value = err.message;
        console.error(err);

    } finally {

        loading.value = false;

    }
});
</script>

<template>

    <main class="confirmation-page">

        <section class="confirmation-header">

            <p class="eyebrow">JAKALTSHA</p>

            <h1>Order Confirmed</h1>

            <p>
                Thank you for supporting JAKALTSHA.
            </p>

        </section>

        <section class="confirmation-section">

            <p
                v-if="loading"
                class="loading"
            >
                Loading your order...
            </p>

            <p
                v-if="error"
                class="error"
            >
                {{ error }}
            </p>

            <div
                v-if="order"
                class="confirmation-card"
            >

                <div class="success-icon">
                    ✓
                </div>

                <h2>
                    Your order has been placed!
                </h2>

                <p>
                    Order #{{ order.id }}
                </p>

                <div class="order-details">

                    <div class="detail-row">
                        <span>Status</span>
                        <strong>{{ order.status }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>Payment</span>
                        <strong>{{ order.payment_status }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>Total</span>
                        <strong>
                            R{{ Number(order.total_amount).toFixed(2) }}
                        </strong>
                    </div>

                </div>

                <RouterLink
                    to="/shop"
                    class="shop-button"
                >
                    Continue Shopping
                </RouterLink>

                <RouterLink
                    to="/"
                    class="home-button"
                >
                    Back to Home
                </RouterLink>

            </div>

        </section>

    </main>

</template>

<style scoped>

.confirmation-page {
    min-height: 100vh;
}

.confirmation-header {
    padding: 70px 8%;
    background: #f2f2f2;
}

.eyebrow {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 3px;
}

.confirmation-header h1 {
    font-size: 64px;
    margin: 0 0 15px;
}

.confirmation-header p {
    font-size: 18px;
}

.confirmation-section {
    max-width: 700px;
    margin: 0 auto;
    padding: 70px 24px;
}

.confirmation-card {
    border: 1px solid #ddd;
    padding: 40px;
    text-align: center;
}

.success-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 20px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 2px solid #111;
    border-radius: 50%;

    font-size: 30px;
}

.confirmation-card h2 {
    margin-bottom: 10px;
}

.order-details {
    margin: 30px 0;
    border-top: 1px solid #ddd;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid #ddd;
}

.shop-button,
.home-button {
    display: block;
    text-decoration: none;
    padding: 14px;
    margin-top: 12px;
}

.shop-button {
    background: #111;
    color: white;
}

.home-button {
    border: 1px solid #111;
    color: #111;
}

.loading {
    text-align: center;
}

.error {
    color: #b00020;
    text-align: center;
}

@media (max-width: 600px) {

    .confirmation-header h1 {
        font-size: 48px;
    }

    .confirmation-card {
        padding: 25px;
    }

}

</style>