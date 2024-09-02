<template>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
        <div class="position-sticky">
          <h4 class="text-center my-4">Admin Dashboard</h4>
          <ul class="nav flex-column">
            <li class="nav-item">
              <router-link class="nav-link" to="/profile">
                <i class="bi bi-person-circle"></i> Profile
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/users">
                <i class="bi bi-person"></i> Manage Users
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/roles">
                <i class="bi bi-shield"></i> Manage Roles
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/permissions">
                <i class="bi bi-lock"></i> Manage Permissions
              </router-link>
            </li>
          </ul>
          <button class="btn btn-danger w-100 mt-4" @click="logout">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </div>
      </nav>

      <!-- Main content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h2 class="h2">Dashboard</h2>
        </div>
        <!-- Your main dashboard content here -->
        <div class="row">
          <!-- Example card -->
          <div class="col-md-4">
            <div class="card shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Statistics</h5>
                <p class="card-text">View key metrics and statistics here.</p>
                <a href="#" class="btn btn-primary">View Details</a>
              </div>
            </div>
          </div>
          <!-- Add more cards or content as needed -->
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  methods: {
    async logout() {
      try {
        await axios.post('/api/logout', {}, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });

        // Remove token and clear header
        localStorage.removeItem('token');
        delete axios.defaults.headers.common['Authorization'];

        // Redirect to login page
        this.$router.push('/login');
      } catch (error) {
        console.error('Logout error:', error);
      }
    },
  }
};
</script>

<style scoped>
/* Sidebar styling */
#sidebar {
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  border-right: 1px solid #ddd;
}

/* Card styling */
.card {
  margin-bottom: 20px;
}

/* Icons */
.bi {
  margin-right: 8px;
}
</style>
