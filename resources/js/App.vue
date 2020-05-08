<template>
    <div>
        <router-view v-if="!isLoading"></router-view>
        <b-loading :is-full-page="true" :active.sync="isLoading"></b-loading>
    </div>
</template>

<script>
    export default {
        name: "App",
        data() {
            return {
                isLoading: true
            };
        },
        created() {
            axios.post('/login').then(response => {
                if (response.data.newUser) {
                    this.$router.replace('/welcome');
                }
                this.isLoading = false;
            });
        }
    }
</script>

<style scoped>

</style>
