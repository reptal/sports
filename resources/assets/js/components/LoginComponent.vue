<template>
    <div class="row text-center  mt-3">
        <div class="col-md-12 ">
            <form v-on:submit.prevent="submitLogin">
                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                <div class="form-group">
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required
                           autofocus
                           v-model="email">
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required
                           v-model="password">
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>

        </div>
    </div>
</template>

<script>
    import store from '../store/index';
    export default {
        data() {
            return {
                email: '',
                password: '',
                loginError: false,
            }
        },
        methods: {
            submitLogin() {
                this.loginError = false;
                axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    // login user, store the token and redirect to dashboard
                    store.commit('loginUser');
                    localStorage.setItem('api-token', response.data.data.token);
                    this.$router.push({name: 'dashboard'});
                }).catch(error => {
                    this.loginError = true
                });
            }
        }
    }
</script>

