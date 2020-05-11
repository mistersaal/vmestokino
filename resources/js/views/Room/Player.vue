<template>
    <div>
        <youtube-player
            v-if="type === 'youtube'"
            :url="url"
            ref="youtube"
            @start="onStart"
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
                .listen('PlayerStart', (e) => {this.start()});
        },
        computed: {
            player() {
                return this.$refs[this.type];
            },
        },
        methods: {
            start() {
                this.player.play()
            },
            onStart() {
                if (this.canControl) {
                    axios.post('/room/' + this.id + '/start', {password: this.password});
                }
            }
        },
    }
</script>

<style scoped>

</style>
