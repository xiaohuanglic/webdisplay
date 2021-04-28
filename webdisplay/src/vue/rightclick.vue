<template>
	<div>
  <!--   <div v-rightClick = "{getrightMenuObj}">
      测试
    </div> -->
     <div
      id="rightMenuDom"
      class="right-menu"
      :style="{
        display: rightMenuStatus,
        top: rightMenuTop,
        left: rightMenuLeft
      }"
    >
      <ul class="rightul">
        <!--分为2组渲染-->
        <li class="rightli">
          <span
            v-for="item in rightMenuList"
            :key="item.id"
            v-show="item.id <= 3"
            @click="item.handler"
            class="rightspan">{{ item.text }}
          </span>
        </li>
      
      </ul>
    </div>
  </div>
  </div>
  </div>
</template>
<script>
import Vue from 'vue'
import axios from "axios";
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
Vue.directive('rightClick',{
    // // 指令的定义        
        bind(el, binding, vnode) {
         
          var list  = [];
          var rightMenuObj ={}
          el.addEventListener('contextmenu', function (ev) {
              ev.preventDefault();
              const oX = ev.clientX+"px";
              const oY = ev.clientY+"px";           
              const e = ev
              binding.value.getrightMenuObj(oY,oX,e)     

          }, false);         
          
                                             
                     
          }
})

export default {
  data() {
      return{
            rightMenuStatus:"none",
            rightMenuTop:"0px",
            rightMenuLeft:"0px",
            rightMenuList:[],
            rightMenuObj: {
            text: [
              "删除图片",
              
            ],
            handler: {
              // deletepicture(ev) {
              //   console.log("删除图片");
              // },
              
            }
          }

           
          
        }
        
      },
  mounted() {
    // 监听全局点击事件
    // document.addEventListener("click", (e) => {
    //   // 隐藏右键菜单
    //   e.preventDefault();
    //   this.rightMenuStatus="none"
   
    //   this.rightMenuTop= "0px"

    //   this.rightMenuLeft = "0px"
 
    // });
  },
  // Vue.directive('focus', {})

   
  methods:{
      getrightMenuObj(rightMenuTop,rightMenuLeft,e){
            // console.log(e);
            this.setrightMenuStatus();
            this.setrightMenuTop(rightMenuTop);
            this.setrightMenuLeft(rightMenuLeft);
            const handlerArray = [];
            const menuList = [];
           var rightMenuObj=this.rightMenuObj;
            for (const key in rightMenuObj.handler) {
                handlerArray.push(rightMenuObj.handler[key]);
            }
            for (let i = 0; i < rightMenuObj.text.length; i++) {
      // 右键菜单对象, 添加名称
                const menuObj = {
                text: rightMenuObj.text[i],
                handler: handlerArray[i],
                    id: i + 1
                };
              menuList.push(menuObj);
            }
            // console.log(menuList)
            this.setrightMenuList(menuList)
            // return rightMenuObj;
        },
           
      setrightMenuStatus(){
       this.rightMenuStatus="block"
       // console.log(rightMenuStatus)

      },    
      setrightMenuTop(rightMenuTop){
       this.rightMenuTop=rightMenuTop
      },
      setrightMenuLeft(rightMenuLeft){
       this.rightMenuLeft=rightMenuLeft
      },
      setrightMenuList(rightMenuList){
       this.rightMenuList=rightMenuList
      }                    
      }
  }

    
</script>
<style scoped>
  .right-menu {
    position: fixed;
    left: 0;
    top: 0;
    width: 166px;
    height: auto;
    background-color: rgb(242, 242, 242);
    border: solid 1px #C2C1C2;
    box-shadow: 0 10px 10px #C2C1C2;
    display: none;
    border-radius: 5px;
  }
  .rightul {
      padding: 0;
      margin: 0;
      font-size: 15px;
  }
  .rightli {
        list-style: none;
        box-sizing: border-box;
        padding: 6px 0;
        border-bottom: 1px solid rgb(216, 216, 217);
  }
  .rightspan{
      display: block;
          height: 20px;
          line-height: 20px;
          padding-left: 16px;
          border-bottom:solid 1px;
         /* border-width:1px;*/
          &:hover {
            background-color: #0070F5;
            cursor: pointer;
            color: #FFFFFF;
          }
  }
</style>