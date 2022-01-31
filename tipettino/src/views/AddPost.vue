<template>
    <div class="d-flex flex-column justify-content-center p-5">
        <uploader 
            v-if="upload"
            @uploaded="(value) => {
                images.push({name: value.name, url: file.url})
                upload.value = false
            }" />
        <ul class="list-group list-group-horizontal">
            <button class="list-group-item" 
                    v-for="image in images"
                    :key=image.name
                    @click="navigator.clipboard.writeText(image.url)">
                <img :src="image.url">
                <p>{{image.name}}</p>
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
            <textarea class="form-control" v-model="body"></textarea>
        </div>
        <button class="btn btn-secondary p-3" @click="sendPost()">Invia</button>
    </div>
</template>

<script setup>
    import Uploader from "../components/Uploader.vue";
    import { reactive, ref } from "vue";

    let images = reactive([])
    let upload = ref(false);
    
    let title = ""
    let description = ""
    let cover = ""
    let body = ""

    function sendPost() {
        fetch('/postapi/addpost.php', {
            method: 'POST',
            body: JSON.stringify({
                title,
                description,
                cover,
                body
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
    }
</script>