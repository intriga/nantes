<template>
    <div class="card card-primary card-outline">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="mailbox-read-info">
                <h5>{{ model.category.title }}</h5>
            </div>
            <!-- /.mailbox-read-info -->
            <!-- form start -->
            <form id="quickForm" @submit.prevent="saveCategory">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        
                        

                        <input 
                            type="text" id="title" name="title" class="form-control" placeholder="Enter title"
                            v-model="model.category.title" 
                            @input="generateSlug"
                        />
                        <input 
                            type="text" name="slug" class="form-control d-none" id="slug"
                            v-model="model.category.slug"
                        />                                                  
                            
                    </div>                  


                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" 
                        
                        >Edit</button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->

        <!-- /.card-footer -->
        <div class="card-footer">
            <div class="float-right">
                <button type="button" class="btn btn-warning"><i class="fas fa-print"></i> edit</button>
                <button type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
            </div>

        </div>
        <!-- /.card-footer -->
    </div>
</template>

<script>

    import axios from 'axios';
    import moment from 'moment';

    export default {

        data() {
            return {
                capturedSlug: null,
                model: {
                    category: {
                        id: '',
                        title: '',
                        slug: '',
                    }
                }
            }
        },

        mounted() {
            this.getCategory();
        },

        methods: {

            generateSlug() {
                const slug = this.model.category.title
                .trim()
                .toLowerCase()
                .replace(/\s+/g, '-') // Replace whitespace with hyphens
                .replace(/[^\w-]+/g, ''); // Remove non-alphanumeric characters

            this.model.category.slug = slug;
            },
            
            getCategory() {

                const urlFull = window.location.href;
                const urlParts = urlFull.split('/');

                const slug = urlParts[urlParts.length - 2];
                // console.log(slug);

                axios.get(`/api/category/${slug}/edit`).then(res => {
                    this.category = res.data;
                    // console.log(this.category);

                    this.model.category = {
                        id: res.data.id,
                        title: res.data.title,
                        slug: res.data.slug,
                    }
                });
            },   
                        

            saveCategory(){
                axios.put('/api/category/'+this.model.category.id+'/edit', 
                            this.model.category).then(res => {
                    //console.log(res.data);
                    
                    window.location = '/categories'
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })                
            }

        }
    }
</script>