<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const artist = ref(null);
const music = ref([]);
const error = ref("");

const API_URL = "http://localhost/JAKALTSHA/backend/routes";

onMounted(async () => {
    try {
        // Get artist information
        const artistResponse = await fetch(
            `${API_URL}/artists.php?id=${route.params.id}`
        );

        if (!artistResponse.ok) {
            throw new Error("Failed to fetch artist");
        }

        artist.value = await artistResponse.json();

        // Get artist's music
        const musicResponse = await fetch(
            `${API_URL}/music.php?artist_id=${route.params.id}`
        );

        if (!musicResponse.ok) {
            throw new Error("Failed to fetch artist music");
        }

        music.value = await musicResponse.json();

    } catch (err) {
        error.value = "Failed to load artist";
        console.error(err);
    }
});
</script>

<template>
    <main class="artist-details-page">

        <p v-if="error" class="error">
            {{ error }}
        </p>

        <template v-if="artist">

            <!-- Artist Header -->
            <section class="artist-header">

                <div class="artist-header-image">
                    <img
                        :src="artist.image"
                        :alt="artist.name"
                    >
                </div>

                <div class="artist-header-content">

                    <p class="eyebrow">JAKALTSHA ARTIST</p>

                    <h1>{{ artist.name }}</h1>

                    <p class="artist-bio">
                        {{ artist.bio }}
                    </p>

                    <RouterLink
                        to="/artists"
                        class="back-button"
                    >
                        ← All Artists
                    </RouterLink>

                </div>

            </section>

            <!-- Music -->
            <section class="music-section">

                <div class="section-heading">
                    <p class="eyebrow">MUSIC</p>
                    <h2>Tracks by {{ artist.name }}</h2>
                </div>

                <div
                    v-if="music.length"
                    class="music-list"
                >

                    <article
                        v-for="track in music"
                        :key="track.id"
                        class="music-card"
                    >

                        <div class="music-image">
                            <img
                                :src="track.cover_image"
                                :alt="track.title"
                            >
                        </div>

                        <div class="music-content">

                            <h3>{{ track.title }}</h3>

                            <p>{{ artist.name }}</p>

                            <audio controls>
                                <source :src="track.audio_url">
                                Your browser does not support audio playback.
                            </audio>

                        </div>

                    </article>

                </div>

                <p v-else class="no-music">
                    No music available for this artist yet.
                </p>

            </section>

        </template>

    </main>
</template>

<style scoped>

.artist-details-page {
    min-height: 100vh;
}

/* Artist Header */

.artist-header {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 500px;
    background: #f2f2f2;
}

.artist-header-image {
    width: 100%;
    height: 500px;
    overflow: hidden;
}

.artist-header-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.artist-header-content {
    padding: 70px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.eyebrow {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 3px;
    margin-bottom: 12px;
}

.artist-header-content h1 {
    font-size: 64px;
    margin: 0 0 20px;
}

.artist-bio {
    max-width: 500px;
    font-size: 18px;
    line-height: 1.7;
    color: #555;
}

.back-button {
    display: inline-block;
    width: fit-content;
    margin-top: 20px;
    padding: 10px 16px;
    background: #111;
    color: white;
    text-decoration: none;
}

.back-button:hover {
    background: #333;
}

/* Music */

.music-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 70px 24px;
}

.section-heading {
    margin-bottom: 35px;
}

.section-heading h2 {
    font-size: 36px;
    margin: 0;
}

.music-list {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

.music-card {
    border: 1px solid #ddd;
    background: white;
    overflow: hidden;
}

.music-image {
    width: 100%;
    height: 260px;
    overflow: hidden;
    background: #e8e8e8;
}

.music-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.music-content {
    padding: 20px;
}

.music-content h3 {
    margin: 0 0 6px;
    font-size: 21px;
}

.music-content p {
    color: #666;
    margin-bottom: 18px;
}

.music-content audio {
    width: 100%;
}

.no-music {
    color: #666;
}

.error {
    padding: 40px 8%;
    color: #b00020;
}

/* Responsive */

@media (max-width: 900px) {

    .artist-header {
        grid-template-columns: 1fr;
    }

    .artist-header-image {
        height: 400px;
    }

    .artist-header-content {
        padding: 50px 30px;
    }

    .music-list {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 600px) {

    .artist-header-image {
        height: 300px;
    }

    .artist-header-content h1 {
        font-size: 48px;
    }

    .music-list {
        grid-template-columns: 1fr;
    }

}

</style>