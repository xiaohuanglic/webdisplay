<template>
	<div>
	 <chatmodel  ref="child" :pageTimer="pageTimer"></chatmodel>
	</div>
</template>
<script>
import chatmodel from './chatmodel.vue'
import axios from "axios";
import Vue from 'vue';
import qs from 'qs'
import url from "../js/totalurl.js";
 axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
const CancelToken = axios.CancelToken;
const source = CancelToken.source();
  var addimage=Vue.extend({
            props:['imgsrc'],
            template:'<img class="getpicmiddle" :src=this.imgsrc>',
          
        })
export default {
    
    components: {chatmodel},
     data() {
      			return {
       
        			pageTimer:[],
      			}	
    		},
        mounted: function () {
        	// console.log(this.$common)
        	var common = this.$common;
        	var newmsg = this.$newmessage;

        	var child = this.$refs.child
        	this.craetelist(this,child,common,newmsg).$mount("#displaylist");

        },
       
         methods:{
         	craetelist(that,child,common,newmsg){
         		// 拿到所有对话人的名字，并显示出来
         		// 两个转跳方法
         		// 1.交谈
         		// 2.消息
         		var html = '<div  ref="getchild" v-mouse:swipedown="downSlide" v-mouse:swipeup="upSlide" class="replayleft chathead"><ul class="chatperson "><li v-for="(item,index) in usernamelist" @click="displaychat(item,index)">{{item["username"]}}<span >({{item["usernum"]}})</span></li></span></ul></div>'
         		var addchat = Vue.extend({
         			template: html,
         			data() {
          			return{
          			// pageTimer :{}, 	
                  totalnum:0,
                  totalpage:0,
          				page:1,
                  displaynum:2,
          				usernamelist:[],
                  usernumslist:[],
                  setsession:[],
                  useridlist:[],
                  // allusernamelist:[]
          			}
          			},
             directives: {
                  touch: {
    // // 指令的定义        
                    bind: function (el, binding, vnode) {
                          
                          var touchType = binding.arg;
                          var timeOutEvent = 0;
                          var direction = '';
    //   //滑动处理
                          var startX, startY;
    //                       //返回角度
                          function GetSlideAngle(dx, dy) {
                              return Math.atan2(dy, dx) * 180 / Math.PI;
                          }

                          function GetSlideDirection(startX, startY, endX, endY) {
                              var dy = startY - endY;
                              var dx = endX - startX;
                              var result = 0;

        //如果滑动距离太短
                              if (Math.abs(dx) < 2 && Math.abs(dy) < 2) {
                                return result;
                              }

                              var angle = GetSlideAngle(dx, dy);
                              if (angle >= -45 && angle < 45) {
                                result = 'swiperight';
                              } else if (angle >= 45 && angle < 135) {
                                result = 'swipeup';
                              } else if (angle >= -135 && angle < -45) {
                                result = 'swipedown';
                              }
                              else if ((angle >= 135 && angle <= 180) || (angle >= -180 && angle < -135)) {
                                result = 'swipeleft';
                              }                     
                              return result;
                          }
                          el.addEventListener('touchstart', function (ev) {
                                // 大于500毫毛为长按
                                startX = ev.touches[0].pageX;
                                startY = ev.touches[0].pageY;


        //判断长按
                                timeOutEvent = setTimeout(() =>{
                                    timeOutEvent = 0 ;
                                    if(touchType === 'press'){
                                      binding.value()
                                    }
                                } , 500);

                                }, false);
                          el.addEventListener('touchmove' , function (ev) {
                                clearTimeout(timeOutEvent)
                                timeOutEvent = 0;
                                });
                          el.addEventListener('touchend', function (ev) {
                              var endX, endY;
                              endX = ev.changedTouches[0].pageX;
                              endY = ev.changedTouches[0].pageY;
                              direction = GetSlideDirection(startX, startY, endX, endY);

                              clearTimeout(timeOutEvent)

                              switch (direction) {
                                case 0:
                                  break;
                                case 'swipeup':
                                  if(touchType === 'swipeup'){
                                      binding.value()
                                  }
                                  break;
                                case 'swipedown':
                                  if(touchType === 'swipedown'){
                                      binding.value()
                                  }
                                  break;
                                case 'swipeleft':
                                  if(touchType === 'swipeleft'){
                                      binding.value()
                                  }
                                  break;
                                case 'swiperight':
                                  if(touchType === 'swiperight'){
                                      binding.value()
                                  }
                                 break;
                                default:
                              }
                            }, false);       


    //                     } 

                                             
                     
                    }
                  },
                  mouse: {
    // // 指令的定义        
                    bind: function (el, binding, vnode) {
                          // console.log(binding);
                          var touchType = binding.arg;
                          var timeOutEvent = 0;
                          var direction = '';
    //   //滑动处理
                          var startX, startY;

    //                       //返回角度
                          function GetSlideAngle(dx, dy) {
                              return Math.atan2(dy, dx) * 180 / Math.PI;
                          }

                          function GetSlideDirection(startX, startY, endX, endY) {
                              var dy = startY - endY;
                              var dx = endX - startX;
                              var result = 0;

        //如果滑动距离太短
                              if (Math.abs(dx) < 2 && Math.abs(dy) < 2) {
                                return result;
                              }

                              var angle = GetSlideAngle(dx, dy);
                              if (angle >= -45 && angle < 45) {
                                result = 'swiperight';
                              } else if (angle >= 45 && angle < 135) {
                                result = 'swipeup';
                              } else if (angle >= -135 && angle < -45) {
                                result = 'swipedown';
                              }
                              else if ((angle >= 135 && angle <= 180) || (angle >= -180 && angle < -135)) {
                                result = 'swipeleft';
                              }                     
                              return result;
                          }
                          el.addEventListener('mousedown', function (ev) {
                                // 大于500毫毛为长按
                                startX = ev.pageX;
                                startY = ev.pageY;

                               
        //判断长按
                                timeOutEvent = setTimeout(() =>{
                                    timeOutEvent = 0 ;
                                    if(touchType === 'press'){
                                      binding.value()
                                    }
                                } , 500);

                                }, false);
                          el.addEventListener('mouseup' , function (ev) {
                                clearTimeout(timeOutEvent)
                                timeOutEvent = 0;
                                var endX = ev.pageX;
                                var endY = ev.pageY;
                                direction = GetSlideDirection(startX, startY, endX, endY);
                                 switch (direction) {
                                case 0:
                                  break;
                                case 'swipeup':
                                  if(touchType === 'swipeup'){
                                      binding.value()
                                  }
                                  break;
                                case 'swipedown':
                                  if(touchType === 'swipedown'){
                                      binding.value()
                                  }
                                  break;
                                case 'swipeleft':
                                  if(touchType === 'swipeleft'){
                                      binding.value()
                                  }
                                  break;
                                case 'swiperight':
                                  if(touchType === 'swiperight'){
                                      binding.value()
                                  }
                                 break;
                                default:
                              }
                                clearTimeout(timeOutEvent)
                          });
                
                      }
                  }

              },
         			mounted() {

         				// 从后台得到聊天人数
         				// 得到相关的人
                // 要判断那不拿到数据
                // if(that.$route.query.userid==null&&that.$route.query.myid==null&&that.$route.query.myname==null&&that.$route.query.personid==null){
                	// 直接拿到所有的数据
                	
                   for(var i =0;i<common["time3"].length;i++){
                   clearInterval(common["time3"][i]);
                    }
                  this.gettotalchatnum()
                  // 进行监听
                  // this.gatchatperson();
                // }
                // else{
                //   // this.getaddchatperson();
                // }
         				
         				// this.gatchatperson();
          				

          			},
          			methods:{
                  downSlide() {
                    // console.log(this.totalpage)
                    if(this.page<this.totalpage){
                      this.page++;
                    }else{
                      this.page = this.totalpage
                    }
                    this.gatchatperson()
                    // this.page++;
                    // return this.page     
                  },
                  upSlide() {
                  	// 设计滚动条
                    // if(this.page>1){
                    //   this.page--;
                    // }else{
                    //   this.page=1
                    // }
                    // this.gatchatperson();
                    // return this.page
                    
                  },
                  getsetsessionfun(getresdata,i,o,getuerdata){
                  	 axios.get(getresdata[i]['chatmsg']).then(res=>{
                     
                           				var resdata = res.data;
                           				

                         				 getuerdata[o].val =  res.data
                         				  // console.log(getuerdata)
                         				  console.log(o)
                              // 再重新赋值
                          				// this.getsavechatdata(res.data);
                          				localStorage.setItem('setsession', JSON.stringify(getuerdata));
                       					})

                  },
                  gettotalchatnum(){
                  	// 判断有没有userid
                    var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
                    axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                        
                          // var myid = JSON.parse(sessionStorage.getItem("vue-session-key"))['username'][1];
                    var myid = res.data['userid'];
                    // console.log(1);
                    axios.get(url+'/gettotalnum.php/?myid='+myid).then(res=>{
                    	
                      if(res.data!="没有数据"){
                        console.log(res.data);
                    //     // 把所有的数据储存在session中
                        for(var i = 0;i<res.data.length;i++){
                        	if(myid==res.data[i]['myid']){
                        		// console.log(res.data[i]['userid'])
                        		this.setsession.push({
                              name:res.data[i]['userid'],
                              val:""
                            })

                        	}else if(myid==res.data[i]['userid']){
                        	this.setsession.push({
                              name:res.data[i]['userid'],
                              val:""
                        	})
                        	}
                   
                        }
                       

                        	localStorage.setItem('setsession',JSON.stringify(this.setsession));


                        var getuerdata = JSON.parse(localStorage.getItem('setsession'));

                        for(var i =0;i<res.data.length;i++){
                        	for(var j = 0;j<getuerdata.length;j++){
                        		
                        		if(getuerdata[j]['name']==res.data[i]['userid']){
                        		

                        			var o = j
                        			this.getsetsessionfun(res.data,i,o,getuerdata);

                        		}
                        	}
                        }
                        this.usernamelist =[];
                  			for(var i = 0;i<res.data.length;i++){
                        	if(myid==res.data[i]['myid']){
                        		
                        	this.usernamelist.push({chatid:res.data[i]["chatid"],username:res.data[i]["username"],userid:res.data[i]["userid"],usernum:res.data[i]["usernum"]});

                        	}else if(myid==res.data[i]['userid']){
                        this.usernamelist.push({chatid:res.data[i]["chatid"],username:res.data[i]["myname"],userid:res.data[i]["userid"],usernum:res.data[i]["mynum"]});
                        	}
                   
                        }
                        var chatid = that.$route.query.chatid;
                        var eqealnum = -1;
                        var eqealdata = {};
                        if(typeof(chatid)!="undefined"&&chatid!==null){
                        	for(var i = 0;i<this.usernamelist.length;i++ ){
                        		if(chatid == this.usernamelist[i]['chatid']){
                        			eqealnum = i;
                        			eqealdata = this.usernamelist[i];
                        		}
                        	}

                        	if(eqealnum!=-1){
                        		var temp = this.usernamelist[0];
                        		var i = 1;
                        		while(i<=eqealnum){
                        			var temp1 = this.usernamelist[i];
                        			this.usernamelist[i] = temp;
                        			temp = temp1
                        			i++;
                        		}
                        	}
                        	this.usernamelist[0] =eqealdata;
                        	// 还有剔除数据 
                        	
                        }
                        // 清除
                        sessionStorage.removeItem('clickflag')
                        var resdata = res.data.length;
                       	this.displaychat(this.usernamelist[0],0);
                        this.totalnum = resdata;
                        if(this.displaynum>=this.totalnum){
                        	this.displaynum = this.totalnum;
                        }
                        this.totalpage = this.totalnum/this.displaynum;
                        if((this.totalnum%this.displaynum)>0){
                            this.totalpage++;
                       
                        }

                    }
                      
                      
                      
                     
                     
                     
                     
                    })
                    })
                   
                  },
   
          			gatchatperson(chatid){
          				
          					// 先显示10个
          					// 向下滑动时，显示下一个10个，向上滑动时，显示上一个10个人数
          					// 迟一点在写
                    // 拿到当前的myid，page设置在session中
                    var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
        
                      axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                         
     
                           var myid = res.data['userid'];

                  axios.get(url+'/get.php/?myid='+myid+'&&page='+this.page+'&&totalnum='+this.totalnum+'&&displaynum='+this.displaynum).then(res=>{
                  			this.usernamelist =[];
                  			for(var i = 0;i<res.data.length;i++){
                        	if(myid==res.data[i]['myid']){
                        		
                        	this.usernamelist.push({chatid:res.data[i]["chatid"],username:res.data[i]["username"],userid:res.data[i]["userid"],usernum:res.data[i]["usernum"]});

                        	}else if(myid==res.data[i]['userid']){
                        this.usernamelist.push({chatid:res.data[i]["chatid"],username:res.data[i]["myname"],userid:res.data[i]["userid"],usernum:res.data[i]["mynum"]});
                        	}
                   
                        }
                    
                    })

                      })
                   
          				},
       

          				getaddchatperson(){
          					var userid = that.$route.query.userid;
          				               var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         // console.log(sessionid)
                      axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                      		var myid = res.data['userid']; 
                      		axios.get(url+'/getchatperson.php/?userid='+userid+"&&myid="+res.data['userid']).then(res=>{
          						console.log(res.data);
          					
          						if(typeof(res.data['chatid']) == "undefined"){
          						
          							this.usernamelist.push({
          								username:res.data["username"],
          								userid:that.$route.query.userid
          							})


          						}else{
          							if(myid==res.data['myid']){
                        				
                        				this.usernamelist.push({chatid:res.data["chatid"],username:res.data["username"],userid:res.data["userid"],usernum:res.data["usernum"]});

                        			}else if(myid==res.data['userid']){
                        				
                        			this.usernamelist.push({chatid:res.data["chatid"],username:res.data["myname"],userid:res.data["userid"],usernum:res.data["mynum"]});
                        			}
          						}

                //               
            				})
                      })
          					
          					// 先判断有没有这个人的聊天
          					// 如果有就显示对话框
          					// 如果没有就不用显示对话框

          				},
          				getchatnum(item,chatdata,time,child,common,newmsg){
          					child.pageTimer.push(time)
          					common["time1"].push(time);
          					// console.log(common)
          					var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
                    		 axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                    		 	var userid = res.data['userid'];
                    		 	 axios.post(url+'/getnum.php',{userid:userid}).then(res=>{
                    		 	 	// 要判断是userid,还是myid来取得数据
                    		 	 	var changindex = [];
                    		 	 	for(var i = 0;i<chatdata.length;i++){
                    		 	 		// if(item['userid']!=chatdata[i]['userid']){
                    		 	 			// console.log(res.data);
                    		 	 			for(var j = 0;j<res.data.length;j++){
                                   // &&item['userid']!=chatdata[i]['userid']&&chatdata[i]['userid']==res.data[j]['userid']
                    		 	 			if(userid==res.data[j]['userid']&&item['userid']!=chatdata[i]&&chatdata[i]['userid']==res.data[j]['userid']){
                                    
                    		 	 					if( res.data[j]['mynum']!=0){
                    		 	 						changindex.push(i);
                    		 	 					}
                    		 	 					chatdata[i]['usernum'] = res.data[j]['mynum']
                    		 	 				}
                                  if(userid==res.data[j]['myid']&&item['userid']!=chatdata[i]['userid']&&chatdata[i]['userid']==res.data[j]['userid']){
                    		 	 					if( res.data[j]['usernum']!=0){
                    		 	 						changindex.push(i);
                    		 	 					}
                    		 	 					chatdata[i]['usernum'] = res.data[j]['usernum']
                    		 	 				}
                    		 	 			}
                    		 	 	

                    		 	 		// }
                    		 	 	}
                    		 	 	// console.log(changindex)
                    		 	 	var eqealnum = -1;
                        			var eqealdata = {};
                    		 	 	if(changindex.length!=0){
                    		 	 		for(var a= 0;a<changindex.length;a++){
                    		 	 			eqealnum = changindex[a];
                    		 	 			eqealdata = chatdata[eqealnum];
                    		 	 			if(eqealnum!=-1){
                        					var temp = chatdata[0];
                        					var i = 1;
                        					
                        					while(i<=eqealnum){
                        						var temp1 = chatdata[i];
                        						console.log("交换")
                        						chatdata[i] = temp;
                        						temp = temp1
                        						i++;
                        						}
                        				}
                        					chatdata[0] =eqealdata;
                        					
                    		 	 		}

                    		 	 	}
                    				newmsg['getnewnum'] = chatdata;
                    				// console.log(newmsg)
                        	
                    		 	
                    		 	})
                    		
                    		 })

          				},
          				displaychat(item,num){

          					 // console.log(child.displayflag)
          					child.clearright(child);
                    
                    		var chatdata = this.usernamelist
                    	;
                    		var time = null;
                    		var that1 = this;

                      var getusernum = function(item,chatdata,time,child,common,newmsg){  
                          // 从第二个开始提取
                           that1.getchatnum(item,chatdata,time,child,common,newmsg);
                        }
                        
                        time = window.setInterval(function(){
                        	getusernum(item,chatdata,time,child,common,newmsg);
                        },3000);
                        // newmsg["getnewnum"] = chatdata
                        	
                        child.pageTimer.push(time);
                       	
                        common["time1"].push(time);
          					that.createchat(that,child,item,num,common).$mount("#displaycontent");
          				}

          			}

         		})

         		return new addchat();
         	},
          	createchat(that,child,chatname,num,common){
           		
           		// var that = this;
              // <div id="outdiv"> 
              // <input type="file" multiple id="file" @change="uploadConfig">


              //<div><input type="file"  id="getppic" accept="image/gif,image/jpeg,image/jpg,image/png" @change="addpicture($event)" ref="ppicInput" class="ppic"> 

              // <img class="dispic" :src="" >

              // <div class="getpic"><img class="dispic" :src="../image/fileimage/file.jpg" ><input type="file" multiple id="file" @change="uploadConfig" ></div>
        	var html = '<div class="chathead"><div id="outdiv" @scroll="handleScroll"><div id="chatmsg"></div><div class="scrollbar" @mouseover="hoverScrollBar "><div class="scroll-div-y-bar"></div></div></div><div class="chatmiddle"><div class="getpicsmall"><img class="getpicsmall" src="../image/fileimage/uploadimg.jpg" ><input type="file"  id="getppic2" accept="image/gif,image/jpeg,image/jpg,image/png" @change="addpicture($event)" ref="ppicInput" class="ppic"></div><div class="getpicsmall"><img class="getpicsmall" src="../image/fileimage/file.jpg" ><input class="filestyle" type="file" multiple id="file" @change="uploadConfig" ></div></div><div id="outdivsend" @scroll="handleScroll"><div id="sendmsg"   @keyup="keyevent($event)"><span v-for="item in filelist">{{item["name"]}}</span><div id="getsendmsg" contenteditable="true"><img  v-for="item in piclist" :is="item.component" :imgsrc="item.imgsrc" class="getpicmiddle"></div></div><div class="scrollbar" @mouseover="hoverScrollBar "><div class="scroll-div-y-bar"></div></div></div></div>'
        	// <div id="outdiv" @scroll="handleScroll"><div id="sendmsg" contenteditable="true"  @keyup.enter="keyevent()"></div><div class="scrollbar" @mouseover="hoverScrollBar "><div class="scroll-div-y-bar"></div></div></div>
        	var addchat = Vue.extend({
                template: html,
                components: {
                'addimage':addimage
                },
                data() {
          			return{
          				userid:"",
          				myid:"",
          				date:'',
          				sendname:"",
            			chatmsg:'',
            			sendmsg:'',
            			chatid:'',
            			usernum:0,
            			mynum:0,
            			username:'',
            			changedata:'',
            			flag:'',
            			mynum:0,
            			piclist:[],
                  filelist:[],
                  urllist:[],
            			formData:{},
            			picindex:0,
            			files:"",
                  scroll:"",
                  scrollTop :0,
                  startY:0,
                  distanceY:0,
                  scrollflag:"",
                  scrollheight:0

          		}
          		},
          		mounted() {
                
                  // child.displayflag = false;
          					 
                // console.log(scrollYBar.style.height)
                this.calcSize();
          			this.load();
                // this.scrollbottom();

          		},
              watch: {
                
              },

          		methods:{
                handleScroll (el) {
                    // 兼容
                    const scrollContainer = document.querySelector('#chatmsg');
                    const scrollY = document.querySelector('.scrollbar');
                    const scrollYBar = document.querySelector('.scroll-div-y-bar');
                    const e = el || event;
                    const target = e.target || e.srcElement;
                    // // 如果最新一次滚动的scrollTop跟上一次不同，即发生了垂直滚动
                    // // 主要是为了区分是垂直滚动还是横向滚动，因为这里暂时不写横向滚动条，所以这里注释，为了一个提醒
                    // // if (target.scrollTop !== scrollTop) {}
                    const scrollAreaValue = scrollContainer.scrollHeight;
                    const clientAreaValue = scrollContainer.clientHeight;
                    const scrollValue = scrollContainer.scrollTop;
                    // console.log(scrollValue)
                    scrollYBar.className += ' is-show'; // 展示滚动条浮标
                    timer && clearTimeout(timer);
                    this.calcSize(); // 每次滚动的时候重新计算滚动条尺寸，以免容器内容发生变化后，滚动条尺寸不匹配变化后的容器宽高
                    const distance = scrollValue * clientAreaValue / scrollAreaValue; // 根据公式二计算滚动条浮标应该移动距离
                    scrollYBar.style.transform = `translateY(${distance}px)`;
                    const timer = setTimeout(() => {
                        scrollYBar.className = scrollYBar.className.replace(' is-show', ''); // 隐藏滚动条浮标
                    }, 800);
                    this.scrollTop = target.scrollTop;
              },
              hoverScrollBar(){
                 const scrollContainer = document.querySelector('#chatmsg');
                  const scrollY = document.querySelector('.scrollbar');
                  const scrollYBar = document.querySelector('.scroll-div-y-bar');
                  const sA = scrollContainer.scrollHeight;
                  const cA = scrollContainer.clientHeight;
    
                  if (sA > cA) {
                    scrollYBar.style[style] = cA * cA / sA + 'px'; // 设置滚动条长度
                    scrollYBar.className += ' is-show';
                    scrollYBar.addEventListener('mousedown', this.clickStart);
                    scrollY.addEventListener('mouseout', this.hoverOutSroll);
                  }

              },
             clickStart (el) {
                  const scrollContainer = document.querySelector('#chatmsg');
                  const scrollY = document.querySelector('.scrollbar');
                  const scrollYBar = document.querySelector('.scroll-div-y-bar');
                  const e = el || event;
                  const target = e.target || e.srcElement;
                  this.startY = e.pageY; // 记录此刻点击时的pageY，用于后面拖动鼠标计算移动了多少距离
                  this.distanceY = scrollContainer.scrollTop; // 记录此刻点击时的内容容器的scrollTop，用于后面根据拖动鼠标移动距离计算得出的内容容器对应滚动比例，进行相加操作，得出最终的scrollTop
                  scrollY.removeEventListener('mouseout', this.hoverOutSroll);
                  document.addEventListener('mousemove', this.moveScrollYBar);
                  document.addEventListener('mouseup', this.clickEnd);
              },
              hoverOutSroll (el) {
                 const scrollContainer = document.querySelector('#chatmsg');
                  const scrollY = document.querySelector('.scrollbar');
                  const scrollYBar = document.querySelector('.scroll-div-y-bar');
                  const e = el || event;
                  const target = e.target || e.srcElement;
                  scrollYBar.className = scrollYBar.className.replace(' is-show', ''); // 隐藏滚动条浮标
                  scrollYBar.removeEventListener('mousedown', this.clickStart);
                  scrollY.removeEventListener('mouseout', this.hoverOutSroll);
              },
              moveScrollBar (el) {
                const scrollContainer = document.querySelector('#chatmsg');
                const scrollY = document.querySelector('.scrollbar');
                const scrollYBar = document.querySelector('.scroll-div-y-bar');
                const e = el || event;
                const delta = e.pageY - this.startY;
                const scrollAreaValue = scrollContainer.scrollHeight;
                const clientAreaValue = scrollContainer.clientHeight;
                let change = scrollAreaValue * delta / clientAreaValue; // 根据移动的距离，计算出内容应该被移动的距离（scrollTop）
                change += this.distanceY; // 加上原本已经移动的内容位置，得出确实的scrollTop
                // 如果计算值是负数，证明肯定回到滚动最开始的位置了
                if (change < 0) {
                    scrollContainer.scrollTop = 0;
                    return;
                }
                // 如果大于最大等于移动距离，那么即到达底部
                if (change + clientAreaValue >= scrollAreaValue) {
                    scrollContainer.scrollTop = scrollAreaValue - clientAreaValue;;

                    return                }
                scrollContainer.scrollTop = change; // 设置了scrollTop会引起scroll事件的触发
            },
            clickEnd () {
                const scrollContainer = document.querySelector('#chatmsg');
                const scrollY = document.querySelector('.scrollbar');
                const scrollYBar = document.querySelector('.scroll-div-y-bar');
                document.removeEventListener('mousemove', this.moveScrollYBar);
                document.removeEventListener('mouseup', this.clickEnd);
                scrollY.addEventListener('mouseout', this.hoverOutSroll);
            },






              calcSize(){
                const scrollContainer = document.querySelector('#chatmsg');
                const scrollY = document.querySelector('.scrollbar');
                const scrollYBar = document.querySelector('.scroll-div-y-bar');
                // 设置高度
                const clientAreaValue = scrollContainer.clientHeight;
                scrollYBar.style.height = (clientAreaValue*(clientAreaValue / scrollContainer.scrollHeight))+ 'px';
              },
              scrollbottom(){
                const scrollContainer = document.querySelector('#chatmsg');
                const scrollY = document.querySelector('.scrollbar');
                const scrollYBar = document.querySelector('.scroll-div-y-bar');
                scrollContainer.scrollTop =scrollContainer.scrollHeight;
                // console.log(scrollContainer.scrollTop);

              },
         			getFormatDate() {
         				var date = new Date();
         				var month = date.getMonth() + 1;
         				var strDate = date.getDate();
         				if (month >= 1 && month <= 9) {
       						month = "0" + month;
    					}
    					if (strDate >= 0 && strDate <= 9) {
        					strDate = "0" + strDate;
    					}
    					var currentDate = date.getFullYear() + "-" + month + "-" + strDate
            			+ " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
         				return currentDate
         			},
         			load(){
         				this.loadgetdata();
     
         			 
         			
              				
         			},

              loadgetdata(){	
              		if (typeof(chatname['chatid']) != "undefined")
					{
    				axios.post(url+'/chat.php',{chatid:chatname['chatid'],name:this.flag}).then(res=>{
                 		console.log(res.data);  
                    if(res.data=="没有数据"){
                      console.log("没有数据")
                    }else{
                      var chatdata = res.data;
                     
                      this.getchatData(chatdata,0)
                    }
                    })
					}
                  

              },
         			addpicture(e){
         				if(window.FileReader) {
							var reader = new FileReader();
						} else {
							alert("您的设备不支持图片预览功能，如需该功能请升级您的设备！");
						}
						var file = e.target.files[0];
						var imageType = /^image\//;
	
						if(!imageType.test(file.type)) {
							alert("请选择图片！");
							return;
						}
						this.picindex++;
						var that = this
                    	reader.readAsDataURL(file)
                    	reader.onload = function(e){
                    
                   
                      if(that.picindex<=8&&that.picindex>0){
                        that.piclist.push({
                          'component':'addimage',
                          'imgsrc':this.result
                        })
                       }else{
                       		console.log("图片不能超过8张")
                       }
                       }

         			},
         			uploadConfig(e){
         		

        				var files = e.target.files
        
                var that = this
                for(var i = 0;i<files.length;i++){
                    this.readFile(files[i],that);
                }

                
          
        			
         			},
              readFile(file,that){
                  var reader = new FileReader();
                  var fileName = file.name.lastIndexOf(".");//获取到文件名开始到最后一个“.”的长度。
                  var fileNameLength = file.name.length;//获取到文件名长度
  
                  var fileFormat = file.name.substring(fileName + 1, fileNameLength);
                
                  var blob = null;
                  var rs = reader.readAsArrayBuffer(file);
                  reader.onload=(e)=>{
                      if(typeof e.target.result ==='object'){
                        blob = new Blob([e.target.result])
                        that.filelist.push({
                          'file':blob,
                          'type':fileFormat,
                          'name':file.name
                        })
                       
                      }else{
                        blob = e.target.result
                        that.filelist.push({
                          'file':blob,
                          'type':'txt',
                          'name':file.name
                        })
                      }
                     
                }

              },
           
         			//判断需要有没有输入数据
          		 	keyevent($event){
          		 		var parent = document.getElementById("getsendmsg");
          		 		var child = parent.childNodes;
          		 		var currentimg = document.getElementsByClassName("getpicmiddle");
          		 		console.log()
//           		 		component: (...)
// imgsrc: (...)
          		 		var getnewlist =[];
          		 		for(var i = 0;i<child.length;i++){
          		 			for(var j = 0;j<currentimg.length;j++){
          		 				if(child[i].isEqualNode(currentimg[j])){
          		 					getnewlist.push({
          		 						component:"addimage",
          		 						imgsrc:child[i]['currentSrc']
          		 					})
          		 				}
          		 			}
          		 		}
          		 		
          		 		if($event['code']=="Enter"||$event['code']=="NumpadEnter"){
          		 			this.piclist = getnewlist
                    this.sendmsg = document.getElementById("getsendmsg").innerText;
          		 			   if(that.$route.query.userid==null&&that.$route.query.myid==null&&that.$route.query.myname==null&&that.$route.query.personid==null){
            
                   axios.get(url+'/get.php/?chatname='+chatname['chatid']).then(res=>{
                   	

               

                       this.userid=res.data['userid'];
                       this.myid = res.data['myid'];
              

                      this.SendChatData();
                      
                     
                      

                    })
         

                }else{
              

                  this.SendChatData()
                }

          		 		}
                
          		 	
          		 	
          	},
          
            SendChatData(){
              var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
         
              axios.post(url+'/checksession.php',{sessionid:sessionid}).then(res=>{
                
                    this.name =res.data['username'];
                    this.flag = res.data['userid'];
                this.date = this.getFormatDate()
                  this.sendmsg = document.getElementById("getsendmsg").innerText;
                  if(this.sendmsg!=""){
                    // console.log(JSON.parse(this.chatmsg))
                    this.chatmsg ="";
                    this.chatmsg =this.date+"   "+this.name+":\n  "+this.sendmsg
                    // console.log(this.chatmsg);
                    document.getElementById("getsendmsg").innerText = "";
                  }

                let config = {
                   headers:{'Content-Type':'multipart/form-data'}
                   // transformRequest: [filelist => this.filelist[0]['file']]
                };
              if(this.filelist.length==0){
                if(typeof(chatname['chatid']) != "undefined"){
                	  axios.post(url+'/chat.php',{chatid:chatname['chatid'],chatmsg:this.chatmsg,userimg:this.piclist,flag:this.flag},{cancelToken: source.token}).then(res=>{
                   
               		
                  this.sendmsg = ''
                  var resdata = res.data.split(',');
                   this.piclist = [];
                  document.getElementById("chatmsg").innerText="";
                  this.getchatData(resdata[resdata.length-1],1); 
                  
                    
                  })
                

                }
            
               
              }else{
                  if(sessionStorage.getItem("fileid")=="undefined"||sessionStorage.getItem("fileid")==null||sessionStorage.getItem("fileid")==""){
                axios.post(url+'/chat.php',{filelist:this.filelist},config).then(res=>{
                   
                    this.urllist[0] = res.data

                   sessionStorage.removeItem('fileid');
                  
                  if(this.urllist.length!=0){
                    var file = document.getElementById('file');
                    file.disabled = true;
                if(typeof(chatname['chatid']) != "undefined"){
                   	  axios.post(url+'/chat.php',{chatid:chatname['chatid'],chatmsg:this.chatmsg,userimg:this.piclist,userfile:this.urllist},{cancelToken: source.token}).then(res=>{
                   
                 

                   
                  this.piclist = [];
                  this.sendmsg = ''
                  var resdata = res.data.split(',');
                  document.getElementById("chatmsg").innerText="";
                    this.getchatData(resdata[1],1); 
                  
                    
                  })

                   }
            
                
                  }
                    
                })
              }else{
                sessionStorage.removeItem('fileid');
                console.log("还在传送中");
              }
              }
           

                      })
              
            },
            closeTimeout(timer){
            	window.clearTimeout(timer);   // 关闭延时定时器
        	},
          	settimer(j,chatdata,getuerdata,chatname,time,common){
          		// console.log(getuerdata[j]['name']+"-------------"+chatname);
          		// var getnewchatname ==sessionStorage.getItem('clickflag');
          		child.pageTimer.push(time);
          		 common["time2"].push(time)
          		if(getuerdata[j]['name']==sessionStorage.getItem('clickflag')){
          			 axios.get(chatdata).then(res=>{
                      this.chatmsg = res.data
                      if(getuerdata[j]['val']!=""){
                       
                        // 最复杂
                        
                        var savechatdat = getuerdata[j]['val'];
                        var resdata = res.data
                        if(savechatdat != resdata){
                            var indexof = resdata.indexOf(savechatdat);
                            if(indexof!=-1){
                              resdata = resdata.substring(indexof);
                           
                              this.getsavechatdata(resdata);
                            }else{
                              this.getsavechatdata(res.data);
                            }
                           
                        }
                         getuerdata[j].val = resdata;
                         localStorage.setItem('setsession', JSON.stringify(getuerdata));

                        // localStorage.setItem('savechatdata',res.data);
                      }
                    
                    })
          			
          		}else{
          			console.log("清除定时器");	
          			 clearInterval(time)
          			 if(time){
          			 	clearInterval(time)
          			 }
          			 

          
          			 
          		}
            	
        	},		 	
          	getchatData(chatdata,flag){
              var getuerdata = JSON.parse(localStorage.getItem('setsession'));
              localStorage.getItem('setsession')
              // clearInterval(time)
              // console.log(chatname['userid']);
              // if(sessionStorage.getItem('clickflag')==null){
              	sessionStorage.setItem('clickflag',chatname['userid']);
              // }
              
              for(var i =0;i<getuerdata.length;i++){
              
                if(getuerdata[i]['name']==chatname['userid']){
                    if(getuerdata[i]['val']!=""){


                      this.getsavechatdata(getuerdata[i]['val']);
                      var j = i;
                      // var __sto = setInterval;
                      
                      var that1 = this
                  
                        var time = window.setInterval(function(){
                        	that1.settimer(j,chatdata,getuerdata,chatname['userid'],time,common)
                        },1000);
                        child.pageTimer.push(time);
                        common["time2"].push(time)
                    }else{
                      var j = i;
                       axios.get(chatdata).then(res=>{
                     
                           var resdata = res.data;
                          getuerdata[j].val = resdata

                              // 再重新赋值
                          this.getsavechatdata(res.data);
                          localStorage.setItem('setsession', JSON.stringify(getuerdata));
                       })
                     
                        
                    }
                    break;
                }
              }


              
          		 		
         			},
         	getsavechatdata(resdata){
            // if(dataflag=='save'){
              var elem = document.getElementById("chatmsg");
              while(elem.hasChildNodes()) //当elem下还存在子节点时 循环继续
              {
                    elem.removeChild(elem.firstChild);
              }
              // }
          
         			var getdata = resdata.split(",-");
         			// console.log(resdata)
              				if(getdata[getdata.length-1].length==0){
              					getdata.splice(getdata.length-1,1);
                       
                        
              				}
              				
              			   
              				for(var i = 0;i<getdata.length;i++){
              					// getdata[i] = getdata[i].split('+');
                      
                        getdata[i] = JSON.parse(getdata[i]);
                        // console.log(getdata[i]);
                        		// var msgarray = getdata[i]["context"].splice("")
              					var bigp = document.createElement("p");
              					bigp.innerHTML = getdata[i]["context"];
              					bigp.setAttribute("class","chatpadding")
              					document.getElementById("chatmsg").appendChild(bigp)
                        // 要提取处理一下
              					if(getdata[i]["imgpath"].length!=0){
                          if(getdata[i]["imgpath"]==","){
                              // console.log("没有图片")
                          }else{

                                getdata[i]["imgpath"] = getdata[i]["imgpath"].split(',')
                                
                                for(var j = 0;j<getdata[i]["imgpath"].length;j++){
                                    if(getdata[i]["imgpath"][j]!=""){
                                          
                                         var bigImg = document.createElement("img");
                                          bigImg.setAttribute("class", "showchatpic chatpadding");
                                          // bigImg.setAttribute("class", "chatpadding")
                                          bigImg.src=getdata[i]["imgpath"][j]
                                          bigImg.addEventListener('click',function(dom){
                                          var Imgdiv = document.createElement("div");
                                          var enlargeimg = document.createElement("img");
                                          enlargeimg.src = dom.path[0].src;
                                          enlargeimg.setAttribute("class", "enlargeimg");
                                          Imgdiv.setAttribute("class", "enlargeimgdiv");
                                          Imgdiv.appendChild(enlargeimg);
                                          document.body.appendChild(Imgdiv);
                                          enlargeimg.addEventListener('click',function(dom){
                                            for(var i = 0;i<dom.path.length;i++){
                                              if(dom.path[i]==document.getElementsByClassName("enlargeimgdiv")[0]){
                                                 document.body.removeChild(dom.path[i])
                                              }
                              
                                                  }
                            
                                                  }         ,false)
                          
                                                  },false);
                                                  document.getElementById("chatmsg").appendChild(bigImg);
                            
                                    } 
                                  }
                             
                          }
              					
              						
              					}

                        if(getdata[i]["filepath"].length!=0){
                            if(getdata[i]["filepath"]==","){
                              console.log("没有文件");
                            }else{
                               getdata[i]["filepath"] = getdata[i]["filepath"].split(',')
                              for(var j = 0;j<getdata[i]["filepath"].length;j++){
                              	if(getdata[i]["filepath"][j]!=""){
                              		  var fileposition = getdata[i]["filepath"][j].indexOf("/file")
  								// console.log(getdata[i]["filepath"])
  								let div = document.createElement('div')
                                let link = document.createElement('a')
                                let p =document.createElement('p');
                                div.setAttribute('class','getsetshape')
                               p.innerText = getdata[i]["filepath"][j].substring(fileposition+1)
                               p.setAttribute("class","chatpadding");
                                link.setAttribute("class","chatmargin setshape")
                                // link.innerText = getdata[i]["filepath"][j].substring(fileposition+1)
                                link.href = getdata[i]["filepath"][j]
                                // link.setAttribute('download', getdata[i]["filepath"][j].substring(fileposition+1))
                                 link.setAttribute('download', getdata[i]["filepath"][j].substring(fileposition+1))
                                 div.appendChild(link);
                                 div.appendChild(p);
                                document.getElementById("chatmsg").appendChild(div);
                                this.filelist=[];
                                file.disabled = false;

                              	}
                              
                              }
                            }
                           
                        }
              					this.scrollbottom()
              					
              				}

                }
          		 	//把数据res.data的处理方法处理一下
          		
          		 }
              })

				return new addchat();
            // new addchat().$mount('#change')
             
              
          	}
      }
    }
        

       

</script>
<style >
.chathead{
	margin-top:1%;
	/*width: 100%;*/
	height: 100%; 
	background-color: #b4c1c5;
	 box-shadow: 5px 2px 2px black;
}
.getpicmiddle{
	width: 20%;
	height: 100px;
	display: inline-block;
	margin-left: 5px;
}
.getpicsmall{
		width: 30;
		height:30px;
		float: left;
		position: relative;
		margin-left: 2%;
}
.chatperson{
	padding-left: 0px;
	margin-left:0px;
	width: 100%;
	
}
.chatperson li{
	border: 0.2rem solid;
	box-shadow: inset 0.3em 0.2em #666;
	/*box-shadow: 10px 5px 5px black;*/
	height: 30px;
	background-color: white;
	padding: 0px;
	margin-top:1px;
	text-align: center;
}
.chatperson li:hover{
	background: #cbd0d4;
}
.enlargeimgdiv{
	position:absolute;
	left:0px;
	top:0px;
	width:100%;
	height:100%;
  text-align:center;
	background-color:rgba(0,0,0,0.8);
	z-index: 999;
}
.enlargeimg{
	position:relative;
	/*left:50%;*/
	top:25%;

}
.box{
	width:150px;
	height:150px;
	display: inline-block;

	
}
.showchatpic{
	width:20%;
	height:20%;

}
.replayleft{
  height: 700px;
  background-color: #a5b1b5;
  box-shadow: 5px 2px 2px black;
}
.chatpadding{
	padding-left:5%;
	/*margin-top: 5%;*/
	font-size: 0.8rem;
}
.filestyle{
	height: 30px;
        width: 30px;
        position: absolute;
        left: 0;
        top: 0;
        margin: 0,0;
        opacity: 0;
        z-index: 99999;
}
.chatmiddle{
	height: 40px;
	width: 90%;
	margin-left: 5%;
}
#getppic2{
	 height: 30px;
        width: 30px;
        position: absolute;
        left: 0;
        top: 0;
        margin: 0,0;
        opacity: 0;
        z-index: 99999;
}
#sendmsg{
	background-color:white;
	width: 100%; 
    
  	height: 150px;
    
    padding: 3px; 
    outline: 0; 
    border: 1px solid #a0b3d6; 
    font-size: 12px; 
   overflow: scroll;
   overflow-x: hidden;
    margin-left: 10px;
}
#getsendmsg{
background-color:white;
  width: 100%; 
    
    height: 100%;
}
#chatmsg{
  background-color:white;
   /*margin-left: -17px;*/
    margin-bottom: -17px;
    overflow: scroll;
    /**宽高的设置是示例，方便大家理解，事实上不应该写死的。**/
    width: 90%; 
    margin-left: 5%;
    height: 500px;


	/*background-color:white;
	width: 373px;
	height:500px; 
    padding: 3px; 
    outline: 0; 
    border: 1px solid #a0b3d6; 
    font-size: 12px; 
    word-wrap: break-word;
    overflow-x: hidden;
  
    _overflow-y: visible;*/
}
.scroll-y-bar.is-show {
    opacity: 1;
    transition: opacity 0s ease 0s;
}
.scrollbar {
   width: 7px;
    border-radius: 7px;
    background-color:rgba(0, 0, 0, .5);
    cursor: pointer;
    opacity: 0;
    transition: opacity .5s ease 0s;

}
.getsetshape{
	width: 20%;
	height:20%;
	margin-bottom: 20%;
	margin-left: 5%;

}
.setshape{
	width: 100%;
	height: 100%;
	display: inline-block;
	
	background-image: url(../image/fileimage/file.jpg) ;
	background-repeat:no-repeat;
	background-position:center;
	background-size: contain
}
.chatmargin{

	margin-bottom: 5%;
	margin-left: 5%;
}
#outdivsend{
	  position: relative;
    display: inline-block;
    overflow: hidden;
    user-select: none;
    width: 90%;
    height:150px; 
    margin-left: 5%
}
#outdiv{
   position: relative;
    display: inline-block;
    overflow: hidden;
    user-select: none;
    width: 100%;
    height:500px; 
/* background-color:white;
	width: 373px; 
	height:300px; 
    padding: 3px; 
    outline: 0; 
    border: 1px solid #a0b3d6; 
    font-size: 12px; */
    /*word-wrap: break-word;*/
   /* overflow-x: hidden;
   
    _overflow-y: visible;*/
	
}
#test{
  width:50px;
  height:50px;
  background-color:black;
}

</style>






