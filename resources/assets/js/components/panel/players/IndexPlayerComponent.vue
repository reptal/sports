<template>
    <div class="container">
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
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h1>Players</h1>
                <div >
                    <router-link class="text-white btn btn-success float-right" :to="{ name: 'create-player' }">Add new Player</router-link>
                    <div class="panel-heading">Players List</div>
                    <div class="panel-body ">
                        <p class="text-center" v-show="loading">Loading ...</p>

                        <table class="table mt-5">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Team Name</th>
                                <th scope="col">Operation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="players" v-for="player in players">
                                <td>{{ player.id }}</td>
                                <td>{{ player.first_name }}</td>
                                <td>{{ player.last_name }}</td>
                                <td>{{ player.team.name }}</td>
                                <td>
                                    <router-link class="text-white btn btn-primary float-right mr-3 ml-3" :to="{ name: 'edit-player' ,params: { id: player.id}}">Edit</router-link>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <pagination-component v-if="pagination && pagination.last_page > 1" :pagination="pagination"
                                              :offset="5"
                                              @paginate="getTeams()"></pagination-component>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                players: [],
                pagination: {
                    'current_page': 1
                },
                loading: false

            }
        },
        mounted() {
            this.getPlayers();
        },
        methods: {
            getPlayers(){
                this.loading = true;
                axios.get('/api/players?page=' + this.pagination.current_page, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('api-token')
                    }
                })
                    .then(response => {
                        this.players = response.data.data.players;
                        this.pagination = response.data.data.pagination;
                        this.loading = false;
                    }).catch(error => {
                    this.loading = false;
                })
            }
        }
    }
</script>