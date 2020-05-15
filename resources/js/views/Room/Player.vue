<template>
    <div>
        <youtube-player
            v-if="type === 'youtube'"
            :url="url"
            ref="youtube"
            @start="onStart"
            @buffering="onBuffering"
            @stop="onStop"
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
                .listen('PlayerBuffering', (e) => {this.start(e.currentTime)})
                .listen('PlayerStop', (e) => {this.stop()});
        },
        computed: {
            player() {
                return this.$refs[this.type];
            }
        },
        data() {
            return {
                anotherControlStart: false,
                anotherControlStop: false,
            };
        },
        methods: {
            start(currentTime) {
                this.anotherControlStart = true;
                this.player.seekTo(currentTime);
                this.player.play();
            },
            onStart() {
                if (this.canControl && !this.anotherControlStart) {
                    axios.post('/room/' + this.id + '/start', {
                        password: this.password,
                        currentTime: this.player.getCurrentTime()
                    });
                }
                this.anotherControlStart = false;
            },
            onBuffering() {
                if (this.canControl && !this.anotherControlStart) {
                    axios.post('/room/' + this.id + '/buffering', {
                        password: this.password,
                        currentTime: this.player.getCurrentTime()
                    });
                }
            },
            stop() {
                this.anotherControlStop = true;
                this.player.stop();
            },
            onStop() {
                if (this.canControl && !this.anotherControlStop) {
                    axios.post('/room/' + this.id + '/stop', {
                        password: this.password
                    });
                }
                this.anotherControlStop = false;
            }
        },
    }
</script>

<style scoped>

</style>
