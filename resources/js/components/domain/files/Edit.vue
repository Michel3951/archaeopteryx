<template>
    <div class="container-fluid">
        <a :href="`/domains/${domain.domain}/files?path=${this.path}`" class="btn btn-primary">Back</a>
        <hr>
        <h1>Edting file: {{ breadcrumb() }}</h1>
        <pre id="editor" style="height: 500px; width: 100%">{{ file.content }}</pre>
        <button class="btn btn-primary" type="button" @click="reset()">Reset</button>
        <button class="btn btn-primary" type="button" @click="save()">Save</button>
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#save-as-modal">Save As</button>
        <button class="btn btn-primary" type="button" onclick="history.back()">Cancel</button>

        <div class="modal fade" id="save-as-modal" tabindex="-1" role="dialog" aria-labelledby="save-as-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="save-as-modal-label">Save file as</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="filename" id="filename" v-model="filename" :class="{'is-invalid': !filename}" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="saveAs()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Edit',
        props: ['domain', 'file', 'path'],
        data: () => ({
            csrf: null,
            filename: ''
        }),
        methods: {
            breadcrumb: function () {
                let path = this.path;
                if (path.startsWith('/')) path = path.slice(1);
                if (path.length > 0) path += '/';
                return path + this.file.name;
            },
            reset: function () {
                this.editor.setValue(this.file.content);
            },
            save: function () {
                fetch(`/domains/${this.domain.domain}/files/save?path=${this.path}&file=${this.file.name}`, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': this.csrf
                    },
                    body: JSON.stringify({
                        _token: this.csrf,
                        content: this.editor.getValue(),
                        file: this.file.name
                    })
                })
                    .then(res => res.json())
                    .then(json => {
                        window.location = json.url
                    });
            },
            saveAs: function () {
                fetch(`/domains/${this.domain.domain}/files/save?path=${this.path}&file=${this.file.name}`, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': this.csrf
                    },
                    body: JSON.stringify({
                        _token: this.csrf,
                        content: this.editor.getValue(),
                        file: this.filename
                    })
                })
                    .then(res => res.json())
                    .then(json => {
                        window.location = json.url
                    });
            }
        },
        mounted() {
            this.csrf = window.Laravel.csrfToken;
            this.editor = ace.edit('editor');
            this.filename = this.file.name;
            let type = this.file.name.split('.').reverse()[0];
            this.editor.getSession().setMode("ace/mode/" + type);
        }
    }
</script>
