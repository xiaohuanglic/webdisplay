<template>
	<div class='all'>
		<div class='head'>
      <ul><li @click="returnmain" >主页</li></ul>  
    </div>
		<div class='middle'>
      <div class='left setdisplaytrue'>
        <div id="displaylist"></div>
      </div>
			<div class='right setdisplay'>
        <div id="displaycontent setdisplay"></div>
      </div>
      <div @click="changedisplayflag">返回</div>
		</div>
		<!-- <div class='tail'>尾部</div> -->
	</div>
</template>
<script>
import axios from "axios";
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
// props: ['pageTimer']
export default {
  data() {
      return {
      //   time1:null,
      //   time2:null,
       displayflag:true,
        pageTimer:[],
      }
    },
      watch:{
                  // 能够触发
      displayflag:function(val){
                  console.log(val)
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
      // mounted: function () {
      //    console.log(this)

      //   },

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
            p.setAttribute('id','displaycontent')
            parent.appendChild(p)
           
             
              
          },
            clearleft(e){
            var parent = e.$root.$el.getElementsByClassName("left")[0]
            var childs = e.$root.$el.getElementsByClassName("left")[0].childNodes
            for(var i = 0; i < childs.length; i++) { 
                parent.removeChild(childs[i]);
              }
              
            let p = document.createElement('div');
            p.setAttribute('id','displaylist')
            parent.appendChild(p)
           
             
              
          },
          returnmain(){
             console.log(this.$common)
            for(var each in this.$common){
              for(var i =0;i<this.$common[each].length;i++){
                   clearInterval(this.$common[each][i]);
              }
                   
            }
           
             this.$router.push({path: '/main'})
          }
      }

    }
</script>
</script>
<style scoped>
	.all{
		width:100%;
	 margin: 0 auto; 
    	/*margin-right: auto;*/
	}
	.head{
    background-color: pink;
    width:100%;
    height:50px;
     margin: 0 auto;
   
  }
  .middle{
  	background-color: yellow;
    width:100%;
    height:700px;
     margin: 0 auto;
  }

  .left{
   
    /*margin-left: 50px;*/
    /*margin: auto; */
    height: 100%;
    width: 100%;
    background-color: #a5b1b5;
    
    /*box-shadow: 5px 2px 2px black;*/
  }
  .right{
   
    height: 100%;
    width: 100%;
    background-color: #b4c1c5;
    box-shadow: 5px 2px 2px black;
  }
  

  li{
    list-style-type:none
  }
/*  img{
    width:150px;
    height:150px
  }*/
  .setdisplay{
    display: none;
  }
  .setdisplaytrue{
    display: block;
  }
</style>