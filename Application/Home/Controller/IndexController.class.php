<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
	public function _initialize() {
		$info = $_SESSION['memberinfo'];
		if (!isset($info->openid)) {
			// 授权登录获取openid
			$this->redirect('/Wechat');
		}
	}
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
						'male' => $info->sex==1?1:0,
						'created'=>time()
					);
				} else {
					$user_data = array(
						'openid' => $info->openid,
						'created'=>time()
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

		$phone = $_POST['phone'];
		$user_profile = D('user_profile');
		$where = array(
			'mobile' => $phone,
		);
		$is_mobile_bind = $user_profile->where($where)->find();
		// header('Content-type: application/json');
		if ($is_mobile_bind) {
			$this->error('手机号已被绑定');
			// print json_encode(array('status' => 0, 'msg' => '手机号已被绑定'));
		} else {
			$_SESSION['srand'] = $srand;
			print $srand;
			$send_back=sendTemplateSMS($phone, array($srand, '5分钟'), "215435");
			// $this->success('短信发送成功');
			// print json_encode(array('status' => 1, 'msg' => '短信发送成功'));
		}
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
			$this->success('手机号码验证成功',U('/index/basic_info'),3);
		} else {
			$this->error('验证码错误',U('/index/index'),3);
			// $this->error('验证码错误,请重新获取');
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
		// if ($_POST['badge_number'] == "") {
		// 	$this->error('退伍证号不能为空');
		// }
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
		$this->assign('user_data', $user_data);
		$this->assign('army_data', $user_army_data);
		$this->assign('education_data', $user_education_data);
		$this->assign('army_num', count($user_army_data));
		$this->assign('education_num', count($user_education_data));
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
		// if (!$data['self_evaluation']) {
		// 	$this->error('自我评价不能为空');
		// }

		$user_profile = D('user_profile');
		$user_army = D('user_army');
		$user_education = D('user_education');

		$info = $_SESSION['memberinfo'];
		$profile_data = array(
			'target_position' => trim($data['target_position']),
			'expected_salary' => trim($data['expected_salary']),
			'duty_time' => $data['duty_time'],
			'honor' => trim($data['honor']),
			'self_evaluation' => trim($data['self_evaluation']),
		);

		$condition = array(
			'openid' => $info->openid,
		);
		$back = $user_profile->where($condition)->save($profile_data);
		$user_data = $user_profile->field('id')->where($condition)->find();
		$uid = $user_data['id'];
		// 保存原来的工作经历
		$army_data = array();
		foreach ($data['service_start'] as $key => $value) {
			if ($value) {
				$army_data[$key]['service_start'] = $value;
			}
		}
		foreach ($data['service_end'] as $key => $value) {
			if ($value) {
				$army_data[$key]['service_end'] = $value;
			}
		}
		foreach ($data['department'] as $key => $value) {
			if ($value) {
				$army_data[$key]['department'] = $value;
			}
		}
		foreach ($data['position'] as $key => $value) {
			if ($value) {
				$army_data[$key]['position'] = $value;
			}
		}
		foreach ($army_data as $key => $value) {
			$update_data = array(
				'start_time' => strtotime($value['service_start']),
				'end_time' => strtotime($value['service_end']),
				'department' => trim($value['department']),
				'position' => trim($value['position']),
			);
			$condition = array(
				'army_id' => $key,
			);
			$user_army->where($condition)->save($update_data);
		}

		// 新建添加的工作经历
		$new_army_data = array();
		foreach ($data['new_service_start'] as $key => $value) {
			if ($value) {
				$new_army_data[$key]['service_start'] = $value;
			}
		}
		foreach ($data['new_service_end'] as $key => $value) {
			if ($value) {
				$new_army_data[$key]['service_end'] = $value;
			}
		}
		foreach ($data['new_department'] as $key => $value) {
			if ($value) {
				$new_army_data[$key]['department'] = $value;
			}
		}
		foreach ($data['new_position'] as $key => $value) {
			if ($value) {
				$new_army_data[$key]['position'] = $value;
			}
		}

		foreach ($new_army_data as $key => $value) {
			$update_data = array(
				'start_time' => strtotime($value['service_start']),
				'end_time' => strtotime($value['service_end']),
				'department' => trim($value['department']),
				'position' => trim($value['position']),
				'u_id' => $uid,
			);
			$user_army->add($update_data);
		}
		// 保存原来的教育经历
		$edu_data = array();
		foreach ($data['edu_service_start'] as $key => $value) {
			if ($value) {
				$edu_data[$key]['service_start'] = $value;
			}
		}
		foreach ($data['edu_service_end'] as $key => $value) {
			if ($value) {
				$edu_data[$key]['service_end'] = $value;
			}
		}
		foreach ($data['school'] as $key => $value) {
			if ($value) {
				$edu_data[$key]['department'] = $value;
			}
		}
		foreach ($data['degree'] as $key => $value) {
			if ($value) {
				$edu_data[$key]['position'] = $value;
			}
		}
		foreach ($edu_data as $key => $value) {
			$update_data = array(
				'start_time' => strtotime($value['service_start']),
				'end_time' => strtotime($value['service_end']),
				'school' => trim($value['school']),
				'degree' => trim($value['degree']),
			);
			$condition = array(
				'edu_id' => $key,
			);
			$user_education->where($condition)->save($update_data);
		}

		// 新建添加的教育经历
		$new_eud_data = array();
		foreach ($data['new_edu_service_start'] as $key => $value) {
			if ($value) {
				$new_edu_data[$key]['service_start'] = $value;
			}
		}
		foreach ($data['new_edu_service_end'] as $key => $value) {
			if ($value) {
				$new_edu_data[$key]['service_end'] = $value;
			}
		}
		foreach ($data['new_school'] as $key => $value) {
			if ($value) {
				$new_edu_data[$key]['school'] = $value;
			}
		}
		foreach ($data['new_degree'] as $key => $value) {
			if ($value) {
				$new_edu_data[$key]['degree'] = $value;
			}
		}

		foreach ($new_edu_data as $key => $value) {
			$update_data = array(
				'start_time' => strtotime($value['service_start']),
				'end_time' => strtotime($value['service_end']),
				'school' => trim($value['school']),
				'degree' => trim($value['degree']),
				'u_id' => $uid,
			);
			$user_education->add($update_data);
		}
		$this->redirect('index/info_finish');
	}
	public function info_finish() {
		$this->display();
	}

}