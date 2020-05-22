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
            <div class="buttons has-addons is-right" v-if="!isMobile">
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
                <b-button
                    @click="sync"
                    icon-left="bolt"
                    :type="synced ? 'is-success' : 'is-danger'"
                    :loading="syncing"
                    v-else
                >{{synced ? 'Синхронизировано' : 'Синхронизировать'}}</b-button>
            </div>
            <div class="buttons has-addons is-right" v-else>
                <b-button
                    @click="invite"
                    icon-left="user-plus"
                    v-if="isAdmin"
                ></b-button>
                <b-button
                    @click="update"
                    icon-left="edit"
                    v-if="isAdmin"
                ></b-button>
                <b-button
                    @click="sync"
                    icon-left="bolt"
                    :type="synced ? 'is-success' : 'is-danger'"
                    :loading="syncing"
                    v-else
                ></b-button>
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
        props: ['room', 'isAdmin', 'synced', 'syncing'],
        computed: {
            link() {
                return this.$store.state.appLink + '#' + this.room.id + '_' + this.room.password;
            },
            isMobile() {
                return window.innerWidth < 1024;
            }
        },
        methods: {
            update() {
                this.$router.push(this.$route.fullPath + '#update');
            },
            invite() {
                this.$router.push(this.$route.fullPath + '#invite');
            },
            sync() {
                this.$emit('sync');
            }
        },
    }
</script>

<style scoped>
    .section {
        padding: 0.5rem 0.75rem;
    }
</style>
