<template>
    <div>
        <h2 class="title is-5">Смотреть вместе</h2>
        <div class="buttons">
            <b-button type="is-danger"
                      size="is-medium"
                      expanded
                      icon-left="youtube"
                      icon-pack="fab"
                      @click="createRoom(
                          'youtube',
                          '^(https://)?((www|m)\\.)?youtube\\.com/watch\\?v=.+'
                      )"
            >
                YouTube
            </b-button>
            <b-button size="is-medium" expanded icon-left="business-time" disabled>
                Скоро будет ещё
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
            }
        },
        components: {CreateRoom}
    }
</script>

<style scoped>

</style>
