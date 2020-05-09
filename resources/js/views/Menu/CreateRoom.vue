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
                    <b-field label="Название">
                        <b-input
                            placeholder="Название комнаты"
                            v-model="title"
                            required>
                        </b-input>
                    </b-field>
                    <b-field label="Ссылка на видео/фильм">
                        <b-input
                            placeholder="Ссылка"
                            :pattern="regexpUrl"
                            validation-message="Неверная ссылка"
                            v-model="url"
                            required>
                        </b-input>
                    </b-field>
                    <b-checkbox v-model="everyone_control">
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
                title: '',
                url: '',
                everyone_control: false,
            };
        },
        methods: {
            close() {
                this.$emit('close');
            },
            create() {
                axios.post('/room', {
                    title: this.title,
                    url: this.url,
                    everyone_control: this.everyone_control,
                    type: this.typeForCreating
                }).then(response => {
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
