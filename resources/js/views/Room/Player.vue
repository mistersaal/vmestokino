<template>
    <div>
        <youtube-player v-if="type === 'youtube'" :url="url"></youtube-player>
    </div>
</template>

<script>
    import YoutubePlayer from "./YoutubePlayer";
    export default {
        name: "Player",
        components: {YoutubePlayer},
        props: ['type', 'url', 'everyone_control']
    }
</script>

<style scoped>

</style>
