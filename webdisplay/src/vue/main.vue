<template>
  
	<div class="main">
    <div class="mainhead">
      <ul >
      <!-- <li v-for="value in showmeg" @click="getUsermeg(value.num,value.usernum,value.myid)">
          
          {{value.myname}} "消息" {{value.usernum}}
     
        
      </li> -->
      <b-navbar toggleable="lg" type="dark" variant="info">
        <!-- <b-navbar-brand href="#">NavBar</b-navbar-brand> -->

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav>
          <b-nav-item @click=jumpBoss()>boss</b-nav-item>
          <b-nav-item @click=jumpFree()>free</b-nav-item>
          <b-nav-item @click=jumpChat()>消息<span v-if="shownewmsg">(new)</span></b-nav-item>
          <b-nav-item @click=exit()>退出</b-nav-item>
          </b-navbar-nav>
           <b-navbar-nav class="ml-auto">
      <!--   <b-nav-form>
          <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
          <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
        </b-nav-form>
 -->
      
      </b-navbar-nav>
       </b-collapse>
      </b-navbar>
      <!-- <a @click=jumpChat()>消息<span v-if="shownewmsg">(new)</span></a>
      <a @click=jumpBoss()>boss</a>
      <a @click=jumpFree()>free</a>
      <span @click="exit()">退出</span> -->
    </ul>
    </div>
    
    <div class="mianmiddle">
    <!--   <a @click=showBoss()>我是Boss</a>
      <a @click=showfree()>我是自由者</a> -->
    <b-nav>
   
    <b-nav-text @click=showBoss()>找员工</b-nav-text>
    <b-nav-text  @click=showfree()>找工作</b-nav-text>
   
  </b-nav>
    <div v-if="show=='Boss'">
    	<!-- 导入bookscrap -->
      <!-- 导成一个模板 -->

        <table  border="1" cellspacing="0">
          <!-- 进行分页 -->
        <tr>
          <th v-for="(item, index) in tdhead">
            {{item}}
          </th>
        </tr>
        <b-tr v-for="(data,index) in disdata" v-if="index<datalength">
          <b-td>{{data['personname']}}</b-td>
          <b-td>{{data['personposition']}}</b-td>
          <b-td><a @click="jumpDeatail(data)">查看</a></b-td>
        <!-- :href="'#/detail/?personid=' + data['personid']+'&&userid='+data['userid']" -->
        </b-tr>
      </table>
      <!-- 分页 -->
     
    </div>
    <div v-if="show=='Free'">
    	<ul>
    		<taskmodel v-on:experiencerequirement="experiencerequirement" v-on:education ="education" v-on:salary = "salary"></taskmodel>
    	</ul>
    	<ul class="mainli">
    		
    		<li v-for="(data,index) in disdata" v-if="index<datalength&&data['dispalyflag']!=0">
    			<div  class="item-wrap" @click="jumpDeatail(data)"><div  class="left"><h3  class="pointer position-name text-ellipsis"><a  href="/job/26122" class="">
										{{data['taskposition']}}
									</a></h3> <div  class="info"><div  class="info-left"><span  class="info-span">
											{{data['salary']}}
										</span> <div  class="base"><span >
												{{data['experiencerequirement']}}
											</span> <div  class="el-divider el-divider--vertical"><!----></div> <span >
												{{data['education']}}
											</span> <div  class="el-divider el-divider--vertical"><!----></div> </div></div>
										</div>
										</div> <div  class="middle"><h3  title="data['taskname']" class="middle-span pointer"><a  href="/company/40522" class="">
										{{data['taskname']}}
									</a></h3> <p  style="display: flex; align-items: center; margin-bottom: 0px;"><div  aria-label="Breadcrumb" role="navigation" class="el-breadcrumb intriduty" style="font-size: 14px; line-height: 1;"><span  class="el-breadcrumb__item" aria-current="page"><span role="link" class="el-breadcrumb__inner">
											
										</span><span role="presentation" class="el-breadcrumb__separator"></span></span></div></p></div> <div  class="right-icon"><img :src="data['avatar']"></div></div>
    		</li>
    	</ul>
     <!--  <table  border="1" cellspacing="0">
        <tr>
           <th v-for="(item, index) in tdhead">
            {{item}}
          </th>
        </tr>
        <tr v-for="(data,index) in disdata" v-if="index<datalength">
          <td>{{data['taskname']}}</td>
          <td>{{data['taskintro']}}</td>
          <td><a @click="jumpDeatail(data)">查看</a></td>
          :href="'#/detail/?taskid=' + data['taskid'] +'&&userid='+data['userid']" -->
        <!-- </tr> -->
      <!-- </table> --> 
    </div>
    </div>
    <div class="mainpagination">
     <ul>
     	<span @click="uppage()">上一页</span>
        <li v-for="n in diaplaypage" v-if="n>=nowpage"class="page" @click="Jmuppage(n,show)">
           {{n}}
        </li>
       <span @click="downpage()">下一页</span>
       <span>总共{{totalpage}}页</span>
      </ul>
    </div>
    <div class="maintail"></div>
		
	</div>
</template>
<script>
import axios from "axios";
import 'jquery';
  import taskmodel from './taskmodel.vue'
 axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'

export default {
		  components: {

          taskmodel,
        
         
          
        },
  		data() {
  			return{
  			getcindition:[],
          	shownewmsg:false,
          	showmeg:[],
          	datalength:"",
          	totalnum:"",
          	nowpage:1,
          	diaplaypage:0,
          	totalpage:"",
          	usernum:0,
  			show:'',
  			bossdata:'',
  			disdata:{},
          	myid:'',
          	userid:'',
          	username:'',
          	userid:'',
          	myname:'',
          	name:'',
          	num:'',
  				tdhead:['名称','要求职位','查看']
  			}
  			
  		},
      mounted() {
          // 再点击的情况下,jump是没有问题的
          // 但是在页面加载的时候
          // this.getUsernum();
          var time = this.$route.query.time;
          // window.clearInterval(time)
          // console.log(time+"time");
          var index = this.getIndex();
          var show = this.getShow();
          
              for(var i =0;i<this.$common["time2"].length;i++){
                   clearInterval(this.$common["time2"][i]);
              }
             
              var newmessage = this.$newmessage
              var common = this.$common
              var that = this
              var checknewmsg = function(newmessage,common,time){
                common["time3"].push(time);
                // console.log(1)
                for(var i = 0;i<newmessage["getnewnum"].length;i++){
                  if(newmessage["getnewnum"][i]["usernum"]!=0){

                    that.shownewmsg = true;
                  }

                }
              }
             
              var time = null; 
              time = window.setInterval(function(){
                          checknewmsg(newmessage,common,time);
                        },3000);
              // console.log()  
          
          if(index!=null&&show!=null){
          		this.show =show;
          		this.Jmuppage(index,show);
          }else{
        
          	   this.showBoss();
          }
          
      },
  		methods:{
  			getshowdata(){
  					if(this.getcindition.length>0){
  						var url = this.$url+'/get.php/?show='+this.show;
  						for(var i =0;i<this.getcindition.length;i++){
  							for(var key in this.getcindition[i]){
  							url +='&&'+key+"="+this.getcindition[i][key];
  						}
  						}
  						
  							axios.get(url).then(res=>{
  							
              				this.extractData(res.data);
           
            			})

  					}else{
  							axios.get(this.$url+'/get.php/?show='+this.show).then(res=>{
  								// console.log(res.data);
              				this.extractData(res.data);
           
            			})

  					}
  				
  				
  				
  			},
  			judgeGetCondition(value){
  				var j = 0;
  				if(this.getcindition.length>0){
  					for(var i =0;i<this.getcindition.length;i++){
  						for(var key in this.getcindition[i]){
  							console.log(this.getcindition[i])
  							if(key==Object.keys(value)[0]){
  							
  								this.getcindition[i][key] = value[key];
  							}else{
  								j++;
  							}
  						}
  						
  					}

  					if(j==this.getcindition.length){
  						this.getcindition.push(value);
  					}
  				}else{
  					this.getcindition.push(value)	
  				}
  			},
  			experiencerequirement(value){
  				// 先判断有没有这个key,有就修改没有就添加
  				if(typeof(value)!='undefined'){
  					this.judgeGetCondition({'experiencerequirement':value})
  				this.getshowdata();
  				}
  				

  				// 从后端拿数据
  				
  				
  				
  			},
  			education(value){
  				if(typeof(value)!='undefined'){
  					this.judgeGetCondition({'education':value})
  				
  				this.getshowdata();
  				}
  				
  			},
  			salary(value){
  				if(typeof(value)!='undefined'){
  					this.judgeGetCondition({'salary':value})
  				
  					this.getshowdata();
  				}
  				
  			},
      exit(){
          for(var each in this.$common){
              for(var i =0;i<this.$common[each].length;i++){
                   clearInterval(this.$common[each][i]);
              }
                   
            }
            sessionStorage.clear();
            localStorage.clear();
            this.$router.push({path: '/login'})


      },
  		jumpChat(){
          if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                this.$router.push({path: '/mchat'})
          } else {
               this.$router.push({path: '/chat'})
          }
  			
  		},
      jumpDeatail(data){
          if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                if(typeof(data['personid'])!="undefined"){
                 this.$router.push({path: '/mdetail?personid=' + data['personid']+'&&userid='+data['userid']})
              }else if(typeof(data['taskid'])!="undefined"){
                   this.$router.push({path: '/mdetail?taskid=' + data['taskid']+'&&userid='+data['userid']})
              }
          } else {
            //  :href="'#/detail/?personid=' + data['personid']+'&&userid='+data['userid']" 
              // :href="'#/detail/?taskid=' + data['taskid'] +'&&userid='+data['userid']" -->
              if(typeof(data['personid'])!="undefined"){
                 this.$router.push({path: '/detail?personid=' + data['personid']+'&&userid='+data['userid']})
              }else if(typeof(data['taskid'])!="undefined"){
                   this.$router.push({path: '/detail?taskid=' + data['taskid']+'&&userid='+data['userid']})
              }
             
          }
      },
      getuser(){
         var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
          
           axios.post(this.$url+'/checksession.php',{sessionid:sessionid}).then(res=>{
              console.log(res.data);
              this.myid = res.data['userid'];
              this.username = res.data['username'];
           })

      },
        getUsermeg(num,usernum,userid){
          // 根据sessionid从后台得到数据
           
          // this.myid = JSON.parse(sessionStorage.getItem("vue-session-key"))['username'][1];
          // this.username = JSON.parse(sessionStorage.getItem("vue-session-key"))['username'][2];
          this.getuser();
          if(num=='usernum'){
            this.$router.push({path: '/chat/?userid='+this.myid+'&&myid='+userid+'&&username='+this.username+'&&usernum='+usernum})
          }else if(num=='mynum'){
            this.$router.push({path: '/chat/?userid='+userid+'&&myid='+this.myid+'&&myname='+this.username+'&&mynum='+usernum})
          }
          


        },
        getUsernum(){
          this.getuser();
          //  this.myid = JSON.parse(sessionStorage.getItem("vue-session-key"))['username'][1];
          // this.username = JSON.parse(sessionStorage.getItem("vue-session-key"))['username'][2];
          axios.post(this.$url+'/chat.php',{userid:this.myid,username:this.username}).then(res=>{
            
            res.data = res.data.substr(0,res.data.length-1)

            var resdata = res.data.split("-")
            
            for(var i = 0;i<resdata.length;i++){
              
              resdata[i] = JSON.parse(resdata[i])
              
              if(resdata[i]['num']=="mynum"){
                resdata = resdata.map(o => {return {myname:o.username,usernum:o.mynum,myid:o.userid,num:o.num,name:o.name}})
              }
            
              
            }
          
             
            
            this.showmeg = resdata
            // echo $usernum['mynum'].','.$usernum['userid'].','.$usernum['username'].',mynum,username';

           
          })
             
        },
  			showBoss(){
  				this.show='Boss'
  				this.getshowdata();
            
  			},

  			showfree(){
  				this.show='Free'
  				this.getcindition=[];
  				this.getshowdata();
          

  			},
        // 公用方法
        goPage(){
          var size = 2;
          this.totalpage = (this.totalnum%size)==0?this.totalnum/size:parseInt(this.totalnum / size) + 1
          this.setTotalpage(this.totalpage);
          // console.log(this.totalpage)
        },
        getIndex(){
        	return sessionStorage.getItem("page");
        },
        getShow(){
        	return sessionStorage.getItem("show");
        },
        getTotalnum(){
          return sessionStorage.getItem("totalnum");
        },
        getTotalpage(){
          return sessionStorage.getItem("totalpage");
        },
        setTotalnum(totalnum){
          sessionStorage.setItem('totalnum', totalnum);
          // this.totalnum
        },
        setTotalpage(totalpage){
          sessionStorage.setItem('totalpage', totalpage);
        },
        setIndex(index){
        	sessionStorage.setItem('page', index);
        },
        setShow(show){
        	sessionStorage.setItem('show', show);
        },
        Jmuppage(index,show){
            // 转跳页面
            	// 设置session,查看返回的时候，可以回到相应的页面
            	// $.session.set('page', index);
            	// sessionStorage.setItem('page', index);
            	this.setIndex(index);
            	this.setShow(show);
              if(this.getcindition.length>0){
              		var url = this.$url+'/getpage.php/?page='+index+'&&totalnum='+this.totalnum+'&&size=2&&show='+show;
  						for(var i =0;i<this.getcindition.length;i++){
  							for(var key in this.getcindition[i]){
  								url +='&&'+key+"="+this.getcindition[i][key];
  							}
  						}
  						
  							axios.get(url).then(res=>{
  								console.log(res.data);
              			this.extractpageData(res.data,index);
           
            			})
              }else{
              	axios.get(this.$url+'/getpage.php/?page='+index+'&&totalnum='+this.totalnum+'&&size=2&&show='+show).then(res=>{
                  console.log(res.data)
                this.extractpageData(res.data,index);
                // console.log(res.data);
           
              })
              }
             

        },
        uppage(){
        	var index = this.getIndex();
        	var show = this.getShow();
        	// 获取当前的页面index
        	// 向上就是index-1
        	// 对index进行判断,如果小于1,index=1
        	// 进行分页显示
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
        	var index = this.getIndex();
        	var show = this.getShow();
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
        // 公用方法
        extractData(data){
              // console.log(data);
              this.jsondata(data);
            
             
           
              this.totalnum = data[data.length-1]['COUNT(*)'];
        	
             
              this.disdata = data;
              this.datalength = data.length-1;
              this.nowpage = 1;
              this.goPage();
              if((this.nowpage+2)>=this.totalpage){
              		this.diaplaypage = this.totalpage;
              }else{
              		this.diaplaypage = this.nowpage+2;
              }
              
              
        },
     
        extractpageData(data,index){
          
            
         	  this.jsondata(data);
            this.disdata = data;
            this.datalength = data.length;

            this.Pagination(index,2);
         
        },
        // 导入一个js文件(公用方法)
        jsondata(data){
        	for(var i =0;i<data.length;i++){
        		if(typeof data[i] === 'string'){
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

              if(this.getIndex!=null){
                index = parseInt(this.getIndex());
              }
             
                this.nowpage = index;
                // if((this.nowpage+num)>this.totalpage){
                //   this.diaplaypage = this.totalpage;
                //   this.nowpage = index-((this.nowpage+num)-this.totalpage);
                // }else if(index<=num){
                //   this.nowpage = 1;
                //   this.diaplaypage = this.nowpage+num;
                // }else{
                //   this.diaplaypage = this.nowpage+num;
                // } 

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
  			jumpBoss(){
          if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                   this.$router.push({path: '/mboss'})
          } else {
               this.$router.push({path: '/boss'})
          }

  				
  			},
  			jumpFree(){
             if((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
                  // window.location.href = "";     //手机
                   this.$router.push({path: '/mfree'})
          } else {
               this.$router.push({path: '/free'})
          }
  				// this.$router.push({path: '/free'})
  			}

  		}

  	}
</script>
<style scoped>


.item-wrap:after {
    content: "";
    position: absolute;
    left: 1%;
    bottom: 0;
    height: 0.1rem;
    width: 100%;
    background: #eee;
}
.item-wrap .left{
    width: 30%;
}

.item-wrap .left .info .info-left .info-span{
    font-size: 1.5rem;
    line-height: 1;
    color: #ffab12;
}
.item-wrap .left .base{
    align-self: center;
    font-size: 0.8rem;
    margin-left: 1%;
    color: #666;
    line-height: 1;
}
.item-wrap .left .base .el-divider {
    margin: 0 4px;
}
.el-divider--vertical {
    display: inline-block;
    background-color: #ccc;
    width: 1px;
    height: 1em;
    margin: 0 8px;
    vertical-align: middle;
    position: relative;
}
.el-divider--vertical:last-child {
    display: inline-block;
    background-color: #ccc;
    width: 0;
    height: 1em;
    margin: 0 8px;
    vertical-align: middle;
    position: relative;
}
.item-wrap .middle .middle-span {
    line-height: 21px;
    margin-bottom: 18px;
}
.item-wrap .middle h3 {
    font-size: 1.2rem;
    font-weight: 400;
    color: #333;
    line-height: 1rem;
}
a, a:focus, a:hover {
    cursor: pointer;
    color: inherit;
    text-decoration: none;
}
.mainli{
	margin:0px;
	padding: 0;
}
.item-wrap .right-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 5%;
    height:5%;
    border-radius: 0.2rem;
    overflow: hidden;
}
.item-wrap .right-icon img {
    width: 100%;
    height: 100%;
    border-radius: 0.2rem;
    -o-object-fit: contain;
    object-fit: contain;
    border: 1px solid #eee;
}
@media only screen and (min-width: 767px){
	.item-wrap{
    position: relative;
    display: flex;
    justify-content: space-between;
    padding: 5%;
    font-size: 0.8rem;
    overflow: hidden;
    background: #fff;
    border-top-left-radius: 0.1rem;
    border-top-right-radius: 0.1rem;
}
.item-wrap .left .info{
    display: flex;
    justify-content: space-between;
}
.item-wrap .left .info .info-left{
    display: flex;
    align-items: center;
}

}
@media only screen and (min-width: 480px) and (max-width: 767px){
.item-wrap{
    position: relative;
    /*display: flex;*/
    /*justify-content: space-between;*/
    padding: 5%;
    font-size: 0.8rem;
    overflow: hidden;
    background: #fff;
    border-top-left-radius: 0.1rem;
    border-top-right-radius: 0.1rem;
}
.item-wrap .left{
    width: 100%;

}
.item-wrap .left h3{
    text-align: center;

}
.item-wrap .left .info{
  
   text-align: center;

}

.item-wrap .left .info .info-left .base{
   margin-top: 0.5rem;
}
.item-wrap .middle  {
	float: left;
	margin-top: 1rem;
	margin-left: 25%;
	margin-right: 1rem;
   text-align: center;
}
.item-wrap .right-icon {
   float: left;
    justify-content: center;
    align-items: center;
    width: 30%;
    height:30%;
    border-radius: 0.2rem;
    overflow: hidden;
}
.item-wrap .right-icon img {
    width: 100%;
    height: 100%;
    border-radius: 0.2rem;
    -o-object-fit: contain;
    object-fit: contain;
    border: 1px solid #eee;
}

}
/* 小于479px */
@media only screen and (max-width: 479px){
	.item-wrap{
    position: relative;
    /*display: flex;*/
    /*justify-content: space-between;*/
    padding: 5%;
    font-size: 0.8rem;
    overflow: hidden;
    background: #fff;
    border-top-left-radius: 0.1rem;
    border-top-right-radius: 0.1rem;
}
.item-wrap .left{
    width: 100%;

}
.item-wrap .left h3{
    text-align: center;

}
.item-wrap .left .info{
  
   text-align: center;

}

.item-wrap .left .info .info-left .base{
   margin-top: 0.5rem;
}
.item-wrap .middle  {
	float: left;
	margin-top: 1rem;
	margin-left: 25%;
	margin-right: 1rem;
   text-align: center;
}
.item-wrap .right-icon {
   float: left;
    justify-content: center;
    align-items: center;
    width: 30%;
    height:30%;
    border-radius: 0.2rem;
    overflow: hidden;
}
.item-wrap .right-icon img {
    width: 100%;
    height: 100%;
    border-radius: 0.2rem;
    -o-object-fit: contain;
    object-fit: contain;
    border: 1px solid #eee;
}
	
}
 .main{
  width: 80%;
  height: 1000px;
  background-color: #e4f1fa;
  position: relative;
  margin: auto;
  /*left: 50%;*/
  /*margin-left:-300px;*/
  /*margin-top: 100px;*/
 }
 .mainhead{
  height: 100px;
  background-color:#17a2b8;
  padding: 0px;
 }
 .mianmiddle .navbar-text{
   /* style */
   /*padding-left: 10px;*/
   text-align: center;
   width: 50%;

 }
 {

 }
.mainhead ul{
  padding:0;
 }
 .page{
  float: left;
  width: 15%;
  height: 20px;
  border: 1px solid black;
  background-color: coral;
  text-align: center;
 }
 .mainpagination{
  padding-top: 5%; 
  margin: auto;
  width: 60%
 }
 table{
  width: 95%;
 margin-left: 2.5%;
 background-color: #ebeff1
 }
 th{
  text-align: center;
 }
 tr{
  width: 100%;
 }
 td{
  text-align: center;
  padding: 5px;
  color: #212529;
  font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  font-weight: 400;
 
  font-size: 1rem;
  width: 33%;
 }
</style>
