<template>
    <div class="page-hero d-flex align-items-center justify-content-center">
        <form class="w-50" @submit.prevent="sendForm()">
            <div class="mb-3">
                <label class="form-label" for="name">Name: </label>
                <input class="form-control" type="text" id="name" v-model="name" placeholder="Mario Rossi">
            </div>
            <div class="mb-3">
                <label class="form-label" for="username">Username(email): </label>
                <input class="form-control" type="email" id="username" v-model="username" placeholder="user@example.it">
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password: </label>
                <input class="form-control" type="password" id="password" v-model="password">
            </div>
            <div class="mb-3">
                <label class="form-label" for="confpassword">Confirm Password: </label>
                <input class="form-control" type="password" id="confpassword" v-model="confpassword">
            </div>
            <div class="mb-3">
                <input class="form-control btn btn-secondary w-100" type="submit" id="submit" value="Send">
            </div>
        </form>
    </div>
    <div :class="`alert alert-${alertreason} alert-dismissible fixed-bottom fade ${(alertmex != ''?'show':'')}`" role="alert">
        <h4 class="alert-heading">{{alertreason.toLocaleUpperCase()}}!</h4>
        <p>{{alertmex}}</p>
        <button type="button" class="btn-close" @click="alertmex = ''" aria-label="Close"></button>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    data() {
        return {
            username: "",
            name: "",
            password: "",
            confpassword: "",
            alertmex: "",
            alertreason: ""
        }
    },
    methods: {
        sendForm() {
            if (this.username != '' && this.name != '' && this.password != '' && this.password == this.confpassword) {
                fetch('/accounts/register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: this.username,
                        name: this.name,
                        password: this.password
                    })
                }).then(res => res.json())
                    .then(res => {
                        if (res.result == "success") {
                            this.alertreason = "success"
                        } else {
                            this.alertreason = "error"
                        }
                        this.alertmex = res.reason
                    })
            }
        }
    }
})
</script>

<style scoped>
    form {
        width: 80vw;
        max-width: 800px;
        margin-top: 64px;
    }
</style>