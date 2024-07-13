<template>
    <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Category</h3>
            </div>
            <!-- /.card-header -->
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
                            type="hidden" name="slug" class="form-control" id="slug"
                            v-model="model.category.slug"
                        />                                                  
                            
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
                category: {
                    title: '',
                    slug: '',
                }
            }
        };
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

        saveCategory() {
            axios.post('/api/category', this.model.category).then(res => {
                console.log(res.data);

                this.model.category = { // Reset the form data
                    title: '',
                    slug: '',
                };
                
                window.location.href = '/categories';

            })
            .catch(error => {
                console.error('Error:', error); // Handle errors
            });
        },
    }
};
</script>