import { createRouter, createWebHistory } from 'vue-router'
import Main from '../views/Main.vue';
import Catalog from '../views/Catalog.vue';
import Item from '../views/Item.vue';
import Registration from '../views/Registration.vue';
import Authorization from '../views/Authorization.vue';
import Profile from '../views/Profile.vue';

const routes = [
    {
        path: '/',
        name: 'Main',
        component: Main
    },
    {
        path: '/catalog/:category?/:type?',
        name: 'Catalog',
        component: Catalog,
        props: true,
    },
    {
        path: '/catalog/item',
        name: 'Item',
        component: Item
    },
    {
        path: '/registration',
        name: 'Registration',
        component: Registration
    },
    {
        path: '/authorization',
        name: 'Authorization',
        component: Authorization
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile
    },
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router
