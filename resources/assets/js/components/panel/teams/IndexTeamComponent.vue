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
                <h1>Teams</h1>
                <div >
                    <router-link class="text-white btn btn-success float-right" :to="{ name: 'create-team' }">
                        Add new Team
                    </router-link>
                    <div class="panel-heading">Teams List</div>
                    <div class="panel-body ">
                        <p class="text-center" v-show="loading">Loading ...</p>
                        <table class="table mt-5">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Players Count</th>
                                <th scope="col">Operation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="teams" v-for="team in teams">
                                <td>{{ team.id }}</td>
                                <td>{{ team.name }}</td>
                                <td>{{ team.slug }}</td>
                                <td>{{ team.players_count }}</td>
                                <td>
                                    <router-link class="text-white btn btn-success float-right"
                                                 :to="{ name: 'show-team' ,params: { id: team.id}}">Show
                                    </router-link>
                                    <router-link class="text-white btn btn-primary float-right mr-3 ml-3"
                                                 :to="{ name: 'edit-team' ,params: { id: team.id}}">Edit
                                    </router-link>

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
                teams: [],
                pagination: {
                    'current_page': 1
                },
                loading: false
            }
        },
        mounted() {
            this.getTeams();
        },
        methods: {
            getTeams(){
                this.loading = true;
                axios.get('/api/teams?page=' + this.pagination.current_page, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('api-token')
                    }
                })
                    .then(response => {
                        this.loading = false;
                        this.teams = response.data.data.teams;
                        this.pagination = response.data.data.pagination;
                    }).catch(error => {
                    this.loading = false;

                })
            }
        }
    }
</script>