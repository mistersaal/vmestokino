export default new Vuex.Store({
    state: {
        ownRoom: null,
        historyIsEmpty: 2,
        types: {
            youtube: {
                id: 1,
                color: 'is-danger',
                icon: 'youtube',
                iconType: 'fab',
                regExp: '^(https://)?(((www|m)\\.)?youtube\\.com/watch\\?v=|youtu\\.be/).+',
                name: 'YouTube'
            }
        },
        user: {},
        appLink: 'https://vk.com/app7447010',
        audioOn: true,
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
        },
        setUser(state, user) {
            state.user = user;
        },
        setAudio(state, audio) {
            state.audioOn = audio;
        },
    }
})
