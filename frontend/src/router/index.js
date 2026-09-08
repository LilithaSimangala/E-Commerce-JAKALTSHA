import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),

    routes: [
        {
            path: "/",
            name: "home",
            component: () => import("../views/HomePage.vue")
        },

        {
            path: "/login",
            name: "login",
            component: () => import("../views/LoginPage.vue")
        },

        {
            path: "/register",
            name: "register",
            component: () => import("../views/RegisterPage.vue")
        },

        {
            path: "/artists",
            name: "artists",
            component: () => import("../views/ArtistsPage.vue")
        },

        {
            path: "/artists/:id",
            name: "artist-details",
            component: () => import("../views/ArtistDetailsPage.vue")
        },

        {
            path: "/music",
            name: "music",
            component: () => import("../views/MusicPage.vue")
        },

        {
            path: "/shop",
            name: "shop",
            component: () => import("../views/ShopPage.vue")
        },

        {
            path: "/products/:id",
            name: "product-details",
            component: () => import("../views/ProductDetailsPage.vue")
        },

        {
            path: "/cart",
            name: "cart",
            component: () => import("../views/CartPage.vue")
        },

        {
            path: "/checkout",
            name: "checkout",
            component: () => import("../views/CheckoutPage.vue")
        },

        {
    path: "/payment",
    name: "payment",
    component: () => import("../views/PaymentPage.vue")
},

        {
            path: "/order-confirmation/:id",
            name: "order-confirmation",
            component: () => import("../views/OrderConfirmationPage.vue")
        }
    ]
});

export default router;