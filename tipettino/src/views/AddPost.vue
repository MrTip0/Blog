<template>
    <div class="d-flex flex-column justify-content-center p-5 vw-100">
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
                <img :src="image">
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

        <div v-html="preview" />
    </div>
</template>

<script lang="ts">
    import Uploader from "../components/Uploader.vue";
    import mark from 'markdown-it';
    import hljs from 'highlight.js';
    import { defineComponent } from 'vue'

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
        updatePreview() {
            this.preview = this.md.render(this.body)
        }
    }
})
</script>