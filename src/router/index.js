import IndexView from '../views/Index.vue'
import PostView from '../views/Post.vue'

const routes = [
    { path: '/', component: IndexView },
    { path: '/post/:id', name: 'Post', component: PostView },
]

export default routes;