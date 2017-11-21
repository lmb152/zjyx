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
		$whereStr ='1 ';
		$area=$industry=$expected='';
		if($_GET['area']){
			$area=$_GET['area'];
			$whereStr .= " and location like '%".$_GET["area"]."%'";
		}
		if($_GET['industry']){
			$industry=$_GET['industry'];
			$whereStr .= " and industry = '".$_GET['industry']."'";
		}
		if($_GET['expected']){
			$expected=$_GET['expected'];
			switch ($_GET['expected']) {
				case '3K以下':
					$whereStr .= ' and salary < 3000';
					break;
				case '3K-5K':
					$whereStr .= ' and salary >=3000 and salary<5000';
					break;
				case '5K-8K':
					$whereStr .= ' and salary >=5000 and salary<8000';
					break;
				case '8K-10K':
					$whereStr .= ' and salary >=8000 and salary<10000';
					break;
				case '10K以上':
					$whereStr .= ' and salary >=10000';
					break;
				default:
					break;
			}
		}
		$this->assign('area',$area);
		$this->assign('industry_temp',$industry);
		$this->assign('expected',$expected);
		if ($qstr != "") {
			$whereStr .= "p_name like '%" . $qstr . "%'";
		}

		if ($whereStr != "") {
			$where['_string'] = $whereStr;
		}
		// 获取总条数
		$all_num=M("position")->where($where)->select();
		$count=count($all_num);

		$page = $_POST['page'] ? $_POST['page'] : 1; //获取请求的页数
		$num = 10; //请求条数
		// dump($where);exit;
		// $list = M('position')
		$list = M("position")->page($page, $num)->where($where)->order('istop desc')->select();
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