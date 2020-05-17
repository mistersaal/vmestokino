export default new Vuex.Store({
    state: {
        ownRoom: null,
        historyIsEmpty: 2,
    },
    mutations: {
        createdOwnRoom(state, payload) {
            state.ownRoom = payload;
        },
        deletedOwnRoom(state) {
            state.ownRoom = null;
        },
        historyPushed(state) {
            state.historyIsEmpty -= 1;
        }
    }
})
