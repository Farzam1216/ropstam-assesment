<!-- Navbar.vue -->
<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <router-link class="navbar-brand" :to="loggedIn ? '/dashboard' : '/'">{{ loggedIn ? userName : 'My App' }}</router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item" v-if="!loggedIn">
              <router-link class="nav-link" to="/login">Login</router-link>
            </li>
            <li class="nav-item" v-if="!loggedIn">
              <router-link class="nav-link" to="/register">Register</router-link>
            </li>
            <li class="nav-item" v-if="loggedIn">
              <button class="nav-link btn btn-link" @click="logout">Logout</button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </template>

  <script>
  export default {
    data() {
      return {
        loggedIn: false,
        userName: ''
      };
    },
    methods: {
      logout() {
        localStorage.removeItem('token');
        this.$router.push('/login');
      },
      fetchUserName() {

      }
    },
    mounted() {
      this.loggedIn = localStorage.getItem('token') !== null;
      if (this.loggedIn) {
        this.fetchUserName();
      }
    }
  };
  </script>

