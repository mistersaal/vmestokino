<template>
    <b-modal :active="isOpen"
             has-modal-card
             trap-focus
             :can-cancel="['escape', 'outside']"
             @close="close"
             destroy-on-hide
    >
        <form @submit.prevent="testConnection">
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title has-text-weight-bold">
                        Присоединиться
                    </p>
                </header>
                <section class="modal-card-body">
                    <b-field label="Номер комнаты">
                        <b-input
                            placeholder="Номер комнаты"
                            type="number"
                            validation-message="Обязательное поле"
                            v-model.number="number"
                            @input="numInput($event)"
                            @keypress.native="onlyInt($event)"
                            :has-counter="false"
                            required>
                        </b-input>
                    </b-field>
                    <b-field label="Пароль">
                        <b-input
                            placeholder="Пароль"
                            type="text"
                            validation-message="Обязательное поле"
                            v-model="password"
                            maxlength="10"
                            :has-counter="false"
                            required>
                        </b-input>
                    </b-field>
                </section>
                <footer class="modal-card-foot">
                    <b-button @click="close">Отмена</b-button>
                    <b-button type="is-primary" native-type="submit" :disabled="disabled" :loading="isLoading">
                        Присоединиться
                    </b-button>
                </footer>
            </div>
        </form>
    </b-modal>
</template>

<script>
    export default {
        name: "ConnectModal",
        data() {
            return {
                isLoading: false,
                number: '',
                password: ''
            };
        },
        computed: {
            disabled() {
                return this.number === '' || this.password === '';
            },
            isOpen() {
                return this.$route.hash === '#connect';
            },
        },
        methods: {
            close() {
                this.$router.back();
            },
            testConnection() {
                this.isLoading = true;
                axios.get('/room/' + this.number + '/check?password=' + this.password)
                    .then(this.connect)
                    .catch(() => {
                        this.$buefy.toast.open({
                            message: 'Номер или пароль неверный!',
                            type: 'is-danger',
                            queue: false
                        });
                        this.isLoading = false;
                    });
            },
            connect() {
                this.$router.push('/room/' + this.number + '?password=' + this.password);
            },
            numInput(value) {
                if (value > 999999999) {
                    this.$nextTick(() => {
                        this.number = 999999999;
                    })
                } else if (value < 0) {
                    this.$nextTick(() => {
                        this.number = 0;
                    })
                }
            },
            onlyInt($event) {
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                console.log(keyCode);
                if (keyCode < 48 || keyCode > 57) {
                    $event.preventDefault();
                }
            }
        }
    }
</script>

<style scoped>

</style>
