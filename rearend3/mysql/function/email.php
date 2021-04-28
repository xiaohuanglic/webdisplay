<?php
// require_once './PHPMailer-master/PHPMailer-master/PHPMailer-master/src/';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// require './PHPMailer-master/src/Exception.php'; //文件相对路径
// require './PHPMailer-master/src/PHPMailer.php'; 
// require './PHPMailer-master/src/SMTP.php';

 function sendmessage($meg,$email,$flag){
 	$mail = new PHPMailer(true);
	$mail->CharSet ="UTF-8";                     //设定邮件编码
    $mail->SMTPDebug = 0;                        // 调试模式输出
    $mail->isSMTP();                             // 使用SMTP
    $mail->Host = 'smtp.163.com';                // SMTP服务器
    $mail->SMTPAuth = true;                      // 允许 SMTP 认证
    $mail->Username = 'pppahm@163.com';                // SMTP 用户名  即邮箱的用户名
    $mail->Password = 'OAJFKDISCBDVRGJE';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
    $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
    $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

    $mail->setFrom('pppahm@163.com', 'Mailer');  //发件人
    echo $email;
    $mail->addAddress($email, 'Joe');  // 收件人
   
    //Content
    $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
    $mail->Subject = '这里是邮件标题' . time();
    if($flag=='active'){
    $mail->Body    = '<!DOCTYPE html>
    <html>
    <head>
        <title>激活</title>
    </head>
    <body>
        <a href="http://localhost:8081/#/login/?Activecode='.$meg.'">http://localhost:8081/#/login/?Activecode='.$meg.'</a>
    </body>
    </html>';
    }else if($flag=='resetpaw'){
    $mail->Body    = '<!DOCTYPE html>
    <html>
    <head>
        <title>激活</title>
    </head>
    <body>
       <a href="http://localhost:8081/#/login/?resetcode='.$meg.'">http://localhost:8081/#/login/?resetcode='.$meg.'</a>
    </body>
    </html>';
    }
   
    $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

    $mail->send();
 

 }		
	

?>