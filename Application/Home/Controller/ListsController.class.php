<?php
namespace Home\Controller;
use Think\Controller;
class ListsController extends Controller {
    public function _initialize(){
        // 获取用户openid
        $info=$_SESSION['memberinfo'];
        if(!isset($info->openid)){
            // 授权登录获取openid
            // $this->redirect('/Wechat');
        }  
    }
    public function index(){
    	$this->display();
    } 
    public function position_info(){
        $this->display();
    } 
}