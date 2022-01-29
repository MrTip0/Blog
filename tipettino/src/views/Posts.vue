<template>
    <div class="container">
        <router-link v-for="post in posts" :key="post.link" class="card" :to="'/post/' + post.link">
            <img :src="post.cover" :alt="post.title" class="card-img-top">
            <div class="card-img-overlay">
                <h1 class="card-title">{{post.title}}</h1>
                <p class="card-text">{{post.description}}</p>
            </div>
        </router-link>
    </div>
</template>

<script setup lang="ts">
    import { ref } from "vue";
    import { RouterLink } from "vue-router";
    let posts = ref<any[]>([])
    fetch("/postapi/getposts.php")
        .then(res => res.json())
        .then(res => {
            posts = res
        })
</script>

<style scoped>
    .card {
        width: 450px;
    }
</style>