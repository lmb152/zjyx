<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        // 获取用户openid
        $info=$_SESSION['memberinfo'];
        if(!isset($info->openid)){
            // 授权登录获取openid
            $this->redirect('/Wechat');
        }else{
            $user_profile=D('user_profile');
            $where=array(
                    'openid'=>$info->openid,
                );
            $user_data_temp = $user_profile->where($where)->find();
            if(!$user_data_temp){
                if($info->subscribe){
                    $user_data=array(
                        'openid'=>$info->openid,
                        'imgurl'=>$info->headimgurl,
                        'male'=>$info->sex,
                    );
                }else{
                    $user_data=array(
                        'openid'=>$info->openid,
                    );
                }
                $user_profile->data($user_data)->add();
            }else{
                $user_data=array(
                    'imgurl'=>$info->headimgurl,
                    'male'=>$info->sex,
                );
                $user_profile->where($where)->save($user_data);
            }
        }
        $this->assign('openid',$info->openid);
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