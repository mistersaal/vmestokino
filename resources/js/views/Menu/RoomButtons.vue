<template>
    <div class="box">
        <h2 class="title is-5" v-if="!ownRoom">Создать комнату</h2>
        <h2 class="title is-5" v-else>Своя комната</h2>
        <room-data-control
            :init-room="ownRoom"
            :default-type="defaultType"
            :types="types"
        ></room-data-control>
        <div class="buttons" v-if="!ownRoom">
            <b-button v-for="(button, type) in types" :key="button.id"
                      :type="button.color"
                      size="is-medium"
                      expanded
                      :icon-left="button.icon"
                      :icon-pack="button.iconType"
                      @click="createRoom(type)"
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
                      icon-left="edit"
                      @click="updateRoom"
            >
                Редактировать комнату
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
    import RoomDataControl from "../../components/RoomDataControl";
    export default {
        name: "RoomButtons",
        data() {
            return {
                defaultType: 'youtube',
                types: this.$store.state.types,
            };
        },
        methods: {
            createRoom(type) {
                this.defaultType = type;
                this.$router.push(this.$route.fullPath + '#create');
            },
            updateRoom() {
                this.$router.push(this.$route.fullPath + '#update');
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
            toOwnRoom() {
                this.$router.push('/room');
            }
        },
        components: {RoomDataControl},
        computed: {
            ownRoom() {
                return this.$store.state.ownRoom;
            }
        }
    }
</script>

<style scoped>

</style>
