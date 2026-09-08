<template>
    <footer class="footer">
        <div class="footer-container">

            <div class="footer-brand">
                <h2>JAKALTSHA</h2>
                <p>
                    Music. Merchandise. South African Artists.
                </p>
            </div>

            <div class="footer-links">
                <RouterLink to="/">Home</RouterLink>
                <RouterLink to="/music">Music</RouterLink>
                <RouterLink to="/artists">Artists</RouterLink>
                <RouterLink to="/shop">Shop</RouterLink>
                <RouterLink to="/cart">Cart</RouterLink>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 JAKALTSHA. All rights reserved.</p>
        </div>
    </footer>
</template>

<style scoped>
.footer {
    margin-top: 40px;
    background: #111;
    color: white;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 24px;

    display: flex;
    justify-content: space-between;
    gap: 40px;
}

.footer-brand h2 {
    margin-bottom: 10px;
}

.footer-brand p {
    margin: 0;
}

.footer-links {
    display: flex;
    gap: 20px;
    align-items: center;
}

.footer-links a {
    color: white;
    text-decoration: none;
}

.footer-links a:hover {
    text-decoration: underline;
}

.footer-bottom {
    border-top: 1px solid #333;
    padding: 16px 24px;
    text-align: center;
}

.footer-bottom p {
    margin: 0;
}
</style>