<template>
    <div>
        <h2 class="title is-5">Смотреть вместе</h2>
        <div class="buttons">
            <b-button type="is-danger"
                      size="is-medium"
                      expanded
                      icon-left="youtube"
                      icon-pack="fab"
                      @click="createRoom('youtube')"
            >
                YouTube
            </b-button>
            <b-button size="is-medium" expanded icon-left="business-time" disabled>
                Скоро будет ещё
            </b-button>
        </div>
        <create-modal
            :is-creating="isCreating"
            :type-for-creating="typeForCreating"
            @close="closeModal"
        ></create-modal>
    </div>
</template>

<script>
    import CreateModal from "./CreateModal";
    export default {
        name: "CreateButtons",
        data() {
            return {
                isCreating: false,
                typeForCreating: ''
            };
        },
        methods: {
            createRoom(type) {
                this.isCreating = true;
            },
            closeModal() {
                this.isCreating = false;
            }
        },
        components: {CreateModal}
    }
</script>

<style scoped>

</style>
