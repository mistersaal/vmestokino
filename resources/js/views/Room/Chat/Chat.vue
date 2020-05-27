<template>
    <div>
        <section class="section chat-body" ref="chatBody">
            <div style="padding-top: 0.75rem;">
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
                                  @focus.native=""
                                  :loading="sending"
                                  :disabled="!message"
                        ></b-button>
                    </p>
                </b-field>
            </form>
        </section>
        <div class="scrolldown-button" v-show="needScrollDown">
            <b-button size="is-large" class="has-text-primary" rounded icon-left="chevron-down" @click="scrollDown"/>
        </div>
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
                chatPosition: 0,
                needScrollDown: false,
            };
        },
        computed: {
            chatBody() {
                return this.$refs['chatBody'];
            },
        },
        watch: {
            chatPosition(to, from) {
                if (this.positionAtBottom()) {
                    this.needScrollDown = false;
                }
            },
        },
        created() {
            Echo.join('room.player.' + this.id + '.' + this.password)
                .listen('MessageSent', (e) => {
                    e.message.own = this.$store.state.user.id === e.message.user.id;
                    this.messages.push(e.message);
                    if (this.positionAtBottom()) {
                        this.$nextTick(this.scrollDown);
                    } else {
                        this.needScrollDown = true;
                    }
                })
        },
        mounted() {
            this.onResize();
            window.addEventListener('resize', this.onResize);
            this.chatBody.addEventListener('scroll', this.onChatScroll);
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.onResize);
            this.chatBody.removeEventListener('scroll', this.onChatScroll);
        },
        methods: {
            positionAtBottom() {
                return (this.chatBody.scrollHeight - this.chatBody.clientHeight - this.chatPosition) < 10;
            },
            onChatScroll() {
                this.chatPosition = this.chatBody.scrollTop;
            },
            onResize() {
                this.windowHeight = window.innerHeight;
                this.windowWidth = window.innerWidth;
            },
            scrollDown() {
                this.chatBody.scrollTop = this.chatBody.scrollHeight;
            },
            send() {
                if (!this.message || this.sending) {
                    return;
                }
                const message = this.message;
                this.sending = true;
                this.message = '';
                axios.post('/room/' + this.id + '/message', {
                    password: this.password,
                    text: message
                }).then(() => {
                    this.sending = false;
                    this.messages.push({
                        text: message,
                        own: true,
                        user: {img: ''},
                    });
                    this.$nextTick(this.scrollDown);
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
    .chat-body {
        display: flex;
        flex-direction: column-reverse;
        position: fixed;
        width: 100%;
        top: calc(104px + min(56vw, 320px) + var(--sat));
        bottom: calc(52px + var(--sab));
        overflow-y: scroll;
        scroll-behavior: smooth;
    }
    .message-input {
        position: fixed;
        bottom: var(--sab);
        width: 100%;
        height: 52px; padding: 0.5rem 0.75rem;
        box-shadow: 0 -2px 10px rgba(10, 10, 10, 0.05);
    }
    .scrolldown-button {
        position: absolute;
        bottom: 70px;
        right: 20px;
    }
    .scrolldown-button .button {
        padding: 10px 18px 6px 18px;
        border-width: 0;
        box-shadow: 0 2px 10px rgba(10, 10, 10, 0.07);
    }
</style>