<template>
    <div>
        <youtube :video-id="videoId"></youtube>
    </div>
</template>

<script>
    export default {
        name: "YoutubePlayer",
        props: ['url'],
        computed: {
            videoId() {
                return this.$youtube.getIdFromURL(this.url);
            }
        }
    }
</script>

<style>
    iframe {
        width: 100% !important;
        height: 360px !important;
    }
</style>
