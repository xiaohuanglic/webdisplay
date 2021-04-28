<template>
  <div >
     <b-form-select class="getselect"v-model="selected" :options="options" size="sm">选择你添加的模块</b-form-select>
     <div  v-for="(item,index) in list" :is="item.component" :name="item.title" v-rightClick ="{getrightMenuObj}" v-on:certificatevalue="certificatevalue" v-on:edcexperiencevalue="edcexperiencevalue" v-on:selfevaluationvalue="selfevaluationvalue" v-on:workexperiencevalue="workexperiencevalue" :certificatedata="certificatedata" :selfevaluationdata="selfevaluationdata" :edcexperiencedata="edcexperiencedata" :workexperiencedata="workexperiencedata" v-on:edcexperienceflag="edcexperienceflag" v-on:workexperienceflag="workexperienceflag" :pushflag="pushflag" :edcpushflag ="edcpushflag" :studylist="studylist" :joblist="joblist" :edcmethod="edcmethod" :jobmethod="jobmethod">
       <!-- <workexperience></workexperience> -->
       
     </div>
     <rightclick ref="rightclick"></rightclick>
   <!--  <b-form-select v-model="selected" :options="options" size="sm" class="mt-3"></b-form-select> -->
    <!-- <div class="mt-3">Selected: <strong>{{ selected }}</strong></div> -->
    
  </div>
</template>
<script>
import axios from "axios";
import workexperience from './moptionpersonmodel/workexperience.vue';
import edcexperience from './moptionpersonmodel/edcexperience.vue';
import rightclick from '../rightclick.vue';
import certificate from './moptionpersonmodel/certificate.vue';
import selfevaluation from './moptionpersonmodel/selfevaluation.vue';
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
    components: {
      workexperience,
      edcexperience,
      certificate,
      rightclick,
      
      selfevaluation
          
    },
    data() {
      return {
       selected: null,
        options: [
          { value: 'workexperience', text: '增加工作经历模块' },
          { value: 'edcexperience', text: '增加教育背景模块' },
          { value: 'certificate', text: '增加证书奖励模块' },
          { value: 'selfevaluation', text: '增加自我评价模块'},
         
        ],
        modelobject:{},
        edcjudgeflag:{},
        jobjudgeflag:{},
        list:[],
        certificatedata:"",
        selfevaluationdata:"",

        edcexperiencedata:{
          
        },
        workexperiencedata:{

        },
        joblist:[],
        studylist:[],
        edcmethod:"add",
        jobmethod:"add",
        pushflag:false,
        edcpushflag:false,
        rightMenuObj: {
          text: [
                "删除该模块",
                "取消"
              
            ],
            handler: {
                // deletemodel(ev){
                //   console.log("删除该模块")
                // }
              
            }
      },
      }
    },
    watch:{
      selected:function(newval){
        // 判断是否已经拥有该组件
        for(var i = 0;i<this.list.length;i++){
          if(this.list[i]['component']==newval){
             
              return;
          }
        }
        this.list.push({
          'component':newval,
          'title':newval
        })
        
      },
   

    


    },
    methods: {
       getrightMenuObj(rightMenuTop,rightMenuLeft,e){
                      var that = this;
                    
                      this.rightMenuObj.handler.deletemodel = function deletemodel(){
                                  
                                  that.deletemodel(e)
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
                       this.$refs.rightclick.rightMenuStatus = 'block'
                  },
      deletemodel(e){
        
          var deletename = "";
         for(var i = 0;i<e['path'].length;i++){
           var deletenode = e['path'][i]['attributes']
           if(typeof(deletenode) != "undefined"){
               if(deletenode.hasOwnProperty("name")){
                
                deletename = e['path'][i]['attributes']['name']['value'];
              
              }
           }
            
           
         }
         
         var temp = 0
         for(var i =0;i<this.list.length;i++){
            if(this.list[i]['title']==deletename){
              temp = i
              break;
            }
         }
         this.list.splice(temp,1);
         delete this.modelobject[deletename];
         // 清除相关的数据
         // console.log(this.list)
      },
      certificatevalue: function (childValue) {
        // childValue就是子组件传过来的值
        this.modelobject['certificate'] = childValue;
        // this.certificatevalue = childValue;
      },
      selfevaluationvalue:function(childValue){
        // this.selfdescription = childValue
        this.modelobject['selfevaluation'] = childValue;
      },
      edcexperiencevalue:function (value) {
        // childValue就是子组件传过来的值
        // console.log(value);
        this.modelobject['edcexperience'] = value;
        // this.eduobject = value;
      },
      workexperiencevalue:function(value){
        this.modelobject['workexperience'] = value;
      },
      edcexperienceflag:function(value){
      	this.edcjudgeflag = value;

      },
      workexperienceflag:function(value){
      	this.jobjudgeflag = value
      }

      // onContext(ctx) {
      //   this.context = ctx
      // }
    }

    }
</script>
<style scoped>
.getselect{
  width: 70%;
  margin-left: 5%;
  display: inline-block;
}
</style>