<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
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
    // 手机绑定
    public function bind_phone(){
        $this->redirect('index/basic_info');
    }
    public function basic_info(){
        $this->display();
    } 
    // 基本信息保存
    public function basic_info_save(){
        $this->redirect('index/detail_info');
    }
    public function detail_info(){
        $this->display();
    } 
    // 详细信息保存
    public function detail_info_save(){
        $this->redirect('index/info_finish');
    }
    public function info_finish(){
        $this->display();
    }
}