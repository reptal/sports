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
        <form class="form-signin" v-on:submit.prevent="submitEditPlayer">

            <h1 class="h3 mb-3 font-weight-normal"> Edit Player</h1>
            <div class="form-group">
                <label for="inputFirst" class="sr-only">First Name</label>
                <input type="text" id="inputFirst" class="form-control" placeholder="First Name" required autofocus
                       v-model="player.first_name">
            </div>
            <div class="form-group">
                <label for="inputLast" class="sr-only">Last Name</label>
                <input type="text" id="inputLast" class="form-control" placeholder="Last NAME" required autofocus
                       v-model="player.last_name">
            </div>
            <div class="form-group">
                <label for="inputTeam" class="sr-only">Last Name</label>
                <select id="inputTeam" class="form-control" required autofocus v-model="player.team_id">
                    <option v-for="team in allTeams" v-bind:value="team.id" :selected="team.id==player.team_id">
                        {{team.name}}
                    </option>
                </select>
            </div>


            <button class="btn btn-lg btn-primary btn-block" type="submit" :disabled="loading">Update</button>
            <p class="text-center" v-show="loading">Loading ...</p>
        </form>

    </div>
</template>
<script>
    export default {
        data() {
            return {
                player: {
                    first_name: '',
                    last_name: '',
                    team_id: '',
                    id: ''
                },
                allTeams: [],
                registerError: false,
                loading: false
            }
        },
        methods: {
            //submit form
            submitEditPlayer() {
                this.loading = true;
                this.loginError = false;
                let playerId = this.player.id;
                axios.put('/api/players/' + playerId, {
                        first_name: this.player.first_name,
                        last_name: this.player.last_name,
                        team: this.player.team_id

                    },
                    {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('api-token')
                        }
                    }).then(response => {
                    // login user, store the token and redirect to dashboard
                    this.$router.push({name: 'index-player'});
                    this.loading = false;
                }).catch(error => {
                    this.registerError = true;
                    this.loading = false;
                });
            },
            //get team
            getPlayer(){
                let self = this;
                let playerId = this.$route.params.id;
                axios.get('/api/players/' + playerId,
                    {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('api-token')
                        }
                    }).then(response => {
                    // login user, store the token and redirect to dashboard
                    self.player = response.data.data.player;
                }).catch(error => {
                    this.registerError = true
                });
            },
            getTeams(){
                axios.get('/api/teams?limit=0', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('api-token')
                    }
                })
                    .then(response => {
                        this.allTeams = response.data.data.teams;
                    }).catch(error => {

                })
            },
        },
        mounted() {
            this.getTeams();
            this.getPlayer();
        }
    }
</script>