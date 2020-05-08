<template>
    <div>
        <name-header></name-header>
        <div class="section">
            <div class="container">
                <create-buttons></create-buttons>
                <connect-buttons style="margin-top: 30px;"></connect-buttons>
            </div>
        </div>
    </div>
</template>

<script>
    import NameHeader from "./NameHeader";
    import CreateButtons from "./CreateButtons";
    import ConnectButtons from "./ConnectButtons";
    export default {
        name: "Menu",
        components: {
            NameHeader,
            CreateButtons,
            ConnectButtons
        }
    }
</script>

<style scoped>

</style>
