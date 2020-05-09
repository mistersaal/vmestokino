<template>
    <div style="height: 100vh">
        <youtube :video-id="'dQw4w9WgXcQ'"></youtube>
    </div>
</template>

<script>
    export default {
        name: "YoutubePlayer",
        mounted() {

        }
    }
</script>

<style>
    iframe {
        width: 100% !important;
        height: 360px !important;
    }
</style>
