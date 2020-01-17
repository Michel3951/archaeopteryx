<template>
    <div class="container-fluid">
        <div class="shadow-sm mb-3 p-3">
            <a href="/domains/new" class="btn btn-primary"><i class="fa fa-plus"></i> New domain</a>
        </div>
        <div class="card mb-3 shadow-sm" v-for="domain in JSON.parse(domains)" v-bind:key="domain.id">
            <div class="card-header">
                <h1>{{ domain.domain }}</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li><a :href="'/domains/' + domain.domain + '/files?path=/'"><i class="fas fa-folder-open"></i> File Manager</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Index',
        props: ['domains'],
        data: () => ({
            csrf: null,
        }),
        methods: {},
        mounted() {
            this.csrf = window.Laravel.csrfToken;

        }
    }
</script>
