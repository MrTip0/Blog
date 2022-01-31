<template>
    <div class="container">
        <router-link v-for="post in posts" :key="post.link" class="card" :to="'/post/' + post.link">
            <img :src="post.cover" :alt="post.title" class="card-img-top">
            <div class="card-img-overlay">
                <h1 class="card-title">{{post.title}}</h1>
                <p class="card-text">{{post.description}}</p>
            </div>
        </router-link>
        <div :class="'alert alert-error alert-dismissible fixed-bottom fade' + (showerr?'show':'')" role="alert">
            <h4 class="alert-heading">Error!</h4>
            <p>{{alertmex}}</p>
            <button type="button" class="btn-close" @click="showerr = false" aria-label="Close"></button>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { ref, reactive } from "vue";
    import { RouterLink } from "vue-router";
    let posts = reactive<any[]>([])
    let alertmex = ref("");
    let showerr = ref(false);

    fetch("/postapi/getposts.php")
        .then(res => res.json())
        .then(res => {
            posts = res
        })
        .catch(err => {
            alertmex.value = err
            showerr.value = true
        })
</script>

<style scoped>
    .card {
        width: 450px;
    }
</style>