<template>
    <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Category</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="quickForm" @submit.prevent="saveUser">
                <div class="card-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" 
                                id="name" placeholder="Enter Name"
                                v-model="model.user.name"
                            />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" 
                                id="exampleInputEmail1" placeholder="Enter email"
                                v-model="model.user.email"
                            />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" class="form-control" 
                                id="password" placeholder="Password"
                                v-model="model.user.password"
                            />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" 
                        
                        >Create</button>
                </div>
            </form>
        </div>
</template>

<script>

//import slugify from 'slugify';
import axios from 'axios';

export default {
    data() {
        return {       
            model: {
                user: {
                    name: '',
                    email: '',
                    password: '',
                }
            }
        };
    },
       
    methods: {

        saveUser() {
            axios.post('/api/user', this.model.user).then(res => {
                console.log(res.data);

                this.model.user = { // Reset the form data
                    name: '',
                    email: '',
                    password: '',
                };
                
                window.location.href = '/users';

            })
            .catch(error => {
                console.error('Error:', error); // Handle errors
            });
        },
    }
};
</script>