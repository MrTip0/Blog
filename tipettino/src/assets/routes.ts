import { createRouter, createWebHistory } from "vue-router";

const Login = ()=> import('../views/Login.vue')
const AboutMe = ()=> import('../views/AboutMe.vue')
const Post = ()=> import('../views/Post.vue')
const Posts = ()=> import('../views/Posts.vue')
const Index = ()=> import('../views/Index.vue')
const AddPost = ()=> import('../views/AddPost.vue')
const Register = ()=> import('../views/Register.vue')

const routes = [
    { path: "/", component: Index },
    { path: "/index", component: Index },
    { path: "/about", component: AboutMe },
    { path: "/post/:link", component: Post },
    { path: "/posts", component: Posts },
    { path: "/login", component: Login },
    { path: "/addpost", component: AddPost },
    { path: "/register", component: Register },
]

export default createRouter({
    history: createWebHistory(),
    routes
})