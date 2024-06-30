<template>
    <div class="card card-primary card-outline">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="mailbox-read-info">
                <h5>{{ model.post.title }}</h5>
                <h6>
                    <span class="mailbox-read-time float-right">{{ format_date(model.post.created_at) }}</span>
                </h6>
            </div>
            <!-- /.mailbox-read-info -->
            <div class="mailbox-read-message">

                <p>{{ model.post.content }}</p>

            </div>
            <!-- /.mailbox-read-message -->
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
                        title: '',
                        content: '',
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

                axios.get(`/api/post/${slug}`).then(res => {
                    this.post = res.data;
                    console.log(this.post);

                    this.model.post = {
                        title: res.data.title,
                        content: res.data.content,
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