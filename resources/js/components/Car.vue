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
                            <h2>Car Management</h2>
                        </div>
                        <div class="card-body">
                            <button @click="showAddForm = true">Add Car</button>

                            <table id="carTable" class="display">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Color</th>
                                        <th>Model</th>
                                        <th>Make</th>
                                        <th>Registration No</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="car in cars" :key="car.id">
                                        <td>{{ car.category.name }}</td>
                                        <td>{{ car.name }}</td>
                                        <td>{{ car.color }}</td>
                                        <td>{{ car.model }}</td>
                                        <td>{{ car.make }}</td>
                                        <td>{{ car.registration_no }}</td>
                                        <td>
                                            <button @click="showEditForm(car)">Edit</button>
                                            <button @click="deleteCar(car.id)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Add Car Form -->
                            <div v-if="showAddForm">
                                <form @submit.prevent="addCar">
                                    <label>Name: </label>
                                    <input type="text" v-model="newCar.name" required><br>
                                    <label>Color: </label>
                                    <input type="text" v-model="newCar.color" required><br>
                                    <label>Model: </label>
                                    <input type="text" v-model="newCar.model" required><br>
                                    <label>Make: </label>
                                    <input type="text" v-model="newCar.make" required><br>
                                    <label>Registration No: </label>
                                    <input type="text" v-model="newCar.registration_no" required><br>
                                    <label>Category: </label>
                                    <select v-model="newCar.category_id" required>
                                        <option v-for="category in categories" :value="category.id" :key="category.id">
                                            {{ category.name }}</option>
                                    </select><br>
                                    <button type="submit">Save</button>
                                    <button @click="cancelAdd">Cancel</button>
                                </form>
                            </div>

                            <!-- Edit Car Form -->
                            <div v-if="showEdit">
                                <form @submit.prevent="editCar">
                                    <label>Name: </label>
                                    <input type="text" v-model="selectedCar.name" required><br>
                                    <label>Color: </label>
                                    <input type="text" v-model="selectedCar.color" required><br>
                                    <label>Model: </label>
                                    <input type="text" v-model="selectedCar.model" required><br>
                                    <label>Make: </label>
                                    <input type="text" v-model="selectedCar.make" required><br>
                                    <label>Registration No: </label>
                                    <input type="text" v-model="selectedCar.registration_no" required><br>
                                    <label>Category: </label>
                                    <select v-model="selectedCar.category_id" required>
                                        <option v-for="category in categories" :value="category.id" :key="category.id">
                                            {{ category.name }}</option>
                                    </select><br>
                                    <button type="submit">Save</button>
                                    <button @click="cancelEdit">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import Sidebar from '../components/Sidebar.vue';
import axios from 'axios';

export default {
    components: {
        Navbar,
        Sidebar
    },
    data() {
        return {
            cars: [],
            categories: [],
            showAddForm: false,
            showEdit: false,
            newCar: {
                name: '',
                color: '',
                model: '',
                make: '',
                registration_no: '',
                category_id: null
            },
            selectedCar: {
                id: null,
                name: '',
                color: '',
                model: '',
                make: '',
                registration_no: '',
                category_id: null
            },
            errorMessage: ''
        };
    },
    mounted() {
        this.fetchCars();
        this.fetchCategories();
        this.initializeDataTable();
    },
    methods: {
        fetchCars() {
            axios.get('/api/car')
                .then(response => {
                    this.cars = response.data;
                })
                .catch(error => {
                    console.error('Error fetching cars:', error);
                });
        },
        fetchCategories() {
            axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.error('Error fetching categories:', error);
                });
        },
        addCar() {
            axios.post('/api/car/store', this.newCar)
                .then(response => {
                    this.cars.push(response.data);
                    this.showAddForm = false;
                    this.newCar = {
                        name: '',
                        color: '',
                        model: '',
                        make: '',
                        registration_no: '',
                        category_id: null
                    };
                    this.fetchCars();
                })
                .catch(error => {
                    this.errorMessage = 'Failed to add car: ' + error.response.data.message;
                });
        },
        editCar() {
            axios.put(`/api/car/${this.selectedCar.id}/update`, this.selectedCar)
                .then(response => {
                    const index = this.cars.findIndex(car => car.id === this.selectedCar.id);
                    this.cars[index] = response.data;
                    this.showEdit = false;
                    this.fetchCars();

                })
                .catch(error => {
                    this.errorMessage = 'Failed to edit car: ' + error.response.data.message;
                });
        },
        deleteCar(id) {
            axios.delete(`/api/car/${id}/destroy`)
                .then(() => {
                    this.cars = this.cars.filter(car => car.id !== id);
                    this.fetchCars();
                })
                .catch(error => {
                    this.errorMessage = 'Failed to delete car: ' + error.response.data.message;
                });
        },
        showEditForm(car) {
            this.selectedCar = { ...car };
            this.showEdit = true;
        },
        cancelAdd() {
            this.showAddForm = false;
            this.newCar = {
                name: '',
                color: '',
                model: '',
                make: '',
                registration_no: '',
                category_id: null
            };
        },
        cancelEdit() {
            this.showEdit = false;
            this.selectedCar = {
                id: null,
                name: '',
                color: '',
                model: '',
                make: '',
                registration_no: '',
                category_id: null
            };
        },
        initializeDataTable() {
            $(document).ready(() => {
                $('#carTable').DataTable();
            });
        }
    }
};
</script>

<style scoped>
.error-message {
    color: red;
}
</style>
