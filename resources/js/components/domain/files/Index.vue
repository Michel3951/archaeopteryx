<template>
    <div class="container-fluid">
        <h1 class="mb-3">File manager for {{ domain.domain }}</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#create-file">Create file</button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#create-directory">Create directory</button>
        <table class="file-table mt-3">
            <thead>
            <tr>
                <th>Filename</th>
                <th style="min-width: 100px">Size</th>
                <th style="min-width: 80px">Date</th>
                <th>User</th>
                <th>Group</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="path !== '/'">
                <td colspan="5"><i class="fas fa-level-up-alt"></i> <a :href="'?path=' + up()">Level up</a></td>
            </tr>
            <tr v-for="(file, index) in files.files">
                <td v-if="file.type === 'dir'"><i class="fa fa-folder"></i> <a :href="'?path=' + formatPath(file.name)">{{
                    file.name }}</a></td>
                <td v-else><i class="fa fa-file"></i> <a :href="openFilePath(file.name)">{{ file.name }}</a></td>
                <td v-if="file.type === 'dir'"></td>
                <td v-else>{{ formatSize(file.size) }}</td>
                <td>{{ file.dateAsString }}</td>
                <td>{{ file.user }}</td>
                <td>{{ file.group }}</td>
            </tr>
            </tbody>
        </table>

        <div class="modal fade" id="create-file" tabindex="-1" role="dialog" aria-labelledby="create-file-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="create-file-label">Create new file</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="file[name]" id="filename" v-model="file.name" :class="{'is-invalid': !file.name}" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="createFile()">Create file</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="create-directory" tabindex="-1" role="dialog" aria-labelledby="create-directory-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="create-directory-label">Create new directory</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="directory[name]" id="filename" v-model="directory.name" :class="{'is-invalid': !directory.name}" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="createDirectory()">Create directory</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Index',
        props: ['domain', 'files', 'path'],
        data: () => ({
            csrf: null,
            file: {
                name: ''
            },
            directory: {
                name: ''
            }
        }),
        methods: {
            createFile: function () {
                console.log(this.file)
                fetch(`/domains/${this.domain.domain}/files/create?path=${this.path}&name=${this.file.name}`, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': this.csrf
                    },
                    body: JSON.stringify({
                        _token: this.csrf,
                        name: this.file.name,
                        type: 'file'
                    })
                })
                    .then(res => res.json())
                    .then(json => {
                        window.location = json.url
                    });
            },
            createDirectory: function() {
                fetch(`/domains/${this.domain.domain}/files/create?path=${this.path}&name=${this.file.name}`, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': this.csrf
                    },
                    body: JSON.stringify({
                        _token: this.csrf,
                        name: this.directory.name,
                        type: 'directory'
                    })
                })
                    .then(res => res.json())
                    .then(json => {
                        // window.location = json.url
                    });
            },
            formatPath: function (child) {
                let current = this.path;
                if (!current.endsWith('/')) {
                    current += '/';
                }
                return current + child;
            },
            openFilePath: function (file) {
                return `/domains/${this.domain.domain}/files/open?path=${this.path}&file=${file}`
            },
            up: function () {
                let path = this.path.replace(/\/[-_.a-zA-Z0-9]+$/, '');
                if (!path) return '/';
                return path;
            },
            formatSize: function (size) {
                if (size > 1048576) {
                    return `${(size / 1048576).toFixed(1)} mb`;
                } else if (size > 1048576) {
                    return `${(size / 1048576).toFixed(1)} mb`;
                } else if (size > 1024) {
                    return `${(size / 1024).toFixed(1)} kb`;
                } else {
                    return `${size.toFixed(1)} b`
                }
            }
        },
        mounted() {
            this.csrf = window.Laravel.csrfToken;
        }
    }
</script>
