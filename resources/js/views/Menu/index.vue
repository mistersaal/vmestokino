<template>
    <div>
        <name-header></name-header>
        <div class="section" style="padding: 1.25rem">
            <div class="container">
                <room-buttons></room-buttons>
                <connect-buttons></connect-buttons>
                <info-buttons></info-buttons>
            </div>
        </div>
    </div>
</template>

<script>
    import NameHeader from "./NameHeader";
    import RoomButtons from "./RoomButtons";
    import ConnectButtons from "./ConnectButtons";
    import InfoButtons from "./InfoButtons";
    export default {
        name: "Menu",
        components: {
            NameHeader,
            RoomButtons,
            ConnectButtons,
            InfoButtons
        }
    }
</script>

<style scoped>

</style>
