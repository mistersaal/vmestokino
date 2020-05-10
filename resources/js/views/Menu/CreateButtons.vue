<template>
    <div>
        <h2 class="title is-5">Смотреть вместе</h2>
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
        name: "CreateButtons",
        data() {
            return {
                isCreating: false,
                hasOwnRoom: false,
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
            closeModal() {
                this.isCreating = false;
            },
            toOwnRoom() {
                this.$router.push('/room');
            }
        },
        components: {CreateRoom},
        created() {
            const loadingComponent = this.$buefy.loading.open()
            axios.get('/room').then(() => {this.hasOwnRoom = true; loadingComponent.close()});
        }
    }
</script>

<style scoped>

</style>
