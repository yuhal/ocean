<?php 
namespace traits\controller;
use think\Session;

trait Middle
{
	public function isLogin($user_id=null){

		if(session('user_info_'.$user_id)){
            return session('user_info_'.$user_id);
		}else{
            return false;
		}
		
	}
	
}
