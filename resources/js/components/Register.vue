<!-- Register.vue -->
<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form @submit.prevent="register">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="name" id="name"
                                    placeholder="Enter your name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" v-model="email" id="email"
                                    placeholder="Enter email" required>
                            </div>
                            <!-- <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" v-model="password" id="password"
                                    placeholder="Password" required>
                            </div> -->
                            <button type="submit" class="btn btn-primary">Register</button>
                            <p>Already have an account? <router-link to="/login">Login</router-link></p>
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
            name: '',
            email: '',
            // password: ''
        };
    },
    methods: {
        async register() {
            try {
                const response = await axios.post('/api/users/register', {
                    name: this.name,
                    email: this.email,
                    // password: this.password
                });
                this.$router.push('/login');
            } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>
