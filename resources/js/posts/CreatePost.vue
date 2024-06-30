<template>
    <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Post</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="quickForm" @submit.prevent="savePost">
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

        savePost(){
            axios.post('/api/post/', this.model.post).then(res => {
                console.log(res.data);
                
                this.model.post = {
                    title: '',
                    slug: '',
                    content: '',
                }
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })

            
        }
    }
};
</script>