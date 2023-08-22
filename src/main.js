import './assets/main.css'
import './assets/base.css'
import 'tailwindcss/tailwind.css'
import {createRouter, createWebHashHistory} from 'vue-router'
import routes from './router/index'

import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

const router = createRouter({
    history: createWebHashHistory(),
    routes: routes
})

import {createApp} from 'vue'
import App from './App.vue'

const app = createApp(App);

app.use(ElementPlus)
app.use(router).mount('#app')
