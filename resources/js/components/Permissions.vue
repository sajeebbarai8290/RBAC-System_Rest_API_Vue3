<template>
  <div class="container mt-5">
    <h2>Manage Permissions</h2>
    <div class="mb-3 d-flex justify-content-between align-items-center">
      <button class="btn btn-secondary float-right" @click="goBack">Back to Dashboard</button>
      <button class="btn btn-primary" @click="openModal">Create Permission</button>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="permission in permissions" :key="permission.id">
          <td>{{ permission.name }}</td>
          <td>
            <button class="btn btn-sm btn-warning" @click="editPermission(permission)">Edit</button>
            <button class="btn btn-sm btn-danger" @click="confirmDelete(permission.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Create/Edit Permission Modal -->
    <div v-if="modalVisible" class="modal show" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ isEdit ? 'Edit Permission' : 'Create Permission' }}</h5>
            <button type="button" class="close" @click="closeModal">&times;</button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="savePermission">
              <div class="mb-3">
                <label for="permissionName" class="form-label">Permission Name</label>
                <input v-model="permissionForm.name" type="text" class="form-control" id="permissionName" required>
              </div>
              <button type="submit" class="btn btn-primary">{{ isEdit ? 'Update' : 'Create' }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div v-if="modalVisible" class="modal-backdrop show"></div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      permissions: [],
      permissionForm: {
        name: '',
      },
      isEdit: false,
      editingPermissionId: null,
      modalVisible: false,
    };
  },
  async created() {
    await this.fetchPermissions();
  },
  methods: {
    async fetchPermissions() {
      try {
        const response = await axios.get('/api/permissions', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        this.permissions = response.data;
      } catch (error) {
        console.error('Error fetching permissions:', error.response?.data || error.message);
      }
    },
    openModal() {
      this.permissionForm = { name: '' };
      this.isEdit = false;
      this.modalVisible = true;
    },
    async savePermission() {
      try {
        if (this.isEdit) {
          await axios.put(`/api/permissions/${this.editingPermissionId}`, this.permissionForm, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
          });
        } else {
          await axios.post('/api/permissions', this.permissionForm, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
          });
        }
        await this.fetchPermissions();
        this.closeModal();
        Swal.fire('Success!', 'Permission saved successfully.', 'success');
      } catch (error) {
        console.error('Error saving permission:', error.response?.data || error.message);
      }
    },
    editPermission(permission) {
      this.permissionForm = { name: permission.name };
      this.editingPermissionId = permission.id;
      this.isEdit = true;
      this.modalVisible = true;
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
        await this.deletePermission(id);
      }
    },
    async deletePermission(id) {
      try {
        await axios.delete(`/api/permissions/${id}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        await this.fetchPermissions();
        Swal.fire('Deleted!', 'Permission has been deleted.', 'success');
      } catch (error) {
        console.error('Error deleting permission:', error.response?.data || error.message);
        Swal.fire('Error!', 'An error occurred while deleting the permission.', 'error');
      }
    },
    closeModal() {
      this.modalVisible = false;
    },
    goBack() {
      this.$router.push('/dashboard');
    },
  },
};
</script>

<style scoped>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  overflow: hidden;
  background: rgba(0, 0, 0, 0.5);
}
.modal-dialog {
  margin: 15px auto;
  max-width: 500px;
}
.modal-content {
  position: relative;
  background-color: #fff;
  border-radius: 0.3rem;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
  padding: 1rem;
}
.modal-header {
  border-bottom: 1px solid #dee2e6;
}
.modal-title {
  margin: 0;
  line-height: 1.5;
}
.close {
  padding: 0.5rem 1rem;
  margin: -0.5rem -1rem -0.5rem auto;
  color: #000;
  background: transparent;
  border: 0;
  cursor: pointer;
  font-size: 1.5rem;
}
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1040;
}
</style>
