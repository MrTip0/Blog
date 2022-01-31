<template>
    <div class="d-flex flex-column justify-content-center" v-if="title != ''">
        <p class="h1">{{title}}</p>
        <p class="h3">{{description}}</p>
        <p>{{rendered}}</p>
    </div>
</template>

<script setup>
    import { ref } from "vue";
    import mark from 'markdown-it';
    import hljs from 'highlight.js';

    let md = mark({
        html: true,
        linkify: true,
        typographer: true,
        highlight: function (str, lang) {
            if (lang && hljs.getLanguage(lang)) {
            try {
                return hljs.highlight(str, { language: lang }).value;
            } catch (__) {}
            }

            return '';
        }
    })

    let title = ref("")
    let description = ref("")
    let rendered = ref("")
    let link = this.$route.params.link

    fetch(`/postapi/getpost?link=${link}`)
        .then(res => res.json())
        .then(res => {
            title.value = res.title
            description.value = res.description
            rendered.value = md.render(res.body)
        })
</script>