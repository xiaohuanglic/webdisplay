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
 import rightclick from './rightclick.vue'
  import personcomponent from './person/personcomponent.vue'
  // import optionperson from './optionperson.vue'
   import taskmodel from './taskmodel.vue'
   import displaymodel from './dispalymodel/displaymodel.vue'
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
            template:'<div class="getpic" :imgsrc=this.imgdata><img class="dispic" :src=this.imgdata ><input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" class="getippic" @change.stop.prevent="changeImage($event)"></div>',
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
          rightclick,
          taskmodel,
          personcomponent
         
          
        },
        mounted:function(){
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
          var Profile = this.personalIntro(this.Allchild,that);
          new Profile().$mount('#addleft');
        },

        data() {
        return{
          Allchild:"",
         
        
        }
        
      },
      methods:{
        // getrightMenuObj(){
        //  this.$refs.rightclick.getrightMenuObj()
        // },
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
            var html =  '<form id="addtask"><div><img :src="upload" class="Avatar"><input type="file" name="avatar" id="uppic" accept="image/gif,image/jpeg,image/jpg,image/png" @change="changeImage($event)" ref="avatarInput" class="uppic"></div></br><input type="hidden" id="taskid" v-model="taskid"><label for="taskname">公司名称:</label><input type="text" id="taskname" v-model="taskname" required="required"></br></br><label for="taskposition">公司职位:</label><input type="text" id="taskposition" v-model="taskposition" required="required"></br></br><label for="address">填写地址:</label><div><b-form-textarea id="address" v-model="address" placeholder="输入地址" rows="3" max-rows="6"></b-form-textarea></div><label for="positiondescription">职位描述:</label><div><b-form-textarea id="positiondescription" v-model="positiondescription" placeholder="Enter something..." rows="3" max-rows="6"></b-form-textarea></div><label for="jobrequirements">任职要求:</label><div><b-form-textarea id="jobrequirements" v-model="jobrequirements" placeholder="Enter something..." rows="3" max-rows="6"></b-form-textarea></div><taskmodel v-on:experiencerequirement="experiencerequirement" v-on:education="education" v-on:salary="salary" :getexperiencerequirement="getexperiencerequirement" :geteducation="geteducation" :getsalary="getsalary"></taskmodel><input type="file" name="ppic" id="getppic" accept="image/gif,image/jpeg,image/jpg,image/png" @change="addpicture($event)" ref="ppicInput" class="ppic"><div><div v-for="(item,index) in list" :is="item.component" :imgsrc="item.imgsrc" :indexnum="item.index" :oldflag="item.oldflag" :key="item" v-rightClick = "{getrightMenuObj}" ></div></div><br><br><input type="button" value="提交" class="submit" @click="Push()"/><p v-if="imgmeg!=stringflag">{{imgmeg}}</p><rightclick ref="rightclick"></rightclick></form>'
            var addpersonal = Vue.extend({
              template: html,
              components: {
                'addimgc':addimage,
                rightclick,
                taskmodel,
                },
                data: function () {
                    return {
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
                        rightMenuObj: {
                        text: [
                            "删除图片",
                            "取消"
              
                        ],
                        handler: {
                          // deletepicture(){

                          // }
              
                        }
                      },
                       

                    }
                },
                mounted() {
                    // 先判断得到的数据有没有5条；
                    // 如果超过5条则按键不能使用

                  
                    if(this.add!='update'){
                        // console.log(1);
                      axios.get(url+'/getpicture.php/?picture=getpicture').then(res=>{
                        
                          this.upload = res.data
                      })
                    }else if(this.add=='update'){
                      console.log(2);
              
                    }
                  
                  

                 
                },
                watch:{
                  // 能够触发
                    list:function(){
                          var that = this;
                   
                    }
                },

                methods:{
                  experiencerequirement(value){
                     this.getexperiencerequirement = value;
                  },
                  education(value){
                      this.geteducation = value;
                  },
                  salary(value){
                    this.getsalary = value;
                  },
                  getrightMenuObj(rightMenuTop,rightMenuLeft,e){
                      var that = this;
                      this.rightMenuObj.handler.deletepicture = function deletepicture(){
                                  // console.log(e);
                                  that.deteleImage(e)
                                   that.$refs.rightclick.rightMenuStatus = "none";
                                  that.$refs.rightclick.rightMenuTop = "0px";
                                  that.$refs.rightclick.rightMenuLeft = "0px";
                              };
                       this.rightMenuObj.handler.cancel = function cancel(){
                                  that.$refs.rightclick.rightMenuStatus = "none";
                                  that.$refs.rightclick.rightMenuTop = "0px";
                                  that.$refs.rightclick.rightMenuLeft = "0px";
                              };
                      this.$refs.rightclick.rightMenuObj = this.rightMenuObj
                       this.$refs.rightclick.getrightMenuObj(rightMenuTop,rightMenuLeft,e);
                       // this.$refs.rightclick.rightMenuStatus = 'block'
                  },
                
                  changeImage(e){
                     var file = e.target.files[0]
                     var reader = new FileReader()
                     var file = e.target.files[0]
                    this.limitimgsize(file);
                     var that = this
                     reader.readAsDataURL(file)
                     reader.onload = function(e){
                      that.upload=this.result
                     }
                    
                  },
               
                  deteleImage(e){
                    // 拿到index
                    // 修改list里面的index的数字,以及删除list里面的组件
                    // 之后要到后台，删除相关的图片
                   
                    var deleteindex = parseInt(e['path'][1]['attributes']['indexnum']['value']);
                    // console.log(deleteindex);
                     for(var i = 0;i<this.list.length;i++){
                        if(parseInt(this.list[i]['index'])==deleteindex){

                          this.equealid.push(parseInt(this.list[i]['index']));
                          // this.deletepath.push(this.list[i]['imgsrc'])
                          this.list.splice(i,1);
                          // 移出来
                         this.Moveforward(i)
                          this.index = this.list.length;
                          
                          return ;
                        }
                     //    // console.log(this.list[i])
                     }
                      
                  },

                  Moveforward(i){
                   
                      while(i<this.list.length){
                              this.list[i]['index'] = this.list[i]['index']-1;
                              i++;
                          }
                   
                     
                  
                  },
                Push(){
                      var judgeempty = [this.taskposition,this.taskname,this.positiondescription,this.jobrequirements,this.getsalary,this.address,this.getexperiencerequirement,this.geteducation];
                      for(var i = 0;i<judgeempty.length;i++){
                        if(judgeempty[i]==""){
                          // console.log("内容为空")
                          // 弄一个转跳页面
                          return;
                        }
                      }
                      // console.log(this.$refs)
                      // 对内容进行验证
                        var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
                      axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                         if(this.add!='update'){
                      
                      this.add = 'add';
                      
                    }
                    this.getimagesrc = this.$refs.ppicInput.nextElementSibling.children;
                  
                
                    if(this.add=='add'){
                      this.taskid='task'+Number(Math.random().toString().substr(3,length) + Date.now()).toString(36);
                      
                    }
                //    得到相关的修改图片的数据
                  // this.Moveforward(this.moveforwardid);
                    var listindex = []
                    for(var i = 0;i<this.list.length;i++){
                      listindex.push(this.list[i]['index'])
                    }
                    this.deleteimgid = this.equealid;
                  var a = 0;

                    for(var i=0;i<this.getimagesrc.length;i++){
                      
                      
                      var imagevalue = this.getimagesrc[i]['attributes'][0]['value'];
                      var imagenum = this.getimagesrc[i]['attributes'][2]['value'];
                      var checkflag = this.getimagesrc[i]['attributes'][3]['value'];
                      
                      this.listBolb[i] = imagevalue;
                     
                       if(imagevalue.indexOf('data:image')>-1){
                          if(checkflag=="old"){
                            this.imagenum[a] = parseInt(imagenum);

                          a++;
                          
                          }else{
                            this.addnum.push(parseInt(imagenum));
                          }
                        
                     }  
                
                        
                      }
                    a = 0;
                    
                   // 先把必填的，和选填的弄成一个对象

                   var perbaseinfo ={};
                   perbaseinfo['flag'] ='task';
                   perbaseinfo['taskname'] = this.taskname;
                   // perbaseinfo['userid'] = JSON.parse(sessionStorage.getItem("vue-session-key"))['username'][1];
                   perbaseinfo['userid'] = res.data['userid'];
                   perbaseinfo['taskid'] = this.taskid
                   perbaseinfo['avatar'] = this.upload
                   perbaseinfo['proimage'] = this.listBolb
                   perbaseinfo['imagenum'] = this.imagenum
                   perbaseinfo['method'] = this.add
                   perbaseinfo['deleteimgid'] = this.deleteimgid
                   perbaseinfo['listindex'] = listindex;
                   perbaseinfo['addnum'] = this.addnum;
                   perbaseinfo['taskposition'] = this.taskposition;
                   perbaseinfo['address'] = this.address;
                  perbaseinfo['experiencerequirement'] = this.getexperiencerequirement;
                  perbaseinfo['education'] = this.geteducation;
                  perbaseinfo['salary'] = this.getsalary;
                  perbaseinfo['jobrequirements'] = this.jobrequirements;
                  perbaseinfo['positiondescription'] = this.positiondescription;
                  // 由于图片有缓存的问题
                  // 所以显示不出来的，如果进行图片更换的话
                  // 要对原先的图片进行删除
                  // 再进行添加
               
                 axios.post(this.$url+'/task.php',{perbaseinfo:perbaseinfo}).then(res=>{
                    
                    console.log(res.data);
                              

                })
                 

                      })
                   
            
                     
               
                    
                  },
                  limitimgsize(file){
                     var fileSize = 0;
              fileSize = file.size
                    var size = fileSize / 1024;
              if(size>1000){
                this.imgmeg = "图片超出大小"
                return false;   //阻止submit提交
              }
                  },
                  addpicture(e){
                   
                    if(this.index>8){
                    
                      return "图片不能超过8张"
                    }
                    var file = e.target.files[0]
                    this.limitimgsize(file);
                    for(var i =0;i<this.picname.length;i++){
                      if(file.name == this.picname[i]){
                        console.log("重命名请修改名字");
                        return;
                      }
                     }
                    this.picname.push(name);
                    var reader = new FileReader()
            
                    var that = this
                    reader.readAsDataURL(file)

                    reader.onload = function(e){
                   
                   
                    if(that.index<=8&&that.index>0){
                        that.list.push({
                          'component':'addimgc',
                          'imgsrc':this.result,
                          'index':that.index,
                          'oldflag':'new'
                        })
                       

                    }
                     
                     
                     
                    }
                    this.index++;
                    
                    
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
                template:'<div><table><tr><th v-for="(item, index) in tdhead" v-if="index ==1||index >=3">{{item}}</th></tr><tr v-for="(data,index) in disdata" v-if="index<datalength"><td>{{data["taskname"]}}</td><td>{{data["personinfo"]}}</td><td @click=Getupdate(1,data)>修改</td><td @click=Getupdate(2,data)>删除</td><td @click=viewresume(data)>查看简历</td></tr></table><pagination ref="pagination" @getpageData="getpagedata"></pagination></div>',
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
                      tdhead:['Id','名称',"价格","介绍",'修改','删除',"查看简历"]

                    }
                },
                mounted() {
                  // 得到数据进行修改
                  // 可以运用main的显示方法
                  // console.log(this.$refs.pagination)
                    // pagename:"",
                    // showname:"",
                    // totalnumname:"",
                    // totalpagename:""
                  this.$refs.pagination.pagename = "taskpagetabele"
                  this.$refs.pagination.showname = "taskshowtabele"
                  this.$refs.pagination.totalnumname = "tasktotalnumtable"
                  this.$refs.pagination.totalpagename = "tasktotalpagetable"
                  
                
                    this.getpersontable();
                 
                  
                  
                },
                methods:{
                  viewresume(data){
                    // console.log(data['taskid'])
                    // createpersoncom
                    var resume={};
                    resume['taskid'] = data['taskid']
                    var that1 = that
                     axios.post(this.$url+'/resume.php',{resume:resume}).then(res=>{   
                           that.Allchild.clearright(that.Allchild)
                             // Allchild.clearright(Allchild);
                            var creatcreatpersoncom = that1.createpersoncom(that.Allchild,that,res.data); 
                            new creatcreatpersoncom().$mount('#addright');
                          })
                    
                  },
                  getpagedata(index){
                    // 先把任务的数量拿出来
                     var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
                      axios.post(this.$url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                         // var userid = JSON.parse(sessionStorage.getItem('vue-session-key'))['username'][1];
                          var userid = res.data['userid'];
                      this.$refs.pagination.show = "Free"
                      
                       axios.get(this.$url+'/gettablepage.php/?page='+index+'&&totalnum='+ this.$refs.pagination.totalnum+'&&size=2&&show='+this.$refs.pagination.show+'&&userid='+userid).then(res=>{
                      
                            this.$refs.pagination.extractpageData(res.data,index);
                              this.disdata = this.$refs.pagination.disdata;
                              this.datalength = this.$refs.pagination.datalength; 
                          // console.log(res.data)
              
           
                     })
                      })
                     
                     
                  },
                  getpersontable(){
                    // 得到自己自己企业任务的信息
                      var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
                      axios.post(this.$url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                         this.flag="persontable"
                    this.show='Free';

                    // var userid = JSON.parse(sessionStorage.getItem('vue-session-key'))['username'][1];
                     var userid =res.data['userid'];
                    // console.log(userid);
                    axios.get(this.$url+'/gettable.php/?show='+this.show+'&&flag='+this.flag+'&&userid='+userid).then(res=>{
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
                              // this.$refs.pagination.totalnum = this.$refs.pagination.getTotalnum();
                              
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

        createDialog(Allchild,that,id){
          var html =  '<div class="blackground" id="mountdialogue"><div class="Dialog"><p>是否确认删除</P><button class="Dialogsure" @click="confirm">确认</button><button class="Dialogcancel" @click="cancel">取消</button></div></div>';
          var addDialog = Vue.extend({
            template: html,
            data: function () {
                    return {
                        newpageflag:true

                    }
                },
                mounted() {
                  // document.getElementsByClassName('blackground')[0].style.display = 'block'
                },
                methods:{
                  confirm(){
                    
                    this.updata = axios.get(url+'/del.php/?taskid='+id.taskid+'&&method=delete&&userid='+id.userid).then(res=>{
                        console.log(res.data)
                      })
                    that.createPageInstance("delete",Allchild,that);
                  
                    this.reload();
                   
                  },

                  cancel(){
                      this.reload()
                   
                    
                  },

                  reload(){
                    var self = document.getElementById('mountdialogue');
                    var parent = self.parentElement;
                    parent.removeChild(self);
                    var childNode = document.createElement('div');
                    childNode.setAttribute('id','dialogue')
                    parent.appendChild(childNode);
                  }
                }

           })
          return new addDialog();

        },

        // 分出去
        // <ul><li @click.self=updateifm>信息修改删除</li></ul>
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
        personalIntro(Allchild,that){
          // var creatchildperson = this.creatchildperson();
          // var creatPersonal = this.creatPersonal();
          // 创建个人信息
          // <div class="tasklist"><ul><li @click=publish()>添加企业介绍</li><li v-if="this.flag" :is="updatedata"></li></ul></div>
        var updatedata = that.creatchildperson(Allchild,that);
        var Profile = Vue.extend({
                template:'<div class="tasklist"> <b-list-group><b-list-group-item @click=publish() variant="dark">添加企业介绍</b-list-group-item><b-list-group-item v-if="this.flag" :is="updatedata"></b-list-group-item></b-list-group></ul></div>',
                components: {
                  'updatedata':updatedata,
                
                },
                data:function(){
                    return {
                         flag:0,
                         updatedata:'',
                         personflag:0,
                         
                    }
                },
                methods:{
                    publish(){
                      
                        this.flag=!this.flag;
                        this.updatedata='updatedata'
                        var divname=Allchild.$root.$el.getElementsByClassName("right")[0].childNodes[0].getAttribute('id')
                        var addperson = that.creatPersonal(Allchild,that);
                      
                        if(divname!="addright"){
                          Allchild.clearright(Allchild)
                        }
                        
                  
                    new addperson().$mount("#addright");
                    
                    
                        
                   
                        
                    }
                }
            })
              

                 
            
            return Profile;

        }
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


















