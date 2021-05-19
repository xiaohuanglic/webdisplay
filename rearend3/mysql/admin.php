<?php

class Admin{
	public function Sendmsg($task){
		$myid = 'admin1';
			$userid = $task['userid'];
			$chat = new Chat();
			$data = $chat->getaddchatperson($userid,$myid);
			// chatid:chatname['chatid'],chatmsg:this.chatmsg,userimg:this.piclist,flag:this.flag
			$data['userid'] = $userid;
			$data['myid'] = $myid;
			$data['myname'] = 'admin';
			if(!empty($task['dispalyflag'])){
				$senddata = "你发布的岗位已经通过审核";
			}else{
				$senddata = "你发布的岗位不通过通过审核";
			}
			$data['chatmsg'] =  date('Y-m-d').' '.'admin'.'<a href=".#/boss?taskid='.$task['taskid'].'&&userid='.$userid.'"'.'>查看</a>'.$senddata;
			$data['userimg'] = "";
			// $data['piclist'] = "";
			$data['flag'] = $myid;
			if(empty($data['chatid'])){
				$data['usernum'] = 0;
				$data['mynum'] = 1;
				$chat->addchatmsg($data);
			}else{
				// 已经有chatid的

				$chat->savechatmsg($data);
			}
	}
	public function changDisplayFlag($table,$task){

			UpdateData($table,array('dispalyflag'),array("'".$task['dispalyflag']."'","''"),array('taskid'),array("'".$task['taskid']."'"));
			$this->Sendmsg($task);
			// 发送消息通过了
			// 先判断有没有该消息
			

	}

	public function Unpass($table,$task){
		$this->Sendmsg($task);
	}
	
}