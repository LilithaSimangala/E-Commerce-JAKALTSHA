const API_URL = "/api";

export async function getMusic() {
    const response = await fetch(`${API_URL}/music.php`);

    if (!response.ok) {
        throw new Error("Failed to fetch music");
    }

    return await response.json();
}