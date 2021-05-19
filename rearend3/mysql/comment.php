<?php
class Comment{
	public function addComment($comment){
		if(!empty($comment)){
			$comment['comentid'] = 'comment'.md5(uniqid(mt_rand(), true));
			$getkey = $this->getnewkey($comment);
			$getnewvalue = $this->getnewvalue($comment);

			// 添加到表里面
			Adddata('comment',$getkey,$getnewvalue);
			$this->getComment($comment);
			// 添加后要立即显示

		}
	}
	public function getPageComment($comment){
		getTableDatacon("*","comment",['topic_id'],["'".$comment['topic_id']."'"],[0,2]);
	}
	public function getComment($comment){
		// 
		Select(array('*'),'comment',['topic_id'],["'".$comment['topic_id']."'"],function($result){
				$array = [];
			$a = 0;
			while($row = $result->fetch_assoc()) {
				$array[$a] = $row;

				$a++;
				 
    		}
    		echo json_encode($array);
		});
		

	}
	public function getJumpPagecon($comment,$table,$key,$value){
	// 显示的条数n
	// 得到的初始数据为($show-1)*n
	// 得到的终条数为(($show-1)*n)+(n-1)
	// 得到的终条数要进行判断（($show-1)*n)+(n-1)是否大于总条数
	// 如果大于则终条数显示为总条数
	
	$strat = ($comment['page']-1)*$comment['size'];
	$end = (($comment['page'])*$comment['size'])+($comment['size']-1);
	if($end>((int)$comment['totalnum']-1)){
		$end = (int)$comment['totalnum']-1;
	}


	if($strat!=$end){
		// $limit = ($strat,$end);
		// 提取方法;
		chatPageLimitCon("*",$table,$key,$value,[$strat,$comment['size']]);
	
	}else{
		// 进行单条数据提取;
		chatPageLimitCon("*",$table,$key,$value,[$strat,((int)$comment['totalnum']%$comment['size'])]);
	}
	// echo $strat." ".$end;
}
	public function deleteComment($comment){
		
		// 先删除所有回复
		// 再删除评论
		DeleteData('reply',['comment_id'],["'".$comment['comentid']."'"]);
		DeleteData('comment',['comentid'],["'".$comment['comentid']."'"]);

	}
	public function addreply($reply){
		// $reply['comentid']
			$reply['id'] = 'reply'.md5(uniqid(mt_rand(), true));
			$getkey = $this->getnewkey($reply);
			$getnewvalue = $this->getnewvalue($reply);
			Adddata('reply',$getkey,$getnewvalue);
			// echo $reply['id'];
			// $this->displayreply($reply);

	}
	public function disAllReply($reply){
				$comment_id = $this->getnewvalue($reply['comment_id']);
		$getarray = [];
		for($i=0;$i<sizeof($comment_id);$i++){
			$getarray[$i] = Select(['*'],'reply',['comment_id'],[$comment_id[$i]],function($result){
				$array = [];
			$a = 0;
			
			while($row = $result->fetch_assoc()) {
			
			
				$array['comment_id'] = $row['comment_id'];
				$array[$a] = array($row);

					
			
				$a++;
			
				
				 
    		}

    		return $array;
		});
	}
    		
    		echo json_encode($getarray);	
	}
	public function displayreply($reply){
		$comment_id = $this->getnewvalue($reply['comment_id']);
		$getarray = [];
		for($i=0;$i<sizeof($comment_id);$i++){
			$getarray[$i] = SelectLimitcon(['*'],'reply',['comment_id'],[$comment_id[$i]],[0,2],function($result){
				$array = [];
			$a = 0;
			
			while($row = $result->fetch_assoc()) {
			
			
				$array['comment_id'] = $row['comment_id'];
				$array[$a] = array($row);

					
			
				$a++;
			
				
				 
    		}

    		return $array;
		});
	}
    		
    		echo json_encode($getarray);	
    		
    			
	
	}
	public function displaypagereply($reply){
		getTableDatacon(["*"],"reply",['comment_id'],["'".$reply['comment_id']."'"],[0,2]);

	}
	public function deleteReply($comment){
			// var_dump($comment);
		// 拿到相关id下的回复
		DeleteData('reply',['id'],["'".$comment['replyid']."'"]);

	}
	public function Senddata($task){
		// var_dump($task);
		Sendmsg($task);
	}
	public function Changid($id){
		UpdateData('reply',['canread'],['1'],['id'],["'".$id."'"]);
	}
	public function getnewkey($comment){
		$array = [];
		$i = 0;
		foreach ($comment as $key => $value) {

			$array[$i] = $key;
			$i++;
		}
		return $array;
	}

	public function getnewvalue($comment){
		$array = [];
		$i = 0;
		// 判断是否为字符串
		if(is_string($comment)){
			$array[$i] = "'".$comment."'";
			return $array;
		}else{
			foreach ($comment as $key => $value) {
			$array[$i] = "'".$value."'";
			$i++;
			}

		}
		

		return $array;
	}
}