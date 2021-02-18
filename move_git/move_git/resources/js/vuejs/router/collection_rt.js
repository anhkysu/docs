/**
 * Created by macintosh on 23/1/20.
 */
import Vue from 'vue'
import Router from 'vue-router'
import CollectionAdd from '../components/collection/template/CollectionAdd.vue'
import CollectionList from '../components/collection/template/CollectionList.vue'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            redirect: '/list'
        },
        {
            path: '/list',
            name: 'collection-list',
            component: CollectionList
        },
        {
            path: '/add',
            name: 'collection-add',
            component: CollectionAdd
        }
    ]
})