<template>
    <section class="section">
        <div class="container is-fluid">
            <div class="level is-mobile">
                <figure class="image is-24x24 has-tooltip-right" v-for="user in users" :data-tooltip="user.name">
                    <img class="is-rounded" :src="user.img" :alt="user.name">
                </figure>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "RoomUsers",
        props: ['users'],
    }
</script>

<style scoped>
    .section {
        padding: 0.75rem;
    }
    .image:not(:last-child) {
        margin-right: -3px;
    }
</style>
