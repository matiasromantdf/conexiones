import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Consultas from '../views/ConsultasView.vue'
import NuevoTramite from '../views/NuevoTramiteView.vue'
import Inspecciones from '../views/InspeccionesView.vue'
import inspeccion from '../views/InspeccionView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path:'/consultas',
      name:'consultas',
      component:Consultas,
    },
    {
      path:'/nuevo-tramite',
      name:'nuevo-tramite',
      component:NuevoTramite,
    },
    {
      path:'/inspecciones',
      name:'inspecciones',
      component:Inspecciones,
    },
    {
      path:'/inspeccion/:id',
      name:'inspeccion',
      component:inspeccion,
    }
   
  ]
})

export default router
