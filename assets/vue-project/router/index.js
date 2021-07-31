import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/map',
    component: () => import('../components/Map.vue')
  },
  {
    path: '/registration',
    component: () => import('../components/Registration.vue')
  },
  {
    path: '/',
    component: () => import('../components/VueEnter.vue') 
  },
  
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
