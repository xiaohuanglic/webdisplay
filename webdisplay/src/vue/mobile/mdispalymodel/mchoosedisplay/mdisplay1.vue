<template>
	<div id="display1a4">
      <div class="display1height displaymain ">
          <div class="display1right"><img class="display1img" :src="displaydata.avatar"></div>
          <div class="display1left ">
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
            <div class="instrolie"><div></div>基本资料<div></div></div>
           <p><span><label>姓名</label>:{{displaydata.personname}}</span><span><label>身高</label>:{{displaydata.personheight}}</span><span v-if="displaydata.gender=='0'"><label>姓别</label>:女</span><span v-if="displaydata.gender=='1'"><label>姓别</label>:男</span></p>
        <p><span><label>学历</label>:{{displaydata.personeducational}}</span><span><label>民族</label>:{{displaydata.nationality}}</span>
          
        <span><label>生日</label>:{{displaydata.birdthday}}</span></p>
        </div>
       
       </div>
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
            <li  v-for="item in displaydata.job">
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
        <div class="instrolie" ><div></div>个人技能<div></div></div>
        <div class="siglediv">
          {{displaydata.certificate}}
        </div>
      </div>
      <div class="display1height" v-if="displaydata.selfevaluation"><div class="instrolie"><div></div>自我介绍<div></div></div>
      <div class="siglediv">{{displaydata.selfevaluation}}</div></div>
      <div class="display1height displayimg" v-if="displaydata.proimage"><div class="instrolie"><div></div>项目图片<div></div></div>
      <div v-for="item in displaydata.proimage" class="displayimglist"><img :src="item"></div>
      
      </div>
      <!-- <button>完成</button> -->

	</div>

</template>
<script>
	export default{
	 props:['displaydata','distance'],
  	data() {
      return {
       
      }
    },
    mounted:function(){
      if(this.distance==1){
        // document.getElementById("display1a4").setAttribute("class","distance")
        document.getElementById("display1a4").setAttribute("class","distance")
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
  .display1right .display1img{
    width: 100%;
    height: 100%;
  }
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
label{
  margin-right: 1.5%;
  margin-left: 0.5%;
}
#display1a4{
  width:100%;
  /*height: 831.6px;*/
  border: solid 0.1rem;
  box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
  background-color: #c7e0fc;
  /*margin-left: 256px;*/
}
#display1a4 label{
 color:#444;
 font-weight: bold;
 font-size: 0.8rem;

}
#displayedclist{
  padding-left: 0px;
  padding-top: 5%;
}
#displayedclist label{
  margin-right: 15%; 
}
#displayedclist span{
  margin-right: 1%;

}
#displayjoblist{
  padding-left: 0px;
   padding-top: 5%;
}
#displayjoblist li:first-child{
  border-top:solid 0px; 
 
  
}
#displayjoblist li{
  border-top:solid 1px; 
 padding-top: 5%;
 padding-bottom: 5%;
  
}
#displayjoblist label{
  margin-right: 15%; 
}
#displayjoblist span{
  margin-right: 10%;
  
}
#displayedclist li:first-child{
  border-top:solid 0px; 
 
  
}
#displayedclist li{
  border-top:solid 1px; 
 padding-top: 5%;
 padding-bottom: 5%;
  
}
.distance{
  margin-left: 0%;
} 
.instrolie{
  text-align: center;
  color: #666;
  font-weight: bold;
  font-size: 1rem;
  width: 25%;
  position: absolute;
  left:25%;
  top:-5%;
  margin-left:15%; 
  margin-bottom: 10%;
}
.instrolie div:first-child{
  display: inline-block;
  position: absolute;
  left: -150%;
  top:50%;

  height: 0.15rem;
  width: 100%;
  background-color: #666;
  /*border: solid 1px;*/
  /*padding-left:0px; */
}
.instrolie div:nth-child(2){
  display: inline-block;
  position: absolute;
  left: 130%;
  top:50%;
  height:  0.15rem;
  width: 100%;
  background-color: #666;
  /*border: solid 1px;*/

  /*padding-left:0px; */
}
.siglediv{
  font-size: 0.9rem;
  padding-top: 15%;
  padding-bottom: 10%;
}
.displaymain{
  width: 100%;
  /*height: 150px;*/
  /*mar*/
}

.display1left p{

  width: 100%;
  font-size: 1rem;
}
.display1left p:nth-child(1){
  font-size: 1.5rem;
}
.display1left p:nth-child(2) span{
  font-size: 0.9rem;
  margin-right: 5%;
}
.display1right{
  /*display: inline-block;*/
 /* position: absolute;
  right: 5%;
  top:5%;*/

  height:50%;
  width: 50%;


}
.display1base{
  /*height: 15%;*/
   /*padding-top: 20%;*/

}
.display1base p{
  font-size: 0.8rem;
  margin-top: 15%;
  /*margin-left: 40px;*/
}
.display1base span{
  font-size: 0.8rem;
  margin-right: 10%;
  /*margin-left: 40px;*/
}
/*.display1right img{
   height: 118.88px;;
  width: 100px;

}*/
.display1left{


  /*height: 15%;*/
  width: 100%;
}

.displayimg img{

  width: 150px;
  height: 150px;
}
.displayimglist{
  margin-top: 15%;
  display: inline-block;
  margin-right: 5%;
}
.displayimglist img{
 width: 50%;
 height: 100px;
}
.display1height span{
  /*height: 16.7%;*/
  font-size: 0.9rem;
  /*border-bottom: solid 2px #666;*/
}
.display1height{
  
  width:100%;
  padding: 5% 5% 5% 5%;
  position: relative;
  /*border-bottom: solid 2px #666;*/
}
</style>