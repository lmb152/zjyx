<?php
namespace Webadmin\Controller;
use Think\Controller;
use Webadmin\Common\CommonController;

class IndexController extends CommonController {
	public function index() {
		$is_admin=0;
		if($_SESSION['role'] == 'admin'){
			$all_user_profile=M('user_profile')->select();
			$all_position=M('position')->select();
			$all_user=M('user')->where(array('role'=>'company'))->select();

			$today_time=strtotime(date('Y-m-d'));
			$new_user=M('user_profile')->where('created>='.$today_time)->select();
			$new_position=M('position')->where('pub_time>='.$today_time)->select();

			$this->assign('user_num',count($all_user_profile));
			$this->assign('position_num',count($all_position));
			$this->assign('company_num',count($all_user));
			$this->assign('new_user',count($new_user));
			$this->assign('new_position',count($new_position));
			$is_admin=1;
		}
		$this->assign('is_admin',$is_admin);
		$this->display();
	}
	// 生成验证码
	public function verify() {
		$Verify = new \Think\Verify();
		$Verify->fontSize = 30;
		$Verify->length = 4;
		ob_end_clean();
		$Verify->entry();
	}
	// 登录
	public function login() {

		if (!I('param.')) {
			echo "<script>alert('请输入用户名和密码')</script>";
			exit;
			// $this->redirect('/Webadmin/index', 3,'请输入用户名和密码');
		}
		// $code =I('param.vcode');
		// $verify = new \Think\Verify();
		// if (!$verify->check($code)) {
		//     $this->error('验证码错误，请刷新后重试',U('/Webadmin/index'));
		$user = M('user');
		$condition['name'] = trim($_POST['username']);
		$condition['pwd'] = trim($_POST['password']);
		if ($condition['name'] && $condition['pwd']) {
			$condition['pwd'] = md5($condition['pwd']);
			$userInfo = $user->where($condition)->find();
			if ($userInfo) {
				$_SESSION['uid'] = $userInfo['id'];
				$_SESSION['uname'] = $userInfo['name'];
				$_SESSION['role'] = $userInfo['role'];
				echo "<script>alert('登陆成功');window.location.href='/Webadmin/index';</script>";
				exit;
				// $this->redirect('/Webadmin/index', 3,'登陆成功');
			} else {
				echo "<script>alert('用户名或密码错误');</script>";exit;
				$this->redirect('/Webadmin/index', 3,'用户名或密码错误');
			}
		} else {
			echo "<script>alert('请输入用户名和密码');</script>";exit;
			$this->redirect('/Webadmin/index', 3,'请输入用户名和密码');
		}

	}
	//注销
	public function logout() {
		unset($_SESSION['uname']);
		$this->success('登出成功',U('/Webadmin/index'),3);
		// $this->redirect('Webadmin/index/login');

	}
	public function left() {
		// $artkind = M('artkind');
		// $artkind_content = array();
		// // 获取主分类
		// $condition['parent'] = 0;
		// $artkind_parents = $artkind->where($condition)->select();
		// unset($condition);
		// foreach ($artkind_parents as $k => $v) {
		// 	$artkind_content[$k][0] = $v;
		// 	$condition['parent'] = $v['id'];
		// 	$artkind_childs = $artkind->where($condition)->select();
		// 	if ($artkind_childs) {
		// 		$artkind_content[$k][1] = $artkind_childs;
		// 	} else {
		// 		$artkind_content[$k][1][] = $v;
		// 	}
		// }
		// $this->assign('leftmenu', $artkind_content);
		$this->display('/left');
	}
}