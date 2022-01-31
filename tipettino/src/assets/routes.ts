import { createRouter, createWebHistory } from "vue-router";

import Login from '../views/Login.vue'
import AboutMe from '../views/AboutMe.vue'
import Post from '../views/Post.vue'
import Posts from '../views/Posts.vue'
import Index from '../views/Index.vue'
import AddPost from '../views/AddPost.vue'

const routes = [
    { path: "/", component: Index },
    { path: "/index", component: Index },
    { path: "/about", component: AboutMe },
    { path: "/post/:link", component: Post },
    { path: "/posts", component: Posts },
    { path: "/login", component: Login },
    { path: "/addpost", component: AddPost },
]

export default createRouter({
    history: createWebHistory(),
    routes
})