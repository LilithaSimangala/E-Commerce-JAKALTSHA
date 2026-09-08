<script setup>
import { computed, ref } from "vue";
import { RouterLink } from "vue-router";

const cart = ref(
    JSON.parse(localStorage.getItem("cart")) || []
);

const total = computed(() => {
    return cart.value.reduce(
        (sum, item) => sum + item.price * item.quantity,
        0
    );
});

function updateCart() {
    localStorage.setItem("cart", JSON.stringify(cart.value));
}

function removeItem(id) {
    cart.value = cart.value.filter(item => item.id !== id);
    updateCart();
}

function increaseQuantity(item) {
    item.quantity++;
    updateCart();
}

function decreaseQuantity(item) {
    if (item.quantity > 1) {
        item.quantity--;
        updateCart();
    }
}
</script>

<template>
    <main class="cart-page">

        <!-- Header -->

        <section class="cart-header">
            <p class="eyebrow">JAKALTSHA</p>

            <h1>Your Cart</h1>

            <p>
                Review your selected products before checkout.
            </p>
        </section>

        <!-- Cart -->

        <section class="cart-section">

            <div v-if="cart.length === 0" class="empty-cart">

                <h2>Your cart is empty.</h2>

                <p>
                    Browse the JAKALTSHA store and add something you like.
                </p>

                <RouterLink to="/shop" class="shop-button">
                    Browse Shop
                </RouterLink>

            </div>

            <div v-else class="cart-layout">

                <!-- Cart Items -->

                <div class="cart-items">

                    <article
                        v-for="item in cart"
                        :key="item.id"
                        class="cart-item"
                    >

                        <div class="item-image">
                            <img
                                :src="item.image"
                                :alt="item.name"
                            >
                        </div>

                        <div class="item-details">

                            <h2>{{ item.name }}</h2>

                            <p>
                                R{{ item.price.toFixed(2) }}
                            </p>

                            <div class="quantity-controls">

                                <button
                                    @click="decreaseQuantity(item)"
                                >
                                    −
                                </button>

                                <span>
                                    {{ item.quantity }}
                                </span>

                                <button
                                    @click="increaseQuantity(item)"
                                >
                                    +
                                </button>

                            </div>

                            <button
                                class="remove-button"
                                @click="removeItem(item.id)"
                            >
                                Remove
                            </button>

                        </div>

                        <div class="item-total">

                            R{{ (item.price * item.quantity).toFixed(2) }}

                        </div>

                    </article>

                </div>

                <!-- Summary -->

                <aside class="cart-summary">

                    <h2>Order Summary</h2>

                    <div class="summary-row">

                        <span>Items</span>

                        <span>
                            {{ cart.length }}
                        </span>

                    </div>

                    <div class="summary-row total-row">

                        <strong>Total</strong>

                        <strong>
                            R{{ total.toFixed(2) }}
                        </strong>

                    </div>

                    <RouterLink
                        to="/checkout"
                        class="checkout-button"
                    >
                        Proceed to Checkout
                    </RouterLink>

                    <RouterLink
                        to="/shop"
                        class="continue-button"
                    >
                        Continue Shopping
                    </RouterLink>

                </aside>

            </div>

        </section>

    </main>
</template>

<style scoped>

.cart-page {
    min-height: 100vh;
}

/* Header */

.cart-header {
    padding: 70px 8%;
    background: #f2f2f2;
}

.eyebrow {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 3px;
    margin-bottom: 10px;
}

.cart-header h1 {
    font-size: 64px;
    margin: 0 0 15px;
}

.cart-header p {
    font-size: 18px;
}

/* Cart Section */

.cart-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 70px 24px;
}

/* Empty Cart */

.empty-cart {
    text-align: center;
    padding: 80px 20px;
}

.empty-cart h2 {
    font-size: 32px;
}

.empty-cart p {
    color: #666;
    margin-bottom: 25px;
}

.shop-button {
    display: inline-block;
    padding: 12px 20px;
    background: #111;
    color: white;
    text-decoration: none;
}

/* Layout */

.cart-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 50px;
}

/* Cart Item */

.cart-item {
    display: grid;
    grid-template-columns: 140px 1fr auto;
    gap: 25px;
    padding: 25px 0;
    border-bottom: 1px solid #ddd;
}

.item-image {
    width: 140px;
    height: 140px;
    background: #e8e8e8;
    overflow: hidden;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-details h2 {
    margin: 0 0 8px;
    font-size: 22px;
}

.item-details p {
    color: #666;
}

/* Quantity */

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 15px;
    margin: 15px 0;
}

.quantity-controls button {
    width: 32px;
    height: 32px;
    border: 1px solid #ccc;
    background: white;
    cursor: pointer;
    font-size: 18px;
}

.quantity-controls span {
    min-width: 20px;
    text-align: center;
}

.remove-button {
    padding: 7px 12px;
    border: none;
    background: transparent;
    color: #b00020;
    cursor: pointer;
    padding-left: 0;
}

.item-total {
    font-weight: bold;
    font-size: 18px;
}

/* Summary */

.cart-summary {
    border: 1px solid #ddd;
    padding: 25px;
    height: fit-content;
}

.cart-summary h2 {
    margin-top: 0;
    margin-bottom: 25px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 18px;
}

.total-row {
    border-top: 1px solid #ddd;
    padding-top: 20px;
    font-size: 20px;
}

.checkout-button {
    display: block;
    padding: 14px;
    background: #111;
    color: white;
    text-align: center;
    text-decoration: none;
    margin-top: 25px;
}

.checkout-button:hover {
    background: #333;
}

.continue-button {
    display: block;
    padding: 12px;
    border: 1px solid #111;
    color: #111;
    text-align: center;
    text-decoration: none;
    margin-top: 12px;
}

/* Responsive */

@media (max-width: 850px) {

    .cart-layout {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 600px) {

    .cart-header h1 {
        font-size: 48px;
    }

    .cart-item {
        grid-template-columns: 100px 1fr;
    }

    .item-image {
        width: 100px;
        height: 100px;
    }

    .item-total {
        grid-column: 2;
    }

}

</style>