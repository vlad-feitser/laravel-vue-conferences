import axios from "axios";

export const userModule = {
    state: () => ({
        token: localStorage.getItem("token"),
        user: JSON.parse(localStorage.getItem("user")),
        joined_conferences: JSON.parse(
            localStorage.getItem("joined_conferences")
        ),
        favorite_lectures: JSON.parse(
            localStorage.getItem("favorite_lectures")
        ),
    }),
    getters: {
        getToken(state) {
            return state.token;
        },
        getUser(state) {
            return state.user;
        },
        getJoinedConferences(state) {
            return state.joined_conferences;
        },
        getFavoritesLectures(state) {
            return state.favorite_lectures;
        },
    },
    mutations: {
        setToken(state, bool) {
            state.token = bool;
        },
        setUser(state, user) {
            state.user = user;
        },
        setJoinedConferences(state, conference) {
            state.joined_conferences = conference;
        },
        setFavoritesLectures(state, lecture) {
            state.favorite_lectures = lecture;
        },
    },
    actions: {
        async loginUser({ commit }, user) {
            await axios.get("/sanctum/csrf-cookie");

            const response = await axios.post("/login", {
                email: user.email,
                password: user.password,
            });
            if (response.status === 200) {
                commit("setToken", true);
                commit("setUser", response.data.user);
                commit("setJoinedConferences", response.data.join);
                commit("setFavoritesLectures", response.data.favorites);
                localStorage.setItem(
                    "user",
                    JSON.stringify(response.data.user)
                );
                localStorage.setItem(
                    "token",
                    response.config.headers["X-XSRF-TOKEN"]
                );
                localStorage.setItem(
                    "joined_conferences",
                    JSON.stringify(response.data.join)
                );
                localStorage.setItem(
                    "favorite_lectures",
                    JSON.stringify(response.data.favorites)
                );
            }
        },
        async registerUser({ commit }, user) {
            await axios.get("/sanctum/csrf-cookie");
            const response = await axios.post("/register", {
                firstname: user.firstname,
                lastname: user.lastname,
                email: user.email,
                password: user.password,
                password_confirmation: user.password_confirmation,
                type: user.type,
                birthdate: user.birthdate,
                country: user.country,
                phone: user.phone,
            });
            if (response.status === 200) {
                commit("setToken", true);
                commit("setUser", response.data.user);
                commit("setJoinedConferences", response.data.join);
                commit("setFavoritesLectures", response.data.favorites);
                localStorage.setItem(
                    "user",
                    JSON.stringify(response.data.user)
                );
                localStorage.setItem(
                    "token",
                    response.config.headers["X-XSRF-TOKEN"]
                );
                localStorage.setItem(
                    "joined_conferences",
                    JSON.stringify(response.data.join)
                );
                localStorage.setItem(
                    "favorite_lectures",
                    JSON.stringify(response.data.favorites)
                );
            }
        },
        logout({ commit }) {
            axios.post("/logout").then((response) => {
                localStorage.removeItem("token");
                localStorage.removeItem("user");
                localStorage.removeItem("joined_conferences");
                localStorage.removeItem("favorite_lectures");
                commit("setUser", null);
                commit("setToken", false);
                commit("setJoinedConferences", null);
                commit("setFavoritesLectures", null);
            });
        },
        join({ commit }, conferenceId) {
            axios
                .post("/api/conferences/" + conferenceId + "/join")
                .then((response) => {
                    commit("setJoinedConferences", response.data);
                    localStorage.setItem(
                        "joined_conferences",
                        JSON.stringify(response.data)
                    );
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        unjoin({ commit }, conferenceId) {
            axios
                .post("/api/conferences/" + conferenceId + "/unjoin")
                .then((response) => {
                    commit("setJoinedConferences", response.data);
                    localStorage.setItem(
                        "joined_conferences",
                        JSON.stringify(response.data)
                    );
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        addFavorite({ commit }, id) {
            axios
                .post("/api/lectures/" + id + "/favorite")
                .then((res) => {
                    commit("setFavoritesLectures", res.data);
                    localStorage.setItem(
                        "favorite_lectures",
                        JSON.stringify(res.data)
                    );
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        deleteFavorite({ commit }, id) {
            axios
                .post("/api/lectures/" + id + "/unfavorite")
                .then((res) => {
                    commit("setFavoritesLectures", res.data);
                    localStorage.setItem(
                        "favorite_lectures",
                        JSON.stringify(res.data)
                    );
                })
                .catch((e) => {
                    console.log(e);
                });
        },
    },
    namespaced: true,
};
