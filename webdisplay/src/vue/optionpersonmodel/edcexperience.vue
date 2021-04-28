<template>
	<div>
    
    <div id="edcexperience">
    <div>
     <label for="example-datepicker">学习开始时间</label>
        <b-form-datepicker id="example-datepicker" v-model="edustrattime" class="mb-2"></b-form-datepicker>
    
    <label for="example-datepicker">学习结束时间</label>
        <b-form-datepicker id="example-datepicker" v-model="eduendtime" class="mb-2"></b-form-datepicker>
    </div>
    <label for="edcschool">学校名称</label><input type="text" id="edcschool" v-model="edcschool" required="required">
    <div class="description">
    <label for="edcdescription">技能描述:</label><br>
    <b-form-textarea
      id="textarea"
      v-model="edcdescription"
      placeholder="Enter something..."
      rows="4"
      max-rows="6"
    ></b-form-textarea>
    </div>
    <b-button size="sm" class="workadd" @click="addeduexpericence" id="edcadd">添加另一份学习经历</b-button>
     <b-button size="sm" class="workadd" @click="updata" id="updec">显示上一页</b-button>
    <b-button size="sm" class="workadd" @click="downdata" id="dowmedc" :disabled="dowmdisable">显示下一页</b-button>
     <b-button size="sm" class="workadd" @click="deletedata" id="deledc" :indexlist="listindex">删除</b-button>
  </div>
	</div>
</template>
<script>
import axios from "axios";
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
  props:['edcexperiencedata','edcpushflag','edcmethod','studylist'],
    data() {
      return {
        edustrattime:"",
        eduendtime:"",
        edcschool:"",
        edcdescription:"",
        peredcid:"",
        edclist:[],
        dowmdisable:true,
        index:0,
        totalpage:0,
        pageflag:true,
        upflag:false,
        downflag:false,
        refresh:false,
        listindex:0,
        endflag:false,
        updateendflag:false,
        // context: null
      }
    },
    mounted:function(){
     if(this.edcmethod=="update"){
          document.getElementById("updec").disabled = true;
          document.getElementById("edcadd").disabled = true;
          this.dowmdisable = false
     }
     if(this.edcmethod=="update"&&this.studylist.length==0){
          document.getElementById("updec").disabled = false;
          this.dowmdisable = false
     }
     if(this.studylist.length>0){
      this.edclist = this.studylist;
      this.edustrattime = this.edclist[0]['val']["edustrattime"];
      this.eduendtime = this.edclist[0]['val']["eduendtime"];
      this.edcschool = this.edclist[0]['val']["edcschool"];
      this.edcdescription = this.edclist[0]['val']["edcdescription"];
      this.peredcid = this.edclist[0]['val']["peredcid"];
      this.listindex = 0;
      this.index=0;
      this.totalpage = this.edclist.length-1;
     }
    },
    computed: {
      listenChange () {
        if(this.edcmethod!="update"){
          if(this.pageflag==false){
          return "";
        }else{
        var lisencedata = {};
        lisencedata["edustrattime"] = this.edustrattime
        lisencedata["eduendtime"] = this.eduendtime
        lisencedata["edcschool"] = this.edcschool
        lisencedata["edcdescription"] = this.edcdescription
        lisencedata["peredcid"] = this.peredcid
        // const {name1,name2} = this
        return lisencedata;
        }
        
        }else{
          // console.log("更新设置")
              var lisencedata = {};
              lisencedata["edustrattime"] = this.edustrattime
              lisencedata["eduendtime"] = this.eduendtime
              lisencedata["edcschool"] = this.edcschool
              lisencedata["edcdescription"] = this.edcdescription
              lisencedata["peredcid"] = this.peredcid
        // // const {name1,name2} = this
              return lisencedata;
        }
      },
      listenflagChange(){
        if(this.edcmethod!="update"){
            var flagdata = {};
            flagdata["upflag"] = this.upflag;
            flagdata["downflag"] = this.downflag;
            return flagdata;
        }else{
          console.log("refresh")
        }
       
      }
    },
    watch:{
      listenChange(val){
        if(this.edcmethod!="update"){
           if(val!=""){
           this.edclist =[];
       
          this.edclist.push({
            val
          })
          this.$emit('edcexperiencevalue', this.edclist)
          }
        }else{
          if(this.listindex<this.edclist.length-1){
              this.edclist[this.listindex]['val']['edustrattime']  =val["edustrattime"]
              this.edclist[this.listindex]['val']['eduendtime']  = val["eduendtime"]
              this.edclist[this.listindex]['val']['edcschool']  = val["edcschool"]
              this.edclist[this.listindex]['val']['edcdescription']  = val["edcdescription"]
              this.edclist[this.listindex]['val']['peredcid']  = val["peredcid"]
              this.$emit('edcexperiencevalue', this.edclist)
          }else if(this.listindex==this.edclist.length-1&&this.updateendflag==false){
              this.edclist[this.listindex]['val']['edustrattime']  =val["edustrattime"]
              this.edclist[this.listindex]['val']['eduendtime']  = val["eduendtime"]
              this.edclist[this.listindex]['val']['edcschool']  = val["edcschool"]
              this.edclist[this.listindex]['val']['edcdescription']  = val["edcdescription"]
              this.edclist[this.listindex]['val']['peredcid']  = val["peredcid"]
              this.$emit('edcexperiencevalue', this.edclist)
            // 没点添加的
          }else if(this.listindex==this.edclist.length-1&&this.updateendflag==true){
            // 点了添加的
            this.updateendflag = false;
            this.listindex++;
          } 
          // if(this.updateendflag==true){
          //   this.updateendflag = false;
          // }
        }
        
      },
      listenflagChange(val){
        if(this.edcmethod!="update"){
          this.$emit('edcexperienceflag', val);
        }else{
          console.log("更新操作")
        }
        
      },
      edcpushflag:function(val){
        // console.log(val);
        if(this.edcmethod!="update"){
             if(val==true){
          if(this.pageflag==false){
            this.getpushdata()

            this.$emit('edcexperiencevalue', this.edclist)
            this.totalpage++;
          }
         
          }
        }else{
          if(val==true){
            if(this.index>=this.edclist.length-1&&this.endflag==true){
               this.getpushdata()

              this.$emit('edcexperiencevalue', this.edclist)
              this.totalpage++;
              this.endflag = false;
            }
              
            
           
          }
        }
       
      },
      edcmethod:function(val){
        
      },
      studylist:function(val){
        if(val.length>0){
          console.log(val)
        }
      },
      listindex:function(val){
       
         if(this.listindex==this.edclist.length){
          document.getElementById("deledc").disabled = true;

          // console.log("测试")
        }
      }

    },
    methods: {
      addeduexpericence(){
       
        
        if(this.edcmethod!="update"){
            this.pageflag = false;
          if(this.downflag==true){
            this.downflag = false;
            this.upflag =false;
            this.dowmdisable =true;
          // document.getElementById("dowmedc").disabled = false;
            this.edustrattime="";
            this.eduendtime = "";
            this.edcschool="";
            this.edcdescription="";
            this.peredcid="";
            return;
          }

          if(this.totalpage==0){
            this.edclist=[];
          }
        // 提取方法
          this.getpushdata()
        // console.log(this.edclist)
          this.$emit('edcexperiencevalue', this.edclist)
          this.edcclear()

        }
        if(this.edcmethod=="update"){
          // 先清空后加载
          if(this.edclist.length>0){
             if(this.refresh==false){
            this.edcclear();
            }else if(this.index ==this.edclist.length-1){
            this.edcclear();
            
            // this.endflag=true;
            }

          }
         
          this.refresh=true;
          this.endflag=true;
          this.updateendflag=true;
          document.getElementById("deledc").disabled = true;
          this.getpushdata();
          this.$emit('edcexperiencevalue', this.edclist)
          this.edcclear();
        }
       
       
      },
      edcclear(){
        this.edustrattime="";
        this.eduendtime = "";
        this.edcschool="";
        this.edcdescription="";
        this.peredcid="";
        this.totalpage++;

        this.index++;
      },
      updata(){
        this.index--;
        this.endflag = false; 
        if(this.edcmethod!="update"){
          if(this.upflag==false){
          this.getpushdata();
          
          // document.getElementById("dowmedc").disabled = false;
          }
          document.getElementById("edcadd").disabled = true;
          this.dowmdisable =false;
        // document.getElementById("dowmedc").disabled = false;
          this.upflag = true;
          this.downflag = false;
        // 按键不能按
        }
        if(this.edcmethod=="update"){
          if(this.index==this.edclist.length){
             this.getpushdata();
          }
          document.getElementById("deledc").disabled = false;
          document.getElementById("edcadd").disabled = true;
          this.dowmdisable = false;
          if(this.index ==0){
            document.getElementById("updec").disabled = false;
          }
        }

        
        if(this.index<=0){
          this.index = 0;
          document.getElementById("updec").disabled = true;
        }
        if(this.index<=this.edclist.length){
          // 提取函数
          this.getpagedata(this.index);
        
        }

      },
      downdata(){
        this.index++;
        if(this.edcmethod!="update"){
          document.getElementById("updec").disabled = false;
       
          if(this.index == this.edclist.length-1){
          // id="dowmedc"
            document.getElementById("edcadd").disabled = false;
            this.dowmdisable =true;
           // document.getElementById("dowmedc").disabled = true;

            this.downflag = true;

          }

        }
        if(this.edcmethod=="update"){
           document.getElementById("updec").disabled = false;
           document.getElementById("edcadd").disabled = true;
            if(this.index == this.edclist.length-1){
              this.dowmdisable =true;
              document.getElementById("edcadd").disabled = false;

           

            }
            if(this.edclist.length-1==0){
              document.getElementById("edcadd").disabled = false;
              this.dowmdisable =true;
            }
        }
        if(this.index>=this.edclist.length-1){
          this.index = this.edclist.length-1;
        }
         if(this.index<=this.edclist.length){
          this.getpagedata(this.index);
         
        }
        
        

      },
      deletedata(){

        this.edclist.splice(this.listindex,1);
        this.$emit('edcexperiencevalue', this.edclist)
         document.getElementById("edcadd").disabled = true;
         document.getElementById("updec").disabled = true;
         if(this.listindex==this.edclist.length){
            document.getElementById("edcadd").disabled = false;
             document.getElementById("updec").disabled = false;
            this.dowmdisable = true;
            // 清空内容
         }
         this.getpagedata(this.listindex)
        // 上一页显示的按钮，不能使用，添加按钮不能使用
        // 显示内容清空，并把当前的内容重新赋值
        // if(this.listindex==this.edclist.length-1){
        //   this.edcclear();
        // }
        
      },
      getpushdata(){
        // 对内容进行判断，用for循环
          var judgeflag = this.judgedata();
          if(judgeflag){
               var val = {};
              val["edustrattime"] = this.edustrattime
              val["eduendtime"] = this.eduendtime
              val["edcschool"] = this.edcschool
              val["edcdescription"] = this.edcdescription
              val["peredcid"] = this.peredcid
              this.edclist.push({
                val
              })
              this.listindex++;
          }
         

      },
      getpagedata(index){
          if(this.edclist.length>0){
            this.edustrattime = this.edclist[index]['val']['edustrattime'];
            this.eduendtime = this.edclist[index]['val']['eduendtime'];
            this.edcschool = this.edclist[index]['val']['edcschool'];
            this.edcdescription = this.edclist[index]['val']['edcdescription'];
            this.peredcid = this.edclist[index]['val']['peredcid'];
            this.listindex = index;
          }
          
      },
      judgedata(){
          var judege = [this.edustrattime,this.eduendtime,this.edcschool,this.edcdescription];
          for(var i = 0;i<judege.length;i++){
            if(judege[i]==""){
              return false;
            }
          }

          return true;
      }
    }

    }
</script>
<style scoped>
#edcexperience{
  border: 1px solid;
   padding-top: 10px;
  padding-bottom: 10px;
   margin-top:20px;
   margin-left: 20% 
}
#edcexperience .form-control{
  width: 60%;
  margin-left: 20%;
  /*display:inline-block;*/
  /*padding: 0.375rem 0.75rem;*/
  height: calc(1.5em + 0.75rem + 2px);

}
.workadd{
  margin-top: 5%;
  margin-left: 5%;
}
#edcexperience #example-datepicker__outer_{
  /*display: inline-block;*/
  margin-left: 20%;
}
#edcexperience .description .form-control{
  width: 60%;
  display:inline-block;
  margin-left: 20%;

 
}
</style>