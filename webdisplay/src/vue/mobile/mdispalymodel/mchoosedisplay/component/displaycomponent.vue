<template>
	<div >
	  <p  >显示组件</p>
    <div class="display2component" v-drag="dragevent" :positionX="positionX" :positionY="positionY">
      <div><div class="changsize"><span class="leftsize" v-leftpull="leftpullevent"></span><span class="rightsize"></span><span class="upsize"></span><span class="downsize"></span><span class="equalsize"></span><img :src="displaylist.avatar"></div></div>
      <ul><li @click="changfontsize">修改字体大小</li><li @click="changfontcolor">修改字体颜色</li><li @click="changsize">修改组件尺寸大小</li><li  @click="changborder">边框设置</li><li @click="changimg">背景设置</li></ul>
    </div>
	</div>

</template>
<script>
  // import displaycomponent from './component/displaycomponent.vue';
	export default{
	 props:['displaylist'],
  	data() {
      return {
        // displaylist: [],
        positionX:0,
        positionY:0,
        

      }
    },
    watch:{

    },
    directives:{
      drag:{
        update:function(el,binding,vnode){
          let odiv = el;
          let positionX = el.attributes['positionX'].value
          let positionY = el.attributes['positionY'].value;
          let left = 0;
          let top = 0;
          el.onmousedown = (e)=>{
             
                  //鼠标按下并移动的事件
           
                  let disX = e.pageX-positionX;
                  let disY = e.pageY-positionY;
          
                 document.onmousemove = (e)=>{
                        
                        left = e.pageX-disX ;    
                        top =  e.pageY-disY;
                
                        odiv.style.left = left + 'px';
                        odiv.style.top = top + 'px';
                    };
                    document.onmouseup = (e) => {
                        document.onmousemove = null;
                        document.onmouseup = null;
                        binding.value(left,top);

                    };
              
            };
          


        }
      },
      leftpull:{
        update:function(el,binding,vnode){
          let odiv = el;
        
          let dowmx = 0;
           
          el.onmousedown = (e)=>{
                  binding.value(true);
                  dowmx = e.pageX;
                  document.onmousemove = (e)=>{
                        var ele = document.getElementsByClassName("changsize")[0];
                        var left = e.pageX-dowmx ;

                        let width = ele.childNodes[5].clientWidth;
                        width+=left;
                        ele.childNodes[5].style.width = width+'px';   
                        ele.style.width = width+'px';
                
                      
                    };
                  document.onmouseup = (e) => {
                        document.onmousemove = null;
                        document.onmouseup = null;
                        binding.value(false);

                    };
          
            };


        }
      },
      right:{
        update:function(el,binding,vnode){
          let odiv = el;
        
          let dowmx = 0;
           
          el.onmousedown = (e)=>{
                  binding.value(true);
                  dowmx = e.pageX;
                  document.onmousemove = (e)=>{
                        var ele = document.getElementsByClassName("changsize")[0];
                        var left = e.pageX-dowmx ;

                        let width = ele.childNodes[5].clientWidth;
                        width+=left;
                        ele.childNodes[5].style.width = width+'px';   
                        ele.style.width = width+'px';
                
                      
                    };
                  document.onmouseup = (e) => {
                        document.onmousemove = null;
                        document.onmouseup = null;
                        binding.value(false);

                    };
          
            };


        }
      }
    },
    mounted:function(){
      console.log(this.displaylist)
    },
    methods:{
    	dragevent(x,y){
      
     
        this.positionX = x;

        this.positionY = y;
       
	   },
     leftpullevent(flag){
        // console.log("测试")
        var ele = document.getElementsByClassName("display2component")[0];
        if(flag==true){
              
              ele.onmousedown = null
              document.onmousemove = null;
              document.onmouseup = null;
        }else{
          var x= ele.attributes['positionX'].value;
          var y = ele.attributes['positionY'].value
          ele.onmousedown=this.dragevent(x,y);
        }
     
       
     },
     changsize(){
      console.log("改变图片大小")
     },
     changfontsize(){
      console.log("改变字体大小")
      },
      changfontcolor(){
        console.log("改变字体颜色")
      },
       changborder(){
      console.log("改变边框")
      },
       changfontcolor(){
      console.log("改变字体颜色")
      },
      changimg(){
        console.log("改变背景")
      }
      }
      }

</script>
<style scoped>
.display2component{
  text-align: center;
  position: relative;
}
.display2component li{
    float: left;
    font-size: 10px;
    margin-right:10px;
    margin-top: 5px; 
    border: solid 1px;
    padding: 3px;
   /* position: absolute;
    left: 0px;
    bottom: 0px;*/
}
.display2component img{
  width: 150px;
  height: 150px;
}
/* <div><div class="changsize"><span class="leftsize">左</span><span class="rightsize">右</span><span class="upsize">上</span><span class="downsize"></span><span class="equalsize">缩放</span><img :src="displaylist.avatar"></div></div>*/
.changsize{
  position: relative;
  width: 150px;
  height: 150px;
  /*border: solid 1px;*/
}
.changsize .leftsize{
  position: absolute;
  width: 10px;
  height: 10px;
  background-color: #666;
  border-radius:50%;
  left: 0;
  top: 50%;
  margin-left: -5px;
  /*display: none;*/
}
.changsize .rightsize{
  position: absolute;
  width: 10px;
  height: 10px;
  background-color:#666;
  border-radius:50%;
  right: 0;
  top: 50%;
  margin-right: -5px;
  /*display: none;*/
}
.changsize .upsize{
  position: absolute;
  width: 10px;
  height: 10px;
  background-color: #666;
  border-radius:50%;
  left: 50%;
  top: 0;
  margin-top: -5px;
  /*display: none;*/

}
.changsize .downsize{
  position: absolute;
  width: 10px;
  height: 10px;
  background-color: #666;
  border-radius:50%;
  left: 50%;
  bottom:0;
  margin-bottom:-5px;
  /*display: none;*/
}
.changsize .equalsize{
  position: absolute;
  width: 10px;
  height: 10px;
  background-color: #666;
  border-radius:50%;
  left: 0;
  top:0;
  margin-top: -5px;
  margin-left: -5px;
  /*display: none;*/
}
</style>