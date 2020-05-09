<template>
    <div>
        <router-view v-if="isReady"></router-view>
        <b-loading :is-full-page="true" :active="!isReady"></b-loading>
    </div>
</template>

<script>
    export default {
        name: "App",
        data() {
            return {
                appInit: false,
                isLoading: true
            };
        },
        computed: {
            isReady() {
                return this.appInit && !this.isLoading;
            }
        },
        created() {
            bridge.send("VKWebAppInit", {})
                .then(e => this.appInit = e.result);
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
                    this.$router.replace('/welcome');
                } else if (response.data.hasRoom) {
                    this.$router.replace('/room');
                }
                this.isLoading = false;
            });
        }
    }
</script>

<style scoped>

</style>
