<template>
    <div class="level is-mobile">
        <div class="level-left" v-if="own"></div>
        <div :class="{'level-left': !own, 'level-right': own}">
            <div class="level-item" v-if="!own">
                <figure class="image is-24x24">
                    <img class="is-rounded" :src="img" alt="">
                </figure>
            </div>
            <div class="level-item">
                <b-notification :type="own ? 'is-light' : 'is-primary'" :closable="false">{{ text }}</b-notification>
            </div>
        </div>
        <div class="level-right" v-if="!own"></div>
    </div>
</template>

<script>
    export default {
        name: "ChatMessage",
        props: ['img', 'text', 'own'],
    }
</script>

<style scoped>
    .notification {
        max-width: 70vw;
        word-break: break-word;
        line-height: 1.25rem;
        border-radius: 1.0rem;
        padding: 0.6rem;
    }
    .level-left, .level-right {
        align-items: flex-start;
    }
</style>
