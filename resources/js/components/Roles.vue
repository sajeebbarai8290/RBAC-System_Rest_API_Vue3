<template>
  <div class="container mt-5">
    <h2>Manage Roles</h2>
    <div class="mb-3 d-flex justify-content-between align-items-center">
      <button class="btn btn-secondary float-right" @click="goBack">Back to Dashboard</button>
      <button class="btn btn-primary mb-3" @click="showCreateRoleModal">Create Role</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Permissions</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="role in roles" :key="role.id">
          <td>{{ role.name }}</td>
          <td>{{ role.permissions.map(permission => permission.name).join(', ') }}</td>
          <td>
            <button class="btn btn-sm btn-info" @click="showRoleDetails(role)">Show</button>
            <button class="btn btn-sm btn-warning" @click="editRole(role)">Edit</button>
            <button class="btn btn-sm btn-danger" @click="confirmDeleteRole(role.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Create/Edit Role Modal -->
    <div v-if="showRoleModal" class="modal fade show d-block" tabindex="-1" style="display: block;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ isEdit ? 'Edit Role' : 'Create Role' }}</h5>
            <button type="button" class="btn-close" @click="closeRoleModal"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="saveRole">
              <div class="mb-3">
                <label for="roleName" class="form-label">Role Name</label>
                <input v-model="roleForm.name" type="text" class="form-control" id="roleName" required>
              </div>
              <div class="mb-3">
                <label for="rolePermissions" class="form-label">Permissions</label>
                <select v-model="roleForm.permissions" multiple class="form-control" id="rolePermissions">
                  <option v-for="permission in permissions" :key="permission.id" :value="permission.id">
                    {{ permission.name }}
                  </option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">{{ isEdit ? 'Update' : 'Create' }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Role Details Modal -->
    <div v-if="showRoleDetailsModal" class="modal fade show d-block" tabindex="-1" style="display: block;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Role Details</h5>
            <button type="button" class="btn-close" @click="closeRoleDetailsModal"></button>
          </div>
          <div class="modal-body">
            <p><strong>Name:</strong> {{ selectedRole.name }}</p>
            <p><strong>Permissions:</strong> {{ selectedRole.permissions.map(permission => permission.name).join(', ') }}</p>
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
      roles: [],
      permissions: [],
      roleForm: {
        name: '',
        permissions: [],
      },
      isEdit: false,
      editingRoleId: null,
      showRoleModal: false,
      showRoleDetailsModal: false,
      selectedRole: null,
    };
  },
  async created() {
    await this.fetchRoles();
    await this.fetchPermissions();
  },
  methods: {
    async fetchRoles() {
      try {
        const response = await axios.get('/api/roles', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.roles = response.data;
      } catch (error) {
        console.error('Error fetching roles:', error);
      }
    },
    async fetchPermissions() {
      try {
        const response = await axios.get('/api/permissions', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.permissions = response.data;
      } catch (error) {
        console.error('Error fetching permissions:', error);
      }
    },
    showCreateRoleModal() {
      this.roleForm = { name: '', permissions: [] };
      this.isEdit = false;
      this.showRoleModal = true;
    },
    async editRole(role) {
      this.roleForm = {
        name: role.name,
        permissions: role.permissions.map(permission => permission.id), // Use IDs for the selected permissions
      };
      this.editingRoleId = role.id;
      this.isEdit = true;
      this.showRoleModal = true;
    },
    async saveRole() {
      try {
        if (this.isEdit) {
          // Update existing role
          await axios.put(`/api/roles/${this.editingRoleId}`, {
            name: this.roleForm.name,
            permissions: this.roleForm.permissions, // Contains IDs
          }, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
          });
          Swal.fire('Updated!', 'Role has been updated.', 'success');
        } else {
          // Create new role
          await axios.post('/api/roles', {
            name: this.roleForm.name,
            permissions: this.roleForm.permissions, // Contains IDs
          }, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
          });
          Swal.fire('Created!', 'Role has been created.', 'success');
        }
        this.closeRoleModal(); // Close the modal after saving
        await this.fetchRoles(); // Refresh the roles list
      } catch (error) {
        console.error('Error saving role:', error.response?.data);
        Swal.fire('Error!', 'An error occurred while saving the role.', 'error');
      }
    },
    async confirmDeleteRole(id) {
      const result = await Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
      });

      if (result.isConfirmed) {
        await this.deleteRole(id);
      }
    },
    async deleteRole(id) {
      try {
        await axios.delete(`/api/roles/${id}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        Swal.fire('Deleted!', 'Role has been deleted.', 'success');
        await this.fetchRoles();
      } catch (error) {
        console.error('Error deleting role:', error);
        Swal.fire('Error!', 'An error occurred while deleting the role.', 'error');
      }
    },
    showRoleDetails(role) {
      this.selectedRole = role;
      this.showRoleDetailsModal = true;
    },
    closeRoleDetailsModal() {
      this.showRoleDetailsModal = false;
      this.selectedRole = null;
    },
    closeRoleModal() {
      this.showRoleModal = false;
      this.isEdit = false;
      this.editingRoleId = null;
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
