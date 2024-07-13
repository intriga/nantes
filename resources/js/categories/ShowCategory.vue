<template>
    <div class="card card-primary card-outline">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="mailbox-read-info">
                <h5>{{ model.category.title }}</h5>
                <h6>
                    <span class="mailbox-read-time float-right">{{ format_date(model.category.created_at) }}</span>
                </h6>
            </div>
            
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
                        title: '',
                        created_at: '',
                    }
                }
            }
        },

        mounted() {
            this.getPost();
        },

        methods: {
            getPost() {

                const urlFull = window.location.href;
                const urlParts = urlFull.split('/');

                const slug = urlParts[urlParts.length - 1];
                //console.log(slug);

                axios.get(`/api/category/${slug}`).then(res => {
                    this.category = res.data;
                    console.log(this.category);

                    this.model.category = {
                        title: res.data.title,
                        created_at: res.data.created_at,
                    }
                });
            },            
            

            format_date(value) {
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY');
                }
            }

        }
    }
</script>