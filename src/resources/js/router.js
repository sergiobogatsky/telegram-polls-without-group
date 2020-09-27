import VueRouter from 'vue-router'
// Pages
import Index from './pages/Index'
import Create from './pages/Create'
import Show from './pages/Show'

// Routes
const routes = [
    {
        path: '/polls',
        name: 'Index',
        component: Index,
        meta: {
            auth: false
        }
    },
    {
        path: '/polls/create',
        name: 'Create',
        component: Create,
        meta: {
            auth: false
        }
    },
    {
        path: '/polls/show/:id',
        name: 'Show',
        component: Show,
        meta: {
            auth: false
        },
        props: true
    },
]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router
