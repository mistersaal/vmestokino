<template>
    <div>
        <name-header></name-header>
        <div class="section">
            <div class="container">
                <create-buttons></create-buttons>
                <connect-buttons style="margin-top: 30px;"></connect-buttons>
                <info-buttons style="margin-top: 30px;"></info-buttons>
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
