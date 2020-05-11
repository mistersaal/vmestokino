<template>
    <div>
        <name-header></name-header>
        <div class="section" style="padding: 1.25rem">
            <div class="container">
                <create-buttons></create-buttons>
                <connect-buttons></connect-buttons>
                <info-buttons></info-buttons>
            </div>
        </div>
    </div>
</template>

<script>
    import NameHeader from "./NameHeader";
    import CreateButtons from "./CreateButtons";
    import ConnectButtons from "./ConnectButtons";
    import InfoButtons from "./InfoButtons";
    export default {
        name: "Menu",
        components: {
            NameHeader,
            CreateButtons,
            ConnectButtons,
            InfoButtons
        }
    }
</script>

<style scoped>

</style>
