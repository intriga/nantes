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
                        <label>Minimal</label>
                        <select v-model="model.categories.id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
                            <option value="" disabled>Select a category</option>
                            <option v-for="value in categories" :key="value.id" :value="value.id">{{ value.title }}</option>
                        </select>

                        <!-- Display additional content based on selection -->
                        <div v-if="model.categories.id">
                        <!-- Content to show when a category is selected -->
                        Selected category ID: {{ model.categories.id }}
                        </div>
                        <div v-else>
                        <!-- Content to show when no category is selected -->
                        Please select a category.
                        </div>

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
                        
                        >Create</button>
                </div>
            </form>
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

import slugify from 'slugify';
import axios from 'axios';

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
            model: {
                post: {
                    title: '',
                    slug: '',
                    content: '',
                    file:   '',
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
        };
    },

    created(){
        this.getCategory();
    },
       
    methods: {

        getCategory() {
            axios.get('/api/categories').then(res => {
                this.categories = res.data;
                console.log(this.categories);
            });
        },

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

            const selectedCategory = this.model.categories.id;
            console.log(selectedCategory);
            //const categoryIdToSend = selectedCategory ? selectedCategory.id : null;

            const formData = new FormData(); // Create a FormData object
            formData.append('title', this.model.post.title);
            formData.append('slug', this.model.post.slug);
            formData.append('content', this.model.post.content);
            formData.append('image', this.model.post.file); // Assuming 'file' is a file input
            formData.append('category_id', selectedCategory); // Use the extracted category ID

            axios.post('/api/post', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    },
                })
                .then(res => {
                    // console.log(res.data);

                    this.model.post = { // Reset the form data
                        title: '',
                        slug: '',
                        content: '',
                        file: '',
                        category_id: '',
                    };
                    //this.model.categories = {};
                    
                    window.location.href = '/posts';

                })
                .catch(error => {
                    console.error('Error:', error); // Handle errors
                });
            },
    }
};
</script>