<template>
    <div style="height: 100%; width: 100%">
        <transition name="fade">
            <router-view v-if="isReady"></router-view>
        </transition>
        <b-loading :is-full-page="true" :active="!isReady"></b-loading>
    </div>
</template>

<script>
    export default {
        name: "App",
        data() {
            return {
                appInit: true,//TODO
                isLoading: true
            };
        },
        computed: {
            isReady() {
                return this.appInit && !this.isLoading;
            }
        },
        beforeCreate() {
            axios.interceptors.response.use(undefined, (error) => {
                if (!error.response) {
                    this.$buefy.toast.open({
                        message: 'Что-то с интернет соединением...',
                        type: 'is-danger',
                        queue: false
                    })
                }
                return Promise.reject(error);
            });
            bridge.subscribe(e => {
                if (e.detail.type === 'VKWebAppUpdateConfig') {
                    const scheme = e.detail.data.scheme ? e.detail.data.scheme : 'client_light';
                    if (scheme !== 'client_light' && scheme !== 'bright_light') {
                        document.getElementById('dark_scheme').media = "";
                        document.getElementById('light_scheme').media = "none";
                    }
                }
            });
            bridge.send("VKWebAppInit", {})
                .then(e => this.appInit = e.result);
            bridge.send('VKWebAppStorageGet', {keys: ['messageAudio']})
                .then(({keys}) => {
                    if (!keys[0].value) {
                        bridge.send('VKWebAppStorageSet', {key: 'messageAudio', value: 'true'});
                        keys[0].value = 'true';
                    }
                    this.$store.commit('setAudio', keys[0].value === 'true');
                })
            setTimeout(() => {
                if (!this.appInit) {
                    this.$buefy.snackbar.open({
                        duration: 10 * 1000,
                        message: 'Похоже, мы не смогли получить доступ к клиенту ВК.',
                        type: 'is-danger',
                        actionText: null
                    })
                    throw new Error('ВК клиент недоступен');
                }
            }, 5 * 1000);
            axios.post('/login').then(response => {
                if (response.data.newUser) {
                    if (this.$route.path !== '/welcome') {
                        this.$router.replace('/welcome');
                    }
                }
                if (response.data.room) {
                    this.$store.commit('createdOwnRoom', response.data.room);
                }
                this.$store.commit('setUser', response.data.user);
                this.isLoading = false;
            }).catch(error => {
                this.$buefy.snackbar.open({
                    duration: 10 * 1000,
                    message: 'Ошибка аутентификации',
                    type: 'is-danger',
                    actionText: null
                })
                throw new Error('Ошибка аутентификации');
            });
        }
    }
</script>

<style scoped>

</style>
