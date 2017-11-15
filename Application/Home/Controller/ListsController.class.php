<?php
namespace Home\Controller;
use Think\Controller;

header("Content-type: text/html; charset=utf-8");
class ListsController extends Controller {
	public function _initialize() {
		// 获取用户openid
		$info = $_SESSION['memberinfo'];
		if (!isset($info->openid)) {
			// 授权登录获取openid
			// $this->redirect('/Wechat');
		}
	}
	public function index() {
		// 获取城市列表
		$area = D('area');
		$p_condition = array(
			'parent_id' => 0,
		);
		$provice = $area->where($p_condition)->select();
		foreach ($provice as $key => &$value) {
			$c_condition = array(
				'parent_id' => $value['id'],
			);
			$city = $area->where($c_condition)->select();
			$value['cities'] = $city;
		}
		$this->assign('provice', $provice);
		// 获取行业类目
		$industry = D('industry');
		$industry_parent = $industry->group('industry_parent')->select();
		foreach ($industry_parent as $key => &$value) {
			$value['industry_name'] = $value['industry_parent'];
			$condition = array(
				'industry_parent' => $value['industry_parent'],
			);
			$industry_child = $industry->where($condition)->select();
			$value['industry'] = $industry_child;
		}
		$this->assign('industry', $industry_parent);

		$qstr = $_GET['qstr'] && trim($_GET['qstr']) ? trim($_GET['qstr']) : '';
		if ($qstr != "") {
			$whereStr = "p_name like '%" . $qstr . "%'";
		}
		$where['type'] = 1;

		if ($whereStr != "") {
			$where['_string'] = $whereStr;
		}
		// 获取总条数
		$all_num=M("position")->where($where)->select();
		$count=count($all_num);

		$page = $_POST['page'] ? $_POST['page'] : 1; //获取请求的页数
		$num = 2; //请求条数
		// dump($where);exit;
		// $list = M('position')
		$list = M("position")->page($page, $num)->where($where)->select();
		foreach ($list as $key => &$value) {
			$value['pub_time']=date('m-d',$value['pub_time']);
		}
		//判断ajax请求
		if (IS_POST) {
			$ajax_back=array();
			$ajax_back=$list;
			unset($list);
			header('Content-type:text/json');
			$list['data']=$ajax_back;
			$list['page_num']=$page+1;
			if($count<=$page*$num){
				$list['no_more']=1;
			}
			echo json_encode($list); //将数组转成json格式返回
			exit; //中断后面的display()
		}
		$this->assign('qstr', $qstr);
		$this->assign('list', $list);
		$this->display();
	}
	public function position_info() {
		$rs = M('position')->where('p_id=' . $_GET['p_id'])->find();
		$this->assign('data', $rs);
		$this->display();
	}
}