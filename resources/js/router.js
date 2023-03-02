import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "home",
            component: () => import("./components/Main/HomeComponent.vue"),
        },
        {
            path: "/profile",
            name: "profile",
            component: () => import("./components/Main/ProfileComponent.vue"),
        },
        {
            path: "/profile/settings",
            name: "profile.settings",
            component: () => import("./components/Main/ProfileSettingsComponent.vue"),
        },
        {
            path: "/auth",
            name: "auth",
            component: () => import("./components/User/MainAuthComponent.vue"),
        },
        {
            path: "/password-email",
            name: "password.email",
            component: () => import("./components/User/PasswordEmail.vue"),
        },
        {
            path: "/dictionary",
            name: "dictionary",
            component: () => import("./components/Dictionary/Main.vue"),
        },
        {
            path: "/word/:user_id/:word_id",
            name: "word",
            component: () => import("./components/Dictionary/Word.vue"),
        },
    ],
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("x_xsrf_token");

    if (!token) {
        if (
            to.name === "auth" ||
            to.name === "home" ||
            to.name === "password.email" ||
            to.name === "password.reset"
        ) {
            return next();
        } else {
            return next({
                name: "auth",
            });
        }
    }
    if (
        to.name === "password.reset" ||
        to.name === "password.email" ||
        to.name === "auth" && token
    ) {
        return next({
            name: "cabinet",
        });
    }

    next();
});

export default router;
