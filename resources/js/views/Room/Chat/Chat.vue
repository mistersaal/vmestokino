<template>
    <div>
        <section class="section" :style="{height: chatHeight + 'px', 'overflow-y': 'scroll'}">
            <div class="container is-fluid">
                <chat-message
                    v-for="(message, key) in messages"
                    :key="key"
                    :img="message.user.img"
                    :text="message.text"
                    :own="message.own"
                />
            </div>
        </section>
        <section class="section message-input">
            <form @submit.prevent="send">
                <b-field>
                    <b-input expanded
                             v-model="message"
                             maxlength="1500"
                             :has-counter="false"
                             placeholder="Сообщение"
                    ></b-input>
                    <p class="control">
                        <b-button native-type="submit"
                                  icon-left="paper-plane"
                                  :loading="sending"
                                  :disabled="!message"
                        ></b-button>
                    </p>
                </b-field>
            </form>
        </section>
    </div>
</template>

<script>
    import ChatMessage from "./ChatMessage";
    export default {
        name: "Chat",
        components: {ChatMessage},
        props: ['id', 'password'],
        data() {
            return {
                messages: [],
                message: '',
                sending: false,
                windowHeight: 0,
                windowWidth: 0,
            };
        },
        computed: {
            chatHeight() {
                let playerHeight = 0.56 * this.windowWidth > 320 ? 320 : 0.56 * this.windowWidth;
                return this.windowHeight - 52 * 3 - playerHeight;
            }
        },
        watch: {

        },
        created() {
            Echo.join('room.player.' + this.id + '.' + this.password)
                .listen('MessageSent', (e) => {
                    e.message.own = false;
                    this.messages.push(e.message);
                })
        },
        mounted() {
            this.onResize();
            window.addEventListener('resize', this.onResize);
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.onResize);
        },
        methods: {
            onResize() {
                this.windowHeight = window.innerHeight;
                this.windowWidth = window.innerWidth;
            },
            send() {
                if (!this.message) {
                    return;
                }
                this.sending = true;
                axios.post('/room/' + this.id + '/message', {
                    password: this.password,
                    text: this.message
                }).then(() => {
                    this.sending = false;
                    this.messages.push({
                        text: this.message,
                        own: true,
                        user: {img: ''},
                    });
                    this.message = '';
                });
            },
        }
    }
</script>

<style scoped>
    .section {
        padding: 0.75rem;
    }
    .level {
        margin-bottom: 0.5rem !important;
    }
    .message-input {
        height: 52px; padding: 0.5rem 0.75rem;
        box-shadow: 0 -2px 10px rgba(10, 10, 10, 0.05);
    }
</style>
