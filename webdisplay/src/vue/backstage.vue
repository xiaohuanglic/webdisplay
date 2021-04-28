<template>
	<div>
	   <div class='head'>头</div>
     <div class="middle clearfix">
        <div class='left '>
          <div id='addleft'></div>
        </div>
        <div class='right '>
          <div id='addright'></div>
        </div>
     </div>
      <div class="tail"></div>
    
	</div>
</template>
<script>
import axios from "axios";
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
    methods:{
          clearright(e){
            var parent = e.$root.$el.getElementsByClassName("right")[0]
            var childs = e.$root.$el.getElementsByClassName("right")[0].childNodes
            for(var i = 0; i < childs.length; i++) { 
                parent.removeChild(childs[i]);
              }
              
            let p = document.createElement('div');
            p.setAttribute('id','addright')
            parent.appendChild(p)
           
             
              
          }
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
    float:left;
    width:20%;
    height:2500px;
    background-color: #e3e8ec;

  }
 
  .right{
   
    width:80%;
    float: left;
    height:2500px;
    background-color: lightgreen;

  }
  li{
    list-style-type:none
  }
</style>