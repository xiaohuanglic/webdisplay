<template>
<div class='waibu'>
<div class="login">
	<!-- v-if="todosList==''" -->
  <button type="button" v-if="isloginshow" @click=showlogin()>登录</button>
  <button type="button" v-if="isregintershow" @click=showregister()>注册</button>
  <div v-if="show=='注册'">
  	<!-- <button type="button" @click=mobileRegistered()>手机号码注册</button> -->
  	<button type="button" @click=emailRegistered()>邮箱注册</button>
  	<form v-if = "showRegistered=='邮箱注册'">
  		<label for="username">用户名:</label>
  		<input type="text" id="username" v-model="username" required="required"><br><br>
 		 <label for="password" >密码:</label>
  		<input type="password" id="password" v-model="password" required="required"><br><br>
      <label for="email" >邮箱:</label>
      <input type="text" id="email" v-model="email" required="required"><br><br>
      <!-- 验证码 -->
  		<input type="button" value="注册" class="submit" @click="onClick(username,password,email)"/>
      <p>{{message}}</p>
	</form>
  	<form v-if = "showRegistered=='手机注册'">
  		<label for="username">用户名:</label>
  		<input type="text" id="username" v-model="username" required="required"><br><br>
 		 <label for="mobile" >手机号:</label>
  		<input type="mobile" id="mobile" v-model="mobile" required="required"><br><br>
      	<label for="mobilecode" >手机验证:</label>
      	<input type="text" id="mobilecode" v-model="mobilecode"><br><br>
      	<input type="button" value="发送验证码" @click="sendPhoneCode(mobile,username)"/>
      <!-- 验证码 -->
  		<!-- <input type="button" value="注册" class="submit" @click="onClick(username,password,email)"/> -->
      <p>{{message}}</p>
	</form>
  </div>
 
  <form id="dislogin">
      <label for="email" >用户名:</label>
      <input type="text" id="username" v-model="username" required="required"><br><br>
     <label for="password" >密码:</label>
      <input type="password" id="password" v-model="password" required="required"><br><br>
     <!-- 验证码 -->
      <div class="code" id="checkCode"></div>
      <p><a href="#" @click="createCode()">看不清换一张</a></p>
      <label for="inputCode" >验证码:</label>
      <input type="text"  id="inputCode" v-model="inputCode" required="required"/>
      <p><input type="button" value="登录" class="submit" @click="Login(email,password,inputCode)"/></p>
      <a href="#" @click="forget">忘记密码</a>
      <p>{{message}}</p>
  </form>
  <div v-if="show=='忘记'">
     <label for="email">邮箱:</label>
      <input type="text" id="email" v-model="email"><br><br>
      <button @click="submitemailtime">{{forgetpaw}}({{emailtime}})s</button>
      <p @click="islogin">返回登录注册页面</p>
      <p>{{message}}</p>
  </div>
  <div v-if="show=='resetpaw'">
     <label for="resetpassword1">修改密码:</label>
      <input type="password" id="resetpassword1" v-model="resetpassword1" ><br><br>
      <label for="resetpassword2">重新输入密码:</label>
      <input type="password" id="resetpassword2" v-model="resetpassword2"><br><br>
      <button @click="submitpaw">修改密码</button>
      <p @click="islogin">返回登录注册页面</p>
      <p>{{message}}</p>
  </div>
  <div v-if="show=='重新发送邮件'">
  	 <a v-if="todosList!=''" v-on:click="Sendtimeemail(todosList)">{{resend}}({{time}})s</a>
  	<p v-if="todosList!=''" @click="isdisplaythis">返回登录注册页面</p>
  </div>
</div>
</div>
</template>
<script>
	import axios from "axios";
	import Vue from 'vue'
  	import VueSession from 'vue-session'
  	import 'jquery';
  	Vue.use(VueSession)
  	const session = Vue.prototype.$session;
    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
		export default {
  		data() {
    		return {
    		isloginshow:true,
    		isregintershow:true,
    		forgetpaw:"发送邮箱",
    		resend:"重新发送邮箱激活码",
    		showRegistered:"",
          mobilecode:"",
          show:"登录",
          active:"",
          inputCode:"",
      		todosList:"",
          username:"",
          password:"",
          email:"",
          code:"",
          resetpassword1:"",
          resetpassword2:"",
          dislogin:"",
          message:"",
          Activecode:this.$route.query.Activecode,
          resetcode:this.$route.query.resetcode,
          time:60,
          emailtime:45
    		};
    		
  		},
      watch:{
       Activecode:{
            handler(newName, oldName) {
            this.ajax('http://localhost:5001/Activeemail.php/?Activecode='+newName,'get',{},{},(res) => {
                if(res.data=="账号激活成功"){
                 this.todosList=""
               }
            })
           

          },
          immediate: true
        },
      
    },
  		mounted() {
    		// console.log(this.resetcode)
        this.resetpawcode();

        if(this.show=="登录"){
          this.createCode();
        }
        
  		},
  		methods: {
  		isdisplaythis(){
  			this.islogin();
  		},
  		islogin(){
  			this.show ="登录";
  			this.isloginshow = true;
  			this.isregintershow =true;
  			this.todosList==''
  			this.dislogin = document.getElementById("dislogin");
          	this.dislogin.style.display = "block";
          	this.createCode();
  		},
  		mobileRegistered(){
  			this.showRegistered = "手机注册";
  		},

  		emailRegistered(){
  			this.showRegistered = "邮箱注册";
  		},
  		showlogin(){
          this.show="登录"
          this.dislogin = document.getElementById("dislogin");
          this.dislogin.style.display = "block";
          // this.createCode();
        },
        sendPhoneCode(mobile,username){
          // 对手机号码进行验证，是不是手机号码 /^1[3-9]\d{9}$/
          // var myRe = "/^1[3-9]\d{9}$/";
          this.ajax('http://localhost:5001/mobeilphone.php','post',{mobile:mobile,username:username},{headers:{"Content-Type" : "application/json"}},(res)=>{
                console.log(res.data);
              })

          // console.log(mobile);
        },
        createCode(){
          // 生成验证码
          this.code = "";
          var codeLength = 6;
          var checkCode = document.getElementById("checkCode");
           while(checkCode.hasChildNodes()) //当elem下还存在子节点时 循环继续
          {
            checkCode.removeChild(checkCode.firstChild);
          }
          var color = new Array('red','blue','green','yellow','brown','purple')
          var font = new Array('Arial','Georgia','Courier New');
          var fontsize = new Array('20px','25px','35px');
          var fontstyle = new Array('normal','italic','oblique');
          var  backgroundimg= new Array('./image/background/1.jpg','./image/background/2.jpg','./image/background/3.jpg');
          var codeChars = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 
          'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
          for(var i = 0;i<codeLength;i++){
            var childNode =document.createElement('span')
            var create = codeChars[Math.floor(Math.random() * 52)];
            this.code += create
            childNode.innerHTML = create
            childNode.style.color = color[Math.floor(Math.random() * 6)]
            childNode.style.fontFamily = font[Math.floor(Math.random() * 3)]
            childNode.style.fontSize = fontsize[Math.floor(Math.random() * 3)]
            childNode.style.fontStyle = fontstyle[Math.floor(Math.random() * 3)]
            checkCode.appendChild(childNode)
          }
          // 
          checkCode.style.backgroundImage = "url('"+backgroundimg[Math.floor(Math.random() * 3)]+"')";
          checkCode.className = "code";
          // this.inputCode =null;
        },
        submitpaw(){
        	const regex = this.getregex();
			if(!regex.test(this.resetpassword1)&&!regex.test(this.resetpassword2)){
	   	    		this.message = "含有非法字符串";
	   	    		return false;
	   	    	}
          if(this.resetpassword1==this.resetpassword2){
            var flag = "resetpaw";
            this.ajax('http://localhost:5001/push.php','post',{password:this.resetpassword1,flag:flag,resetcode:this.resetcode},{headers:{"Content-Type" : "application/json"}},(res)=>{
               this.message =res.data;
              })
          }else{
            this.message = "密码不相等,请重新输入"
            return;
          }
          this.resetpassword1 ="";
          this.resetpassword2 ="";
        },
        resetpawcode(){
          if(this.resetcode!=undefined){
            this.show = "resetpaw";
            this.hidelogin()
          }
        },
        forget(){
          this.show="忘记"
          this.hidelogin()
        },
        hidelogin(){
        	this.isloginshow = false;
  			this.isregintershow =false;
  			 this.dislogin = document.getElementById("dislogin");
          this.dislogin.style.display = "none";
        },
        submitemailtime(){
        	

        	var timer=null;
	    	var times = 45;
	    	var that = this
	    	if(this.emailtime == 45){
	    		this.submitemail();
	    		
	    		that.forgetpaw ="发送邮箱"
	    	}
	    	timer=setInterval(function(){
           		
            		times--;
            		that.emailtime =times;
            		that.forgetpaw ="请稍等一下,在发送"
	        		if(times<=0){
	            		that.forgetpaw ="发送邮箱"
	            		clearInterval(timer);
	            		that.emailtime = 45;
	            		times=45;
	            
	        		}
	    	},1000)

	    	

        },
        submitemail(){
          var flag = "forgetpaw";
         	const regex = this.getregex();
         	if(!regex.test(this.email)){
	   	    		this.message = "含有非法字符串";
	   	    		return false;
	   	    	}
          this.ajax('http://localhost:5001/push.php','post',{email:this.email,flag:flag},{headers:{"Content-Type" : "application/json"}},(res)=>{
            // this.message = res.data
              console.log(res.data);
          })
         
        },

        showregister(){
          this.show="注册"
          this.dislogin = document.getElementById("dislogin");
          this.dislogin.style.display = "none";
        },
        ajax(url,method,value={},condition={},callback){
              if(method=='post'){
                  axios.post(url,value,condition).then(res => {
                        callback(res)

                });
              }else if(method=='get'){
                axios.get(url).then(res=>{
                      callback(res)
                })
              }
          
        },
        getregex(){
        	const regex = /^[A-Z0-9a-z()~_./+-@&]*$/;
        	return regex;
        },
    	onClick(value1,value2,value3){
          // 要判断验证码正确与否
          // username,password,email
          		const regex = this.getregex();
          		var pswregex = new RegExp('(?=.*[0-9])(?=.*[a-zA-Z]).{8,30}');
	   	    	if(value1===''&&value2===''&&value3===''){
              		this.message = "请输入用户名,密码和邮箱"
	   	    		
	   	    			return false;
	   	    	}
	   	    	if(!regex.test(value1)&&!regex.test(value2)&&!regex.test(value3)){
	   	    		this.message = "含有非法字符串";
	   	    		return false;
	   	    	}
	   	    	if(value2.length!=8){
	   	    		this.message = "密码要8位数字";
	   	    		return false;
	   	    	}
	   	    	if(value2.length!=8){
	   	    		this.message = "密码要8位数字";
	   	    		return false;
	   	    	}
	   	    	if(!pswregex.test(value2)){
	   	    		this.message = "密码中必须包含字母、数字";
	   	    		return false;
	   	    	}
            var that = this;
            this.ajax('http://localhost:5001/register.php','post',{username:this.username,password:this.password,email:this.email},{headers:{"Content-Type" : "application/json"}},(res) => {
              console.log(res.data);
              if(res.data=="你的用户名已经注册"||res.data=="你的邮箱已经注册"){
                that.message = res.data;
                return false
              }
           
                   
                if(typeof res.data != "undefined" && res.data != null && res.data != ""){
                    // console.log(res.data);
                    that.Sendemail(res.data);
                    // 添加定时器
                    this.todosList = res.data;
                }
            this.username ="";
            this.password = "";
            this.email = "";
            this.show ="重新发送邮件";
             this.hidelogin()
            })

        
	   	     
	    },
       Sendemail(value){

              // this.todosList
            this.ajax('http://localhost:5001/Activeemail.php','post',{email:value},{headers:{"Content-Type" : "application/json"}},(res) => {
                // console.log(res.data)
                 this.message = res.data
            })

       }, 
       Sendtimeemail(value){
       		// 设置定时器
       		var timer=null;
	    	var times = 60;
	    	var that = this
	    	if(this.time == 60){
	    		this.Sendemail(value);
	    		
	    		that.resend ="重新发送邮箱激活码"
	    	}
	    	timer=setInterval(function(){
           		
            		times--;
            		that.time =times;
            		that.resend ="请稍等一下,在发送"
	        		if(times<=0){
	            		that.resend ="重新发送邮箱激活码"
	            		clearInterval(timer);
	            		that.time = 60;
	            		times=60;
	            
	        		}
	    	},1000)

	    	
         

       		
       },
       Login(value1,value2,value3){
        // 先检测验证码
        	const regex = this.getregex();
            if(this.code!=""&&this.inputCode!=""){
                // console.log(this.code+"  "+this.inputCode)

                if(this.code.toLowerCase()!=this.inputCode.toLowerCase()){
                  this.message = "输入的验证码不正确"
                  this.inputCode = "";
                  this.password ="";
                  this.username = "";
                  return false;
                }
            }else{
              this.message = "请输入验证码"
              
              return false
            }
            if(value1===''&& value2===''){
              this.message = "请输入用户名和密码"
                // console.log("");
                return false;
            }
            if(!regex.test(value1)&&!regex.test(value2)){
            	  this.message = "包含非法字符"
                // console.log("");
                return false;
            }
            this.ajax('http://localhost:5001/login.php','post',{password:this.password,username:this.username},{headers:{"Content-Type" : "application/json"}},(res) => {
                 if(typeof res.data != "undefined" && res.data != null && res.data != ""){
                 var arr=res.data.split(",");
                 // console.log(arr[0])
                if(arr[0]=="请去激活邮箱"){
                 this.todosList=this.email
                }else if(arr[0]=="登录成功"){
                   if (res.status === 200) {
                      session.clear();
                      session.start();
                      var sessonjson={
                        userid:arr[1],
                        username:arr[2],
                        sessionid:session.get('session-id')
                      }
                      // 存储到服务器上，要拿根据sessionid去拿
                      // session.set('username', arr);
                       this.ajax('http://localhost:5001/session.php','post',{session:sessonjson},{headers:{"Content-Type" : "application/json"}},(res) => {
                // console.log(res.data)
                            console.log(res.data);
                      })
                      this.$router.push({path: '/main'})
                   
                    
                  }
                }
               
                }
            })
            this.password ="";
            this.username = "";

       },
    		createContact: function(){
    	},
    		resetForm: function(){
    	}
  }
};
</script>
<style scoped>
#inputCode{
  width: 60px;
}
#dislogin{
	display:block;
}
.code 
{
  width: 150px;
  height: 50px;
 /*background:url(code_bg.jpg);*/
/* font-family:Arial;
 font-style:italic;
 /*color:blue;*/
/* font-size:30px;
 border:0;
 padding:2px 3px;
 letter-spacing:3px;
 font-weight:bolder;
 float:left;
 cursor:pointer;
 width:150px;
 height:60px;
 line-height:60px;*/
 text-align:center;
 vertical-align:middle;
}
/*.code:nth-child(1){
  padding-left: 25px;
} */
 .waibu{
  width: 600px;
  height: 1000px;
  background-color: rgba(0,0,0,0.2);;
  position: relative;
  left: 50%;
  margin-left:-300px;
  margin-top: 100px;
 }
 .login{
  width: 200px;
  height: 200px;
  position: absolute;
  left: 50%;
  top: 50%;
  margin-left: -100px;
  margin-top: -100px;

 }
</style>