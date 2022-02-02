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

<script lang="ts">
    import { defineComponent } from "vue";
    import { RouterLink } from "vue-router";

export default defineComponent({
    components: {
        RouterLink
    },
    data() {
        type post = {
            cover: string,
            link: string,
            title: string,
            description: string
        }
        let arrpost: post[] = []
        return {
            posts: arrpost,
            alertmex: "",
            showerr: false
        }
    },
    beforeMount() {
        fetch("/postapi/getposts.php")
            .then(res => res.json())
            .then(res => {
                this.posts = res
            })
            .catch(err => {
                this.alertmex = err
                this.showerr = true
            })
    }
})
</script>

<style scoped>
    .card {
        max-width: 450px;
        max-height: 300px;
    }
    img {
        max-width: 450px;
        max-height: 300px;
    }
</style>