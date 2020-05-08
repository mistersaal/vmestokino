<template>
    <b-modal :active="isCreating"
             has-modal-card
             trap-focus
             :destroy-on-hide="false"
             :can-cancel="['escape', 'outside']"
             @close="close"
    >
        <form @submit.prevent>
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">Создать комнату</p>
                </header>
                <section class="modal-card-body">
                    <b-field label="Название">
                        <b-input
                            placeholder="Название комнаты"
                            required>
                        </b-input>
                    </b-field>
                    <b-field label="Ссылка на видео/фильм">
                        <b-input
                            placeholder="Ссылка"
                            required>
                        </b-input>
                    </b-field>
                    <b-checkbox>Видео управляет только создатель комнаты</b-checkbox>
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
        name: "CreateModal",
        props: ['isCreating', 'typeForCreating'],
        methods: {
            close() {
                this.$emit('close');
            }
        }
    }
</script>

<style scoped>

</style>
