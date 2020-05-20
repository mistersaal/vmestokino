<template>
    <section class="section">
        <div class="container is-fluid">
            <room-data-control
                :init-room="room"
                :types="$store.state.types"
                v-if="isAdmin"
            ></room-data-control>
            <invite-friends
                :id="room.id"
                :password="room.password"
                :link="link"
            ></invite-friends>
            <div class="buttons has-addons is-right">
                <b-button
                    @click="invite"
                    icon-left="user-plus"
                    v-if="isAdmin"
                >Пригласить</b-button>
                <b-button
                    @click="update"
                    icon-left="edit"
                    v-if="isAdmin"
                >Редактировать</b-button>
            </div>
        </div>
    </section>
</template>

<script>
    import RoomDataControl from "../../components/RoomDataControl";
    import InviteFriends from "./InviteFriends";
    export default {
        name: "ControlButtons",
        components: {InviteFriends, RoomDataControl},
        props: ['room', 'isAdmin'],
        computed: {
            link() {
                return this.$store.state.appLink + '#' + this.room.id + '_' + this.room.password;
            }
        },
        methods: {
            update() {
                this.$router.push(this.$route.fullPath + '#update');
            },
            invite() {
                this.$router.push(this.$route.fullPath + '#invite');
            },
        },
    }
</script>

<style scoped>
    .section {
        padding: 0.75rem;
    }
</style>
