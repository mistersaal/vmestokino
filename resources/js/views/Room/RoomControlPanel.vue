<template>
    <div class="level is-mobile gray-in-dark-mode">
        <div class="level-left">
            <div class="level-item">
                <room-users :users="users"></room-users>
            </div>
        </div>
        <div class="level-right">
            <div class="level-item">
                <control-buttons
                    :room="room"
                    :is-admin="isAdmin"
                    :synced="synced"
                    :syncing="syncing"
                    @sync="$emit('sync')"
                ></control-buttons>
            </div>
        </div>
    </div>
</template>

<script>
    import ControlButtons from "./ControlButtons";
    import RoomUsers from "./RoomUsers";
    export default {
        name: "RoomControlPanel",
        components: {RoomUsers, ControlButtons},
        props: ['room', 'isAdmin', 'synced', 'syncing', 'users'],
    }
</script>

<style scoped>
    .level {
        box-shadow: 0 2px 10px rgba(10, 10, 10, 0.05);
    }
</style>
