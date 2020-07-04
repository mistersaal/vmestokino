<template>
    <b-modal :active="isOpen"
             has-modal-card
             trap-focus
             :can-cancel="['escape', 'outside']"
             @close="close"
             destroy-on-hide
    >
        <form @submit.prevent="deleteRoom">
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title has-text-weight-bold">
                        Удаление комнаты
                    </p>
                </header>
                <section class="modal-card-body">
                    <p>
                        Вы уверены, что хотите удалить комнату?<br>
                        Все, кто в ней находятся, будут возвращены в меню.
                    </p>
                </section>
                <footer class="modal-card-foot">
                    <b-button @click="close">Отмена</b-button>
                    <b-button type="is-danger" native-type="submit" :loading="isLoading">
                        Удалить комнату
                    </b-button>
                </footer>
            </div>
        </form>
    </b-modal>
</template>

<script>
    export default {
        name: "DeleteRoom",
        data() {
            return {
                isLoading: false
            };
        },
        computed: {
            isOpen() {
                return this.$route.hash === '#delete';
            },
        },
        methods: {
            close() {
                this.$router.back();
            },
            deleteRoom() {
                this.isLoading = true;
                axios.delete('/room').then((r) => {
                    this.$store.commit('deletedOwnRoom');
                    this.$buefy.toast.open({message: r.data.message, queue: false});
                    this.isLoading = false;
                    this.close();
                }).catch((e) => {
                    this.isLoading = false;
                    this.$buefy.toast.open({
                        message: e.response.data.message,
                        type: 'is-danger',
                        queue: false
                    })
                });
            }
        }
    }
</script>

<style scoped>

</style>
