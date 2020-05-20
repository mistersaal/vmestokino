<template>
    <div>
        <b-loading :is-full-page="true" :active="!isReady"></b-loading>
        <nav-menu></nav-menu>
        <player :room="room"
                :id="id"
                :password="password"
                :can-control="canControl"
                :is-admin="isAdmin"
                v-if="isReady"
        ></player>
    </div>
</template>

<script>
    import NavMenu from "./NavMenu";
    import Player from "./Player";
    export default {
        name: "Room",
        components: {Player, NavMenu},
        data() {
            return {
                id: 0,
                password: '',
                canControl: false,
                isAdmin: false,
                room: {}
            };
        },
        computed: {
            isReady() {
                return !_.isEmpty(this.room);
            }
        },
        methods: {
            setListeners() {
                Echo.join('room.player.' + this.id + '.' + this.password)
                    .listen('RoomUpdated', (e) => {
                        this.room = e.room;
                        this.canControl = this.room.everyone_control || this.isAdmin;
                    })
                    .listen('RoomDeleted', () => {
                        Echo.leave('room.player.' + this.id + '.' + this.password);
                        this.$buefy.snackbar.open({
                            duration: 5 * 1000,
                            message: 'Комната была удалена',
                            actionText: null,
                            position: 'is-top'
                        })
                        this.$router.replace('/');
                    });
            },
            setRoomData() {
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
                        this.canControl = this.room.currentUserCanControl;
                        this.isAdmin = this.room.isAdmin;
                        this.setListeners();
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
        },
        created() {
            this.setRoomData();
        }
    }
</script>

<style scoped>

</style>
