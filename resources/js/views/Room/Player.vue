<template>
    <div>
        <youtube-player
            v-if="type === 'youtube'"
            :url="url"
            ref="youtube"
            @start="onStart"
            @buffering="onBuffering"
        ></youtube-player>
    </div>
</template>

<script>
    import YoutubePlayer from "./YoutubePlayer";
    export default {
        name: "Player",
        components: {YoutubePlayer},
        props: ['type', 'url', 'everyone_control', 'id', 'password', 'canControl'],
        created() {
            Echo.join('room.player.' + this.id + '.' + this.password)
                .listen('PlayerStart', (e) => {this.start(e.currentTime)})
                .listen('PlayerBuffering', (e) => {this.start(e.currentTime)});
        },
        computed: {
            player() {
                return this.$refs[this.type];
            }
        },
        methods: {
            start(currentTime) {
                this.player.seekTo(currentTime + 1);
                this.player.play();
            },
            onStart() {
                if (this.canControl) {
                    axios.post('/room/' + this.id + '/start', {
                        password: this.password,
                        currentTime: this.player.getCurrentTime()
                    });
                }
            },
            onBuffering() {
                if (this.canControl) {
                    axios.post('/room/' + this.id + '/buffering', {
                        password: this.password,
                        currentTime: this.player.getCurrentTime()
                    });
                }
            }
        },
    }
</script>

<style scoped>

</style>
