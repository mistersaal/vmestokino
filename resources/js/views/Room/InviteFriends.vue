<template>
    <b-modal :active="isOpen"
             has-modal-card
             trap-focus
             :can-cancel="['escape', 'outside']"
             @close="close"
             destroy-on-hide
    >
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title has-text-weight-bold has-text-primary">
                    Пригласить друзей
                </p>
            </header>
            <section class="modal-card-body">
                <label class="label">Пригласить по ссылке</label>
                <b-field>
                    <b-input :value="link" readonly expanded></b-input>
                    <p class="control">
                        <b-button icon-left="copy" @click="copy(link)"></b-button>
                    </p>
                </b-field>
                <label class="label">По номеру и паролю</label>
                <b-field>
                    <b-input :value="id" readonly expanded></b-input>
                    <b-input :value="password" readonly expanded></b-input>
                    <p class="control">
                        <b-button icon-left="copy"
                                  @click="copy('Номер: ' + id + ' Пароль: ' + password)"
                        ></b-button>
                    </p>
                </b-field>
            </section>
            <footer class="modal-card-foot">
                <b-button @click="close">Закрыть</b-button>
                <b-button type="is-primary" @click="share">Отправить приглашение</b-button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
    export default {
        name: "InviteFriends",
        props: ['id', 'password', 'link'],
        computed: {
            isOpen() {
                return this.$route.hash === '#invite';
            },
        },
        methods: {
            close() {
                this.$router.back();
            },
            copy(value) {
                const el = document.createElement('textarea');
                el.value = value;
                el.setAttribute('readonly', '');
                el.style.position = 'absolute';
                el.style.left = '-9999px';
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);

                this.$buefy.toast.open({message: 'Скопировано в буфер обмена', queue: false});
            },
            share() {
                bridge.send("VKWebAppShare", {"link": this.link})
                    .then(() => {
                        this.$buefy.toast.open({message: 'Приглашение отправлено', queue: false});
                    }).catch((e) => {});
            },
        },
    }
</script>

<style scoped>

</style>
