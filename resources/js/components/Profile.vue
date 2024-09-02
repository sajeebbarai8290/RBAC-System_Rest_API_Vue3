<template>
  <div class="container mt-5">
    <h2>User Profile</h2>
    <button class="btn btn-secondary float-right" @click="goBack">Back to Dashboard</button>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ user.name }}</h5>
        <p class="card-text">Email: {{ user.email }}</p>
        <p class="card-text">Roles: {{ user.roles.map(role => role.name).join(', ') }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
data() {
  return {
    user: {},
  };
},
async created() {
  await this.fetchUserProfile();
},
methods: {
  async fetchUserProfile() {
    try {
      const response = await axios.get('/api/user/profile', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
        },
      });
      this.user = response.data;
    } catch (error) {
      console.error('Error fetching user profile:', error);
    }
  },
  goBack() {
    this.$router.push('/dashboard');
  },
},
};
</script>

<style scoped>
.card {
margin-top: 20px;
}
</style>
