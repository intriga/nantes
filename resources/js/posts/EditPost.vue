<template>
    <div class="card card-primary card-outline">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="mailbox-read-info">
                <h5>{{ model.post.title }}</h5>
            </div>
            <!-- /.mailbox-read-info -->
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
                            type="text" name="slug" class="form-control d-none" id="slug"
                            v-model="model.post.slug"
                        />                                                  
                            
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <!-- <input 
                            type="text" name="old_image" class="form-control" id="old_image"
                            v-model="model.post.old_image"
                        /> -->
                        <input type="file" name="image" class="form-control" ref="fileInput" @change="handleFileChange">
                    </div>

                    <div class="form-group">
                        <span v-if="model.post.category_title">{{ model.post.category_title }}</span>
                        <select v-model="model.categories.id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
                            <option v-for="value in categories" :key="value.id" :value="value.id">{{ value.title }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Textarea</label>
                        <!-- <textarea 
                            class="form-control" id="content" name="content"  rows="3" placeholder="Enter ..."
                            v-model="model.post.content"
                        >
                        </textarea> -->
                        <div id="appckeditor">
                            <ckeditor :editor="editor" v-model="model.post.content" :config="editorConfig"></ckeditor>
                        </div>
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

<style>
#appckeditor {
    color: black;
}
.ck-editor__editable {
    min-height: 300px; /* Adjust the height as needed */
}
</style>

<script>

    import axios from 'axios';
    import moment from 'moment';

    import CKEditor from '@ckeditor/ckeditor5-vue';
    import {
        ClassicEditor,
        Alignment,
        Bold,
        Essentials,
        Heading,
        Indent,
        IndentBlock,
        Italic,
        Link,
        List,
        MediaEmbed,
        Paragraph,
        Table,
        Undo
    } from 'ckeditor5';

    import 'ckeditor5/ckeditor5.css';

    export default {
        name: 'appckeditor',
        components: {
            ckeditor: CKEditor.component
        },
        data() {
            return {
                capturedSlug: null,
                model: {
                    post: {
                        id: '',
                        title: '',
                        slug: '',
                        content: '',
                        image: '',
                        //old_image: '',
                        category_id: '',
                        category_title: '',
                    },
                    categories: [{
                        id: '',
                        title: '',
                    }]
                },
                editor: ClassicEditor,
                editorData: '<h1>Hello from CKEditor 5!</h1>',
                editorConfig: {
                    toolbar: [
                        'undo', 'redo', '|',
                        'heading', '|', 'bold', 'italic', '|',
                        'link', 'insertTable', 'mediaEmbed', '|',
                        'bulletedList', 'numberedList', 'indent', 'outdent', 'alignment'
                    ],
                    plugins: [
                        Alignment,
                        Bold,
                        Essentials,
                        Heading,
                        Indent,
                        IndentBlock,
                        Italic,
                        Link,
                        List,
                        MediaEmbed,
                        Paragraph,
                        Table,
                        Undo
                    ],
                }     
            }
        },

        beforeMount(){
            this.getCategory();
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

            getCategory() {
                axios.get('/api/categories').then(res => {
                    this.categories = res.data;
                    // console.log(this.categories);
                });
            },
            
            getPost() {

                const urlFull = window.location.href;
                const urlParts = urlFull.split('/');

                const slug = urlParts[urlParts.length - 2];
                // console.log(slug);

                axios.get(`/api/post/${slug}/edit`).then(res => {
                    this.post = res.data;
                    // console.log(this.post);

                    this.model.post = {
                        id: res.data.id,
                        title: res.data.title,
                        slug: res.data.slug,
                        content: res.data.content,
                        old_image: res.data.image,
                        image: '',
                        // category_id: res.data.category.id,
                        category_title: res.data.category.title,
                    }
                });
            },   
            
            handleFileChange(e) {
                const file = e.target.files[0];
                this.model.post.image = file;
            },
            

            savePost() {
                const selectedCategory = this.model.categories.id;
                console.log(selectedCategory);

                const formData = new FormData(); // Use FormData for multipart file upload
                formData.append('id', this.model.post.id);
                formData.append('title', this.model.post.title);
                formData.append('slug', this.model.post.slug);
                formData.append('content', this.model.post.content);
                formData.append('old_image', this.model.post.old_image);
                formData.append('category_id', selectedCategory); // Use the extracted category ID

                // Append the image file if it exists
                if (this.model.post.image) {
                    formData.append('image', this.model.post.image);
                }
                
                const headers = {
                    'Content-Type': 'multipart/form-data',
                };

                axios.post('/api/post/' + this.model.post.id + '/edit', formData, { headers })
                    .then((res) => {
                    // console.log(res.data);
                    window.location = '/posts';
                    })
                    .catch((error) => {
                    console.error(error);
                    // Handle errors appropriately (e.g., display error messages to the user)
                    });
            },

        }
    }
</script>