<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
	public function _initialize() {
		// 获取用户openid
		$info = $_SESSION['memberinfo'];
		if (!isset($info->openid)) {
			// 授权登录获取openid
			// $this->redirect('/Wechat');
		}
	}
	public function index() {
		$this->display();
	}
	// 手机绑定
	public function bind_phone() {
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