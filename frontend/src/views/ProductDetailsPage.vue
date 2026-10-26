<script setup>
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const product = ref(null);
const error = ref("");
const quantity = ref(1);

const API_URL = "/api";

onMounted(async () => {
    try {
        const response = await fetch(
            `${API_URL}/products.php?id=${route.params.id}`
        );

        if (!response.ok) {
            throw new Error("Failed to fetch product");
        }

        product.value = await response.json();

    } catch (err) {
        error.value = "Failed to load product";
        console.error(err);
    }
});

function addToCart() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    const existingProduct = cart.find(
        item => item.id === product.value.id
    );

    if (existingProduct) {
        existingProduct.quantity += quantity.value;
    } else {
        cart.push({
            id: product.value.id,
            name: product.value.name,
            price: Number(product.value.price),
            image: product.value.image,
            quantity: quantity.value
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));

    router.push("/cart");
}
</script>

<template>
    <main class="product-details-page">

        <p v-if="error" class="error">
            {{ error }}
        </p>

        <section
            v-if="product"
            class="product-details"
        >

            <!-- Product Image -->

            <div class="product-image">
                <img
                    :src="product.image"
                    :alt="product.name"
                >
            </div>

            <!-- Product Information -->

            <div class="product-info">

                <p class="artist-name">
                    {{ product.artist_name }}
                </p>

                <h1>{{ product.name }}</h1>

                <p class="price">
                    R{{ product.price }}
                </p>

                <p class="description">
                    {{ product.description }}
                </p>

                <p class="stock">
                    {{ product.stock }} available
                </p>

                <div class="quantity">

                    <label for="quantity">
                        Quantity
                    </label>

                    <input
                        id="quantity"
                        v-model.number="quantity"
                        type="number"
                        min="1"
                        :max="product.stock"
                    >

                </div>

                <button
                    class="cart-button"
                    :disabled="product.stock <= 0"
                    @click="addToCart"
                >
                    Add to Cart
                </button>

                <RouterLink
                    to="/shop"
                    class="back-button"
                >
                    ← Back to Shop
                </RouterLink>

            </div>

        </section>

    </main>
</template>

<style scoped>

.product-details-page {
    min-height: 100vh;
}

.product-details {
    max-width: 1200px;
    margin: 0 auto;
    padding: 70px 24px;

    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 70px;
    align-items: center;
}

/* Image */

.product-image {
    width: 100%;
    height: 550px;
    background: #e8e8e8;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Information */

.artist-name {
    color: #666;
    margin-bottom: 10px;
}

.product-info h1 {
    font-size: 52px;
    margin: 0 0 20px;
}

.price {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 25px;
}

.description {
    color: #555;
    line-height: 1.7;
    font-size: 17px;
}

.stock {
    margin: 25px 0;
    color: #555;
}

/* Quantity */

.quantity {
    margin-bottom: 20px;
}

.quantity label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.quantity input {
    width: 80px;
    padding: 10px;
    border: 1px solid #ccc;
}

/* Buttons */

.cart-button {
    display: block;
    width: 100%;
    padding: 14px;
    background: #111;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.cart-button:hover {
    background: #333;
}

.cart-button:disabled {
    background: #999;
    cursor: not-allowed;
}

.back-button {
    display: block;
    margin-top: 15px;
    text-align: center;
    padding: 12px;
    border: 1px solid #111;
    color: #111;
    text-decoration: none;
}

.back-button:hover {
    background: #f2f2f2;
}

.error {
    padding: 40px 8%;
    color: #b00020;
}

/* Responsive */

@media (max-width: 800px) {

    .product-details {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .product-image {
        height: 400px;
    }

    .product-info h1 {
        font-size: 42px;
    }

}

</style>