import Vue from 'vue'
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import CreateForm from './components/CreateForm.vue'
import ShowForm from './components/ShowForm.vue'
import ThankyouPage from './components/ThankyouPage.vue'
import ShowAnswers from './components/ShowAnswers.vue'
import DeletePage from './components/DeletePage.vue'
import Information from './components/Information.vue'
import Index from './components/home/Index.vue'
import ErrorPage from './components/ErrorPage.vue'

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Index
        },
        {
            path: '/error',
            name: 'error',
            component: ErrorPage
        },
        {
            path: '/form/create',
            name: 'form.create',
            component: CreateForm
        },
        {
            path: '/form/thankyou',
            name: 'form.thankyou',
            component: ThankyouPage
        },
        {
            path: '/form/info/:formKey/:answerKey',
            name: 'form.information',
            component: Information
        },
        {
            path: '/form/delete/',
            name: 'form.delete',
            component: DeletePage
        },
        {
            path: '/form/:key',
            name: 'form.show',
            component: ShowForm
        },
        {
            path: '/answers/:key',
            name: 'answer.show',
            component: ShowAnswers
        },
    ]
})