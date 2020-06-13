<template>
    <div class="box">
        <h2 class="title is-5">Присоединиться</h2>
        <connect-modal></connect-modal>
        <div class="buttons">
            <b-button type="is-primary" size="is-medium" expanded icon-left="list-ol" @click="open">
                По номеру комнаты
            </b-button>
        </div>
    </div>
</template>

<script>
    import ConnectModal from "./ConnectModal";
    export default {
        name: "ConnectButtons",
        components: {ConnectModal},
        methods: {
            open() {
                this.$router.push(this.$route.fullPath + '#connect');
            }
        },
    }
</script>

<style scoped>

</style>
