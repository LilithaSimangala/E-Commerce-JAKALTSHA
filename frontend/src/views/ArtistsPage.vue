<script setup>
import { onMounted, ref } from "vue";

const artists = ref([]);
const error = ref("");

const API_URL = "http://localhost/JAKALTSHA/backend/routes";

onMounted(async () => {
    try {
        const response = await fetch(`${API_URL}/artists.php`);

        if (!response.ok) {
            throw new Error("Failed to fetch artists");
        }

        artists.value = await response.json();
    } catch (err) {
        error.value = "Failed to load artists";
        console.error(err);
    }
});
</script>

<template>
    <main class="artists-page">

        <!-- Page Header -->
        <section class="artists-header">
            <p class="eyebrow">JAKALTSHA</p>

            <h1>Artists</h1>

            <p>
                Discover the artists behind the JAKALTSHA sound.
            </p>
        </section>

        <!-- Artists -->
        <section class="artists-section">

            <p v-if="error" class="error">
                {{ error }}
            </p>

            <div v-else class="artists-grid">

                <article
                    v-for="artist in artists"
                    :key="artist.id"
                    class="artist-card"
                >

                    <div class="artist-image">
                        <img
                            :src="artist.image"
                            :alt="artist.name"
                        >
                    </div>

                    <div class="artist-content">

                        <h2>{{ artist.name }}</h2>

                        <p>
                            {{ artist.bio }}
                        </p>

                        <RouterLink
                            :to="`/artists/${artist.id}`"
                            class="artist-button"
                        >
                            View Artist
                        </RouterLink>

                    </div>

                </article>

            </div>

        </section>

    </main>
</template>

<style scoped>

.artists-page {
    min-height: 100vh;
}

/* Header */

.artists-header {
    padding: 70px 8%;
    background: #f2f2f2;
}

.eyebrow {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 3px;
    margin-bottom: 10px;
}

.artists-header h1 {
    font-size: 64px;
    margin: 0 0 15px;
}

.artists-header p {
    font-size: 18px;
}

/* Artists Section */

.artists-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 70px 24px;
}

.artists-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

/* Artist Card */

.artist-card {
    background: white;
    border: 1px solid #ddd;
    overflow: hidden;
}

.artist-image {
    width: 100%;
    height: 320px;
    background: #e8e8e8;
    overflow: hidden;
}

.artist-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.artist-content {
    padding: 22px;
}

.artist-content h2 {
    margin: 0 0 10px;
    font-size: 24px;
}

.artist-content p {
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

.artist-button {
    display: inline-block;
    padding: 10px 16px;
    background: #111;
    color: white;
    text-decoration: none;
}

.artist-button:hover {
    background: #333;
}

/* Error */

.error {
    color: #b00020;
}

/* Responsive */

@media (max-width: 900px) {

    .artists-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 600px) {

    .artists-grid {
        grid-template-columns: 1fr;
    }

    .artists-header h1 {
        font-size: 48px;
    }

}

</style>