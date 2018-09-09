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
        <form class="form-signin" v-on:submit.prevent="submitCreateTeam">

            <h1 class="h3 mb-3 font-weight-normal">Create new Team</h1>
            <div class="form-group">
                <label for="inputName" class="sr-only">Name</label>
                <input type="text" id="inputName" class="form-control" placeholder="Team Name" required autofocus
                       v-model="name">
                <form-error v-if="errors.name" :errors="errors">
                    {{ errors.name }}
                </form-error>
            </div>
            <div class="form-group">
                <label for="inputSlug" class="sr-only">Slug</label>
                <input type="text" id="inputSlug" class="form-control" placeholder="Team url Slug" required autofocus
                       v-model="slug">
                <form-error v-if="errors.slug" :errors="errors">
                    {{ errors.slug }}
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
                name: '',
                slug: '',
                registerError: false,
                errors: {},
                loading: false
            }
        },
        methods: {
            submitCreateTeam() {
                this.loading = true;
                let self = this;
                this.registerError = false;
                axios.post('/api/teams', {
                        name: this.name,
                        slug: this.slug

                    },
                    {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('api-token')
                        }
                    }).then(response => {
                    // login user, store the token and redirect to dashboard
                    this.$router.push({name: 'index-team'});
                    this.loading = false;
                }).catch(error => {
                    this.registerError = true;
                    self.errors = error.response.data.message;
                    this.loading = false;
                });


            }
        }
    }
</script>