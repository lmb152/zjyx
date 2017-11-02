<?php
namespace Webadmin\Common;
use Think\Controller;
class CommonController extends Controller {
    public function _initialize(){
        if(!$this->check_login()){
            if(ACTION_NAME!='verify'){
                $this->display('Index/login');
                if(ACTION_NAME!='login'){
                    exit;
                }
            }
            
        }
    }
    public function check_login(){
    	if(!isset($_SESSION['uname'])){
    		return false;
    	}
        return true;
    }
}