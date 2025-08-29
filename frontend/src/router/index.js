import { createRouter, createWebHistory } from 'vue-router'
import ArticlesList from '../views/ArticlesList.vue'
import CreateArticle from "../views/CreateArticle.vue";
import ArticleDetail from "../views/ArticleDetail.vue";
import ArticleEdit from "../views/ArticleEdit.vue";


const routes = [
    { path: '/', name: 'ArticlesList', component: ArticlesList },
    { path: '/articles/new', name: 'CreateArticle', component: CreateArticle },
    { path: '/articles/:id', name: 'ArticleDetail', component: ArticleDetail },
    { path: '/articles/:id/edit', name: 'ArticleEdit', component: ArticleEdit },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'text-indigo-300',
    linkExactActiveClass: 'text-indigo-400',
})

export default router
