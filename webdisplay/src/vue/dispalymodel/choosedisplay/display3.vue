<template>
	<div id="display3a4" class="clearfix">
	   <div class="display3a4left">
        <div class="display1height displaymain">
          <div class="display1right"><img :src="displaydata.avatar"></div>
          <div class="display1left">
            <!-- personposition -->
            <p><label>求职意向:</label>{{displaydata.personposition}}</p>
            <p>
              <span><label>手机号码</label>:{{displaydata.personmobile}}</span>
              <span><label>邮箱</label>:{{displaydata.personemail}}</span>
            </p>
            <p><label>现居地</label>:{{displaydata.hometown}}</p>
          </div>
      </div>
       <div class="display1height display1base" >
        <div>
            <div class="instrolie1"><div></div>基本资料<div></div></div>
           <p><span><label>姓名</label>:{{displaydata.personname}}</span><span><label>身高</label>:{{displaydata.personheight}}</span><span v-if="displaydata.gender=='0'"><label>姓别</label>:女</span><span v-if="displaydata.gender=='1'"><label>姓别</label>:男</span></p>
        <p><span><label>学历</label>:{{displaydata.personeducational}}</span><span><label>民族</label>:{{displaydata.nationality}}</span>
          
        <span><label>生日</label>:{{displaydata.birdthday}}</span></p>
        </div>
        
       </div>
        <div class="display1height displayimg" v-if="displaydata.proimage"><div class="instrolie1"><div></div>项目图片<div></div></div>
      <div v-if="displaydata.proimage" v-for="item in displaydata.proimage" class="displayimglist"><img :src="item"></div></div> 
     </div>
     <div class="display3a4right">
       
        <div class="display1height" v-if="displaydata.edc">
          <div class="instrolie"><div></div>教育经历<div></div></div>
          <ul id="displayedclist" v-if="displaydata.edc">
            <li v-for="item in displaydata.edc">
              <p>
                <span><label>开始时间:</label>{{item.edustrattime.split(" ")[0]}}</span>
                <span><label>结束时间:</label>{{item.eduendtime.split(" ")[0]}}</span>
                <span><label>学校:</label>{{item.edcschool}}</span>
              </p>
              <div><label>介绍:</label>{{item.edcdescription }}</div>
            </li>
          </ul>
      </div>
      <div class="display1height" v-if="displaydata.job">
        <div class="instrolie"><div></div>工作经历<div></div></div>
        <ul id="displayjoblist" v-if="displaydata.job">
            <li v-for="item in displaydata.job">
              <p>
                <span><label>开始时间:</label>{{item.workstrattime.split(" ")[0]}}</span>
                <span><label>结束时间:</label>{{item.workendtime.split(" ")[0]}}</span>
               
              </p>
              <p> 
                <span><label>公司名称:</label>{{item.workcompany}}</span>
                <span><label>职位名称:</label>{{item.workposition}}</span>
              </p>
              <div><label>介绍:</label>{{item.workdescription }}</div>
            </li>
          </ul>

      </div>
      <div class="display1height" v-if="displaydata.certificate">
        <div class="instrolie"><div></div>个人技能<div></div></div>
        <div class="siglediv">
          {{displaydata.certificate}}
        </div>
      </div>
      <div class="display1height" v-if="displaydata.selfevaluation"><div class="instrolie"><div></div>自我介绍<div></div></div>
      <div class="siglediv">{{displaydata.selfevaluation}}</div></div>
     
     </div>
	</div>

</template>
<script>
	export default{
	 props:['displaydata','distance'],
  	data() {
      return {
        img:"",
        leftheight:"",
        rightheight:""
      }
    },
    mounted:function(){
      // console.log(this.displaydata)
      //  this.img =  this.displaydata.proimage
      // this.img = this.img.split(",")
      if(this.distance==1){
        document.getElementById("display3a4").setAttribute("class","distance")
      }
     
      this.$nextTick(() => {
         this.leftheight = document.getElementsByClassName("display3a4left")[0].offsetHeight;
         this.rightheight = document.getElementsByClassName("display3a4right")[0].offsetHeight;
      // console.log(this.height);
      })
    
    },
    watch:{
      leftheight:function(val){
      	if(val<this.rightheight){
      		document.getElementsByClassName("display3a4left")[0].style.height = this.rightheight+"px"
      	}else{
      		 document.getElementsByClassName("display3a4right")[0].style.height = val+"px"
      	}
       
      },
      rightheight:function(val){
          if(val<this.leftheight){
          document.getElementsByClassName("display3a4right")[0].style.height = this.leftheight+"px"
        }else{
           document.getElementsByClassName("display3a4left")[0].style.height = val+"px"
        }
      }
    },
    methods:{
    	// Jumpdisplay(item){
    	// 	console.log(item)
    	// }
        
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
#display3a4{
   width:588px;
  /*height: 831.6px;*/
  border: solid 1px;
  box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
  background-color: lightgreen;
  position: relative;
  

}
#display3a4 label{
   color:#444;
 font-weight: bold;
 font-size: 14px;
 margin-left: 5px;
 padding-left: 2px;
} 
.display3a4left{
  width:200px;
  background-color: #a4cef2;
  float: left;

  /*height:831.6px; */
}
#display3a4 .instrolie{
  padding-left: 5px;
  font-size: 15px;
  font-weight: bold;
  color: #666;
  position: relative;
}
#display3a4 .instrolie1{
   padding-left: 5px;
  font-size: 15px;
  font-weight: bold;
  color: #666;
  position: relative;
}
#display3a4 #displayedclist li{
  border-bottom:solid 1px; 
  margin-right: 20px;
}
#display3a4 #displayjoblist li{
  border-bottom:solid 1px; 
  margin-right: 20px;
}

#display3a4 .instrolie1 div:first-child{
  position: absolute;
  left: 80px;
  top: 50%;
  width: 100px;
  height: 3px;
  background-color: #666;
}
#display3a4 .instrolie div:first-child{
  position: absolute;
  width: 180px;
  height: 3px;
  background-color: #666;
} 
#display3a4 .instrolie div:first-child{
  position: absolute;
  left: 80px;
  top: 50%;
  width: 280px;
  height: 3px;
  background-color: #666;
}
.distance{
  margin-left: 25%;
} 
.display3a4left .display1base span{
  font-size: 14px;
  color: #333;
}
.display3a4right{
  width:385px;
  background-color: #cfe1f0;
  float: left;
  /*height:831.6px; */
}
.display1right{
  text-align: center;
}
.display1right img {
   height: 118.88px;
   margin-top:20px; 
  width: 100px;

}
.displayimg img{

  width: 150px;
  height: 150px;
}
.displayimglist{
  margin-top: 20px;
  display: inline-block;
  margin-right: 20px;
}
.display3a4right .siglediv{
  margin-left: 40px;
  padding-bottom: 10px;
}
.display3a4right .siglediv{
  margin-left: 40px;
}
.display3a4left .displayimglist{
  margin-top: 20px;
  display: inline-block;
  margin-left: 20px;
  padding-bottom: 10px;
}
.display3a4right .display1height:nth-child(1){
  margin-top: 20px;
}
.display3a4right .display1height{
  margin-left: 5px;
}
</style>