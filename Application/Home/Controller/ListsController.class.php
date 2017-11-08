<?php
namespace Home\Controller;
use Think\Controller;

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
		$qstr = $_GET['qstr'] && trim($_GET['qstr']) ? trim($_GET['qstr']) : '';
		if ($qstr != "") {
			$whereStr = "p_name like '%" . $qstr . "%'";
		}
		$where['type'] = 1;
		if ($whereStr != "") {
			$where['_string'] = $whereStr;
		}
		// $list = M('position')->where($where)->select();
		// dump($list);die;
		$page = $_POST['page'] ? $_POST['page'] : 1; //获取请求的页数
		$num = 2; //请求条数
		$list = M('position')->where($where)->page($page, $num)->select();
		// $list = M("table")->page($page, $num)->select();

		if (IS_POST) {
//判断ajax请求
			$count = count($list);
			if ($count < $num) { //判断是否到尾页
				$list[]['id'] = 0; //到尾页返回0
			}
			echo json_encode($list); //将数组转成json格式返回
			exit; //中断后面的display()
		}
		$this->assign('list', $list);
		$this->display();
	}
	public function position_info() {
		$rs = M('position')->where('p_id=' . $_GET['p_id'])->find();
		$this->assign('data', $rs);
		$this->display();
	}
}