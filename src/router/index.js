import IndexView from '../views/Index.vue'
import PostView from '../views/Post.vue'

const routes = [
    {path: '/', component: IndexView},
    {path: '/archive', component: PostView},
]

export default routes;