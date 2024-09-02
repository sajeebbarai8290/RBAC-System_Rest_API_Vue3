<template>
    <div class="container text-center mt-5">
      <div class="jumbotron bg-light p-5 rounded">
        <h1 class="display-4 mb-4">Welcome to the RBAC System</h1>
        <p class="lead mb-4">A powerful and flexible Role-Based Access Control system to manage your application efficiently.</p>
        <div class="d-flex justify-content-center gap-3">
          <router-link class="btn btn-primary btn-lg" to="/login">Login</router-link>
          <router-link class="btn btn-secondary btn-lg" to="/register">Register</router-link>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Home',
    mounted() {
      console.log('Home component is mounted!');
    }
  };
  </script>
  
  <style scoped>
  /* Add your custom styles here */
  .jumbotron {
    background-color: #f8f9fa;
  }
  </style>
  