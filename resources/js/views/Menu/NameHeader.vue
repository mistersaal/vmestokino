<template>
    <b-navbar :mobile-burger="false">
        <template slot="brand">
            <b-navbar-item
                tag="h1"
                class="title is-4 has-text-primary has-text-weight-bold"
                style="cursor: default"
            >
                Vmestokino.ml
            </b-navbar-item>
        </template>
    </b-navbar>
</template>

<script>
    export default {
        name: "NameHeader"
    }
</script>

<style scoped>

</style>
