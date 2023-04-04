import axios from "axios"

export const conferenceModule = {
    state: () => ({
        conferences: [],
        isConferencesLoading: false
    }),
    getters: {
        getConferences(state) {
            return state.conferences
        }
    },
    mutations: {
        setConferences(state, conferences) {
            state.conferences = conferences
        },
        setLoading(state, bool) {
            state.isConferencesLoading = bool
        },
        deleteConference(state, id) {
            state.conferences.data = state.conferences.data.filter(c => c.id !== id)
        },
    },
    actions: {
        async fetchConferences({commit}, page=1) {
            try {
                commit('setLoading', true)
                const response = await axios.get('/api/conferences?page=' + page)
                commit('setConferences', response.data)
            } catch(e) {
                console.log(e)
            } finally {
                commit('setLoading', false)
            }
        },
        async deleteConference({commit}, id) {
            await axios.delete('/api/conferences/' + id)
            .then(commit('deleteConference', id))
        },
        
    },
    namespaced: true
}