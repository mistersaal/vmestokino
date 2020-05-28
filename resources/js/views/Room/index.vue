<template>
    <div>
        <b-loading :is-full-page="true" :active="!isReady"></b-loading>
        <nav-menu :style="{'margin-top': (this.realHeight - this.windowHeight) + 'px'}"></nav-menu>
        <player :room="room"
                :id="id"
                :password="password"
                :can-control="canControl"
                :is-admin="isAdmin"
                :users="users"
                v-if="isReady"
        ></player>
        <chat v-if="isReady"
              :id="id"
              :password="password"
              :window-height="windowHeight"
              :window-width="windowWidth"
        ></chat>
    </div>
</template>

<script>
    import NavMenu from "./NavMenu";
    import Player from "./Player";
    import Chat from "./Chat/Chat";
    export default {
        name: "Room",
        components: {Chat, Player, NavMenu},
        data() {
            return {
                id: 0,
                password: '',
                canControl: false,
                isAdmin: false,
                room: {},
                users: {},
                windowHeight: 0,
                windowWidth: 0,
                realHeight: 0,
            };
        },
        computed: {
            isReady() {
                return !_.isEmpty(this.room);
            }
        },
        mounted() {
            this.onResize();
            if (window.visualViewport) {
                window.visualViewport.addEventListener('resize', this.onResize);
            } else {
                window.addEventListener('resize', this.onResize);
            }
        },
        beforeDestroy() {
            if (window.visualViewport) {
                window.visualViewport.removeEventListener('resize', this.onResize);
            } else {
                window.removeEventListener('resize', this.onResize);
            }
        },
        methods: {
            onResize() {
                if (window.visualViewport) {
                    this.windowHeight = window.visualViewport.height;
                    this.windowWidth = window.visualViewport.width;
                } else {
                    this.windowHeight = window.innerHeight;
                    this.windowWidth = window.innerWidth;
                }
                this.realHeight = window.innerHeight;
            },
            setListeners() {
                Echo.join('room.player.' + this.id + '.' + this.password)
                    .here((users) => {
                        users.forEach(user => this.$set(this.users, user.id, user));
                    })
                    .joining(user => this.$set(this.users, user.id, user))
                    .leaving(user => this.$delete(this.users, user.id))
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
        },
        destroyed() {
            Echo.leave('room.player.' + this.id + '.' + this.password);
        }
    }
</script>

<style scoped>

</style>
