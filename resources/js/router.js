import Vue from 'vue'
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import CreateForm from './components/CreateForm.vue'
import ShowForm from './components/ShowForm.vue'
import ThankyouPage from './components/ThankyouPage.vue'
import ShowAnswers from './components/ShowAnswers.vue'

export default new VueRouter({
    mode: 'history',
    routes: [
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