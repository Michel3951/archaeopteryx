<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <input type="text" name="_token" v-model="csrf" hidden>
                    <div class="form-group">
                        <label for="domain">Domain</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">www.</div>
                            </div>
                            <input type="text" class="form-control" id="domain" name="domain" placeholder="example.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type">Project type</label>
                        <select name="type" id="type" class="form-control" v-model="type">
                            <option value="0">Plain PHP / HTML</option>
                            <option value="1">Laravel Framework</option>
                        </select>
                    </div>
                    <div class="form-group" v-if="type == 0">
                        <label for="preset">Preset / Template</label>
                        <select name="preset" id="preset" class="form-control" v-model="preset">
                            <option value="">None</option>
                            <option v-for="(preset, index) in JSON.parse(presets)" v-bind:value="preset">/{{ preset.split('/').reverse()[0] }}</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="database[create]" id="database" v-model="database.create">
                            <label class="custom-control-label" for="database">Create new database</label>
                        </div>
                    </div>
                    <div v-if="database.create">
                        <div class="form-group">
                            <label for="database-name">Database name</label>
                            <input type="text" name="database[name]" id="database-name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Create',
        props: ['old', 'errors', 'presets'],
        data: () => ({
            csrf: null,
            domain: null,
            type: 0,
            preset: '',
            database: {
                create: false
            }
        }),
        methods: {
        },
        mounted() {
            this.csrf = window.Laravel.csrfToken;
            Object.entries(JSON.parse(this.old)).forEach(input => {
                if (input[0].startsWith('_')) return;
                this[input[0]] = input[1];
            })
        }
    }
</script>
