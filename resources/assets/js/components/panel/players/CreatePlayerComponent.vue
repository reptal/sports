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
        <form class="form-signin" v-on:submit.prevent="submitCreatePlayer">

            <h1 class="h3 mb-3 font-weight-normal">Create new Player</h1>
            <div class="form-group">
                <label for="inputFirst" class="sr-only">First Name</label>
                <input type="text" id="inputFirst" class="form-control" placeholder="First Name" required autofocus
                       v-model="first_name">
                <form-error v-if="errors.first_name" :errors="errors">
                    {{ errors.first_name }}
                </form-error>
            </div>
            <div class="form-group">
                <label for="inputLast" class="sr-only">Last Name</label>
                <input type="text" id="inputLast" class="form-control" placeholder="Last NAME" required autofocus
                       v-model="last_name">
                <form-error v-if="errors.last_name" :errors="errors">
                    {{ errors.last_name }}
                </form-error>
            </div>
            <div class="form-group">
                <label for="inputTeam" class="sr-only">Last Name</label>
                <select id="inputTeam" class="form-control" required autofocus v-model="team_id">
                    <option v-for="team in allTeams" v-bind:value="team.id">{{team.name}}</option>
                </select>
                <form-error v-if="errors.team" :errors="errors">
                    {{ errors.team }}
                </form-error>
            </div>


            <button class="btn btn-lg btn-primary btn-block" type="submit" :disabled="loading">Create</button>
            <p class="text-center" v-show="loading">Loading ...</p>

        </form>

    </div>
</template>
<script>
    export default {
        data() {
            return {
                first_name: '',
                last_name: '',
                team_id: '',
                allTeams: [],
                registerError: false,
                errors: {},
                loading: false
            }
        },
        methods: {
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
            submitCreatePlayer() {
                this.loading = true;
                let self = this;
                this.registerError = false;
                axios.post('/api/players', {
                        first_name: this.first_name,
                        last_name: this.last_name,
                        team: this.team_id

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
                    self.errors = error.response.data.message;
                    this.loading = false;
                });
            }
        },
        mounted(){
            this.getTeams();
        }
    }
</script>