<script setup>
import { onMounted, ref } from "vue";

const products = ref([]);
const error = ref("");

const API_URL = "http://localhost/JAKALTSHA/backend/routes";

onMounted(async () => {
    try {
        const response = await fetch(`${API_URL}/products.php`);

        if (!response.ok) {
            throw new Error("Failed to fetch products");
        }

        products.value = await response.json();
    } catch (err) {
        error.value = "Failed to load products";
        console.error(err);
    }
});
</script>

<template>
    <main class="shop-page">

        <!-- Header -->
        <section class="shop-header">
            <p class="eyebrow">JAKALTSHA STORE</p>

            <h1>Shop</h1>

            <p>
                Music merchandise and creative essentials from JAKALTSHA.
            </p>
        </section>

        <!-- Products -->
        <section class="shop-section">

            <p v-if="error" class="error">
                {{ error }}
            </p>

            <div v-else class="product-grid">

                <article
                    v-for="product in products"
                    :key="product.id"
                    class="product-card"
                >

                    <div class="product-image">
                        <img
                            :src="product.image"
                            :alt="product.name"
                        >
                    </div>

                    <div class="product-content">

                        <p class="artist-name">
                            {{ product.artist_name }}
                        </p>

                        <h2>{{ product.name }}</h2>

                        <p class="description">
                            {{ product.description }}
                        </p>

                        <div class="product-footer">

                            <strong>
                                R{{ product.price }}
                            </strong>

                            <span>
                                {{ product.stock }} in stock
                            </span>

                        </div>

                        <RouterLink
                            :to="`/products/${product.id}`"
                            class="product-button"
                        >
                            View Product
                        </RouterLink>

                    </div>

                </article>

            </div>

        </section>

    </main>
</template>

<style scoped>

.shop-page {
    min-height: 100vh;
}

/* Header */

.shop-header {
    padding: 70px 8%;
    background: #f2f2f2;
}

.eyebrow {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 3px;
    margin-bottom: 10px;
}

.shop-header h1 {
    font-size: 64px;
    margin: 0 0 15px;
}

.shop-header p {
    font-size: 18px;
}

/* Products */

.shop-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 70px 24px;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

/* Product Card */

.product-card {
    border: 1px solid #ddd;
    background: white;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 320px;
    background: #e8e8e8;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.product-content {
    padding: 22px;
}

.artist-name {
    margin: 0 0 8px;
    color: #666;
    font-size: 14px;
}

.product-content h2 {
    margin: 0 0 10px;
    font-size: 23px;
}

.description {
    color: #666;
    line-height: 1.6;
    min-height: 50px;
}

.product-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 20px 0;
}

.product-footer strong {
    font-size: 22px;
}

.product-footer span {
    font-size: 14px;
    color: #666;
}

.product-button {
    display: block;
    padding: 12px;
    background: #111;
    color: white;
    text-align: center;
    text-decoration: none;
}

.product-button:hover {
    background: #333;
}

/* Error */

.error {
    color: #b00020;
}

/* Responsive */

@media (max-width: 900px) {

    .product-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 600px) {

    .product-grid {
        grid-template-columns: 1fr;
    }

    .shop-header h1 {
        font-size: 48px;
    }

}

</style>