<template>
  <nav class="navbar navbar-expand-md navbar-light bg-light mb-4 fixed-top">
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
        <a :class="defclass" href="/login">Login</a>
      </div>
    </div>
  </nav>
  <router-view style="margin-top:64px"/>
</template>

<script setup lang="ts">
  import { RouterView } from "vue-router";
  const defclass = "nav-link text-center";
  let about = window.location.pathname == "/about" ? defclass + " active" : defclass
  let posts = window.location.pathname == "/posts" ? defclass + " active" : defclass
  let projects = window.location.pathname == "/projects" ? defclass + " active" : defclass
</script>
