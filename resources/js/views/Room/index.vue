<template>
    <div>
        <player :type="room.type"
                :url="room.url"
                :everyone_control="room.everyone_control"
                :id="id"
                :password="password"
                v-if="isReady"
        ></player>
        <section class="section" style="padding: 1.5rem">
            <h1 class="title is-4">{{ room.title }}</h1>
        </section>
    </div>
</template>

<script>
    import Player from "./Player";
    export default {
        name: "Room",
        components: {Player},
        data() {
            return {
                id: 0,
                password: '',
                room: {
                    title: ''
                }
            };
        },
        computed: {
            isReady() {
                return this.id !== 0;
            }
        },
        created() {
            this.id = this.$route.params['id'] ?? 0;
            this.password = this.$route.query['password'] ?? '';
            let path = '/room';
            if (this.id !== 0) {
                path += '/' + this.id + '?password=' + this.password;
            }
            axios.get(path)
                .then(response => {
                    this.room = response.data
                    if (this.id === 0) {
                        this.id = this.room.id;
                        this.password = this.room.password;
                    }
                })
                .catch(error => {
                    let message = 'Произошла ошибка.';
                    if (error.response.status === 404) {
                        message = 'Комната не найдена.';
                    } else if (error.response.status === 403) {
                        message = 'Неверный пароль.';
                    }
                    this.$buefy.snackbar.open({
                        duration: 5 * 1000,
                        message: message,
                        actionText: null,
                        position: 'is-top'
                    })
                    this.$router.replace('/');
                });
        }
    }
</script>

<style scoped>

</style>
