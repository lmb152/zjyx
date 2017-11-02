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
        // $article=M('article');
        // $artkind=M('artkind');
        // // 校园动态
        // $condition['name']='校园动态';
        // $artkind_temp=$artkind->field('id')->where($condition)->find();
        // unset($condition);
        // $condition['artkind']=$artkind_temp['id'];
        // $condition['isindex']='1';
        // $condition['ispassed']='1';
        // $school_news=$article->where($condition)->limit(0,8)->order('released desc')->select();
        // $this->assign('school_news_kind',$artkind_temp['id']);
        // $this->assign('school_news',$school_news);
        // $condition['imgurl']=array('NEQ','');
        // $school_news_img=$article->where($condition)->limit(0,5)->order('released desc')->select();
        // $this->assign('school_news_img',$school_news_img);
        // // 通知公告
        // $condition['name']='通知公告';
        // $artkind_temp=$artkind->field('id')->where($condition)->find();
        // unset($condition);
        // $condition['artkind']=$artkind_temp['id'];
        // $condition['isindex']='1';
        // $condition['ispassed']='1';
        // $announcement=$article->where($condition)->limit(0,8)->order('released desc')->select();
        // $this->assign('announcement_kind',$artkind_temp['id']);
        // $this->assign('announcement',$announcement);
        // // 党建风采
        // $condition['name']='党建风采';
        // $artkind_temp=$artkind->field('id')->where($condition)->find();
        // unset($condition);
        // $condition['artkind']=$artkind_temp['id'];
        // $condition['isindex']='1';
        // $condition['ispassed']='1';
        // $party_building=$article->where($condition)->limit(0,6)->order('released desc')->select();
        // $this->assign('party_building_kind',$artkind_temp['id']);
        // $this->assign('party_building',$party_building);
        // // 学习园地
        // $condition['name']='学习园地';
        // $artkind_parent=$artkind->field('id')->where($condition)->find();
        // // unset($condition);
        // // $condition['parent']=$artkind_parent['id'];
        // $condition['artkind']=$artkind_parent['id'];
        // $condition['isindex']='1';
        // // $artkind_temp=$artkind->field('id')->where($condition)->select();
        // // unset($condition);
        // // foreach ($artkind_temp as $key => $value) {
        // //     if(($key+1)==count($artkind_temp)){
        // //         $temp .=$value['id'];
        // //     }else{
        // //        $temp .=$value['id'].','; 
        // //     } 
        // // }
        // // $condition['artkind']=array('in',$temp);
        // // $condition['isindex']='1';
        // $condition['ispassed']='1';
        // $study_center=$article->where($condition)->limit(0,6)->order('released desc')->select();
        // $this->assign('study_center_kind',$artkind_temp['id']);
        // $this->assign('study_center',$study_center);
        // // 佳作欣赏
        // $condition['name']='佳作欣赏';
        // $artkind_temp=$artkind->field('id')->where($condition)->find();
        // unset($condition);
        // $condition['artkind']=$artkind_temp['id'];
        // $condition['isindex']='1';
        // $condition['ispassed']='1';
        // $art_works=$article->where($condition)->order('released desc')->select();
        // $this->assign('art_works',$artkind_temp['id']);
        // $this->assign('art_works',$art_works);
        // // 其他活动
        // $condition['name']='其他活动';
        // $artkind_temp=$artkind->field('id')->where($condition)->find();
        // unset($condition);
        // $condition['artkind']=$artkind_temp['id'];
        // $condition['isindex']='1';
        // $condition['ispassed']='1';
        // $banner=$article->where($condition)->order('released desc')->find();
        // $this->assign('banner',$artkind_temp['id']);
        // $this->assign('banner',$banner);

    	$this->display();
    }  
}