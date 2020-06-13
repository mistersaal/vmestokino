<template>
    <div>
        <section class="section chat-body"
                 :style="{height: chatHeight + 'px'}"
                 ref="chatBody"
        >
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
        <section class="section message-input gray-in-dark-mode" :style="{'padding-bottom': iphonePaddingBottom + 'px'}">
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
            <b-button size="is-large" rounded icon-left="chevron-down" @click="scrollDown"/>
        </div>
    </div>
</template>

<script>
    import ChatMessage from "./ChatMessage";
    export default {
        name: "Chat",
        components: {ChatMessage},
        props: ['id', 'password', 'windowWidth', 'windowHeight'],
        data() {
            return {
                messages: [],
                message: '',
                sending: false,
                chatPosition: 0,
                needScrollDown: false,
            };
        },
        computed: {
            chatHeight() {
                let playerHeight = 0.56 * this.windowWidth > 320 ? 320 : 0.56 * this.windowWidth;
                let iphonePaddingTop = +getComputedStyle(document.documentElement)
                    .getPropertyValue("--sat").slice(0, -2);
                return this.windowHeight - 52 * 3 - playerHeight - iphonePaddingTop - this.iphonePaddingBottom;
            },
            iphonePaddingBottom()
            {
                if (this.windowHeight < 600) {
                    return 0;
                } else {
                    return +getComputedStyle(document.documentElement)
                        .getPropertyValue("--sab").slice(0, -2);
                }
            },
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
            this.chatBody.addEventListener('scroll', this.onChatScroll);
        },
        beforeDestroy() {
            this.chatBody.removeEventListener('scroll', this.onChatScroll);
        },
        methods: {
            positionAtBottom() {
                return (this.chatBody.scrollHeight - this.chatHeight - this.chatPosition) < 10;
            },
            onChatScroll() {
                this.chatPosition = this.chatBody.scrollTop;
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
    .message-input {
        height: 52px; padding: 0.5rem 0.75rem;
        box-shadow: 0 -2px 10px rgba(10, 10, 10, 0.05);
    }
    .scrolldown-button {
        position: absolute;
        bottom: calc(70px + var(--sab));
        right: 20px;
    }
    .scrolldown-button .button {
        padding: 10px 18px 6px 18px;
        border-width: 0;
        box-shadow: 0 2px 10px rgba(10, 10, 10, 0.07);
    }
    .chat-body {
        display: flex;
        flex-direction: column-reverse;
        overflow-y: scroll;
        scroll-behavior: smooth;
    }
</style>
