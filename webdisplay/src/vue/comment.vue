<template>
	<div>
	
	  <p>评论用户:</p>
	  <b-form-textarea
      id="textarea"
      v-model="text"
      placeholder="Enter something..."
      rows="3"
      max-rows="6"
    ></b-form-textarea>
    <button @click=comment()>提交</button>
    <div>
    	 <ul>
    	 	<li v-for="(item,index) in displaycomment" class="commentlist" v-if="index<displaycomment.length">
    	 		<p>用户：{{item['from_uname']}}</p>
    	 		<div>
    	 		内容：{{item['content']}}

    	 			<ul >回复内容
    	 				<span v-if="getdisplayflag[index]&&getdisplayflag[index]['flag']">有新消息</span>
    	 				<li v-for="(item1,index1) in disreply" v-if="item1['comment_id']==item['comentid']">
    	 					<div v-for="(item2,index2) in item1" v-if="index2<Object.keys(item1).length-1">
                  <!-- {{item2}} -->
    	 						<!-- {{item2['content']}} -->
    	 						<p :class="item2[0]['reply_id']==getuserid&&item2[0]['canread']=='0'?'getreplycolor':'getreplynoncolor'" @click="changRead(item2[0]['id'],item2[0]['comment_id'])" :id="item2[0]['id']">{{item2[0]['from_name']}}: @{{item2[0]['reply_name']}} {{item2[0]['content']}}
                  <!-- 迟一点在调试 -->
                  <span @click="display(item['comentid'],item2[0]['from_uid'],item2[0]['from_name'])">回复</span></p>
    	 						
    	 					</div>
    	 				</li>
              <div @click="getMoreReply(item['comentid'],index)">更多消息</div>
              <!-- <pagination ref="pagination" @getpageData="getpagedata"></pagination> -->
    	 			</ul>
    	 		</div>
    	 		<p><span  @click="display(item['comentid'],item['from_uid'],item['from_uname'])">回复</span></p>
    	 	</li>
    	 </ul>
    </div>
    <pagination ref="pagination" @getpageData="getpagedata"></pagination>
	 <div class="reply">
	 	 <p>回复用户:</p>
	  <b-form-textarea
      id="textarea"
      v-model="repltext"
      placeholder="Enter something..."
      rows="3"
      max-rows="6"
    ></b-form-textarea>
     <button @click="replay()">提交</button>
	 </div>		
	</div>

</template>
<script>
	import display1 from './dispalymodel/choosedisplay/display1.vue'
import display3 from './dispalymodel/choosedisplay/display3.vue'
import forestage from './forestage .vue'
import axios from "axios";
import Vue from 'vue'
import pagination from './pagination.vue'
 axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
	export default {
	props:['taskid','istask'],	
    components: {pagination},
    data() {
      return {
        text: '',
        displaycomment:[],
        disreply:[],
        repltext:"",
        comentid:"",
        from_uid:"",
        from_uname:"",
         datalength:0,
           replylength:3,          
        nowpage:'',
        totalpage:'',
        diaplaypage:'',
        totalnum:'',
        disdata:[],
        getindexarray:[],
        getindex:2,
        numberkey:0,
        getcommentpage:0,
        getreplypage:0,
        getreplyid:"",
        getuserid:"",
        getdisplayflag:[],
        disreplyflag:false,

      }
    },
    mounted:function(){
    	
         this.$refs.pagination.pagename = "taskcommentpagetabele"
                  this.$refs.pagination.showname = "taskcommentshowtabele"
                  this.$refs.pagination.totalnumname = "taskcommenttotalnumtable"
                  this.$refs.pagination.totalpagename = "taskcommentztotalpagetable"
                  this.displayread();
    	
       
     
    	// this.getdisplayReply();
    },
    watch:{
    	displaycomment:function(value){
    		this.getdisplayReply();
    		
        	
    	},
      disreply:function(value){
      //   this.displayread();
        this.displaynewMsg();
      },
      // getdisplayflag:function(value){
      // 	console.log(value)
      // }

     
    },
    methods:{
      changRead(id,commentid){
        // 
         axios.post(this.$url+'/comment.php',{changread:id}).then(res=>{
                            // this.displaycomment = res.data;
                            // 得到数据显示出来
                          
                            // 之后移除class
                            var allListElements = $( "p.getreplycolor" )
                            for(var i = 0;i<allListElements.length;i++){
                              if(allListElements[i].getAttribute( "id" )==id){
                                allListElements[i].removeAttribute("class");
                                allListElements[i].setAttribute("class","getreplynoncolor");
                              }
                            }
                             this.displaynewMsg();
                            // this.disreply = res.data
                           })
         this.$forceUpdate()
        
        
         // 
      },
      displayread(){

        if(typeof(this.istask)!="undefined"){

          var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
              
                      axios.post(this.$url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                        this.getuserid = res.data['userid'];
                        this.displaynewMsg()
                      

                        // 判断当前的内容是否有新消息
                        
                      })

               this.getcommenttable();
        
        }else{
        	// console.log(this.$route)
        	this.getcommenttable();
        }
         
        // console.log(this.$router)
      },
      displaynewMsg(){
 
      	var commentid = [];
    		for(var i = 0;i<this.displaycomment.length;i++){
    			commentid[i] = this.displaycomment[i]['comentid'];
         
    		}

    		var getallreplay ={
    			'comment_id':commentid
    		}
    		
    			 axios.post(this.$url+'/comment.php',{getallreplay:getallreplay}).then(res=>{
                      		 	// this.displaycomment = res.data;
                      		 	// 得到数据显示出来
                      		 	
                      		 	this.displayflag(res);
                      		 	
                      		 	// 拿到数据进行判断
                      		 	
                      		 })
         
      
      },
      displayflag(res){

      	for(var i = 0;i<res.data.length;i++){
      		for(var j = 0;j<Object.keys(res.data[i]).length-1;j++){
      			if(res.data[i][j][0]['reply_id']==this.getuserid&&res.data[i][j][0]['canread']=='0'){
      				this.disreplyflag = true;
      				break;
      			}
      		}
      		this.getdisplayflag[i]={
      			'comment_id':res.data[i]['comment_id'],
      			'flag':this.disreplyflag
      		};
      		
      		this.disreplyflag = false
      	}
      	this.$forceUpdate()
      },
    	display(comentid,from_uid,from_uname){
    	
    		if($( "div.reply" ).css( "display" )=="none"){
    			$( "div.reply" ).css( "display","block" );
    		}else{
    			$( "div.reply" ).css( "display","none" );
    		}
    			this.comentid = comentid
                this.from_uid = from_uid
                this.from_uname = from_uname
    	},
    	getdisplayReply(){
    		var commentid = [];
    		for(var i = 0;i<this.displaycomment.length;i++){
    			commentid[i] = this.displaycomment[i]['comentid'];
          this.getindexarray[i] = 2;
    		}

    		var getcommentid ={
    			'comment_id':commentid
    		}
    		
    			 axios.post(this.$url+'/comment.php',{getcommentid:getcommentid}).then(res=>{
                      		 	// this.displaycomment = res.data;
                      		 	// 得到数据显示出来
                      		 
                      		 	this.disreply = res.data
                      		 })
          this.senddata();

    	},
      senddata(){
         // 发送信息
            
            // var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
                        this.$getDate.getDate();
            //           axios.post(this.$url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                        var time = new Date().Format("yyyy-MM-dd hh:mm:ss");
                        var taskid = this.taskid
                         var getreplydata = {
                                taskid:taskid,
                                userid:this.from_uid,
                                sendata:time+" "+'admin'+'<a href=".#/detail?taskid='+taskid+'&&istask=true"'+'>查看</a>'+"有人回复了你的评论"
                                 // date('Y-m-d').' '.'admin'.'<a href=".#/boss?taskid='.$task['taskid'].'&&userid='.$userid.'"'.'>查看</a>'.$senddata;
                            }
                             axios.post(this.$url+'/comment.php',{getreplydata:getreplydata}).then(res=>{
                           console.log(res.data)
                           })

                      // })
          
      },
      getMoreReply(comentid,index){
               
                
                  var getpagereply={
                  'page':this.getindexarray[index]++,
                  'totalnum':this.$refs.pagination.totalnum,
                  'size':2,
                  'comment_id':comentid
                }
                       
                    axios.post(this.$url+'/comment.php',{getpagereply:getpagereply}).then(res=>{    
                           
                              this.refreshdata(res,comentid);
                    })
                   
                   
      },
      refreshdata(res,comentid){
           var setdata = res.data; 
                        for(var i =0;i<setdata.length;i++){
                        setdata[i] = JSON.parse(setdata[i]);
                        }
                              for(var i =0;i<this.disreply.length;i++){
                                if(this.disreply[i]['comment_id']==comentid){

                                  for(var j = 0;j<setdata.length;j++){
                                    this.replylength = Object.keys(this.disreply[i]).length-1
                                    this.disreply[i][this.replylength] = [setdata[j]];
                                   
                                  }
                                }
                              }
                              this.$forceUpdate()
                             
      },	
    	replay(){
    		// 先设定自己的userid,username
    		$( "div.reply" ).css( "display","none" );
    		 var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         			
                      axios.post(this.$url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                      	var userid = res.data['userid'];
                      	var username = res.data['username'];
                      	var reply={
                      		'comment_id':this.comentid,
                      		'reply_id':this.from_uid,
                      		'reply_name':this.from_uname,
                      		'from_uid':userid,
                      		'from_name':username,
                      		'content':this.repltext,
                          'canread':'0',
                      	}
                      	
                      	 axios.post(this.$url+'/comment.php',{reply:reply}).then(res=>{
                            console.log(res.data);
                            // this.getreplyid =res.data;
                      		 	this.getdisplayReply();
                      		 })
                      	

                      })



    	},

    
      getPagination(res,displaydata){
         
                        
                        var setdata = res.data; 
                        for(var i =0;i<setdata.length;i++){
                        setdata[i] = JSON.parse(setdata[i]);
                        }
                          var settotalnum = setdata[setdata.length-1]['COUNT(*)'];
                          
                         
                         
                      if(this.$refs.pagination.getTotalnum()!=null){
                        if(this.$refs.pagination.getTotalnum()!=settotalnum){
                        console.log(1)
                          this.$refs.pagination.extractData(res.data)
                                if(displaydata=="displaycomment"){
                                   this.displaycomment = this.$refs.pagination.disdata;
                                }
                               
                                this.datalength = this.$refs.pagination.datalength;
                        }else{
                          console.log(2)
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
                             if(displaydata=="displaycomment"){
                                  this.displaycomment = this.$refs.pagination.disdata;
                                }
                              
                              this.datalength = this.$refs.pagination.datalength; 
                      }
                     
                         
                         
           
                    

      },
       getcommenttable(){
        var taskid = this.taskid;
                    var getcomment ={
                          'topic_id':taskid,
                          
                        } 
            axios.post(this.$url+'/comment.php',{getcomment:getcomment}).then(res=>{
                this.getPagination(res,'displaycomment');

              })
                   
                  
                  

                     
                   
          
                  },
          getpagedata(index){
                    // 先把任务的数量拿出来
                 var taskid = this.taskid;  
                var getpagecomment={
                  'page':index,
                  'totalnum':this.$refs.pagination.totalnum,
                  'size':2,
                  'topic_id':taskid
                }
                       
                    axios.post(this.$url+'/comment.php',{getpagecomment:getpagecomment}).then(res=>{    
                               this.$refs.pagination.extractpageData(res.data,index);
                              this.displaycomment = this.$refs.pagination.disdata;
                              this.datalength = this.$refs.pagination.datalength; 
                     //      // console.log(res.data)
                    })
                      
                   

                    
                     
                     
                  },
    	comment(taskid){
    		// 传进来的值
    		taskid = this.taskid;
    		 var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         			
                      axios.post(this.$url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                      	var userid = res.data['userid'];
                      	var username = res.data['username'];
                      	var comment ={
                      		'topic_id':taskid,
                      		'content':this.text,
                      		'from_uid':userid,
                      		'from_uname':username
                      	}
                      		 axios.post(this.$url+'/comment.php',{comment:comment}).then(res=>{
                      		 	this.displaycomment = res.data;
                      		 	
                      		 })
                      })
    	}
    }
  }

</script>
<style scoped>

#textarea{
	margin-right:2%;
	margin-left: 2%;
}
.getreplycolor{
  background-color: coral;
}
.getreplynoncolor{
  background-color:white;
}
.commentlist{
	width: 80%;
	/*margin-top: 1%;*/
	
	padding-bottom: 1%;
	/*text-align: center;*/
	 border:solid 1px #666;
	 border-bottom: solid 0px; 
	 
}
.commentlist:last-child{
	width: 80%;
	
	padding-top: 1%;
	padding-bottom: 1%;
	
	 border:solid 1px #666;
	
	 
}
.displaynone{
	display: none
}
.display{
	display: block
}
.reply{
	display: none;
}
.commentlist p:first-child {
	
	 
}
.commentlist div{
	 border-top:dotted 1px #666;
	 padding-top: 1%;
	 padding-bottom: 1%;
	text-align: center;
	 
}
.commentlist p:last-child {
	border-top: solid 1px #666;
	position: relative;
	 
}
.commentlist p:last-child span{
	position: absolute;
	right: 2%;

	 
}
</style>