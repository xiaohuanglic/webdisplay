<template>
	<div>
		<div v-for="item in displaylist" @click="Jumpdisplay(item)">{{item}}</div>
	  	<display1 v-if="chooseindex==1" :displaydata="displaydata" :distance="distance"> </display1>
	 	<display3 v-if="chooseindex==2" :displaydata="displaydata" :distance="distance"></display3>
	 	<!-- <display3 v-if="chooseindex==3" :displaydata="displaydata"></display3> -->
	 	<button @click="savedisplaymodel">完成</button>	
	</div>
	  	

</template>
<script>
	import axios from "axios";
	import display1 from './mchoosedisplay/mdisplay1.vue';
	// import display2 from './choosedisplay/display2.vue';
	import display3 from './mchoosedisplay/mdisplay3.vue';
  import url from "../../../js/totalurl.js";
	export default{
    props:['personid','isdisplay'],
	  components: {
      display1,
      // display2,
      display3,
    },
  	data() {
      return {
        displaylist: ['1','2'],
        chooseindex:0,
        displaydata:{},
        distance:1,
        getpersonid:this.personid,

       
        // context: null
      }
    },
    watch:{
      getpersonid:function(val){
        this.getpersonid = val;
      },
      isdisplay:function(val){
     
      }
    },
    mounted:function(){
    	// 先设定先，迟点再修改
      // "personalkn5sti32"
    	var personid = this.getpersonid;
    
      // var personid = "personalkn5sti32";
      // 得到usreid
    	// var userid = JSON.parse(sessionStorage.getItem("vue-session-key"))['username'][1];
       var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
        
                      axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                           
                           var userid = res.data['userid'];
                           // var userid = "919384f56f39db240db6888c208e002f";
                          
                           axios.get(url+'/get.php/?personid='+personid+"&&userid="+userid).then(res=>{
                              if(res.data.job.length==1){
                                for(var key in res.data.job[0]){
                                   if(res.data.job[0][key]===null){
                                      
                                    delete res.data.job;
                                    break;
                                   }
                                }
                              }
                              if(res.data.edc.length==1){
                                for(var key in res.data.edc[0]){
                                   if(res.data.edc[0][key]===null){
                                    delete res.data.edc;
                                    break;
                                   }
                                }
                              }
                              if(res.data.proimage==''||res.data.proimage===null||typeof(res.data.proimage) == undefined){
                                   delete res.data.proimage;
                              }else{
                                if(res.data.proimage.indexOf(",")!=-1){
                                    res.data.proimage = res.data.proimage.split(",");
                                }else{
                                  var img = [res.data.proimage]
                                  res.data.proimage =img;
                                }
                              }

                              if(res.data.certificate===null){
                                delete res.data.certificate;
                              }
                              if(res.data.selfevaluation===null){
                                delete res.data.selfevaluation;
                              }
                              // 判断图片有没有逗号
                              if(res.data.isdisplay!=0){
                                    this.chooseindex = res.data.isdisplay;
                              }
                              this.displaydata = res.data;
                              
          // 把拿到的数据传到display模块那里
                  // JSON.parse(res.data);
                            })
                      })
     
    	
    	

    },
    methods:{
    	Jumpdisplay(item){
    		this.chooseindex = item;
    		
    	},
      savedisplaymodel(){
      
        if(this.chooseindex!='1'&&this.chooseindex!='2'){
          return;
        }
        var personid = this.displaydata.personid
        var isdisplay = this.chooseindex;
        axios.get(url+'/displaymode.php/?personid='+personid+'&&isdisplay='+this.chooseindex).then(res=>{
                      
                         
                          console.log(res.data)
              
           
                     })
         //存储到数据库中，得到personid
          //存储进去 
	   },
    }
      }

</script>
<style scoped>

</style>