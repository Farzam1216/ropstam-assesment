<!-- Login.vue -->
<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>

                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form @submit.prevent="login">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" v-model="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" v-model="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                            <p>Don't have an account? <router-link to="/register">Register</router-link></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            errorMessage: ''
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/api/users/login', {
                    email: this.email,
                    password: this.password
                });

                console.log(response.data,response.data.authorization.token);
                localStorage.setItem('token', response.data.authorization.token);
                this.$router.push('/dashboard');

            } catch (error) {
                // Handle login error
                if (error.response && error.response.status === 401) {
                    this.errorMessage = 'Invalid email or password. Please try again.';
                } else {
                    this.errorMessage = 'An error occurred while logging in. Please try again later.';
                }
            }
        }
    }
};
</script>
