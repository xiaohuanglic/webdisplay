<template>

  <div>
    <div v-if="displayflag"><table class="persontable"><tr>
      <th v-for="(item, index) in tdhead">{{item}}</th></tr>
      <tr v-for="(data,index) in disdata" v-if="index<datalength">
      <td class="psersonimg"><img :src='data["avatar"]'></td>
      <td>{{data["personname"]}}</td>
      <td @click=getview(data)>查看</td>
      <td v-if="resumeselect" @click="getchoose(data)">选择</td>
     <!--  <td @click=Getupdate(1,data)>修改</td><td @click=Getupdate(2,data)>删除</td> -->
      </tr></table>
    </div>
    <div  v-if="!displayflag">
      <!-- 显示界面查看时显示，返回时隐藏 -->
      <div><display1 :displaydata="displaydata" v-if="displaydata.isdisplay==1&&mobileflag=='computer'" :distance="distance"></display1><display3 :displaydata="displaydata" v-if="displaydata.isdisplay==2&&mobileflag=='computer'"  :distance="distance"></display3><p>更新时间:{{this.displaydata.updatedate}}</p></div>
       <div><mdisplay1 :displaydata="displaydata" v-if="displaydata.isdisplay==1&&mobileflag=='mobile'" :distance="distance"></mdisplay1><mdisplay3 :displaydata="displaydata" v-if="displaydata.isdisplay==2&&mobileflag=='mobile'"  :distance="distance"></mdisplay3></div>
      <button  @click="comeback">返回</button>
    
      
    
    </div>
    <pagination ref="pagination" @getpageData="getpagedata" :personflag="personflag" @getpagepersondata="getpagepersondata"></pagination>
    </div>

</template>
<script>
  import axios from "axios";

   import pagination from '../pagination.vue'
   import display1 from '../dispalymodel/choosedisplay/display1.vue'
  import display3 from '../dispalymodel/choosedisplay/display3.vue'
   import mdisplay1 from '../mobile/mdispalymodel/mchoosedisplay/mdisplay1.vue'
  import mdisplay3 from '../mobile/mdispalymodel/mchoosedisplay/mdisplay3.vue'
import url from "../../js/totalurl.js";
  export default{
    props:['taskid','persondata','distance'],
   components: {
                  pagination,display1,display3,mdisplay1,mdisplay3
         
          
                },
    data() {
      return {
            datalength:0,
            change:'',
            nowpage:'',
            totalpage:'',
            diaplaypage:'',
            totalnum:'',
            disdata:'',
            updata:'',
            flag:"",
            datalength:"",
            tdhead:['头像'],
            displayflag:true,
            displaydata:{},
            personflag:"",
            resumeselect:true,
            mobileflag:""
       
        // context: null
      }
    },
    mounted(){
                
                
                  
                  if(this.persondata!==null&&typeof(this.persondata) != "undefined"&&this.persondata.length>0){
                      this.$refs.pagination.pagename = "getdatapagetabele"
                  this.$refs.pagination.showname = "getdatashowtabele"
                  this.$refs.pagination.totalnumname = "getdatatotalnumtable"
                  this.$refs.pagination.totalpagename = "getdatatotalpagetable"
                  this.personflag="resumeperson";
                  this.distance = 1;
                  this.resumeselect = false
                   this.getpersondata(this.persondata)
                  }else{
                      this.$refs.pagination.pagename = "resumepagetabele"
                  this.$refs.pagination.showname = "resumeshowtabele"
                  this.$refs.pagination.totalnumname = "resumetotalnumtable"
                  this.$refs.pagination.totalpagename = "resumetotalpagetable"
                     this.getpersontable();
                  }
                 

                 
                  
                  
    },
    watch:{
     
    
    },
    methods:{
          comeback(){
              this.displayflag=true;
             
          },
          getchoose(data){
            // 获得相关的taskid
              var taskid =this.taskid;
              var personid = data['personid'];
              var resume={};
              resume['taskid'] = taskid;
               resume['personid'] = personid;
               axios.post(url+'/resume.php',{resume:resume}).then(res=>{
                console.log(res.data);
             })
              
              // 储存到相关的表中
          },
          getview(data){
            // 转跳页面
          if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                this.mobileflag ="mobile";
          } else {
               this.mobileflag ="computer";
          }
            this.displayflag=false;
              var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
            axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
               var userid = res.data['userid'];
          

            axios.get(url+'/get.php/?'+'personid'+'='+data['personid']+"&&userid="+userid).then(res=>{
              console.log(res.data);
                var value = res.data;
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
                     
             
              })

              })
           
            
          },
         getpagedata(index){
                     var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
                      axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
              
                          var userid = res.data['userid']
                      this.$refs.pagination.show = "Boss"
                      
                       axios.get(url+'/gettablepage.php/?page='+index+'&&totalnum='+ this.$refs.pagination.totalnum+'&&size=2&&show='+this.$refs.pagination.show+'&&userid='+userid).then(res=>{
                      
                            this.$refs.pagination.extractpageData(res.data,index);

                              this.disdata = this.$refs.pagination.disdata;
                              console.log(this.disdata)
                              this.datalength = this.$refs.pagination.datalength; 
                        
              
           
                     })

                      })
                    
                     
                  },
                   getpagepersondata(index){
                           
                            var value = [];
                            for(var i = 0;i<this.persondata.length-1;i++){
                              value[i] = this.persondata[i];
                            }
                            
                           
                            var getvalue = [];
                            var getpagelength = 0
                            if(value.length%2!=0){
                                getpagelength=(value.length%2)+1
                            }else{
                                getpagelength=(value.length%2)
                            }
                            if((index-1)<=0){
                              index = 1;
                              getvalue[0] = value[0];
                                getvalue[1] = value[1]; 
                            }else if(index>=getpagelength){
                              getvalue[0] = value[(index-1)*2];
                             
                              if(((index-1)*2)+(value.length%2)<value.length){
                                getvalue[1] = value[((index-1)*2)+(value.length%2)]
                              }
                              
                              
                            }else{
                              
                                getvalue[0] = value[(index-1)*2];
                                getvalue[1] = value[((index-1)*2)+1]; 

                            }                   
                            // 得到index的数据
                           

                            this.$refs.pagination.extractpageData(getvalue,index);

                            this.disdata = this.$refs.pagination.disdata;
                             
                            this.datalength = this.$refs.pagination.datalength; 
                        
              
           
                   

                      
                    
                     
                  },
                  getpersontable(){
                    // 得到自己用户的数据
                    var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
                     axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                        this.flag="persontable"
                    this.show='Boss';
                   
                    var userid = res.data['userid'];
                    // console.log(userid);
                    axios.get(url+'/gettable.php/?show='+this.show+'&&flag='+this.flag+'&&userid='+userid).then(res=>{
                        var setdata = res.data; 
                        for(var i =0;i<setdata.length;i++){
                        setdata[i] = JSON.parse(setdata[i]);
                        }
                          var settotalnum = setdata[setdata.length-1]['COUNT(*)'];
                          // console.log(res.data)
                      if(this.$refs.pagination.getTotalnum()!=null){
                        if(this.$refs.pagination.getTotalnum()!=settotalnum){
                        
                          this.$refs.pagination.extractData(res.data)
                                this.disdata = this.$refs.pagination.disdata;
                                this.datalength = this.$refs.pagination.datalength;
                        }else{
                          
                          if(this.$refs.pagination.getIndex()!=null&&!isNaN(this.$refs.pagination.getIndex())){
                              this.getpagedata(this.$refs.pagination.getIndex());
                            }else{
                              this.$refs.pagination.setIndex(1);
                              this.getpagedata(this.$refs.pagination.getIndex());

                            }
                        }
                      }else{
                        console.log(3)
                        this.$refs.pagination.extractData(res.data)
                              this.disdata = this.$refs.pagination.disdata;
                              this.datalength = this.$refs.pagination.datalength; 
                      }
                         
                         
           
                      })

                     })
                  
          
                  },
                    getpersondata(value){
                    // 得到自己用户的数据
                    
                      
                  
                        var setdata = value; 
                       
                        var settotalnum = setdata[setdata.length-1]['COUNT(*)'];

                     
                      if(this.$refs.pagination.getTotalnum()!=null){
                       
                        if(this.$refs.pagination.getTotalnum()!=settotalnum){
                        
                          this.$refs.pagination.extractData(value)
                                this.disdata = this.$refs.pagination.disdata;
                                this.datalength = this.$refs.pagination.datalength;
                        }else{
                          
                          if(this.$refs.pagination.getIndex()!=null&&!isNaN(this.$refs.pagination.getIndex())){
                              this.getpagepersondata(this.$refs.pagination.getIndex());
                            }else{
                              this.$refs.pagination.setIndex(1);
                              this.getpagepersondata(this.$refs.pagination.getIndex());

                            }
                        }
                      }else{
                              console.log(3)
                              this.$refs.pagination.extractData(value)
                             
                              this.disdata = this.$refs.pagination.disdata;
                              this.datalength = this.$refs.pagination.datalength; 
                      }
                         
                         
           
                      

                     
                  
          
                  },
                  getdatanull(data){

                    var i = 0;
                    for(var key in data){
                      if(data[key]===null){
                        i++;
                      }else{
                        return true;
                      }
                      
                    }
                    
                    if(i>=data.length-1){
                      return false;
                    }

                    return false;
                    
                    
                  },
   
    }
    }

</script>
<style scoped>
.psersonimg img{
  width:100px;
  height: 100px;
}
.persontable{
  width:100%;
}
.persontable tr{
  width:100%;
  text-align: center;
}
</style>