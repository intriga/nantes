<template>
    <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Post</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="quickForm" @submit.prevent="savePost" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        
                        

                        <input 
                            type="text" id="title" name="title" class="form-control" placeholder="Enter title"
                            v-model="model.post.title" 
                            @input="generateSlug"
                        />
                        <input 
                            type="hidden" name="slug" class="form-control" id="slug"
                            v-model="model.post.slug"
                        />                                                  
                            
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" ref="fileInput" @change="handleFileChange">
                    </div>

                    <div class="form-group">
                        <label>Textarea</label>
                        <textarea 
                            class="form-control" id="content" name="content"  rows="3" placeholder="Enter ..."
                            v-model="model.post.content"
                        >
                        </textarea>
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

import slugify from 'slugify';
import axios from 'axios';

export default {
    data() {
        return {       
            model: {
                post: {
                    title: '',
                    slug: '',
                    content: '',
                    file:   '',
                }
            }
        };
    },
       
    methods: {

        generateSlug() {
            const slug = this.model.post.title
            .trim()
            .toLowerCase()
            .replace(/\s+/g, '-') // Replace whitespace with hyphens
            .replace(/[^\w-]+/g, ''); // Remove non-alphanumeric characters

        this.model.post.slug = slug;
        },

        handleFileChange(e) {
            //console.log(e.target.files[0]["name"]);
            this.model.post.file = e.target.files[0]; // Assuming single file upload
        },

        savePost() {
            const formData = new FormData(); // Create a FormData object
            formData.append('title', this.model.post.title);
            formData.append('slug', this.model.post.slug);
            formData.append('content', this.model.post.content);
            formData.append('image', this.model.post.file); // Assuming 'file' is a file input

            axios.post('/api/post', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    },
                })
                .then(res => {
                    console.log(res.data);

                    this.model.post = { // Reset the form data
                        title: '',
                        slug: '',
                        content: '',
                        file: '',
                    };
                    
                    window.location.href = '/posts';

                })
                .catch(error => {
                    console.error('Error:', error); // Handle errors
                });
            },
    }
};
</script>