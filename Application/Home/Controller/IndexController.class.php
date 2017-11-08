<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
	public function index() {
		// 获取用户openid
		$info = $_SESSION['memberinfo'];
		if (!isset($info->openid)) {
			// 授权登录获取openid
			$this->redirect('/Wechat');
		} else {
			$user_profile = D('user_profile');
			$where = array(
				'openid' => $info->openid,
			);
			$user_data_temp = $user_profile->where($where)->find();
			if (!$user_data_temp) {
				if ($info->subscribe) {
					$user_data = array(
						'openid' => $info->openid,
						'imgurl' => $info->headimgurl,
						'male' => $info->sex,
					);
				} else {
					$user_data = array(
						'openid' => $info->openid,
					);
				}
				$user_profile->data($user_data)->add();
				$this->assign('openid', $info->openid);
				$this->display();
			} else {
				// 若已存在该openid用户并且已绑定手机号码，则直接跳转基本信息页面
				if ($user_data_temp['mobile']) {
					$this->redirect('index/basic_info');
				} else {
					$user_data = array(
						'imgurl' => $info->headimgurl,
						'male' => $info->sex,
					);
					$user_profile->where($where)->save($user_data);
					$this->assign('openid', $info->openid);
					$this->display();
				}

			}
		}
	}
	public function bind_phone() {
		Vendor('sms_demo.SendTemplateSMS');
		$srand = rand(100000, 999999);
		$_SESSION['srand'] = $srand;
		$phone = $_POST['phone'];
		// $send_back=sendTemplateSMS($phone, array($srand, '60s'), "215435");
		print_r($_SESSION['srand']);

	}
	public function bind_phone_save() {
		if ($_POST['certifycode'] == $_SESSION['srand']) {
			$user_profile = D('user_profile');
			$where = array(
				'openid' => $_POST['openid'],
			);
			$user_data_mobile = array(
				'mobile' => $_POST['phone'],
			);
			$user_profile->where($where)->save($user_data_mobile);
			$this->redirect('index/basic_info');
		} else {
			$this->error('验证码错误,请重新获取');
		}
	}
	public function basic_info() {
		$info = $_SESSION['memberinfo'];
		$user = D('user_profile');
		$condition = array(
			'openid' => $info->openid,
		);
		$user_data = $user->where($condition)->find();
		$this->assign('user_data', $user_data);
		$this->display();
	}
	// 基本信息保存
	public function basic_info_save() {
		$data = I('post.');
		if ($_POST['user_name'] == "") {
			$this->error('姓名不能为空');
		}
		if ($_POST['birthday'] == "") {
			$this->error('出生年月不能为空');
		}
		if ($_POST['native_place'] == "") {
			$this->error('籍贯不能为空');
		}
		if ($_POST['ethnic'] == "") {
			$this->error('民族不能为空');
		}
		if ($_POST['height'] == "") {
			$this->error('身高不能为空');
		}
		if ($_POST['weight'] == "") {
			$this->error('体重不能为空');
		}
		if ($_POST['service_start'] == "") {
			$this->error('服役开始时间不能为空');
		}
		if ($_POST['service_end'] == "") {
			$this->error('服役结束时间不能为空');
		}
		if ($_POST['badge_number'] == "") {
			$this->error('退伍证号不能为空');
		}
		$data['birthday'] = strtotime($_POST['birthday']);
		$data['service_start'] = strtotime($_POST['service_start']);
		$data['service_end'] = strtotime($_POST['service_end']);
		// dump($data);die;
		$where = array(
			'openid' => $_SESSION['memberinfo']->openid,
		);
		$rs = M('user_profile')->where($where)->save($data);
		$this->redirect('index/detail_info');
	}

	public function detail_info() {
		$info = $_SESSION['memberinfo'];
		$user = D('user_profile');
		$army = D('user_army');
		$education = D('user_education');
		$condition = array(
			'openid' => $info->openid,
		);
		$user_data = $user->where($condition)->find();
		// 查询工作经历
		$condition = array(
			'u_id' => $user_data['id'],
		);
		$user_army_data = $army->where($condition)->select();
		$user_education_data = $education->where($condition)->select();
		$user_data['army_data'] = $user_army_data;
		$user_data['education_data'] = $user_education_data;
		$this->assign('user_data', $user_data);
		$this->display();
	}
	// 详细信息保存
	public function detail_info_save() {
		$data = I('post.');
		if (!$data['target_position']) {
			$this->error('目标岗位不能为空');
		}
		if (!$data['expected_salary']) {
			$this->error('期望薪资不能为空');
		}
		if (!$data['duty_time']) {
			$this->error('到岗时间不能为空');
		}
		if (!$data['self_evaluation']) {
			$this->error('自我评价不能为空');
		}
		$info = $_SESSION['memberinfo'];
		$profile_data = array(
			'target_position' => $data['target_position'],
			'expected_salary' => $data['expected_salary'],
			'duty_time' => strtotime($data['duty_time']),
			'honor' => $data['honor'],
			'self_evaluation' => $data['self_evaluation'],
		);
		$user_profile = D('user_profile');
		$condition = array(
			'openid' => $info->openid,
		);
		$user_profile->where($condition)->save($profile_data);
		$this->redirect('index/info_finish');
	}
	public function info_finish() {
		$this->display();
	}

}