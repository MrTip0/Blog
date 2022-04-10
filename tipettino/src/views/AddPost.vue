<template>
    <div class="page-hero d-flex justify-content-center">
        <div class="d-flex flex-column align-items-center w-100 ml-4 page">
            <uploader 
                v-if="upload"
                @uploaded="(value: string) => {
                    images.push(value)
                    upload = false
                }" />
            <ul class="list-group list-group-horizontal">
                <button class="list-group-item" 
                        v-for="image in images"
                        :key=image
                        @click="navigator.clipboard.writeText(image)">
                    <img :src="image" width="300">
                </button>
            </ul>
            <button class="btn btn-secondary p-3" @click="upload = !upload">Post image</button>

            <div class="input-group p-3">
                <input class="form-control" type="text" v-model="title" placeholder="title">
            </div>
            <div class="input-group p-3">
                <input class="form-control" type="text" v-model="description" placeholder="description">
            </div>
            <div class="input-group p-3">
                <input class="form-control" type="text" v-model="cover" placeholder="cover url">
            </div>
            <div class="input-group p-3">
                <textarea class="form-control" v-model="body" @input="updatePreview()"></textarea>
            </div>
            <button class="btn btn-secondary p-3" @click="sendPost()">Invia</button>
        </div>
        <div v-html="preview" class="page md"/>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import Uploader from "../components/Uploader.vue";
const markdown = import('markdown-it');

import markdown_highlight from 'markdown-it-highlightjs';
///@ts-ignore
import markdown_attribution from 'markdown-it-attribution';
///@ts-ignore
import markdown_mark from 'markdown-it-mark';

export default defineComponent({
    components: {
        Uploader
    },
    data(){
        let list: Array<string> = []

        return {
            title: "",
            description: "",
            rendered: "",
            images: list,
            upload: false,
            cover: "",
            body: "",
            preview: ""
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
    methods: {
        sendPost() {
            fetch('/postapi/addpost.php', {
                method: 'POST',
                body: JSON.stringify({
                    title: this.title,
                    description: this.description,
                    cover: this.cover,
                    body: this.body
                })
            }).then(res => res.json())
            .then(res => {
                if(res.result == "success") {
                    window.location.pathname = "/"
                } else {
                    alert('error')
                }
            }).catch(err => {
                console.error(err)
            })
        },
        async updatePreview() {
            let md = await this.md;
            this.preview = md.render(this.body)
        }
    }
})
</script>

<style>
    .page {
        max-width: 45vw;
    }
    .md blockquote {
        background-color: white;
        padding: 1rem;
        border-left: 10px solid #808080;
    }
</style>