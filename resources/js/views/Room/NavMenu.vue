<template>
    <b-navbar :mobile-burger="false">
        <template slot="brand">
            <b-navbar-item @click="back" class="hoverable">
                <b-icon icon="arrow-left"></b-icon>
            </b-navbar-item>
            <b-navbar-item style="cursor: default">
                <h1 class="title is-4 has-text-weight-bold">Комната</h1>
            </b-navbar-item>
        </template>
    </b-navbar>
</template>

<script>
    export default {
        name: "NavMenu",
        methods: {
            back() {
                if (this.$store.state.historyIsEmpty) {
                    this.$router.replace('/');
                } else {
                    this.$router.back();
                }
            }
        }
    }
</script>

<style scoped>
    .hoverable:hover {
        color: inherit !important;
        background-color: inherit !important;
    }
</style>
