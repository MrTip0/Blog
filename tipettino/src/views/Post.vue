<script lang="ts">
    import mark from 'markdown-it';
    import hljs from 'highlight.js';
    import { defineComponent } from 'vue'

export default defineComponent({
    data(){
        return {
            title: "",
            description: "",
            rendered: ""
        }
    },
    computed: {
        md:() => mark({
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
    },
    created() {
        fetch(`/postapi/getpost.php?link=${this.$route.params.link}`)
            .then(res => res.json())
            .then(res => {
                this.title = res.title
                this.description = res.description
                this.rendered = this.md.render(res.body)
            })
    }
})
</script>

<template>
    <div class="d-flex flex-column justify-content-center" v-if="title != ''">
        <p class="h1">{{title}}</p>
        <p class="h3">{{description}}</p>
        <div v-html="rendered"></div>
    </div>
</template>