<template>
    <div class="box">
        <h2 class="title is-5" v-if="!ownRoom">Создать комнату</h2>
        <h2 class="title is-5" v-else>Своя комната</h2>
        <create-room
            :is-creating="isCreating"
            :type-for-creating="typeForCreating"
            :regexp-url="regexpUrl"
            @close="closeModal"
        ></create-room>
        <div class="buttons" v-if="!ownRoom">
            <b-button v-for="(button, type) in types" :key="button.id"
                      :type="button.color"
                      size="is-medium"
                      expanded
                      :icon-left="button.icon"
                      :icon-pack="button.iconType"
                      @click="createRoom(
                          type,
                          button.regExp
                      )"
            >
                {{ button.name }}
            </b-button>
            <b-button size="is-medium" expanded icon-left="business-time" disabled>
                Скоро будет ещё
            </b-button>
        </div>
        <div class="buttons" v-else>
            <b-button size="is-medium"
                      :type="types[ownRoom.type].color"
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
                regexpUrl: '',
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
            ownRoom() {
                return this.$store.state.ownRoom;
            }
        }
    }
</script>

<style scoped>

</style>
