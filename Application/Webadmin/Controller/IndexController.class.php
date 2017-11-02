<?php
namespace Webadmin\Controller;
use Think\Controller;
use Webadmin\Common\CommonController;
class IndexController extends CommonController {
    public function index(){
        // if($_SESSION['role']=='admin'){
        //     $articles=M('article');
        //     $artkind=M('artkind');
        //     $count=$articles->count();
        //     $Page =  new \Think\Page($count,C('VAR_NUM'));// 实例化分页类 传入总记录数和每页显示的记录数
        //     //分页跳转的时候保证查询条件
        //     $list=$articles->order('released desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        //     foreach ($list as $key => $value) {
        //         $condition['id']=$value['artkind'];
        //         $artkind_name=$artkind->where($condition)->find();
        //         $list[$key]['artkind_name']=$artkind_name['name'];
        //         $list[$key]['artkind']=$artkind_name['id'];
        //     }
        //     // $p->lastSuffix=false;
        //     // $p->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;每页<b>%LIST_ROW%</b>条&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        //     $Page->setConfig('prev','上一页');
        //     $Page->setConfig('next','下一页');
        //     $Page->setConfig('last','末页');
        //     $Page->setConfig('first','首页');
        //     $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        //     $show = $Page->show();// 分页显示输出
        //     $this->assign('akid',$id);
        //     $this->assign('page',$show);
        //     $this->assign('articles',$list);
        // }
        $this->display();
    }
    // 生成验证码
    public function verify(){
        $Verify = new \Think\Verify();
        $Verify->fontSize = 30;
        $Verify->length   = 4;
        ob_end_clean();
        $Verify->entry();
    }
    // 登录
    public function login(){

        if(!I('param.')){
            exit;
        }
        // $code =I('param.vcode');
        // $verify = new \Think\Verify();
        // if (!$verify->check($code)) {
        //     $this->error('验证码错误，请刷新后重试',U('/Webadmin/index'));
        $user=M('user');
        $condition['name'] = trim($_POST['username']);
        $condition['pwd'] = trim($_POST['password']);
        if($condition['name'] && $condition['pwd']){
            $condition['pwd']=md5($condition['pwd']);
            $userInfo=$user->where($condition)->select();
            if($userInfo){
                $_SESSION['uname']=$userInfo[0]['name'];
                $_SESSION['role']=$userInfo[0]['role'];
                $this->redirect('/Webadmin/index');
            }else{
                $this->error('用户名或密码错误',U('/Webadmin/index'));
            }
        }else{
            $this->error('请输入用户名和密码',U('/Webadmin/index'));
        }
        
    }
    //注销
    public function logout(){
        unset($_SESSION['uname']);
        $this->redirect('Webadmin/index/login');
        
    }
    public function left(){
        // $artkind=M('artkind');
        // $artkind_content=array();
        // // 获取主分类
        // $condition['parent']=0;
        // $artkind_parents=$artkind->where($condition)->select();
        // unset($condition);
        // foreach ($artkind_parents as $k => $v) {
        //     $artkind_content[$k][0]=$v;
        //     $condition['parent']=$v['id'];
        //     $artkind_childs=$artkind->where($condition)->select();
        //     if($artkind_childs){
        //         $artkind_content[$k][1]=$artkind_childs;
        //     }else{
        //         $artkind_content[$k][1][]=$v;
        //     }
        // }
        // $this->assign('leftmenu',$artkind_content);
        $this->display('/left');
    }
}