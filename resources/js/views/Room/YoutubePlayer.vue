<template>
    <div>
        <youtube
            :video-id="videoId"
            ref="player"
            @playing="$emit('start')"
        ></youtube>
    </div>
</template>

<script>
    export default {
        name: "YoutubePlayer",
        props: ['url'],
        computed: {
            videoId() {
                return this.$youtube.getIdFromURL(this.url);
            },
            player() {
                return this.$refs.player.player;
            }
        },
        methods: {
            play() {
                this.player.playVideo();
            },
        },
    }
</script>

<style>
    iframe {
        width: 100% !important;
        height: 360px !important;
        box-shadow: 0 7px 15px rgba(10, 10, 10, 0.15);
    }
</style>
