const $ = require('jquery')
// import Vue from '../node_modules/vue/dist/vue.js'
import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueRouter from 'vue-router'
import index from "./vue/index.vue"
import login from "./vue/login.vue"
import main from "./vue/main.vue"
import boss from "./vue/boss.vue"
import free from "./vue/free.vue"
import detail from "./vue/detail.vue"
import chat from "./vue/chat.vue"
import order from "./vue/order.vue"
import forget from "./vue/forget.vue"
import back from "./vue/back.vue"
import test from "./vue/test.vue"
import mboss from "./vue/mobile/mboss.vue"
import mfree from "./vue/mobile/mfree.vue"
import mchat from "./vue/mobile/mchat.vue"
import mdetail from "./vue/mobile/mdetail.vue"
import resume from "./vue/resume.vue"
import display from "./vue/dispalymodel/displaymodel.vue"
import common from './js/gobal'
import newmessage from './js/newmsg'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
// import 'lib-flexible'


Vue.prototype.$common = common;
Vue.prototype.$newmessage = newmessage;
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
const router = new VueRouter({
  routes: [
    // {path: '/', component: Category},
    {path: '/login', component: login},
    {path:'/main',component:main},
    {path:'/boss',component:boss},
    {path:'/free',component:free},
    {path:'/detail',component:detail},
    {path:'/chat',component:chat},
    {path:'/order',component:order},
    {path:'/forget',component:forget},
    {path:'/back',component:back},
    {path:'/test',component:test},
    {path:'/resume',component:resume},
    {path:'/mboss',component:mboss},
    {path:'/mfree',component:mfree},
    {path:'/mchat',component:mchat},
    {path:'/mdetail',component:mdetail},
    {path:'/display',component:display}
    // display
   
  ]
})
/*被这个坑了几个小时*/
router.beforeEach((to, from, next) => {
        if(!(window.sessionStorage['vue-session-key'])){
          // console.log(1)
          if(to.path === '/login'){
              next();
            }else{
              // console.log(to.query)
              if(Object.keys(to.query).length != 0 ){
                // console.log(to.query)
                if(to.query['Activecode']!=null){
                    next({
                    path: '/login',query: { Activecode: to.query['Activecode']}
                    });
                }else if(to.query['resetcode']!=null){
                  next({
                    path: '/login',query: { resetcode: to.query['resetcode']}
                  });
                }
                  
              }else{
                  next({
                    path: '/login'
                  });
              }
            
               
            }
         
        }else{
          next()
        }

       
      
     
 }
 )
var app = new Vue({
  el: '#app',
  
  router,
  render: function (createElement) {
    return createElement(index)
	}

})

// console.log(Vue)