import VueRouter from 'vue-router'
import AboutPage from '@/views/About.vue'
import HomePage from '@/views/Home.vue'
import NotFoundPage from '@/views/NotFound.vue'
import FileUpload from "@/views/FileUpload";

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: HomePage},
        { path: '/about', component: AboutPage},
        { path: '/upload', component: FileUpload},
        { path: '/*', component: NotFoundPage},
    ]
})


export default router;