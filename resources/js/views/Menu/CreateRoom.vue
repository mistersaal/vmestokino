<template>
    <b-modal :active="isCreating"
             has-modal-card
             trap-focus
             :destroy-on-hide="false"
             :can-cancel="['escape', 'outside']"
             @close="close"
    >
        <form @submit.prevent="create">
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title has-text-weight-bold has-text-primary">Создать комнату</p>
                </header>
                <section class="modal-card-body">
                    <b-field label="Ссылка на видео/фильм">
                        <b-input
                            placeholder="Ссылка"
                            :pattern="regexpUrl"
                            validation-message="Неверная ссылка"
                            v-model="url"
                            maxlength="1000"
                            required>
                        </b-input>
                    </b-field>
                    <b-checkbox v-model="only_admin_control">
                        Видео управляет только создатель комнаты
                    </b-checkbox>
                </section>
                <footer class="modal-card-foot">
                    <button class="button" type="button" @click="close">Отмена</button>
                    <button class="button is-primary">Создать</button>
                </footer>
            </div>
        </form>
    </b-modal>
</template>

<script>
    export default {
        name: "CreateRoom",
        props: ['isCreating', 'typeForCreating', 'regexpUrl'],
        data() {
            return {
                url: '',
                only_admin_control: true,
            };
        },
        methods: {
            close() {
                this.$emit('close');
            },
            create() {
                let room = {
                    url: this.url,
                    everyone_control: !this.only_admin_control,
                    type: this.typeForCreating
                };
                axios.post('/room', room).then(response => {
                    this.$store.commit('createdOwnRoom', room);
                    this.$router.push('/room');
                }).catch(error => {
                    this.$buefy.snackbar.open({
                        message: error.response.data.message,
                        type: 'is-danger',
                        actionText: null,
                        position: 'is-top',
                        queue: false
                    })
                });
            }
        }
    }
</script>

<style scoped>

</style>
