<template>
    <div class="card card-primary card-outline">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="mailbox-read-info">
                <h5>{{ model.post.title }}</h5>
            </div>
            <!-- /.mailbox-read-info -->
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
                            type="text" name="slug" class="form-control d-none" id="slug"
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
                    post: {
                        id: '',
                        title: '',
                        slug: '',
                        content: '',
                    }
                }
            }
        },

        mounted() {
            this.getPost();
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
            
            getPost() {

                const urlFull = window.location.href;
                const urlParts = urlFull.split('/');

                const slug = urlParts[urlParts.length - 2];
                // console.log(slug);

                axios.get(`/api/post/${slug}/edit`).then(res => {
                    this.post = res.data;
                    //console.log(this.post);

                    this.model.post = {
                        id: res.data.id,
                        title: res.data.title,
                        slug: res.data.slug,
                        content: res.data.content,
                    }
                });
            },            
            

            savePost(){
                axios.put('/api/post/'+this.model.post.id+'/edit', 
                            this.model.post).then(res => {
                    //console.log(res.data);
                    
                    window.location = '/posts'
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })

                
            }

        }
    }
</script>