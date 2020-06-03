<template>
    <div>
        <div class="player-div">
            <youtube-player
                v-if="room.type === 'youtube'"
                :url="room.url"
                ref="youtube"
                @start="onStart"
                @buffering="onBuffering"
                @stop="onStop"
                @ready="ready"
            ></youtube-player>
        </div>

        <room-control-panel :room="room"
                            :is-admin="isAdmin"
                            :synced="synced"
                            :syncing="syncing"
                            :users="users"
                            @sync="sync"
        ></room-control-panel>
    </div>

</template>

<script>
    import YoutubePlayer from "./YoutubePlayer";
    import RoomControlPanel from "./RoomControlPanel";
    export default {
        name: "Player",
        components: {RoomControlPanel, YoutubePlayer},
        props: ['room', 'id', 'password', 'canControl', 'isAdmin', 'users'],
        created() {
            Echo.join('room.player.' + this.id + '.' + this.password)
                .listen('PlayerStart', (e) => {this.start(e.currentTime)})
                .listen('PlayerBuffering', (e) => {this.start(e.currentTime)})
                .listen('PlayerStop', (e) => {this.stop()})
                .listenForWhisper('RoomSync', () => {this.onSync()})
                .listen('PlayerState', (e) => {this.setState(e.state)});
        },
        computed: {
            player() {
                return this.$refs[this.room.type];
            }
        },
        data() {
            return {
                anotherControlStart: false,
                anotherControlStop: false,
                synced: false,
                syncing: false,
                stopAfterPlay: false,
            };
        },
        methods: {
            ready() {
                if (!this.isAdmin) {
                    this.player.mute();
                    this.sync();
                }
            },
            sync() {
                this.syncing = true;
                let timer = setInterval(() => {
                    if (this.syncing === false) {
                        clearInterval(timer);
                        return;
                    }
                    Echo.join('room.player.' + this.id + '.' + this.password)
                        .whisper('RoomSync');
                }, 3000);
            },
            onSync() {
                if (this.isAdmin) {
                    axios.post('/room/' + this.id + '/sync', {
                        password: this.password,
                        currentTime: this.player.getCurrentTime(),
                        isPlaying: this.player.isPlaying(),
                    });
                }
            },
            setSynced() {
                this.syncing = false;
                this.synced = true;
            },
            checkSync() {
                if (!this.canControl && !(this.anotherControlStart || this.anotherControlStop)) {
                    this.synced = false;
                }
            },
            setState(state) {
                if (this.syncing) {
                    if (!state.isPlaying) {
                        this.stopAfterPlay = true;
                    }
                    this.start(state.currentTime);
                }
            },
            start(currentTime) {
                this.anotherControlStart = true;
                this.player.seekTo(currentTime);
                this.player.play();
                this.setSynced();
            },
            onStart() {
                if (this.canControl && !this.anotherControlStart && !this.syncing) {
                    axios.post('/room/' + this.id + '/start', {
                        password: this.password,
                        currentTime: this.player.getCurrentTime()
                    });
                }
                if (this.stopAfterPlay) {
                    this.stop();
                    this.stopAfterPlay = false;
                }
                this.checkSync();
                this.anotherControlStart = false;
            },
            onBuffering() {
                if (this.canControl && !this.anotherControlStart && !this.syncing) {
                    axios.post('/room/' + this.id + '/buffering', {
                        password: this.password,
                        currentTime: this.player.getCurrentTime()
                    });
                }
            },
            stop() {
                this.anotherControlStop = true;
                this.player.stop();
                this.setSynced();
            },
            onStop() {
                if (this.canControl && !this.anotherControlStop && !this.syncing) {
                    axios.post('/room/' + this.id + '/stop', {
                        password: this.password
                    });
                }
                this.checkSync();
                this.anotherControlStop = false;
            }
        },
    }
</script>

<style scoped>
    .player-div {
        line-height: 0;
        height: 56vw;
        max-height: 320px;
        width: 100%;
        background-color: #000000;
    }
</style>
