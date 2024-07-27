<template>
    
    <div class="card">
            <div class="card-header">
            <h3 class="card-title">Last Categories</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <a href="/user/create" type="button" class="btn btn-primary btn-block">
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="value in users.data" :key="value">
                            <td>{{ value.id }}</td>
                            <td>{{ value.name }}</td>
                            <td>{{ value.email }}</td>
                            <td>{{ format_date(value.created_at) }}</td>
                            <td>
                                <a :href="'/user/' + value.slug" type="button" class="btn btn-success">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a :href="'/user/' + value.slug + '/edit'" type="button" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger"
                                        @click="deleteUser(value.id)">
                                    <i class="fas fa-eraser"></i>
                                </button>
                            </td>
                        </tr>                
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->

            <div class="card-footer clearfix">
                <Bootstrap4Pagination
                    :data="users"
                    @pagination-change-page="getUsers"
                    class="float-right"
                />
            </div>

        </div>

</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    import { Bootstrap4Pagination } from 'laravel-vue-pagination';


    export default {

        data() {
            return {
                users: []
            }
        },

        components: {
            Bootstrap4Pagination
        },

        mounted() {
            this.getUsers();
        },

        methods: {
            getUsers(page = 1) {
                axios.get('/api/users?page=' + page).then(res => {
                    this.users = res.data;
                    console.log(this.users);
                });
            },

            deleteUser(id) {
                axios.delete(`/api/user/${id}/delete`).then(res => {
                    console.log(res.data);
                    this.getUsers();
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
