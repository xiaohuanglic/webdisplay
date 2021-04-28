<template>
	<div id="workexperience">
    <div>
     <label for="example-datepicker">工作开始时间</label>
        <b-form-datepicker id="example-datepicker" v-model="workstrattime" class="mb-2"></b-form-datepicker>
    
    <label for="example-datepicker">工作结束时间</label>
        <b-form-datepicker id="example-datepicker" v-model="workendtime" class="mb-2"></b-form-datepicker>
    </div>
    <label for="workposition">职位:</label><input type="text" id="workposition" v-model="workposition" required="required">
    <label for="workcompany">公司名称:</label><input type="text" id="workposition" v-model="workcompany" required="required">
    <div class="description">
    <label for="workdescription">职位描述:</label><br>
    <b-form-textarea
      id="textarea"
      v-model="workdescription"
      placeholder="Enter something..."
      rows="4"
      max-rows="6"
    ></b-form-textarea>
    </div>
    <b-button size="sm" class="workadd" @click="addjobexpericence" id="jobadd">添加另一份工作经历</b-button>
   
    <b-button size="sm" class="workadd" @click="updata" id="upadd">显示上一页</b-button>
    <b-button size="sm" class="workadd" @click="downdata" id="dowmadd" :disabled="dowmdisable">显示下一页</b-button>
     <b-button size="sm" class="workadd" @click="deletedata" id="deljob" :indexlist="listindex">删除</b-button>
     <!-- <b-button size="sm" class="workadd" @click="complate">完成填写</b-button> -->
	</div>
</template>
<script>
import axios from "axios";
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
    props:['workexperiencedata','pushflag','jobmethod','joblist'],
    data() {
      return {
        workstrattime: this.workexperiencedata.workstrattime,
        workendtime:this.workexperiencedata.workendtime,
        workposition:this.workexperiencedata.workposition,
        workcompany:this.workexperiencedata.workcompany,
        workdescription:this.workexperiencedata.workdescription,
        perjobid:this.workexperiencedata.perjobid,
        worklist:[],
        listindex:0,
        dowmdisable:true,
        index:0,
        totalpage:0,
        pageflag:true,
        upflag:false,
        downflag:false,
        endflag:false,
        refresh:false,
        updateendflag:false
        // context: null
      }
    },
    mounted:function(){
     if(this.jobmethod=="update"){
          document.getElementById("upadd").disabled = true;
          document.getElementById("jobadd").disabled = true;
          this.dowmdisable = false
     }
     if(this.jobmethod=="update"&&this.joblist.length==0){
          document.getElementById("upadd").disabled = false;
          this.dowmdisable = false
     }

     if(this.joblist.length>0){
      this.worklist = this.joblist;
      this.workstrattime = this.joblist[0]['val']["workstrattime"];
      this.workendtime = this.joblist[0]['val']["workendtime"];
      this.workposition = this.joblist[0]['val']["workposition"];
      this.workcompany = this.joblist[0]['val']["workcompany"];
      this.workdescription = this.joblist[0]['val']["workdescription"];
      this.perjobid = this.joblist[0]['val']["perjobid"];
      this.listindex = 0;
      this.index=0;
      this.totalpage = this.worklist.length-1;
     }
    },
    computed: {
      listenChange(){
          var lisencedata = {};
          lisencedata["workstrattime"] = this.workstrattime
          lisencedata["workendtime"] = this.workendtime
          lisencedata["workposition"] = this.workposition
          lisencedata["workcompany"] = this.workcompany
          lisencedata["workdescription"] = this.workdescription
          lisencedata["perjobid"] = this.perjobid
        if(this.jobmethod!="update"){
            if(this.pageflag==false){
          return "";
        }else{
        
        // const {name1,name2} = this
          return lisencedata;
        }
        }else{
          return lisencedata;

        }
      
       
      },
      listenflagChange(){
        if(this.jobmethod!="update"){
            var flagdata = {};
            flagdata["upflag"] = this.upflag;
            flagdata["downflag"] = this.downflag;
            return flagdata;
        }
       
      }
    },
    watch:{
      listenChange(val){
        // 判断所得数据是否为空
        if(this.jobmethod!="update"){
             if(val!=""){
           this.worklist =[];
       
          this.worklist.push({
            val
          })
          this.$emit('workexperiencevalue', this.worklist)
          }
        }else{

          if(this.listindex<this.worklist.length-1){
               this.getvaldata(this.listindex,val)
          }else if(this.listindex==this.worklist.length-1&&this.updateendflag==false){
               this.getvaldata(this.listindex,val) 
          }else if(this.listindex==this.worklist.length-1&&this.updateendflag==true){
            // 点了添加的
            this.updateendflag = false;
            this.listindex++;
          } 

        }
       
       
      },
      listenflagChange(val){
        if(this.jobmethod!="update"){
            this.$emit('workexperienceflag', val);
        }
        
      },
      pushflag:function(val){
        if(this.jobmethod!="update"){
            if(val==true){
            if(this.pageflag==false){
          
                this.getpushdata()
                this.$emit('workexperiencevalue', this.worklist)
                this.totalpage++;
          }
         
          }
        }else{
           if(val==true){
            if(this.index>=this.worklist.length-1&&this.endflag==true){
               this.getpushdata()

              this.$emit('workexperiencevalue', this.worklist)
              this.totalpage++;
              this.endflag = false;
            }
           
          }

        }
       
      }
    },
    methods: {
      getvaldata(listindex,val){
              this.worklist[listindex]['val']['workstrattime']  =val["workstrattime"]
              this.worklist[listindex]['val']['workendtime']  = val["workendtime"]
              this.worklist[listindex]['val']['workposition']  = val["workposition"]
              this.worklist[listindex]['val']['workcompany']  = val["workcompany"]
              this.worklist[listindex]['val']['workdescription']  = val["workdescription"]
              this.worklist[listindex]['val']['perjobid']  = val["perjobid"]
              this.$emit('workexperiencevalue', this.worklist)
      },
      addjobexpericence(){
        if(this.jobmethod!="update"){
          this.pageflag = false;
        if(this.downflag==true){
          this.downflag = false;
          this.upflag =false;
          this.dowmdisable =true;
          // document.getElementById("dowmadd").disabled = false;
          this.workstrattime="";
          this.workendtime = "";
          this.workposition="";
          this.workcompany="";
          this.workdescription="";
          this.perjobid="";
          return;
        }
        if(this.totalpage==0){
          this.worklist=[];
        }
        // 提取方法
      
        this.getpushdata()
        this.$emit('workexperiencevalue', this.worklist)
        this. edcclear();

        }

        if(this.jobmethod=="update"){
            if(this.worklist.length>0){
                if(this.refresh==false){
              this.edcclear();
              }else if(this.index ==this.worklist.length-1){
              this.edcclear();
            
            // this.endflag=true;
              }
            }

             this.refresh=true;
            this.endflag=true;
            this.updateendflag=true;
            document.getElementById("deljob").disabled = true;
            this.getpushdata();
            this.$emit('workexperiencevalue', this.worklist)
            this.edcclear();
          
        }
        
        
      
        
      },
      edcclear(){
        this.workstrattime="";
        this.workendtime = "";
        this.workposition="";
        this.workcompany="";
        this.workdescription="";
        this.perjobid="";
        this.totalpage++;

        this.index++;
      },
      updata(){
        this.index--;
        this.endflag = false;
        if(this.jobmethod!="update"){
           if(this.upflag==false){
         
          this.getpushdata();
        }
        document.getElementById("jobadd").disabled = true;
        this.dowmdisable =false;
        // document.getElementById("dowmadd").disabled = false;
        this.upflag = true;
        this.downflag = false;

        }
        if(this.jobmethod=="update"){
             if(this.index==this.worklist.length){
             this.getpushdata();
          }
         
          document.getElementById("deljob").disabled = false;
          document.getElementById("jobadd").disabled = true;
          this.dowmdisable = false;
          if(this.index ==0){
            document.getElementById("upadd").disabled = false;
          }

        }
        // 按键不能按

        
        if(this.index<=0){
          this.index = 0;
          document.getElementById("upadd").disabled = true;
        }
        if(this.index<=this.worklist.length){
          // 提取函数
         
          this.getpagedata(this.index);
        
        }

      },
      downdata(){
        this.index++;
         if(this.jobmethod!="update"){
               document.getElementById("upadd").disabled = false;
      
        if(this.index == this.worklist.length-1){
          // id="dowmadd"
          document.getElementById("jobadd").disabled = false;
          this.dowmdisable =true;
           // document.getElementById("dowmadd").disabled = true;

          this.downflag = true;

        }
         }

         if(this.jobmethod=="update"){
          
            document.getElementById("upadd").disabled = false;
            document.getElementById("jobadd").disabled = true;
            if(this.index == this.worklist.length-1){
              this.dowmdisable =true;
              document.getElementById("jobadd").disabled = false;

           

            }
            if(this.worklist.length-1==0){
              document.getElementById("jobadd").disabled = false;
              this.dowmdisable =true;
            }

         }
      
        if(this.index>=this.worklist.length-1){
          this.index = this.worklist.length-1;
        }
         if(this.index<=this.worklist.length){
        
          this.getpagedata(this.index);
         
        }
        
        

      },
      deletedata(){
         // deljob
            // dowmadd
            // upadd
            // jobadd
            // this.$emit('workexperiencevalue', this.worklist)
          
      this.worklist.splice(this.listindex,1);
       this.$emit('workexperiencevalue', this.worklist)
         document.getElementById("jobadd").disabled = true;
         document.getElementById("upadd").disabled = true;
         if(this.listindex==this.worklist.length){
            document.getElementById("jobadd").disabled = false;
             document.getElementById("upadd").disabled = false;
            this.dowmdisable = true;
            // 清空内容
         }
         this.getpagedata(this.listindex)
     
        
      },
      getpagedata(index){
         if(this.worklist.length>0){
          this.workstrattime = this.worklist[index]['val']['workstrattime'];
          this.workendtime = this.worklist[index]['val']['workendtime'];
          this.workposition = this.worklist[index]['val']['workposition'];
          this.workcompany = this.worklist[index]['val']['workcompany'];
          this.workdescription = this.worklist[index]['val']['workdescription'];
          this.perjobid = this.worklist[index]['val']['perjobid'];
          this.listindex = index;
        }
      },
      getpushdata(){
          var judgeflag = this.judgedata();
          if(judgeflag){
                  var val = {};
                  val["workstrattime"] = this.workstrattime
                  val["workendtime"] = this.workendtime
                  val["workposition"] = this.workposition
                  val["workcompany"] = this.workcompany
                  val["workdescription"] = this.workdescription
                  val["perjobid"] = this.perjobid
                  this.worklist.push({
                val
              })

          }
        

      },
      judgedata(){
        // 这个有问题
          var judege = [this.workstrattime,this.workendtime,this.workposition,this.workcompany,this.workdescription];
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
#workexperience{
  border: 1px solid;
  padding-top: 10px;
  padding-bottom: 10px;
  margin-top:20px;
  margin-left: 20%
}
#workexperience .form-control{
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
#workexperience #example-datepicker__outer_{
  /*display: inline-block;*/
  margin-left: 20%;
}
#workexperience .description .form-control{
  width: 60%;
  display:inline-block;
  margin-left: 20%;
  /*width: 100%;*/
}

</style>