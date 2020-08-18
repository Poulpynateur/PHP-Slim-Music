import VueRouter from 'vue-router';
import App from "./views/App";

const routes = [
    {path: '/', name: 'welcome', component: App, redirect: null}
]

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
  })
  
  export default router;