/**
 * Created by macintosh on 23/1/20.
 */
import Vue from 'vue';
import Router from 'vue-router';
import UserDashboardIndex from '../components/userdashboard/template/UserDashboardIndex.vue';
import QualityManagementIndex from '../components/qualitymanagement/template/QualityManagementIndex.vue';
import ProjectIndex from '../components/project/template/ProjectIndex.vue';
import TranslateIndex from '../components/translate/template/TranslateIndex.vue';
import TranslateAction from '../components/translate/template/partials/TranslateAction';
import ToTranslateList from '../components/translate/template/partials/ToTranslateList';
import Unauthorized from '../components/auth/template/Unauthorized.vue';

Vue.use(Router)

let router = new Router({
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/user-dashboard',
            name: 'userDashboard',
            component: UserDashboardIndex,
            meta: {
                requiresAuth: false
            }
        },
        {
            path: '/',
            redirect: 'quan-ly-du-an',
            meta: {
                requiresAuth: false,
                accessKey: 'projectManagement'
            }
        },
        {
            path: '/quan-ly-du-an/:projectId?/:tabName?/:paramValue1?/:paramValue2?',
            name: 'projectManagement',
            component: ProjectIndex,
            meta: {
                requiresAuth: false,
                accessKey: 'projectManagement'
            }
        },
        {
            path: '/bien-phien-dich',
            name: 'translate',
            component: TranslateIndex,
            redirect: '/bien-phien-dich/danh-sach-phien-dich',
            meta: {
                requiresAuth: false,
                accessKey: 'translation'
            },
            children: [
                {
                    path: '/bien-phien-dich/danh-sach-phien-dich',
                    name: 'translateListPage',
                    component: ToTranslateList,
                    meta: {
                        requiresAuth: false,
                        accessKey: 'translation'
                    }
                },
                {
                    path: '/bien-phien-dich/phien-dich/:dataId',
                    name: 'translateActionPage',
                    component: TranslateAction,
                    meta: {
                        requiresAuth: false,
                        accessKey: 'translation'
                    }
                }
            ]
        },
        {
            path: '/kiem-soat-chat-luong/:tabName?/:subtabName?/:paramValue?',
            name: 'qualityManagement',
            component: QualityManagementIndex,
            meta: {
                requiresAuth: false,
                accessKey: 'qualityControl'
            }
        },
        {
            path: '/khong-duoc-cap-quyen',
            name: 'unauthorized',
            component: Unauthorized
        },
    ]
});

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)){
        let {currentUserNavigationControl} = window;
        let isValid = to.matched.every(record => {
            let accessKey = record.meta.accessKey;
            if(!currentUserNavigationControl[accessKey]){
                return false;
            } else if(currentUserNavigationControl[accessKey] == "allow"){
                return true;
            } else {
                return false;
            }
        })
        if(isValid){
            next();
        } else {
            next({name: 'unauthorized'});
        }
    } else {
        next();
    }
})

export default router;