<script lang="ts">
import { defineComponent } from 'vue';
const markdown = import('markdown-it');

import markdown_highlight from 'markdown-it-highlightjs';
///@ts-ignore
import markdown_attribution from 'markdown-it-attribution';
///@ts-ignore
import markdown_mark from 'markdown-it-mark';

export default defineComponent({
    data(){
        return {
            title: "",
            description: "",
            rendered: ""
        }
    },
    computed: {
        md: async() => {
            let markc = await markdown;
            let mark = markc.default({
                html: true,
                linkify: true,
                typographer: true,
                breaks: true
            })
            mark.use(markdown_mark)
            mark.use(markdown_highlight)
            mark.use(markdown_attribution)
            return mark
        }
    },
    created() {
        fetch(`/postapi/getpost.php?link=${this.$route.params.link}`)
            .then(res => res.json())
            .then(async (res) => {
                this.title = res.title
                this.description = res.description
                let md = await this.md
                this.rendered = md.render(res.body)
            })
    }
})
</script>

<template>
    <div class="d-flex flex-column align-items-center fixed-left" v-if="title != ''">
        <div class="body bg-secondary rounded p-3">
            <p class="h1 text-center">{{title}}</p>
            <p class="h3 text-center">{{description}}</p>
            <div v-html="rendered" class="md-rendered"></div>
        </div>
    </div>
</template>

<style>
    .body {
        width: 80vw;
        max-width: 800px;
    }
    .md-rendered blockquote {
        background-color: white;
        padding: 1rem;
        border-left: 10px solid #808080;
    }
</style>