<!DOCTYPE html>
<html>
<title>验证码使用演示</title>
<link href="css/register.css" rel="stylesheet" >
<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="js/register.js" type="text/javascript"></script>
<script>
	function getBasePath(){
	    return '<?php echo 'http://'. $_SERVER['HTTP_HOST']?>';
    }
</script>
</head>
<body>
   <form>
       <div class="row">
           <label>账号: </label><input name="userId">
       </div>
       <div class="row">
           <label>密码:</label><input name="password">
       </div>
       <div class="row">
           <label>手机号:</label><input name="mobile">
       </div>
       <div class="row">
           <label>验证码:</label>
           <input name="verifyCode">
           <button type="button" class="sendVerifyCode">获取短信验证码</button>
       </div>
       <div><button type="button" class="sub-btn">提交</button></div>
   </form>
</body>
</html>