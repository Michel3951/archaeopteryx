<template>
    <div class="container">

    </div>
</template>

<script>
    export default {
        name: 'Name',
        props: ['old', 'errors'],
        data: () => ({
            csrf: null,
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
