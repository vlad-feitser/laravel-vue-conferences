import Vue from "vue";
import ConferencePage from "../pages/ConferencePage.vue";
import ConferenceShow from "../pages/ConferenceShow.vue";
import ConferenceEdit from "../pages/ConferenceEdit.vue";
import LectureEdit from "../pages/LectureEdit.vue";
import LectureShow from "../pages/LectureShow.vue";
import FavoritesLecture from "../pages/FavoritesLecture.vue";
import CategoryShow from "../pages/CategoryShow.vue";
import CreateCategory from "../pages/CreateCategory.vue";
import Login from "../pages/Login.vue";
import Registration from "../pages/Registration.vue";
import UserProfile from "../pages/UserProfile.vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",

    routes: [
        {
            path: "/",
            component: ConferencePage,
            name: "conferences",
        },
        {
            path: "/user/login",
            component: Login,
            name: "login",
        },
        {
            path: "/user/register",
            component: Registration,
            name: "register",
        },
        {
            path: "/users/:id",
            component: UserProfile,
            name: "user.profile",
        },
        {
            path: "/lectures/:id",
            component: LectureShow,
            name: "lectures.show",
        },
        {
            path: "/lectures/:id/edit",
            component: LectureEdit,
            name: "lectures.edit",
        },
        {
            path: "/lectures/:id/favorites",
            component: FavoritesLecture,
            name: "lectures.favorites",
        },
        {
            path: "/conferences/:id",
            component: ConferenceShow,
            name: "conferences.show",
        },
        {
            path: "/conferences/:id/edit",
            component: ConferenceEdit,
            name: "conferences.edit",
        },
        {
            path: "/categories",
            component: CategoryShow,
            name: "categories",
        },
        {
            path: "/categories/create",
            component: CreateCategory,
            name: "categories.create",
        },
    ],
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return { selector: to.hash };
        } else {
            return { x: 0, y: 0 };
        }
    },
});

router.beforeEach(async (to, from, next) => {
    const token = localStorage.getItem("token");
    const user = JSON.parse(localStorage.getItem("user"));

    if (!token) {
        if (
            to.name === "login" ||
            to.name === "register" ||
            to.name === "conferences"
        ) {
            return next();
        } else {
            return next({
                name: "register",
            });
        }
    }

    if (token && (to.name === "login" || to.name === "register")) {
        return next({
            name: "conferences",
        });
    }

    if (
        (!user || (user && user.type !== "Admin")) &&
        to.name === "conferences.edit"
    ) {
        return next({
            name: "conferences",
        });
    }

    if (
        (!user || (user && user.type !== "Admin")) &&
        (to.name === "categories" || to.name === "categories.create")
    ) {
        return next({
            name: "conferences",
        });
    }

    next();
});

export default router;
