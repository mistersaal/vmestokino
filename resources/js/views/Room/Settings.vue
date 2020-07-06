<template>
    <b-modal :active="isOpen"
             has-modal-card
             trap-focus
             :can-cancel="['escape', 'outside']"
             @close="close"
             destroy-on-hide
    >
        <form @submit.prevent="set">
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title has-text-weight-bold">
                        Настройки
                    </p>
                </header>
                <section class="modal-card-body">
                    <b-switch v-model="audioOn">
                        Звук сообщений
                    </b-switch>
                </section>
                <footer class="modal-card-foot">
                    <b-button @click="close">Отмена</b-button>
                    <b-button type="is-primary" native-type="submit">
                        Сохранить
                    </b-button>
                </footer>
            </div>
        </form>
    </b-modal>
</template>

<script>
    export default {
        name: "Settings",
        data() {
            return {
                audioOn: true,
            };
        },
        computed: {
            isOpen() {
                return this.$route.hash === '#settings';
            },
        },
        watch: {
            isOpen() {
                this.audioOn = this.$store.state.audioOn;
            },
        },
        methods: {
            close() {
                this.$router.back();
            },
            set() {
                bridge.send('VKWebAppStorageSet', {key: 'messageAudio', value: this.audioOn.toString()});
                this.$store.commit('setAudio', this.audioOn);
                this.close();
            }
        }
    }
</script>

<style scoped>

</style>
