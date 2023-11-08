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

import {createApp, ref} from 'vue'
import App from './App.vue'
import mitt from 'mitt'

const app = createApp(App);

// 创建一个应用级的事件总线
const bus = mitt()
app.config.globalProperties.$bus = bus;

app.use(ElementPlus)
app.use(router).mount('#app')
