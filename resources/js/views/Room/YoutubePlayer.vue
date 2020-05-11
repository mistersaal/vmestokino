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
        box-shadow: 0 7px 15px rgba(10, 10, 10, 0.15);
    }
</style>
