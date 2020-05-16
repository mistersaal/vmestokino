<template>
    <div class="box">
        <h2 class="title is-5" v-if="!hasOwnRoom">Создать комнату</h2>
        <h2 class="title is-5" v-else>Своя комната</h2>
        <div class="buttons" v-if="!hasOwnRoom">
            <b-button type="is-danger"
                      size="is-medium"
                      expanded
                      icon-left="youtube"
                      icon-pack="fab"
                      @click="createRoom(
                          'youtube',
                          '^(https://)?(((www|m)\\.)?youtube\\.com/watch\\?v=|youtu\\.be/).+'
                      )"
            >
                YouTube
            </b-button>
            <b-button size="is-medium" expanded icon-left="business-time" disabled>
                Скоро будет ещё
            </b-button>
        </div>
        <div class="buttons" v-else>
            <b-button type="is-primary"
                      size="is-medium"
                      expanded
                      icon-left="users"
                      @click="toOwnRoom"
            >
                Зайти в свою комнату
            </b-button>
            <b-button type="is-light"
                      size="is-medium"
                      expanded
                      icon-left="trash-alt"
                      @click="deleteRoom"
            >
                Удалить комнату
            </b-button>
        </div>
        <create-room
            :is-creating="isCreating"
            :type-for-creating="typeForCreating"
            :regexp-url="regexpUrl"
            @close="closeModal"
        ></create-room>
    </div>
</template>

<script>
    import CreateRoom from "./CreateRoom";
    export default {
        name: "RoomButtons",
        data() {
            return {
                isCreating: false,
                typeForCreating: '',
                regexpUrl: ''
            };
        },
        methods: {
            createRoom(type, regexp) {
                this.typeForCreating = type;
                this.regexpUrl = regexp;
                this.isCreating = true;
            },
            deleteRoom() {
                axios.delete('/room').then((r) => {
                    this.$store.commit('deletedOwnRoom');
                    this.$buefy.snackbar.open({
                        message: r.data.message,
                        actionText: null,
                        position: 'is-top',
                        queue: false
                    })
                }).catch((e) => {
                    this.$buefy.snackbar.open({
                        message: e.response.data.message,
                        actionText: null,
                        position: 'is-top',
                        queue: false
                    })
                });
            },
            closeModal() {
                this.isCreating = false;
            },
            toOwnRoom() {
                this.$router.push('/room');
            }
        },
        components: {CreateRoom},
        computed: {
            hasOwnRoom() {
                return this.$store.state.hasOwnRoom;
            }
        }
    }
</script>

<style scoped>

</style>
