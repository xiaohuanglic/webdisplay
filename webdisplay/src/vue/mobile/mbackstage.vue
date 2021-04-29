<template>
	<div>
	   <div class='head'>
        <b-navbar toggleable="lg" type="dark" variant="info">
        <!-- <b-navbar-brand href="#">NavBar</b-navbar-brand> -->

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav>
          <b-nav-item @click=jumpMain()>主页面</b-nav-item>
          <b-nav-item @click=jumpBoss()>boss</b-nav-item>
          <b-nav-item @click=jumpFree()>free</b-nav-item>
          <b-nav-item @click=jumpChat()>消息<span v-if="shownewmsg">(new)</span></b-nav-item>
          <b-nav-item @click=exit()>退出</b-nav-item>
          </b-navbar-nav>
           <b-navbar-nav class="ml-auto">
      <!--   <b-nav-form>
          <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
          <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
        </b-nav-form>
 -->
      
      </b-navbar-nav>
       </b-collapse>
      </b-navbar> 
     </div>
     <div class="middle clearfix">
        <div class='left setdisplaytrue'>
          <div id='addleft'></div>
        </div>
        <div class='right setdisplay'>
          <div id='addright'></div>
          
        </div>
        <div @click="changedisplayflag">返回</div>
     </div>
      <div class="tail"></div>
    
	</div>
</template>
<script>
import axios from "axios";
import url from "../../js/totalurl.js";
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
    // props['displayflag']
  data: function () {
                  return {
                      displayflag:true,
                     
                  }
                },
     watch:{
                  // 能够触发
      displayflag:function(val){
                  var getleft = document.getElementsByClassName("left");
                  var getright = document.getElementsByClassName("right");
                         if(val==true){
                          getleft[0].setAttribute("class","left setdisplaytrue")
                          getright[0].setAttribute("class","right setdisplay")
                         }else{
                           
                          getright[0].setAttribute("class","right setdisplaytrue")
                          getleft[0].setAttribute("class","left setdisplay")
                         }
                   
                    }
                },
    methods:{
          changedisplayflag(){
           
            this.displayflag = true;
            
          },
          clearright(e){
            var parent = e.$root.$el.getElementsByClassName("right")[0]
            var childs = e.$root.$el.getElementsByClassName("right")[0].childNodes
            for(var i = 0; i < childs.length; i++) { 
                parent.removeChild(childs[i]);
              }
              
            let p = document.createElement('div');
            p.setAttribute('id','addright')
            parent.appendChild(p)
           
             
              
          },
                 jumpMain(){
         
               this.$router.push({path: '/main'})
          
        
      },
          jumpChat(){
          if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                this.$router.push({path: '/mchat'})
          } else {
               this.$router.push({path: '/chat'})
          }
        
      },
            exit(){
          for(var each in this.$common){
              for(var i =0;i<this.$common[each].length;i++){
                   clearInterval(this.$common[each][i]);
              }
                   
            }
            sessionStorage.clear();
            localStorage.clear();
            this.$router.push({path: '/login'})


      },
          jumpBoss(){
          if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                   this.$router.push({path: '/mboss'})
          } else {
               this.$router.push({path: '/boss'})
          }

          
        },
        jumpFree(){
             if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                   this.$router.push({path: '/mfree'})
          } else {
               this.$router.push({path: '/free'})
          }
          // this.$router.push({path: '/free'})
        },
      }

    }
</script>
<style scoped>
    .clearfix:after{
  content: "020"; 
  display: block; 
  height: 0; 
  clear: both; 
  visibility: hidden;  
  }

.clearfix {
  /* 触发 hasLayout */ 
  zoom: 1; 
  }
nav.navbar.navbar-dark.bg-info.navbar-expand-lg{
  z-index: 999;
}
 .head{
    background-color: coral;
    width:80%;
    height:50px;
    margin-left:auto;
    margin-right: auto;
  }
  .middle{
    margin-left:auto;
    margin-right: auto;
    width:80%;
    height:100%;
  }
  .left{
    
    width:100%;
    height:100%;
    background-color: #e3e8ec;

  }
 
  .right{
   
    width:100%;
    height:100%;
    background-color: lightgreen;

  }
  li{
    list-style-type:none
  }
  .setdisplay{
    display: none;
  }
  .setdisplaytrue{
    display: block;
  }
</style>