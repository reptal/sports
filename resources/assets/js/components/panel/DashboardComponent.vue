<template>
    <div class="mt-3 text-center">
        <div class="row text-center">
            <p>
                <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
                |
                <router-link :to="{ name: 'index-team' }">Teams</router-link>
                |
                <router-link :to="{ name: 'index-player' }">Players</router-link>
                |
                <router-link :to="{ name: 'logout' }">Logout</router-link>
            </p>
        </div>

        <h2 class="h2">Dashboard</h2>
        <div>
            <p>Teams Count:{{teams}}</p>
            <p>Players Count:{{players}}</p>
        </div>
    </div>


</template>

<script>
    export default {
        data() {
            return {
                players: '',
                teams: ''
            }
        },
        mounted() {
            axios.get('/api/dashboard', {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('api-token')
                }
            })
                .then(response => {
                    this.teams = response.data.data.teams;
                    this.players = response.data.data.players

                }).catch(error => {

            })
        }
    }
</script>