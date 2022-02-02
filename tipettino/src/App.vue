<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-secondary mb-4 fixed-top">
      <div class="container-fluid justify-content-between">
        <a class="navbar-brand text-uppercase" href="/">
          <img src="./assets/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
          tipettino
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse navbar-nav-scroll" id="navbarScroll">
          <ul class="nav nav-pills nav-fill me-auto">
            <a :class="about" href="/about" id="about-link">About me</a>
            <a :class="posts" href="/posts" id="posts-link">Posts</a>
            <a :class="projects" href="/projects" id="projects-link">Projects</a>
          </ul>
          <a :class="defclass" href="/login" v-if="username==''">Login</a>
          <img :src="username" class="rounded-circle" v-else>
        </div>
      </div>
    </nav>
    <router-view class="routview"></router-view>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { RouterView } from "vue-router";
import gravatar from 'gravatar';

const defclass = "nav-link text-center";

export default defineComponent({
  components: {
    RouterView
  },
  data() {
    return {
      defclass: "nav-link text-center",
      username: ""
    }
  },
  computed: {
    about: ()=> window.location.pathname == "/about" ? defclass + " active" : defclass,
    posts: ()=> window.location.pathname == "/posts" ? defclass + " active" : defclass,
    projects: ()=> window.location.pathname == "/projects" ? defclass + " active" : defclass
  },
  beforeMount() {
    fetch('/accounts/whoami.php')
      .then(res => res.json())
      .then(res => {
        if (res.logged == true) {
          this.username = gravatar.url(res.user, {s: '40'})
        }
      })
      .catch(err => {
        console.error(err)
      })
  }
})
</script>

<style scoped>
  .routview {
    margin-top: 64px;
    margin: 64px;
  }
</style>