export default new Vuex.Store({
    state: {
        hasOwnRoom: false
    },
    mutations: {
        createdOwnRoom(state) {
            state.hasOwnRoom = true;
        },
        deletedOwnRoom(state) {
            state.hasOwnRoom = false;
        }
    }
})
