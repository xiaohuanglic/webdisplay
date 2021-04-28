<template>
	<div class='all'>
		<div class='head'>头部</div>
		<div class='middle'>
			<div id='change'></div>
		</div>
		<div class='tail'>尾部</div>
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
</script>
<style scoped>
	.all{
		width:90%;
		margin-left:auto;
    	margin-right: auto;
	}
	.head{
    background-color: coral;
    width:90%;
    height:50px;
   
  }
  .middle{
  	background-color: #cce0f0;
    width:90%;
    /*height:700px;*/
  }

  li{
    list-style-type:none
  }
 /* img{
    width:150px;
    height:150px
  }*/
</style>