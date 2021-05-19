<template>
  <div>
    <!-- v-rightClick = "{getrightMenuObj}" -->
   <backstage ref="child"></backstage>
   <div id="dialogue"></div>
  </div>
</template>
<script>
 import backstage from './backstage.vue'
 import pagination from './pagination.vue'

  import personcomponent from './person/personcomponent.vue'

  import taskmodel from './taskmodel.vue'
 import Vue from 'vue'
 import axios from "axios";
import url from "../js/totalurl.js";
// 做一个数字标记
// 修改了相关的数字的图片,就对相应的图片进行时间戳的更新
 var addimage=Vue.extend({
            props:['imgsrc'],
             data: function () {
                  return {
                      imgdata:"",
                      imgmeg:"",
                  }
                },
            template:'<div class="getpic" :imgsrc=this.imgdata><img class="dispic" :src=this.imgdata ></div>',
             mounted() {
              // console.log(this.$parent);
                this.imgdata=this.imgsrc
             },
              methods:{
                  changeImage(e){
                     var file = e.target.files[0]
                     var fileSize = e.target.files[0].size;
              var size = fileSize / 1024;
              if(size>1000){
                this.imgmeg = "图片超出大小"
                return false;   //阻止submit提交
              }

                     var reader = new FileReader()
                     var that = this
                     reader.readAsDataURL(file)
                     reader.onload = function(e){
                        that.imgdata=this.result
                     }
                    
                  }
              }

          
        })
    export default {
      
        components: {backstage,
      
         
          personcomponent
         
          
        },
        mounted:function(){
        		var that = this
		 var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
		axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
			if(res.data['username']!="admin"){
				that.$router.push({path: '/login'})
			}
			
		})
            for(var each in this.$common){
              for(var i =0;i<this.$common[each].length;i++){
                   clearInterval(this.$common[each][i]);
              }
                   
            }
           for(var each in this.$common){
              for(var i =0;i<this.$common[each].length;i++){
                   clearInterval(this.$common[each][i]);
              }
                   
            }
          this.Allchild = this.$refs.child;
          // this.getrightMenuObj()
          var that = this;
          var Profile = this.creatchildperson(this.Allchild,that);
          new Profile().$mount('#addleft');
        },

        data() {
        return{
          Allchild:"",
         
        
        }
        
      },
      methods:{
      
        publish(){
          this.change="publish"
          
        },
        order(){
          this.change="order"
          
        },
        creatPage(Allchild,that,personid){
           var html =  '<div><p v-if ="newpageflag">更新成功</p><p v-if ="addflag"><displaymodel :personid="personid"></displaymodel></p><p v-if="deleteflag">删除成功</p></div>';
           var addnewpage = Vue.extend({
            template: html,
            components:{
              displaymodel
            },
            data: function () {
                    return {
                        newpageflag:false,
                        deleteflag:false,
                        addflag:false,
                        personid:personid,

                    }
                },
            mounted:function(){
                // this.personid = personid;

            }

           })
          return new addnewpage();
        },
        createPageInstance(flag,Allchild,that,personid){
            var newpage= new this.creatPage(Allchild,that,personid);
                    var divname=Allchild.$root.$el.getElementsByClassName("right")[0].childNodes[0].getAttribute('id')
                    if(flag=="add"){
                      newpage.newpageflag = false;
                      newpage.deleteflag = false;
                      newpage.addflag = true;
                    }else if(flag=="delete"){
                      newpage.newpageflag = false;
                      newpage.deleteflag = true;
                      newpage.addflag = false;
                    }else{
                      newpage.newpageflag = true;
                      newpage.deleteflag = false;
                      newpage.addflag = false;
                    }
                    

                    if(divname!="addright"){
                      Allchild.clearright(Allchild);
              newpage.$mount('#addright')

                    }else{
                      newpage.$mount('#addright')
                    }
        },
        // 分出去
  // <label for="address">填写地址:</label><div><b-form-textarea id="address" v-model="address" placeholder="输入地址" rows="3" max-rows="6"></b-form-textarea><pre class="mt-3 mb-0">{{ address }}</pre></div>
        creatPersonal(Allchild,that){
            var html =  '<form id="addtask"><div><img :src="upload" class="Avatar"><input type="file" name="avatar" id="uppic" accept="image/gif,image/jpeg,image/jpg,image/png" @change="changeImage($event)" ref="avatarInput" class="uppic"></div></br><input type="hidden" id="taskid" v-model="taskid"><label for="taskname">公司名称:</label><input type="text" id="taskname" v-model="taskname" required="required"></br></br><label for="taskposition">公司职位:</label><input type="text" id="taskposition" v-model="taskposition" required="required"></br></br><label for="address">填写地址:</label><div><b-form-textarea id="address" v-model="address" placeholder="输入地址" rows="3" max-rows="6"></b-form-textarea></div><label for="positiondescription">职位描述:</label><div><b-form-textarea id="positiondescription" v-model="positiondescription" placeholder="Enter something..." rows="3" max-rows="6"></b-form-textarea></div><label for="jobrequirements">任职要求:</label><div><b-form-textarea id="jobrequirements" v-model="jobrequirements" placeholder="Enter something..." rows="3" max-rows="6"></b-form-textarea></div><taskmodel v-on:experiencerequirement="experiencerequirement" v-on:education="education" v-on:salary="salary" :getexperiencerequirement="getexperiencerequirement" :geteducation="geteducation" :getsalary="getsalary"></taskmodel><div><div v-for="(item,index) in list" :is="item.component" :imgsrc="item.imgsrc" :indexnum="item.index" :oldflag="item.oldflag" :key="item" ></div></div><br><br><button @click="pass">通过</button><button @click="notpass">不通过</button></form>'
            var addpersonal = Vue.extend({
              template: html,
              components: {
                'addimgc':addimage,
             	 // rightclick,
                taskmodel,
            
                },
                data: function () {
                    return {
                    	userid:"",
                      imgmeg:"",
                      stringflag:"",
                        change:"",
                        taskid:"",
                        taskname:"",
                        taskposition:"",
                        positiondescription:"",
                        jobrequirements:"",
                        proimage:[],
                        geteducation:"",
                        getexperiencerequirement:"",
                        getsalary:"",
                        address:"",
                        // personintro:"",
                        upload:'',
                        add:'',
                        dom:"",
                        index:0,
                        list:[],
                        iamge:"",
                        listBolb:[],
                        getimagesrc:"",
                        imagenum:[],
                        deleteimgid:[],
                        delimgflag:0,
                        equealid:[],
                        moveforwardid:[],
                        addnum:[],
                        picname:[],
                       
                       

                    }
                },
                mounted() {
                   
                  
                  

                 
                },
                watch:{
               
                },

                methods:{
             		pass(){
             			// 修改displayflag 进行显示
             			// 根据testid找到userid查找chatid，没有就创建
             			// 发送通知
             			var task = {
             				'taskid':this.taskid,
             				'userid':this.userid,
             				'dispalyflag':'1',

             			}
             			
             		axios.post(url+'/adminpass.php',{task:task}).then(res=>{
									
						console.log(res.data);
					})
             			

             		},
             		notpass(){
             			// 根据testid找到userid查找chatid，没有就创建
             			// 发送通知不通过
             				var task = {
             				'taskid':this.taskid,
             				'userid':this.userid,
             				
             			}
             			
             		axios.post(url+'/adminpass.php',{task:task}).then(res=>{
									
						console.log(res.data);
					})
             		}
                 

                }
            })

            return addpersonal;
    },
    // 进行修改
      // 每个组件单独写一个算法
      // 分出去
      // 分页单独写一个组件
      // <ul> <li v-for="n in diaplaypage" v-if="n>=nowpage"class="page" @click="Jmuppage(n,show)">{{n}}</li></ul>
        creatpersontable(Allchild,that){
          // 导入模板，迟一点
          // 添加分页模块
          var tableifm = Vue.extend({
                template:'<div><table><tr><th v-for="(item, index) in tdhead" v-if="index ==1||index >=3">{{item}}</th></tr><tr v-for="(data,index) in disdata" v-if="index<datalength"><td>{{data["taskname"]}}</td><td>{{data["personinfo"]}}</td><td @click=Getupdate(1,data)>查看</td></tr></table><pagination ref="pagination" @getpageData="getpagedata"></pagination></div>',
                 components: {
                  pagination,

         
          
                },
                data:function(){
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
                      tdhead:['Id','名称',"价格","介绍",'查看']

                    }
                },
                mounted() {
                 
                  this.$refs.pagination.pagename = "checktaskpagetabele"
                  this.$refs.pagination.showname = "checktaskshowtabele"
                  this.$refs.pagination.totalnumname = "checktasktotalnumtable"
                  this.$refs.pagination.totalpagename = "checktasktotalpagetable"
                  
                
                    this.getpersontable();
                 
                  
                  
                },
                methods:{
                  viewresume(data){
                    // console.log()
                    // createpersoncom
                  
                           that.Allchild.clearright(that.Allchild)
                             // Allchild.clearright(Allchild);
                             // console.log(res.data+"boss");
                            var creatcreatpersoncom = that.createpersoncom(that.Allchild,that,data['taskid']); 
                            new creatcreatpersoncom().$mount('#addright');
                         
                    
                  },
                  getpagedata(index){
                    // 先把任务的数量拿出来
                
          //                 var userid = res.data['userid'];
          				var show = "Free";
                      this.$refs.pagination.show = "Free"
         		axios.get(this.$url+'/getpage.php/?page='+index+'&&totalnum='+this.totalnum+'&&size=2&&show='+show+"&&displayflag=true").then(res=>{
                 		        this.$refs.pagination.extractpageData(res.data,index);
                              	this.disdata = this.$refs.pagination.disdata;
                             	this.datalength = this.$refs.pagination.datalength; 
                          		// console.log(res.data)
               
           
            		})
                  
                   
                     
                     
                  },
                  getpersontable(){
                    // 得到自己自己企业任务的信息
                   
                         this.flag="persontable"
                    this.show='Free';

                  

                   
                    
                    axios.get(url+'/get.php/?show='+this.show+"&&displayflag=true").then(res=>{
                     
                        var setdata = res.data; 
                        for(var i =0;i<setdata.length;i++){
                        setdata[i] = JSON.parse(setdata[i]);
                        }
                          var settotalnum = setdata[setdata.length-1]['COUNT(*)'];
                         
                      if(this.$refs.pagination.getTotalnum()!=null){
                        if(this.$refs.pagination.getTotalnum()!=settotalnum){
                        
                          this.$refs.pagination.extractData(res.data)
                                this.disdata = this.$refs.pagination.disdata;
                                this.datalength = this.$refs.pagination.datalength;
                        }else{
                          
                          if(this.$refs.pagination.getIndex()!=null&&!isNaN(this.$refs.pagination.getIndex())){
                              // this.$refs.pagination.totalnum = this.$refs.pagination.getTotalnum();
                              
                              this.getpagedata(this.$refs.pagination.getIndex());
                            }else{
                              this.$refs.pagination.setIndex(1);
                              this.getpagedata(this.$refs.pagination.getIndex());

                            }
                        }
                      }else{
                       
                        this.$refs.pagination.extractData(res.data)
                              this.disdata = this.$refs.pagination.disdata;
                              this.datalength = this.$refs.pagination.datalength; 
                      }
                         
                         
                         
           
                      })

                      
                   
          
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

              // 修改
                  Getupdate(personflag,item){
                    
                    if(personflag=="1"){
                      // console.log(item)
                      
                      // 只能修改自己账号用户的personid
                      var addp = that.creatPersonal(Allchild,that)
                      Allchild.clearright(Allchild);
              var updateperson = new addp().$mount('#addright')
              // 得到数据
              
              this.updata = axios.get(url+'/get.php/?taskid='+item['taskid']+"&&userid="+item['userid']).then(res=>{
                   return res.data;
                   

                  // JSON.parse(res.data);
                      })
              
                      this.updata.then((value)=>{
                        
                          updateperson.upload = value.avatar
                          updateperson.taskid = value.taskid
                          updateperson.taskname = value.taskname
                          updateperson.taskposition = value.taskposition
                          updateperson.positiondescription = value.positiondescription;
                          updateperson.jobrequirements = value.jobrequirements;
                          updateperson.getexperiencerequirement = value.experiencerequirement;
                          updateperson.address = value.address
                          updateperson.getsalary = value.salary
                          updateperson.geteducation = value.education;
                          updateperson.add = 'update';
         					updateperson.userid = value.userid
                    
        
        
        
        
        
                         if(value.proimage!=""){
                         	 var img = value.proimage;
                  img = img.split(',')
                  // console.log(updateperson.list);
                  updateperson.index = img.length;
                  for(var i = 0;i<img.length;i++){
                    updateperson.list.push({
                                    'component':'addimgc',
                                    'imgsrc':img[i],
                                    'index':i+1,
                                    'oldflag':'old'
                                })
                  }

                         }
                 
                  
                          

                      })

                  

                    }else if(personflag=="2"){
                    
                      if(document.getElementById('dialogue')!=null){

                        that.createDialog(Allchild,that,item).$mount('#dialogue')
                      }
                      
                  
                    }
                  }
                }


            }) 
      
      return tableifm;
        },
         createpersoncom(Allchild,that,getpersondata){
          var html =  '<div><personcomponent :persondata="persondata"></personcomponent></div>';
          var addPersoncom = Vue.extend({
            template: html,
            components: {personcomponent},
            data: function () {
                    return {
                       
                      persondata:getpersondata
                    }
                },
                mounted() {
                   
                },
                methods:{
                 
                }

           })
          return addPersoncom;

        },

     
        creatchildperson(Allchild,that){
          
           var updatedata =  Vue.extend({
              template: '<b-list-group-item @click.self=updateifm variant="dark">信息修改删除</b-list-group-item>',
               data:function(){
                    return {
                      change:'',
                      tableifm:"",
                    }
                },
                methods:{
                  updateifm(){
                    this.tableifm = that.creatpersontable(Allchild,that);
                    var divname=Allchild.$root.$el.getElementsByClassName("right")[0].childNodes[0].getAttribute('id')

                    if(divname!="addright"){
                      Allchild.clearright(Allchild);
              new this.tableifm().$mount('#addright')

                    }else{
                      new this.tableifm().$mount('#addright')
                    }
                    
                  }
               
                }

            })
            return updatedata;
        },

      }

       
    }

</script>
<style >
   li{
    list-style-type:none
  }
  .fullscreen{
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-color:rgba(0,0,0,0.2);

  }
  #address{
  	 width: 70%;
  margin-left: 25%;
  }
  .surebotton{
    width: 10%;
    height: 10%;
    position: absolute;
    bottom: 5%;
    left: 50%;
    margin-left: -5%;
    text-align: center;
  }
  .cannelbotton{
     width: 10%;
    height: 10%;
    position: absolute;
    bottom: 5%;
    left: 50%;
    margin-left: -5%;
    text-align: center;
  }
/*  .refunk{
    width: 300px;
    height: 300px;
    background-color: pink;
    position: absolute;
    left: 50%;
    top:50%;
    margin-left: -150px;
    margin-top: -150px;
    z-index: 300
  }*/
  .Avatar{
    height: 150px;
    width: 150px;
    position: absolute;

  }
  .uppic{
       height: 150px;
        width: 150px;
        margin: 0,0;
        opacity: 0;
        z-index: 99999;
  }
  .dispic{
    height: 150px;
    width: 150px;
     position: absolute;

  }
  .getippic{
      height: 150px;
        width: 150px;
        margin: 0,0;
        opacity: 0;
        z-index: 99999;
  }
  .getpic{
    width:150px;
    height:150px;
    float:left;
  }
  .size{
    height: 150px;
    width: 150px;
  }
  .orderli{
    float: left;
    width: 7.5%;
    text-align:center
  }


  .clearfix{
    *zoom:1;
  }
.clearfix:after{
    content: "";
    display: block;
    clear: both;
  }
.blackground{
  position:absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
/*  background-color:#000;
    opacity: 0.1;*/
  /*background-color: rgba(6,6,6,0.8);*/
}
.Dialog{
  border: 1px solid;
  width: 20%;
  height: 20%;
  position: relative;
  left: 50%;
  top: 50%;
  background-color:white;
  margin-left: -10px;
  margin-top: -10px;
  z-index:100; 

}
/*Dialogsure">确认</button><button class="Dialogcancel*/

.Dialog p{
  position: relative;
  width: 80%;
  height: 20%;
  left: 50%;
  top: 50%;
  margin-left: -40px;
  margin-top: -10px; 
  
}
.Dialogsure{
  position: relative;
  
  left: 15%;
  top: 50%;
  /*margin-left: -50px;*/
  
}
.Dialogcancel{
  position: relative;
  
  left: 25%;
  top: 50%;
  /*margin-left: -50px;*/
  
}
label{
  margin-left: 5%;
  margin-right:5%;
}
.tasklist{
  text-align: center;
  margin: auto;
}
#example-datepicker__outer_{
  /*display: inline-block;*/
  margin-left: 20%;
}
#positiondescription{
  width: 70%;
  margin-left: 25%;
}
#jobrequirements{
   width: 70%;
  margin-left: 25%;
}

/*#addpersonal #example-datepicker__dialog_{
  
}*/
table tr td{ border:1px solid #0094ff; }

</style>


















