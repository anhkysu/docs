import Vue from 'vue'
import Router from 'vue-router'
import TranslateAction from '../components/translate/template/partials/TranslateAction';
import ToTranslateList from '../components/translate/template/partials/ToTranslateList';

Vue.use(Router)

export default new Router({
    linkActiveClass: "active",    
    routes: [
        {
            path: '/danh-sach-phien-dich',
            name: 'translateListPage',
            component: ToTranslateList
        },
        {
            path: '/phien-dich/:dataId',
            name: 'translateActionPage',
            component: TranslateAction
        },
        {
            path: '',
            redirect: {name: 'translateListPage'}
        },
    ]
})