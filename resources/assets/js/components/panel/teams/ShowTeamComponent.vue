<template>
    <div class="text-center form-wrapper">
        <div class="row text-center mt-3">
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
        <ul class="list-group" v-if="team">
            <li class="list-group-item active">{{team.name}} <span class="float-right">(Team)</span></li>

            <li class="list-group-item"  v-for="player in team.players">
                {{player.first_name}} &nbsp; {{player.last_name}}
                <span class="float-right">(Player)</span>
            </li>

        </ul>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                team: {},
            }
        },
        methods: {
            getTeam(){
                let self = this;
                let teamId = this.$route.params.id;
                axios.get('/api/teams/' + teamId + '/players',
                    {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('api-token')
                        }
                    }).then(response => {
                    // login user, store the token and redirect to dashboard
                    self.team = response.data.data.team;
                }).catch(error => {
                    this.registerError = true
                });
            }
        },
        mounted() {
            this.getTeam();
        }
    }
</script>