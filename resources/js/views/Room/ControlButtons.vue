<template>
    <section class="section">
        <div class="container is-fluid">
            <room-data-control
                :init-room="room"
                :types="$store.state.types"
            ></room-data-control>
            <div class="buttons is-right">
                <b-button
                    @click="update"
                    icon-left="edit"
                >Редактировать</b-button>
            </div>
        </div>
    </section>
</template>

<script>
    import RoomDataControl from "../../components/RoomDataControl";
    export default {
        name: "ControlButtons",
        components: {RoomDataControl},
        props: ['room'],
        methods: {
            update() {
                this.$router.push(this.$route.fullPath + '#update');
            },
        },
    }
</script>

<style scoped>
    .section {
        padding: 0.75rem;
    }
</style>
