import axios from "axios"

export const lectureModule = {
    state: () => ({
        lectures: []
    }),
    getters: {
        getLectures(state) {
            return state.lectures
        }
    },
    mutations: {
        setLectures(state, lectures) {
            state.lectures = lectures
        },
        deleteLecture(state, id) {
            state.lectures = state.lectures.filter(l => l.id !== id)
        },
    },
    actions: {
        async fetchLectures({commit}) {
            try {
                const response = await axios.get('/api/lectures')
                commit('setLectures', response.data.lectures)
            } catch(e) {
                console.log(e)
            } finally {
            }
        },
        async deleteLectures({commit}, id) {
            await axios.delete('/api/lectures/' + id)
            .then(commit('deleteLecture', id))
        },
        
    },
    namespaced: true
}