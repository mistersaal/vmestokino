export default new Vuex.Store({
    state: {
        hasOwnRoom: false,
        historyIsEmpty: 2,
    },
    mutations: {
        createdOwnRoom(state) {
            state.hasOwnRoom = true;
        },
        deletedOwnRoom(state) {
            state.hasOwnRoom = false;
        },
        historyPushed(state) {
            state.historyIsEmpty -= 1;
        }
    }
})
