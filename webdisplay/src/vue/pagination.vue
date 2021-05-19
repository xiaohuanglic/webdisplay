<template>
	<div>
   <ul>
      <span @click="uppage()">上一页</span>
        <li v-for="n in diaplaypage" v-if="n>=nowpage"class="page" @click="Jmuppage(n,show)" :colorindex="n">
           {{n}}
        </li>
       <span @click="downpage()">下一页</span>
       <span>总共{{totalpage}}页</span>
      </ul> 
  </div>
</template>
<script>
import axios from "axios";
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
  props:['personflag'],
    data() {
        return{
         
            datalength:"",
            totalnum:"",
            nowpage:1,
            diaplaypage:0,
            totalpage:"",
            num:'',
            show:'',
            disdata:"",
            pagename:"",
            showname:"",
            totalnumname:"",
            totalpagename:"",
            size:2,
            clicknum:""
        }
        
      },
    watch: {
     clicknum: function (val) {
          this.displaycolor(val);
        }
      },
    methods:{
        goPage(){
          // var size = 2;
          this.totalpage = (this.totalnum%this.size)==0?this.totalnum/this.size:parseInt(this.totalnum / this.size) + 1
          this.setTotalpage(this.totalpage);
          // console.log(this.totalpage)
        },
        displaycolor(val){
          this.$nextTick(() => {
                  var childenode = document.getElementsByClassName("page");
                  var childenodecolor = "";
                  var j = 0
                  for(var i = 0;i<childenode.length;i++){
   
                      childenode[i].removeAttribute("id","nowindex");
           
                  }
         
          
                for(var i = 0;i<childenode.length;i++){
                      childenodecolor = childenode[i].getAttribute("colorindex")

                    if(val == childenodecolor){
                    childenode[i].setAttribute("id","nowindex");
                }
            // console.log()
          }
        })
          
        },
        getIndex(){
          return sessionStorage.getItem(this.pagename);
        },
        getShow(){
          return sessionStorage.getItem(this.showname);
        },
        getTotalnum(){
          return sessionStorage.getItem(this.totalnumname);
        },
        getTotalpage(){
          return sessionStorage.getItem(this.totalpagename);
        },
        setTotalnum(totalnum){
          sessionStorage.setItem(this.totalnumname, totalnum);
          // this.totalnum
        },
        setTotalpage(totalpage){
          sessionStorage.setItem(this.totalpagename, totalpage);
        },
        setIndex(index){
          sessionStorage.setItem(this.pagename, index);
        },
        setShow(show){
          sessionStorage.setItem(this.showname, show);
        },
        Jmuppage(index,show){
            // 转跳页面
              // 设置session,查看返回的时候，可以回到相应的页面
              // $.session.set('page', index);
              // sessionStorage.setItem('page', index);
              this.setIndex(index);
              this.setShow(show);
              if(this.personflag=="resumeperson"){
                this.$emit('getpagepersondata',index);
              }else{
                this.$emit('getpageData',index);
              }
              
              
      

        },

        uppage(){
         
         
          // 获取当前的页面index
          // 向上就是index-1
          // 对index进行判断,如果小于1,index=1
          // 进行分页显示
          if(this.getIndex()!=null&&this.getShow()!=null){
             var index = this.getIndex();
              var show = this.getShow();
            }else{
              this.setIndex(1);
            }
            this.clicknum = index;
            
          if(index<=1){
            return;
          }else{
            index--;
            this.setIndex(index);
              this.setShow(show);
              this.Jmuppage(index,show);
            // sessionStorage.setItem('page', index);
            // this.Pagination(index,2);
          }

        },
        downpage(){
          // 获取当前的页面index
          // 向下就是index+1
          // 对index进行判断,如果大于总页数,index=totalnum;
          // 进行分页显示
          if(this.getIndex()!=null&&this.getShow()!=null){
             var index = this.getIndex();
              var show = this.getShow();
            }else{
              this.setIndex(1);
            }
            this.clicknum = index;
          this.judgegetdata();
          
          if(index>=this.totalpage){
            return;
          }else{
            index++;
            this.setIndex(index);
              this.setShow(show);
              this.Jmuppage(index,show);
            // sessionStorage.setItem('page', index);
            // this.Pagination(index,2);
          }

        },
        judgegetdata(){
           if(this.getIndex()!=null&&this.getShow()!=null){
             var index = this.getIndex();
              var show = this.getShow();
            }else{
              this.setIndex(1);
            }
            this.clicknum = index;
        },  
        // 公用方法
        extractData(data){
              this.jsondata(data);
              this.totalnum = data[data.length-1]['COUNT(*)'];
              this.setTotalnum(this.totalnum);
              this.disdata = data;
              this.datalength = data.length-1;
              this.nowpage = 1;
              this.clicknum = 1;
              this.displaycolor(this.clicknum);
              this.goPage();

              if((this.nowpage+2)>=this.totalpage){
                  this.diaplaypage = this.totalpage;
              }else{
                  this.diaplaypage = this.nowpage+2;
              }

              // this.setIndex(index);
              // this.setShow(show);
              
        },
        
        extractpageData(data,index){
          
            
            this.jsondata(data);
            this.disdata = data;
            this.datalength = data.length;
            this.displaycolor(index);
            this.Pagination(index,2);
         
        },
        // 导入一个js文件(公用方法)
        jsondata(data){

          for(var i =0;i<data.length;i++){
            if(typeof data[i] == 'string'){
               data[i] = JSON.parse(data[i]);
            }
               
          }

            return data;
        },
           // 对当前显示的页面进行边界
              // this.nowpage+2大于总页数就显示总页数
              // 分页完成
        Pagination(index,num){
              if(this.getTotalpage()!=null){
                // 要转成数字不然会有bug
                  this.totalpage = parseInt(this.getTotalpage());
              }

              if(this.getIndex()!=null){
                index = parseInt(this.getIndex());
              }
             
                this.nowpage = index;
                this.clicknum = index;
                this.displaycolor(index);
                if((this.nowpage+num)>this.totalpage){
                  this.diaplaypage = this.totalpage;
                  this.nowpage = index-((this.nowpage+num)-this.totalpage);
                }else if(this.nowpage<=num){
                  this.nowpage = 1;
                    this.diaplaypage = this.nowpage+num;
                }else{
                  this.diaplaypage = this.nowpage+(num-1);
                  this.nowpage =  this.nowpage-(num-1);
                } 
                
            
          },

           
             
              
        }
      }

    
</script>
<style scoped>
 .page{
  float: left;
  width: 20px;
  height: 20px;
  border: 1px solid black;
  background-color: coral;
  text-align: center;
 }
 #nowindex{
     background-color: white;
 }
</style>