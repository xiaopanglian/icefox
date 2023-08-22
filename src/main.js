import './assets/main.css'
import './assets/base.css'
import 'tailwindcss/tailwind.css'
import {createRouter, createWebHashHistory} from 'vue-router'
import routes from './router/index'

const router = createRouter({
    history: createWebHashHistory(),
    routes: routes
})

import {createApp} from 'vue'
import App from './App.vue'

createApp(App).use(router).mount('#app')
