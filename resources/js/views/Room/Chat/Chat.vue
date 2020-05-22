<template>
    <div>
        <section class="section" :style="{height: chatHeight + 'px', 'overflow-y': 'scroll'}">
            <div class="container is-fluid">
                <chat-message
                    v-for="(message, key) in messages"
                    :key="key"
                    :img="users[message.user_id].img"
                    :text="message.text"
                    :own="message.own"
                />
            </div>
        </section>
        <section class="section message-input">
            <b-field>
                <b-input expanded></b-input>
                <p class="control">
                    <b-button icon-left="paper-plane"></b-button>
                </p>
            </b-field>
        </section>
    </div>
</template>

<script>
    import ChatMessage from "./ChatMessage";
    export default {
        name: "Chat",
        components: {ChatMessage},
        props: ['users'],
        data() {
            return {
                messages: [{"user_id":5,"text":"Сообщениеееееееееееееееееееееее просто огромноееееееееееееееееееееееее","own":false},{"user_id":5,"text":"Сообщение","own":false},{"user_id":5,"text":"Сообщениеееееееееееееееееееееее просто огромноееееееееееееееееееееееее","own":true},{"user_id":5,"text":"Сообщение","own":false},{"user_id":5,"text":"Сообщение","own":false},{"user_id":5,"text":"Сообщение","own":true}],
            };
        },
        computed: {
            chatHeight() {
                let playerHeight = 0.56 * window.innerWidth > 320 ? 320 : 0.56 * window.innerWidth;
                return window.innerHeight - 52 * 3 - playerHeight;
            }
        },
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
