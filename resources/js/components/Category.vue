<template>
    <div>

        <navbar></navbar>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                    <sidebar></sidebar>
                </div>
                <div class="col-lg-10">
                    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>

                    <div class="card">
                        <div class="card-header">
                            <h2>Category Management</h2>
                        </div>
                        <div class="card-body">

                            <button @click="showAddModal">Add Category</button>

                            <table id="categoryTable" class="display">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in categories" :key="category.id">
                                        <!-- <td>{{ category.id }}</td> -->
                                        <td>{{ category.name }}</td>
                                        <td>
                                            <button @click="showEditModal(category)">Edit</button>
                                            <button @click="deleteCategory(category.id)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Add Category Modal -->
                            <div v-if="showAdd">
                                <div>
                                    <input type="text" v-model="newCategoryName" placeholder="Category Name" required>
                                    <button @click="addCategory">Add</button>
                                </div>
                                <button @click="closeAddModal">Close</button>
                            </div>

                            <!-- Edit Category Modal -->
                            <div v-if="showEdit">
                                <div>
                                    <input type="text" v-model="editCategoryName" placeholder="Category Name">
                                    <button @click="updateCategory">Update</button>
                                </div>
                                <button @click="closeEditModal">Close</button>
                            </div>
                        </div>
                    </div>
                    <!-- Add more dashboard cards as needed -->
                </div>
            </div>
        </div>





    </div>
</template>

<script>
import 'datatables.net';
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';

import axios from 'axios';

// Add Authorization header to every request
axios.interceptors.request.use(
    config => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

export default {
    components: {
        Navbar,
        Sidebar
    },
    data() {
        return {
            categories: [],
            showAdd: false,
            showEdit: false,
            newCategoryName: '',
            editCategoryName: '',
            selectedCategory: null,
            errorMessage: '',
        };
    },
    mounted() {
        this.fetchCategories();
        this.initializeDataTable();
    },
    methods: {

        fetchCategories() {

            const token = localStorage.getItem('token');
            if (!token) {
                console.error('Authorization Token not found');
                return;
            }

            const headers = { Authorization: `Bearer ${token}` };
            axios.get('/api/categories', { headers })
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.error('Error fetching categories:', error);
                });


        },
        addCategory() {

            const token = localStorage.getItem('token');
            if (!token) {
                console.error('Authorization Token not found');
                return;
            }

            const headers = { Authorization: `Bearer ${token}` };

            axios.post('/api/categories/store', { name: this.newCategoryName })
                .then(response => {
                    this.categories.push(response.data);
                    this.newCategoryName = '';
                    this.closeAddModal();
                    this.fetchCategories();
                })
                .catch(error => {
                    this.errorMessage = '';
                    this.errorMessage = error.response;

                });
        },
        updateCategory() {
            axios.put(`/api/categories/${this.selectedCategory.id}/update`, { name: this.editCategoryName })
                .then(response => {
                    const index = this.categories.findIndex(category => category.id === this.selectedCategory.id);
                    this.categories[index].name = this.editCategoryName;
                    this.editCategoryName = '';
                    this.closeEditModal();
                    this.fetchCategories();

                })
                .catch(error => {
                    this.errorMessage = error.response;
                });
        },
        deleteCategory(id) {
            axios.delete(`/api/categories/${id}/destroy`)
                .then(response => {
                    this.categories = this.categories.filter(category => category.id !== id);
                    this.fetchCategories();

                })
                .catch(error => {
                    this.errorMessage = error.response;
                });
        },
        showAddModal() {
            this.showAdd = true;
        },
        closeAddModal() {
            this.showAdd = false;
        },
        showEditModal(category) {
            this.showEdit = true;
            this.selectedCategory = category;
            this.editCategoryName = category.name;
        },
        closeEditModal() {
            this.showEdit = false;
            this.selectedCategory = null;
            this.editCategoryName = '';
        },
        initializeDataTable() {
            $(document).ready(() => {
                $('#categoryTable').DataTable();
            });
        }
    }
};
</script>

<style scoped>
/* Add your component styles here */
</style>
