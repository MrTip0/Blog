<template>
    <div>
        <div class="page-hero d-flex align-items-center justify-content-center">
            <form @submit.prevent="sendlogin()" class="w-50">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" v-model="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" v-model="password">
                </div>
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-secondary" value="Log in"/>
                    <button class="btn btn-outline-danger">Forgot password</button>
                </div>
            </form>
        </div>
        <div :class="'alert alert-error alert-dismissible fixed-bottom fade' + (showerr?'show':'')" role="alert">
            <h4 class="alert-heading">Error!</h4>
            <p>{{alertmex}}</p>
            <button type="button" class="btn-close" @click="showerr = false" aria-label="Close"></button>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { ref } from "vue";
    let username = ref("")
    let password = ref("")
    let alertmex = ref("")
    let showerr = ref(false)
    function sendlogin(){
        fetch('/accounts/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                user: username.value,
                pass: password.value
            }),
        })
        .then(res => res.json())
        .then(res => {
            if(res.result == "success") {
                window.location.pathname = "/"
            } else {
                alertmex.value = res.reason
                showerr.value = true
            }
        })
        .catch(err => {
            alertmex.value = err
            showerr.value = true
        })
    }
</script>