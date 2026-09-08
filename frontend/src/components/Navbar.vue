<template>
    <nav class="navbar">
        <div class="navbar-container">

            <RouterLink to="/" class="logo">
                JAKALTSHA
            </RouterLink>

            <div class="nav-links">
                <RouterLink to="/">Home</RouterLink>
                <RouterLink to="/music">Music</RouterLink>
                <RouterLink to="/artists">Artists</RouterLink>
                <RouterLink to="/shop">Shop</RouterLink>
                <RouterLink to="/cart">Cart</RouterLink>
            </div>

            <div class="nav-auth">
                <RouterLink to="/login">Login</RouterLink>
                <RouterLink to="/register" class="register-button">
                    Register
                </RouterLink>
            </div>

        </div>
    </nav>
</template>

<style scoped>
.navbar {
    width: 100%;
    background: #111;
    color: white;
}

.navbar-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 16px 24px;

    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    color: white;
    text-decoration: none;
    font-size: 24px;
    font-weight: bold;
}

.nav-links {
    display: flex;
    gap: 24px;
}

.nav-links a,
.nav-auth a {
    color: white;
    text-decoration: none;
}

.nav-links a:hover,
.nav-auth a:hover {
    text-decoration: underline;
}

.nav-auth {
    display: flex;
    align-items: center;
    gap: 16px;
}

.register-button {
    border: 1px solid white;
    padding: 8px 14px;
    border-radius: 4px;
}
</style>