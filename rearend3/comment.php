<?php
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
	header('Access-Control-Allow-Headers:x-requested-with, content-type');
	
	include "./mysql/function/mysql.php";
	include "./mysql/comment.php";
  include "./mysql/chat.php";
	include "./mysql/serivce.php";
	// 根据的数据，触发相应的函数
	$data = file_get_contents('php://input');
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$comment = json_decode($data, true);
		$getcomment =new Comment();
  		if(!empty($comment['comment']['topic_id'])){
  			// 评论区
  			
  			$getcomment->addComment($comment['comment']);
  		}else{
  			// 回复区
  			if(!empty($comment['getcomment']['topic_id'])){
  					$getcomment->getPageComment($comment['getcomment']);
  			}else if(!empty($comment['reply'])){
  				$getcomment->addreply($comment['reply']);
  			}else if(!empty($comment['getcommentid'])){
          $getcomment->displayreply($comment['getcommentid']);
        }else if(!empty($comment['topic_id'])){
        
          $getcomment->getPageComment($comment);
        }else if(!empty($comment['comentid'])){
          $getcomment->deleteComment($comment);
        }else if(!empty($comment['comment_id'])){
          $getcomment->displaypagereply($comment);
        }else if(!empty($comment['replyid'])){
          $getcomment->deleteReply($comment);
        }else if(!empty($comment['getpagecomment'])){
          $getcomment->getJumpPagecon($comment['getpagecomment'],'comment',['topic_id'],["'".$comment['getpagecomment']['topic_id']."'"]);
        }else if(!empty($comment['getpagereply'])){
          $getcomment->getJumpPagecon($comment['getpagereply'],'reply',['comment_id'],["'".$comment['getpagereply']['comment_id']."'"]);
        }else if(!empty($comment['getreplydata'])){
          $getcomment->Senddata($comment['getreplydata']);
        }else if(!empty($comment['changread'])){
          $getcomment->Changid($comment['changread']);
        }else if(!empty($comment['getallreplay'])){
          $getcomment->disAllReply($comment['getallreplay']);
        }                       
  		}
  	


  	}
  if($_SERVER["REQUEST_METHOD"] == "GET"){
		
	}