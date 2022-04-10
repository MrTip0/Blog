import { createApp } from 'vue'
import '../scss/custom.scss'
import 'highlight.js/styles/github.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import routes from './assets/routes'
import App from './App.vue'

createApp(App)
    .use(routes)
    .mount('#app')
