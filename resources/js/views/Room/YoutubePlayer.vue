<template>
    <div>
        <youtube
            :video-id="videoId"
            ref="player"
            @playing="$emit('start')"
            @buffering="$emit('buffering')"
            @paused="$emit('stop')"
            @ready="$emit('ready')"
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
            stop() {
                this.player.pauseVideo();
            },
            mute() {
                this.player.mute();
            },
            seekTo(currentTime) {
                this.player.seekTo(currentTime);
            },
            getCurrentTime() {
                return this.player.getCurrentTime();
            },
            isPlaying() {
                return this.player.getPlayerState() === 1;
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
