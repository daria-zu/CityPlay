import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/registration',
    component: () => import('../components/Registration.vue')
  },
  {
    path: '/',
    component: () => import('../components/Main.vue') 
  },
  
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
