import VueRouter from 'vue-router'
import AboutPage from '@/views/About.vue'
import ProjectsPage from '@/views/Projects.vue'
import ProjectPage from '@/views/Project.vue'
import NotFoundPage from '@/views/NotFound.vue'
import ProjectUpload from "@/views/ProjectUpload";
import Impressum from "@/views/Impressum";
import Datenschutz from "@/views/Datenschutz";

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', redirect: '/projects'},
        { path: '/projects', component: ProjectsPage},
        { path: '/project/:id', component: ProjectPage, name: 'Project', props: true},
        { path: '/about', component: AboutPage},
        { path: '/upload', component: ProjectUpload},
        { path: '/impressum', component: Impressum},
        { path: '/datenschutz', component: Datenschutz},
        { path: '/*', component: NotFoundPage},
    ]
})
export default router;