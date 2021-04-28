<template>
  <div>
    <!-- v-rightClick = "{getrightMenuObj}" -->
   <backstage ref="child"></backstage>
   <div id="dialogue"></div>
  </div>
</template>
<script>
 import backstage from './mbackstage.vue'
 import pagination from '../pagination.vue'
 import rightclick from '../rightclick.vue'
  import optionperson from './moptionperson.vue'
   import displaymodel from './mdispalymodel/mdisplaymodel.vue'
 import Vue from 'vue'
 import axios from "axios";
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
            template:'<div class="mgetpic" :imgsrc=this.imgdata><img class="mdispic" :src=this.imgdata ><input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" class="mgetippic" @change.stop.prevent="changeImage($event)"></div>',
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
          optionperson
          
        },
        mounted:function(){
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
        // <displaymodel :personid="personid" :isdisplay=isdisplay></displaymodel>
        creatPage(Allchild,that,personid,getisdisplay){
           var html =  '<div><p v-if ="newpageflag"><displaymodel :personid="personid" :isdisplay=isdisplay></displaymodel></p><p v-if ="addflag" ><displaymodel :personid="personid" :isdisplay=isdisplay></displaymodel></p><p v-if="deleteflag">删除成功</p></div>';
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
                        isdisplay:getisdisplay

                    }
                },
            mounted:function(){
                // this.personid = personid;

            }

           })
          return new addnewpage();
        },
        createPageInstance(flag,Allchild,that,personid,getisdisplay){
            var newpage= new this.creatPage(Allchild,that,personid,getisdisplay);
                    var divname=Allchild.$root.$el.getElementsByClassName("right")[0].childNodes[0].getAttribute('id')
                   
                    if(flag=="add"){
                      newpage.newpageflag = false;
                      newpage.deleteflag = false;
                      newpage.addflag = true;
                    }else if(flag=="delete"){
                      newpage.newpageflag = false;
                      newpage.deleteflag = true;
                      newpage.addflag = false;
                    }else if(flag=="update"){
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
        creatPersonal(Allchild,that){
           // 添加一个删除函数
           // @contextmenu.prevent="deteleImage($event)"
           // <label for="personintro">个人介绍:</label><div><textarea id="personintro" rows="4" cols="50" v-model="personintro" required="required"></textarea>
           // v-rightClick = "{getrightMenuObj}"
           // <label for="personname">姓名:</label><input type="text" id="personname" v-model="personname" required="required">
    //  <label for="example-datepicker"></label><b-form-datepicker id="example-datepicker" v-model="birdthday" class="mb-2"></b-form-datepicker>
            var html =  '<form id="addpersonal"><div class="getmAvatar"><img :src="upload" class="mAvatar"><input type="file" name="avatar" id="uppic" accept="image/gif,image/jpeg,image/jpg,image/png" @change="changeImage($event)" ref="avatarInput" class="muppic"></div><input type="hidden" id="personid" v-model="personid"><br><br><div><label for="personname">姓名:</label><input type="text" id="personname" v-model="personname" required="required"><label for="gender">性别:</label><b-form-select id="getgender" v-model="gender" :options="options" size="sm"></b-form-select></div> <label for="personheight">身高:</label><input type="text" id="personheight" v-model="personheight" required="required"><label for="nationality">民族:</label><input type="text" id="nationality" v-model="nationality" required="required"><br><br><label for="personemail">邮箱:</label><input type="text" id="personemail" v-model="personemail" required="required"><label for="personmobile">手机号码:</label><input type="text" id="personmobile" v-model="personmobile" required="required"><br><br><div><label for="hometown">现居地:</label><input type="text" id="hometown" v-model="hometown" required="required"></div><label for="personeducational">学历:</label><input type="text" id="personeducational" v-model="personeducational" required="required"><br><br><label for="birdthday">出生日期:</label><b-form-datepicker id="datepicker-sm " v-model="birdthday"  size="sm" class="mb-2"></b-form-datepicker><br><br><label for="personposition">求职意向:</label><input type="text" id="personposition" v-model="personposition" required="required"><br><br><optionperson ref="addpersonmodel"></optionperson></div><input type="file" name="ppic" id="getppic" accept="image/gif,image/jpeg,image/jpg,image/png" @change="addpicture($event)" ref="ppicInput" class="ppic"><div><div v-for="(item,index) in list" :is="item.component" :imgsrc="item.imgsrc" :indexnum="item.index" :oldflag="item.oldflag" :key="item" v-rightClick = "{getrightMenuObj}" ></div></div><br><br><input type="button" value="提交" class="submit" @click="Push()"/><p v-if="imgmeg!=stringflag">{{imgmeg}}</p><rightclick ref="rightclick"></rightclick></form>'
            var addpersonal = Vue.extend({
              template: html,
              components: {
                'addimgc':addimage,
                rightclick,
                optionperson
                },
                data: function () {
                    return {
                      imgmeg:"",
                      stringflag:"",
                        change:"",
                        personid:"",
                        birdthday:"",
                        // personinfo:"",
                        personname:"",
                        personheight:"",
                        nationality:"",
                        personemail:"",
                        personmobile:"",
                        personposition:"",
                        hometown:"",
                        personeducational:"",
                        certdescription:"",
                        selfdescription:"",
                        isdisplay:'0',
                        gender:0,
                        options:[
                      { value: 0, text: '女' },
                      { value: 1, text: '男' },
                       
                ],
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
                      axios.get('http://localhost:5001/getpicture.php/?picture=getpicture').then(res=>{
                        
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
         //        getuserid(perbaseinfo){
         //              var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // // console.log(sessionid)
         //              axios.post('http://localhost:5001/checksession.php',{sessionid:sessionid}).then(res=>{
         //                  perbaseinfo['userid'] = res.data['userid'];
         //              })
         //        },
                Push(){
                      // console.log(this.$refs)
                      // 对内容进行验证
                  var judgeempty = [this.birdthday,this.personname,this.personheight,this.nationality,this.personemail,this.personposition,this.hometown,this.personmobile];
                      for(var i = 0;i<judgeempty.length;i++){
                        if(judgeempty[i]==""){
                          console.log("内容为空")
                          // 弄一个转跳页面
                          return;
                        }
                      }
                var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
                      axios.post('http://localhost:5001/checksession.php',{sessionid:sessionid}).then(res=>{
                          if(this.add!='update'){
                      
                      this.add = 'add';
                      
                    }
                    this.getimagesrc = this.$refs.ppicInput.nextElementSibling.children;
                  
                
                    if(this.add=='add'){
                      this.personid='personal'+Number(Math.random().toString().substr(3,length) + Date.now()).toString(36);
                      
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
                   perbaseinfo['flag'] ='personal';
                   perbaseinfo['personname'] = this.personname;
                  
                   perbaseinfo['userid'] =res.data['userid']
                   perbaseinfo['personid'] = this.personid
                   perbaseinfo['avatar'] = this.upload
                   perbaseinfo['proimage'] = this.listBolb
                   perbaseinfo['imagenum'] = this.imagenum
                   perbaseinfo['method'] = this.add
                   perbaseinfo['deleteimgid'] = this.deleteimgid
                   perbaseinfo['listindex'] = listindex;
                   perbaseinfo['addnum'] = this.addnum;
                   perbaseinfo['personheight'] = this.personheight;
                   perbaseinfo['nationality'] = this.nationality;
                   perbaseinfo['personemail'] = this.personemail;
                   perbaseinfo['personmobile'] = this.personmobile;
                   perbaseinfo['personposition'] = this.personposition;
                   perbaseinfo['hometown'] = this.hometown;
                   perbaseinfo['personeducational'] = this.personeducational;
                   perbaseinfo['birdthday'] = this.birdthday;
                   perbaseinfo['gender'] = this.gender;
                   perbaseinfo['isdisplay'] =this.isdisplay;
                    if(typeof(this.$refs.addpersonmodel.modelobject['certificate']) != "undefined"){
                      perbaseinfo['certificate'] =this.$refs.addpersonmodel.modelobject['certificate'];
                    }
                    if(typeof(this.$refs.addpersonmodel.modelobject['selfevaluation']) != "undefined"){
                      perbaseinfo['selfevaluation'] =this.$refs.addpersonmodel.modelobject['selfevaluation'];
                    }
                 
                   var perjob = {};
                   var peredc = {};

                  
                   if((this.$refs.addpersonmodel.edcjudgeflag["downflag"]==false&&this.$refs.addpersonmodel.edcjudgeflag["upflag"]==false)||JSON.stringify(this.$refs.addpersonmodel.edcjudgeflag) === '{}'){
                      this.$refs.addpersonmodel.edcpushflag=true;
                   }
                   if((this.$refs.addpersonmodel.jobjudgeflag["downflag"]==false&&this.$refs.addpersonmodel.jobjudgeflag["upflag"]==false)||JSON.stringify(this.$refs.addpersonmodel.jobjudgeflag) === '{}'){
                      this.$refs.addpersonmodel.pushflag=true;
                   }
                   // this.$refs.addpersonmodel.pushflag=true;
                   
                   if(typeof(this.$refs.addpersonmodel.modelobject['workexperience']) != "undefined"){
                      perjob = this.$refs.addpersonmodel.modelobject['workexperience']
                   }
                   if(typeof(this.$refs.addpersonmodel.modelobject['edcexperience']) != "undefined"){
                      peredc = this.$refs.addpersonmodel.modelobject['edcexperience']
                      
                   }
                  
                   // console.log(peredc);
                   
                  

                  
                  
                  // 由于图片有缓存的问题
                  // 所以显示不出来的，如果进行图片更换的话
                  // 要对原先的图片进行删除
                  // 再进行添加
                
                 axios.post('http://localhost:5001/person.php',{perbaseinfo:perbaseinfo,perjob:perjob,peredc:peredc}).then(res=>{
                    console.log(res.data)
                    // console.log(res.data);
                              

                })
                  var getpersonid = this.personid
                      var getisdisplay = this.isdisplay
                      that.creatPage(Allchild,that,getpersonid,getisdisplay);
                      that.createPageInstance(this.add,Allchild,that,getpersonid,getisdisplay);
                 
                })
                   
                
                      
                  // 重新赋值
                //提取成一个方法
                     
                     
               
                    
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
                template:'<div><table><tr><th v-for="(item, index) in tdhead" v-if="index ==1||index >=3">{{item}}</th></tr><tr v-for="(data,index) in disdata" v-if="index<datalength"><td>{{data["personname"]}}</td><td>{{data["personinfo"]}}</td><td @click=Getupdate(1,data)>修改</td><td @click=Getupdate(2,data)>删除</td></tr></table><pagination ref="pagination" @getpageData="getpagedata"></pagination></div>',
                 components: {
                  pagination
         
          
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
                      tdhead:['Id','名称',"价格","介绍",'修改','删除']

                    }
                },
                mounted() {
                
                  this.$refs.pagination.pagename = "pagetabele"
                  this.$refs.pagination.showname = "showtabele"
                  this.$refs.pagination.totalnumname = "totalnumtable"
                  this.$refs.pagination.totalpagename = "totalpagetable"
                  
                
                    this.getpersontable();
                 
                  
                  
                },
                methods:{
                  getpagedata(index){
                     var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
                      axios.post('http://localhost:5001/checksession.php',{sessionid:sessionid}).then(res=>{
                          // var userid = JSON.parse(sessionStorage.getItem('vue-session-key'))['username'][1];
                          var userid = res.data['userid']
                      this.$refs.pagination.show = "Boss"
                      
                       axios.get('http://localhost:5001/gettablepage.php/?page='+index+'&&totalnum='+ this.$refs.pagination.totalnum+'&&size=2&&show='+this.$refs.pagination.show+'&&userid='+userid).then(res=>{
                      
                            this.$refs.pagination.extractpageData(res.data,index);
                              this.disdata = this.$refs.pagination.disdata;
                              this.datalength = this.$refs.pagination.datalength; 
                          // console.log(res.data)
              
           
                     })

                      })
                    
                     
                  },
                  getpersontable(){
                    // 得到自己用户的数据
                    var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
                     axios.post('http://localhost:5001/checksession.php',{sessionid:sessionid}).then(res=>{
                        this.flag="persontable"
                    this.show='Boss';
                    // var userid = JSON.parse(sessionStorage.getItem('vue-session-key'))['username'][1];
                    var userid = res.data['userid'];
                    // console.log(userid);
                    axios.get('http://localhost:5001/gettable.php/?show='+this.show+'&&flag='+this.flag+'&&userid='+userid).then(res=>{
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
              
              this.updata = axios.get('http://localhost:5001/get.php/?personid='+item['personid']+"&&userid="+item['userid']).then(res=>{
                   return res.data;
                   

                  // JSON.parse(res.data);
                      })
              
                      this.updata.then((value)=>{
                        
                          updateperson.upload = value.avatar
                          updateperson.personid = value.personid
                          updateperson.personname = value.personname
                          updateperson.personheight = value.personheight
                          updateperson.nationality = value.nationality
                          updateperson.personemail = value.personemail
                          updateperson.personmobile = value.personmobile
                          updateperson.personposition = value.personposition
                          updateperson.hometown = value.hometown
                          updateperson.personeducational = value.personeducational
                          updateperson.birdthday = value.birdthday
                          updateperson.gender = value.gender
                          updateperson.add = 'update';
                          updateperson.isdisplay=value.isdisplay;
                          updateperson.$refs.addpersonmodel.selfevaluationdata="";
                          updateperson.$refs.addpersonmodel.certificatedata ="";
         //                 updateperson.$refs.addpersonmodel.edcexperiencedata={};
         //                 updateperson.$refs.addpersonmodel.workexperiencedata={};
                          if(typeof(value.selfevaluation) != "undefined"&&value.selfevaluation!==null){
                            updateperson.$refs.addpersonmodel.list.push({
                              'component':"selfevaluation",
                            'title':"selfevaluation"
                            })
                            updateperson.$refs.addpersonmodel.selfevaluationdata=value.selfevaluation
                          }
                          if(typeof(value.certificate) != "undefined"&&value.selfevaluation!==null){
                            updateperson.$refs.addpersonmodel.list.push({
                              'component':"certificate",
                            'title':"certificate"
                            })
                            updateperson.$refs.addpersonmodel.certificatedata = value.certificate;
                          }
                          if(typeof(value.edc) != "undefined"&&value.edc.length>0){
                            if(this.getdatanull(value.edc[0])){
                                updateperson.$refs.addpersonmodel.list.push({
                              'component':"edcexperience",
                            'title':"edcexperience"
                            })
                            var studylist = [];
                            updateperson.$refs.addpersonmodel.edcmethod ="update"; 
                            for(var i =0;i<value.edc.length;i++){
                            //   val['val'] = value.edc[i]
                                      studylist.push({'val':value.edc[i]});
                                  }
                           
                                  updateperson.$refs.addpersonmodel.studylist =studylist;

                            }
                          

                          }
                          if(typeof(value.job) != "undefined"&&value.job.length>0){
                            if(this.getdatanull(value.job[0])){
                              updateperson.$refs.addpersonmodel.list.push({
                              'component':"workexperience",
                            'title':"workexperience"
                            })
                            var joblist = [];
                            updateperson.$refs.addpersonmodel.jobmethod ="update"; 
                            for(var i =0;i<value.job.length;i++){
                            //   val['val'] = value.edc[i]
                                      joblist.push({'val':value.job[i]});
                                  }
                           
                                  updateperson.$refs.addpersonmodel.joblist =joblist;

                            }
                            
                          }

                  // var img = value.proimage;

                  if(value.proimage==''||value.proimage===null||typeof(value.proimage) == undefined){
                                   delete value.proimage;
                              }else{
                                if(value.proimage.indexOf(",")!=-1){
                                    value.proimage = value.proimage.split(",");
                                }else{
                                  var getimg = [value.proimage]
                                  value.proimage =getimg;
                                }
                              }
                  if(value.proimage){
                      var img = value.proimage;
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
                  console.log(id["personid"])
                },
                methods:{
                  confirm(){
                    
                    this.updata = axios.get('http://localhost:5001/del.php/?personid='+id.personid+'&&method=delete&&userid='+id.userid).then(res=>{
                        console.log(res.data)
                      })
                    that.createPageInstance("delete",Allchild,that,id.personid,id.userid);
                    this.reload();
                  
                  },

                  cancel(){
                      this.reload();
                  
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
        creatchildperson(Allchild,that){
          // <ul><li @click.self=updateifm>个人信息修改删除</li></ul>
           var updatedata =  Vue.extend({
              template: '<b-list-group-item @click.self=updateifm variant="dark">个人信息修改删除</b-list-group-item>',
               data:function(){
                    return {
                      change:'',
                      tableifm:"",
                    }
                },
                methods:{
                  updateifm(){
                    Allchild.displayflag = false;
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
          // <div><ul><li @click=publish()>个人介绍</li><li v-if="this.flag" :is="updatedata"></li></ul></div>
        var updatedata = that.creatchildperson(Allchild,that);
        var Profile = Vue.extend({
                template:'<div class="tasklist"> <b-list-group><b-list-group-item @click=publish() variant="dark">个人介绍</b-list-group-item><b-list-group-item v-if="this.flag" :is="updatedata"></b-list-group-item></b-list-group></ul></div>',
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
                        Allchild.displayflag = false;
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
<style scoped="scoped">
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
  .surebotton{
    width: 100px;
    height: 20px;
    position: absolute;
    bottom: 10px;
    left: 50%;
    margin-left: -100px;
    text-align: center;
  }
  .cannelbotton{
    width: 100px;
    height: 20px;
    position: absolute;
    bottom: 10px;
    left: 50%;
    margin-left: 10px;
    text-align: center;
  }
 
  .getmAvatar{
    height: 100px;
    width: 50%;
     position:relative;
  }
  .mAvatar{
    height: 100%;
    width: 100%;
    position: absolute;

  }
  .muppic{
       height:100%;
        width: 100%;
        margin: 0,0;
        opacity: 0;
        z-index: 99999;
  }
  .mdispic{
    height: 100%;
    width: 100%;
     position: absolute;

  }
  .mgetippic{
      height: 100%;
        width: 100%;
        margin: 0,0;
        opacity: 0;
        z-index: 99999;
  }
  .mgetpic{
    width:50%;
    height:100px;
    position: relative;
    float:left;
  }
  .size{
    height: 20%;
    width: 20%;
  }
  .orderli{
    float: left;
    width: 7.5%;
    text-align:center
  }
  .orderul{
    width:900px;
    height: 100px;
  }
  .orderfirstul{
    width: 900px;
    height: 20px;
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
#personmobile{
  width: 10%;
}
#getbirdthday{
  width: 20%;
}
#personname{
  width: 10%;
}
#nationality{
  width: 10%;

}
#personheight{
  width: 20%;
  
}
#hometown{
  width: 80%;
}
/*#addpersonal .custom-select{
  width: 80%;
  margin-left: 20%
}*/
select#getgender {
  width: 30% !important;
  display: inline-block;
}

/*#addpersonal .form-control{
  width: 80%;
   margin-left: 20%;
  display:inline-block;
  /*padding: 0.375rem 0.75rem;*/
  /*height: calc(1.5em + 0.75rem + 2px);*/

/*}*/
/*#example-datepicker__outer_{
  display: inline-block;
  margin-left: 20%;
}*/
/*#addpersonal #example-datepicker__dialog_{
  
}*/
table tr td{ border:1px solid #0094ff; }

</style>


















