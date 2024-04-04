<!-- Dashboard.vue -->
<template>
    <div>
      <navbar></navbar>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-2">
            <sidebar></sidebar>
          </div>
          <div class="col-lg-10">
            <h1>Welcome to the Dashboard</h1>
            <div class="card">
              <div class="card-header">
                Dashboard
              </div>
              <div class="card-body">
                Dashboard
              </div>
            </div>
            <!-- Add more dashboard cards as needed -->
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import Navbar from '../components/Navbar.vue';
  import Sidebar from '../components/Sidebar.vue';

  export default {
    components: {
      Navbar,
      Sidebar
    }
  };
  </script>

  <style scoped>
  /* Add custom styles here */
  </style>
