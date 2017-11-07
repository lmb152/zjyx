<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
	public function index() {
		// 获取用户openid
		// $info = $_SESSION['memberinfo'];
		// if (!isset($info->openid)) {
		// 	// 授权登录获取openid
		// 	$this->redirect('/Wechat');
		// } else {
		// 	$user_profile = D('user_profile');
		// 	$where = array(
		// 		'openid' => $info->openid,
		// 	);
		// 	$user_data_temp = $user_profile->where($where)->find();
		// 	if (!$user_data_temp) {
		// 		if ($info->subscribe) {
		// 			$user_data = array(
		// 				'openid' => $info->openid,
		// 				'imgurl' => $info->headimgurl,
		// 				'male' => $info->sex,
		// 			);
		// 		} else {
		// 			$user_data = array(
		// 				'openid' => $info->openid,
		// 			);
		// 		}
		// 		$user_profile->data($user_data)->add();
		// 	} else {
		// 		$user_data = array(
		// 			'imgurl' => $info->headimgurl,
		// 			'male' => $info->sex,
		// 		);
		// 		$user_profile->where($where)->save($user_data);
		// 	}
		// }
		// $this->assign('openid', $info->openid);
		$this->display();
	}
	// 手机绑定
	public function bind_phone() {
		// $to = 17733831804;
		Vendor('sms_demo.demo.SendTemplateSMS');
		sendTemplateSMS("17733831804", array('3456', '60'), "215435");
		dump();die;
		$this->redirect('index/basic_info');
	}
	public function basic_info() {
		$this->display();
	}
	// 基本信息保存
	public function basic_info_save() {
		$data = I('post.');
		$data['birthday'] = strtotime($_POST['birthday']);
		$data['service_start'] = strtotime($_POST['service_start']);
		$data['service_end'] = strtotime($_POST['service_end']);
		// dump($data);die;
		$rs = M('user_profile')->add($data);
		$this->redirect('index/detail_info', array('id' => $rs['id']));
	}

	public function detail_info() {
		$this->display();
	}
	// 详细信息保存
	public function detail_info_save() {
		$this->redirect('index/info_finish');
	}
	public function info_finish() {
		$this->display();
	}

}