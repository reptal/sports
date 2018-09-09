<template>

</template>

<script>
    import store from '../store/index';
    export default {
        mounted () {
            localStorage.removeItem('api-token');
            store.commit('logoutUser');
            this.$router.push({ name: 'login' });
        }
    }
</script>