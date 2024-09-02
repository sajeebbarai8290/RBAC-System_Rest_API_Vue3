<template>
  <div class="container mt-5">
    <h2>Manage Users</h2>
    <div class="mb-3 d-flex justify-content-between align-items-center">
      <button class="btn btn-secondary float-right" @click="goBack">Back to Dashboard</button>
      <button class="btn btn-primary mb-3" @click="showCreateUserModal = true">Create User</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Roles</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.roles.map(role => role.name).join(', ') }}</td>
          <td>
            <button class="btn btn-sm btn-warning" @click="editUser(user)">Edit</button>
            <button class="btn btn-sm btn-danger" @click="confirmDelete(user.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Create User Modal -->
    <div v-if="showCreateUserModal" class="modal fade show d-block" tabindex="-1" style="display: block;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create User</h5>
            <button type="button" class="btn-close" @click="showCreateUserModal = false"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createUser">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="newUser.name" id="name" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" v-model="newUser.email" id="email" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" v-model="newUser.password" id="password" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="roles" class="form-label">Roles</label>
                <select v-model="newUserRoles" id="roles" multiple class="form-select">
                  <option v-for="role in allRoles" :key="role.id" :value="role.name">
                    {{ role.name }}
                  </option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Create</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit User Modal -->
    <div v-if="selectedUser" class="modal fade show d-block" tabindex="-1" style="display: block;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit User</h5>
            <button type="button" class="btn-close" @click="selectedUser = null"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateUser">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="selectedUser.name" id="name" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" v-model="selectedUser.email" id="email" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="roles" class="form-label">Roles</label>
                <select id="roles" v-model="selectedRoles" multiple class="form-select">
                  <option v-for="role in allRoles" :key="role.id" :value="role.name">
                    {{ role.name }}
                  </option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      users: [],
      allRoles: [],
      selectedUser: null,
      selectedRoles: [],
      showCreateUserModal: false,
      newUser: {
        name: '',
        email: '',
        password: '',
      },
      newUserRoles: [],
    };
  },
  async created() {
    await this.fetchUsers();
    await this.fetchRoles();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await axios.get('/api/users', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.users = response.data;
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    },
    async fetchRoles() {
      try {
        const response = await axios.get('/api/roles', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.allRoles = response.data;
      } catch (error) {
        console.error('Error fetching roles:', error);
      }
    },
    async confirmDelete(id) {
      const result = await Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
      });

      if (result.isConfirmed) {
        await this.deleteUser(id);
      }
    },
    async deleteUser(id) {
      try {
        await axios.delete(`/api/users/${id}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.users = this.users.filter(user => user.id !== id);
        Swal.fire('Deleted!', 'User has been deleted.', 'success');
      } catch (error) {
        console.error('Error deleting user:', error);
        Swal.fire('Error!', 'An error occurred while deleting the user.', 'error');
      }
    },
    editUser(user) {
      this.selectedUser = { ...user };
      this.selectedRoles = user.roles.map(role => role.name);
      this.showCreateUserModal = false; // Assuming you want to close the create modal
    },
    async updateUser() {
      try {
        await axios.put(`/api/users/${this.selectedUser.id}`, {
          ...this.selectedUser,
          roles: this.selectedRoles,
        }, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.selectedUser = null;
        await this.fetchUsers();
        Swal.fire('Updated!', 'User has been updated.', 'success');
      } catch (error) {
        console.error('Error updating user:', error);
        Swal.fire('Error!', 'An error occurred while updating the user.', 'error');
      }
    },
    async createUser() {
      try {
        await axios.post('/api/users', {
          ...this.newUser,
          roles: this.newUserRoles,
        }, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.showCreateUserModal = false;
        this.newUser = { name: '', email: '', password: '' };
        this.newUserRoles = [];
        await this.fetchUsers();
        Swal.fire('Created!', 'User has been created.', 'success');
      } catch (error) {
        console.error('Error creating user:', error);
        Swal.fire('Error!', 'An error occurred while creating the user.', 'error');
      }
    },
    goBack() {
      this.$router.push('/dashboard');
    },
  },
};
</script>

<style scoped>
.modal {
  display: block;
}
</style>
