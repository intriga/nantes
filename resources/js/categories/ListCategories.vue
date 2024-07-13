<template>
    
    <div class="card">
            <div class="card-header">
            <h3 class="card-title">Last Categories</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <a href="/category/create" type="button" class="btn btn-primary btn-block">
                        <i class="fas fa-plus"></i>
                        Create
                    </a>
                </div>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-striped table-dark">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="value in categories" :key="value">
                            <td>{{ value.id }}</td>
                            <td>{{ value.title }}</td>
                            <td>{{ format_date(value.created_at) }}</td>
                            <td>
                                <a :href="'/category/' + value.slug" type="button" class="btn btn-success">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a :href="'/category/' + value.slug + '/edit'" type="button" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger"
                                        @click="deleteCategory(value.id)">
                                    <i class="fas fa-eraser"></i>
                                </button>
                            </td>
                        </tr>                
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>

</template>

<script>
    import axios from 'axios';
    import moment from 'moment';

    export default {

        data() {
            return {
                categories: []
            }
        },

        mounted() {
            this.getCategories();
        },

        methods: {
            getCategories() {
                axios.get('/api/categories').then(res => {
                    this.categories = res.data;
                    //console.log(this.categories);
                });
            },

            deleteCategory(id) {
                axios.delete(`/api/category/${id}/delete`).then(res => {
                    console.log(res.data);
                    this.getCategories();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },

            format_date(value) {
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY');
                }
            }

        }
    }
</script>
