<template>
   <forestage ref="child"></forestage>
</template>
<script>
import display1 from './mdispalymodel/mchoosedisplay/mdisplay1.vue'
import display3 from './mdispalymodel/mchoosedisplay/mdisplay3.vue'
import forestage from '../forestage .vue'
import axios from "axios";
import Vue from 'vue'
import url from "../../js/totalurl.js";
 axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
    
        components: {forestage,display1,display3},
        data() {
          return{
            id:'',
            resdata:{},
            getdata:'',
            proimage:[],
          }
        
        },
        mounted: function () {
          for(var each in this.$common){
              for(var i =0;i<this.$common[each].length;i++){
                   clearInterval(this.$common[each][i]);
              }
                   
            }
          // var userid = JSON.parse(sessionStorage.getItem("vue-session-key"))['username'][1]
          var userid = this.$route.query.userid
          var that = this;
            if(this.$route.query.personid!=undefined){
               var personid = this.$route.query.personid
           
            this.resdata = this.SendId(personid,userid,'personid')
            
            this.resdata.then((value)=>{
              
              this.creatpersonpage(value,that.$router);
            })
            }else if(this.$route.query.taskid!=undefined){
               var taskid = this.$route.query.taskid
               this.resdata = this.SendId(taskid,userid,'taskid');
               this.resdata.then((value)=>{
                      console.log(value)
                    this.creattaskpage(value,that.$router)
              })
            }
           
          
        },
        watch:{
            $route(to,from){
            
          }
        },

        methods:{
          creatpersonpage(value,router){
               var html ='<div><display1 :displaydata="displaydata" v-if="displaydata.isdisplay==1" ></display1><display3 :displaydata="displaydata" v-if="displaydata.isdisplay==2"></display3><p>更新时间:{{this.displaydata.updatedate}}</p><input type="button" @click=chatperson() value="交谈"/></div>'
                  var addpersonal = Vue.extend({
                  template: html,
                   components: {display1,display3},
                  data() {
                    return{
                        displaydata:{},
                   
                      }
                  },
                  watch:{
                  
                  },
                   mounted() {
                      // this.proimage = proimage
                      if(value.job.length==1){
                                for(var key in value.job[0]){
                                   if(value.job[0][key]===null){
                                      
                                    delete value.job;
                                    break;
                                   }
                                }
                              }
                              if(value.edc.length==1){
                                for(var key in value.edc[0]){
                                   if(value.edc[0][key]===null){
                                    delete value.edc;
                                    break;
                                   }
                                }
                              }
                              if(value.proimage==''||value.proimage===null||typeof(value.proimage) == undefined){
                                   delete value.proimage;
                              }else{
                                if(value.proimage.indexOf(",")!=-1){
                                    value.proimage = value.proimage.split(",");
                                }else{
                                  var img = [value.proimage]
                                  value.proimage =img;
                                }
                              }

                              if(value.certificate===null){
                                delete value.certificate;
                              }
                              if(value.selfevaluation===null){
                                delete value.selfevaluation;
                              }
                      this.displaydata = value;
                      console.log(value)
                      

                      
                   },
                   methods:{
                      chatperson(){
                        var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
                      axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                      
                        var myid = res.data['userid'];
                        var myname = res.data['username'];
                     
                        var myname = res.data['username'];
                        if(myid==value.userid){
                            return;
                        }
                        axios.get(url+'/getchatperson.php/?userid='+value.userid+"&&myid="+myid).then(res=>{
                      // console.log(res.data);
                      console.log(res.data)
                      if(typeof(res.data['chatid']) == "undefined"||res.data=="没有该用户"||typeof(res.data) == "undefined"){
                      
                        var chatmsg ="";
                       var piclist=[];
                       var usernum =0;
                      var username = res.data['username'];
                      var flag = value.userid;

                          axios.post(url+'/chat.php',{userid:value.userid,myid:myid,chatmsg:chatmsg,usernum:usernum,myname:myname,username:username,userimg:piclist,flag:flag}).then(res=>{
                   
               
                 

                       
                   
                  var resdata = res.data.split(',');
                   if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                      router.push({path: '/mchat/?chatid='+resdata[0]})
                  } else {
                      router.push({path: '/chat/?chatid='+resdata[0]})
                  }
                 
               
                  // this.getchatData(resdata[resdata.length-1],1); 
                   })
                         

                      }else{
                         if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                       router.push({path: '/mchat/?chatid='+res.data['chatid']});
                  } else {
                       router.push({path: '/chat/?chatid='+res.data['chatid']});
                  }
                     
                     
                       
                        
                    
                      }

                //               
                    })
                 


                      })
                        
                      },
    

                   },
                 

                })
                new addpersonal().$mount('#change')
          },
          creattaskpage(value,router){
               var html ='<div><div class="taskhead "><ul class="mtaskhalf clearfix"><li><h3><span>{{displaydata.taskposition}}</span><span>{{displaydata.salary}}</span></h3><p>{{displaydata.education}}</p><p>{{displaydata.experiencerequirement}}</p><p>更新时间:{{displaydata.updatedate}}</p></li><li><p><img :src="displaydata.avatar"><label>公司名称:</label>{{displaydata.taskname}}</p><p><label>地址：</label>{{displaydata.address}}</p></li></ul></div><div class="mtasktail"><div><p>职位描述:</p><div>{{displaydata.jobrequirements}}</div><p>任职描述:</p><div>{{displaydata.positiondescription}}</div></div><div v-if="displaydata.proimage"  class="mtaskimg clearfix"><p>公司图片:</p><ul v-if="displaydata.proimage"><li v-for="item in displaydata.proimage"><img :src="item"></li></ul></div></div><input type="button" @click=sendresume(displaydata.taskid) value="投递简历"/><input type="button" @click=chatperson() value="交谈"/></div>'
                  var addpersonal = Vue.extend({
                  template: html,
                   components: {display1,display3},
                  data() {
                    return{
                        displaydata:{},
                   
                      }
                  },
                  watch:{
                  
                  },
                   mounted() {
                      if(value.proimage==''||value.proimage===null||typeof(value.proimage) == undefined){
                                   delete value.proimage;
                              }else{
                                if(value.proimage.indexOf(",")!=-1){
                                    value.proimage = value.proimage.split(",");
                                }else{
                                  var img = [value.proimage]
                                  value.proimage =img;
                                }
                              }
                      this.displaydata = value;

                      
                   },
                   methods:{
                      chatperson(){
             var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
                      axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                      
                        var myid = res.data['userid'];
                        var myname = res.data['username'];
                     
                        var myname = res.data['username'];
                        if(myid==value.userid){
                            return;
                        }
                        axios.get(url+'/getchatperson.php/?userid='+value.userid+"&&myid="+myid).then(res=>{
                      // console.log(res.data);
                      console.log(res.data)
                      if(typeof(res.data['chatid']) == "undefined"||res.data=="没有该用户"||typeof(res.data) == "undefined"){
                      
                        var chatmsg ="";
                       var piclist=[];
                       var usernum =0;
                      var username = res.data['username'];
                      var flag = value.userid;

                          axios.post(url+'/chat.php',{userid:value.userid,myid:myid,chatmsg:chatmsg,usernum:usernum,myname:myname,username:username,userimg:piclist,flag:flag}).then(res=>{
                   
               
                 

                       
                   
                  var resdata = res.data.split(',');
                  if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                      router.push({path: '/mchat/?chatid='+resdata[0]})
                  } else {
                      router.push({path: '/chat/?chatid='+resdata[0]})
                  }
                
                  // this.getchatData(resdata[resdata.length-1],1); 
                   })
                         

                      }else{
                    
                     
                     
                         if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                       router.push({path: '/mchat/?chatid='+res.data['chatid']});
                  } else {
                       router.push({path: '/chat/?chatid='+res.data['chatid']});
                  }
                        
                    
                      }

                //               
                    })
                 


                      })
                        
                      },
                       sendresume(taskid){
                        // 把相关的person设置成一个组件
                        // 转跳页面
                        
                        // var gettaskid = taskid
                        router.push({path: '/resume?taskid='+taskid});

                     
                      },
    

                   }

                })
                new addpersonal().$mount('#change')
          },
          SendId(id,userid,idname){
 
             
           
           return axios.get(url+'/get.php/?'+idname+'='+id+"&&userid="+userid).then(res=>{
             
                return res.data;
             
              })
          }
        }
      
      }

</script>
<style >
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

  .avatar{
    height:150px;
    width:150px;
  }
  .enlargepic{
    width:150px;
    height:150px;
    position: absolute;
  }
  .pichref{
    display:block;
    width:150px;
    height:150px;
     margin: 0,0;
        opacity: 0;
        z-index: 99999;
  }
  .proimg{
    float:left;
    padding-left:10px
  }


.taskhalf{
  border-bottom: solid 1px;
}
.mtaskhalf{

}
.mtaskhalf p img{
  width: 20%;
  height: 20%;
}
.mtaskhalf li{
  text-align: center;
  /*float: left;*/
  width: 80%;
  background-color: #cce0f0;
  /*margin-left: 2.5%;*/
  margin-top: 5%;
  /*border-right:solid 0.8rem #666;*/
}
.mtaskhalf li:last-child{
  font-size: 0.8rem;
  border-right:solid 0px #666;
}
.mtaskhalf li:first-child h3 span{
  color: #789;
}
.mtaskhalf li:first-child span{
  padding-right: 10px;
}
.mtaskhalf li:first-child p{
  font-size: 0.8rem;
  font-weight: bolder;
  color:#666;
}
.mtaskhalf li p label{
 font-size: 0.8rem;
 color: #666;
 font-weight: bolder;
}
.mtaskhalf li p img{
 width: 100px;
 height: 100px;
}
.mtasktail{
  border-top: solid 2px;
  border-color: #666
}
.mtasktail{
  padding-top: 5%;
  padding-left: 5%;
  padding-bottom: 5%;
}
.mtasktail div{
  /*font-weight: bold;*/
  font-size: 0.8rem;
  /*color: #666;*/
}
.mtasktail p{
  font-weight: bold;
  font-size: 0.9rem;
  color: #666;
}
.mtasktail .mtaskimg li{
  margin-left: 5%;
  float: left;
}
.mtasktail .mtaskimg img{
  width: 80%;
  height: 80%;
}
</style>
<!-- <div class="checkbox" ><div v-for="(value, key, index) in promoney"><label class="moneytext">{{key}}:{{value}}</label><input type="checkbox" v-model="whom" v-bind:value="key+space+value"  @click="chooseActivity(index)"/></div></div> -->
<!-- <input type="button" @click=order() value="付款"/> -->
<!-- <a :href=item class="pichref"></a> -->