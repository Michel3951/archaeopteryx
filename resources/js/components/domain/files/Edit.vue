<template>
    <div class="container-fluid">
        <a :href="`/domains/${domain.domain}/files?path=${this.path}`" class="btn btn-primary">Back</a>
        <hr>
        <h1>Edting file: {{ breadcrumb() }}</h1>
        <pre id="editor" style="height: 500px; width: 100%">{{ file.content }}</pre>
    </div>
</template>

<script>
    export default {
        name: 'Edit',
        props: ['domain', 'file', 'path'],
        data: () => ({
            csrf: null,
        }),
        methods: {
            breadcrumb: function () {
                let path = this.path;
                if (path.startsWith('/')) path = path.slice(1);
                if (path.length > 0) path += '/';
                return path + this.file.name;
            }
        },
        mounted() {
            this.csrf = window.Laravel.csrfToken;
            let editor = ace.edit('editor');
            editor.getSession().setMode("ace/mode/php");
        }
    }
</script>
