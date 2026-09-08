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
    <div class="home">

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <p class="eyebrow">SOUTH AFRICAN MUSIC & CULTURE</p>

                <h1>
                    DISCOVER THE
                    <span>JAKALTSHA</span>
                    SOUND.
                </h1>

                <p class="hero-text">
                    Discover independent artists, listen to new music,
                    and shop merchandise from the artists you support.
                </p>

                <div class="hero-buttons">
                    <RouterLink to="/music" class="primary-button">
                        Explore Music
                    </RouterLink>

                    <RouterLink to="/shop" class="secondary-button">
                        Shop Merchandise
                    </RouterLink>
                </div>
            </div>
        </section>

        <!-- Music Section -->
        <section class="section">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">LISTEN NOW</p>
                    <h2>Featured Music</h2>
                </div>

                <RouterLink to="/music" class="view-link">
                    View All →
                </RouterLink>
            </div>

            <div v-if="error">
    <p>{{ error }}</p>
</div>

<div v-else class="music-grid">
    <div
        v-for="track in music"
        :key="track.id"
        class="music-card"
    >
        <div class="music-card-image">
            <span>♪</span>
        </div>

        <div class="music-card-content">
            <h3>{{ track.title }}</h3>
            <p>{{ track.artist_name }}</p>

            <audio controls>
                <source :src="track.audio_url">
                Your browser does not support audio playback.
            </audio>
        </div>
    </div>
</div>
        </section>

        <!-- Artists Section -->
        <section class="section">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">MEET THE ARTISTS</p>
                    <h2>Artists on JAKALTSHA</h2>
                </div>

                <RouterLink to="/artists" class="view-link">
                    View Artists →
                </RouterLink>
            </div>

            <div class="artist-placeholder">
                <p>Discover the artists behind the music.</p>
            </div>
        </section>

        <!-- Merchandise Section -->
        <section class="section merchandise-section">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">WEAR THE SOUND</p>
                    <h2>Merchandise</h2>
                </div>

                <RouterLink to="/shop" class="view-link">
                    Shop All →
                </RouterLink>
            </div>

            <div class="merch-placeholder">
                <p>Artist merchandise coming soon.</p>
            </div>
        </section>

    </div>
</template>

<style scoped>
.home {
    min-height: 100vh;
}

/* Hero */

.hero {
    min-height: 600px;
    display: flex;
    align-items: center;
    padding: 80px 8%;
    background: #f2f2f2;
}

.hero-content {
    max-width: 800px;
}

.eyebrow {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 3px;
    margin-bottom: 15px;
}

.hero h1 {
    font-size: clamp(50px, 8vw, 100px);
    line-height: 0.95;
    margin: 0 0 30px;
    font-weight: 900;
}

.hero h1 span {
    display: block;
}

.hero-text {
    max-width: 600px;
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 30px;
}

.hero-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.primary-button,
.secondary-button {
    padding: 14px 24px;
    text-decoration: none;
    font-weight: bold;
}

.primary-button {
    background: #111;
    color: white;
}

.secondary-button {
    border: 2px solid #111;
    color: #111;
}

/* Sections */

.section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 80px 24px;
}

.section-heading {
    display: flex;
    justify-content: space-between;
    align-items: end;
    margin-bottom: 30px;
}

.section-heading h2 {
    font-size: 36px;
    margin: 0;
}

.view-link {
    color: #111;
    text-decoration: none;
    font-weight: bold;
}

.music-placeholder,
.artist-placeholder,
.merch-placeholder {
    min-height: 180px;
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fafafa;
}

.merchandise-section {
    padding-bottom: 100px;
}

.music-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.music-card {
    border: 1px solid #ddd;
    background: #fff;
}

.music-card-image {
    height: 220px;
    background: #e8e8e8;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 60px;
}

.music-card-content {
    padding: 20px;
}

.music-card-content h3 {
    margin: 0 0 6px;
    font-size: 20px;
}

.music-card-content p {
    margin: 0 0 15px;
    color: #666;
}

.music-card audio {
    width: 100%;
}
</style>