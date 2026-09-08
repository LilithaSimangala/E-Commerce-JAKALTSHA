<script setup>
import { onMounted, ref } from "vue";
import { getMusic } from "../services/api";

const music = ref([]);
const error = ref("");

onMounted(async () => {
    try {
        music.value = await getMusic();
    } catch (err) {
        error.value = "Failed to load music";
        console.error(err);
    }
});
</script>

<template>
    <main class="music-page">

        <section class="music-header">
            <p class="eyebrow">JAKALTSHA</p>
            <h1>Music</h1>
            <p>
                Discover music from independent South African artists.
            </p>
        </section>

        <section class="music-section">

            <p v-if="error" class="error">
                {{ error }}
            </p>

            <div v-else class="music-grid">

                <article
                    v-for="track in music"
                    :key="track.id"
                    class="music-card"
                >
                    <div class="music-card-image">
                        <img
                            :src="track.cover_image"
                            :alt="track.title"
                        >
                    </div>

                    <div class="music-card-content">
                        <h2>{{ track.title }}</h2>

                        <p class="artist-name">
                            {{ track.artist_name }}
                        </p>

                        <audio controls>
                            <source :src="track.audio_url">
                            Your browser does not support audio playback.
                        </audio>
                    </div>
                </article>

            </div>

        </section>

    </main>
</template>

<style scoped>
.music-page {
    min-height: 100vh;
}

/* Header */

.music-header {
    padding: 70px 8%;
    background: #f2f2f2;
}

.eyebrow {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 3px;
    margin-bottom: 10px;
}

.music-header h1 {
    font-size: 64px;
    margin: 0 0 15px;
}

.music-header p {
    font-size: 18px;
}

/* Music section */

.music-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 70px 24px;
}

.music-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

/* Music card */

.music-card {
    background: white;
    border: 1px solid #ddd;
    overflow: hidden;
}

.music-card-image {
    width: 100%;
    height: 260px;
    background: #e8e8e8;
    overflow: hidden;
}

.music-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.music-card-content {
    padding: 20px;
}

.music-card-content h2 {
    margin: 0 0 6px;
    font-size: 20px;
}

.artist-name {
    margin: 0 0 18px;
    color: #666;
}

.music-card audio {
    width: 100%;
}

/* Error */

.error {
    color: #b00020;
}

/* Responsive */

@media (max-width: 900px) {
    .music-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .music-grid {
        grid-template-columns: 1fr;
    }

    .music-header h1 {
        font-size: 48px;
    }
}
</style>