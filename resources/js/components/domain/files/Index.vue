<template>
    <div class="container-fluid">
        <h1 class="mb-3">File manager for {{ domain.domain }}</h1>

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
    </div>
</template>

<script>
    export default {
        name: 'Index',
        props: ['domain', 'files', 'path'],
        data: () => ({
            csrf: null,
        }),
        methods: {
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
                let path = this.path.replace(/\/[.a-zA-Z-_0-9]+$/, '');
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
