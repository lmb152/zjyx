<?php
namespace Webadmin\Controller;
use Think\Controller;
use Webadmin\Common\CommonController;

class ListController extends CommonController {
	public function index() {
		echo "124";
		$this->show();
	}
	// 列表
	public function lists() {
		$passed=0;
		if ($_GET['name'] == 1) {
			$where='1 ';
			$qstr = $_POST['qstr'] && trim($_POST['qstr']) ? trim($_POST['qstr']) : '';
			if ($qstr != "") {
				$where .= "and mobile like '%".$qstr."%' or user_name like '%" . $qstr . "%' or target_position like '%" . $qstr . "%'";
			}
			if($_SESSION['role']=='company'){
				$where .= ' and status=1';
			}else{
				$passed=1;
			}
			$User = M('user_profile'); // 实例化User对象
			$count = $User->where($where)->count(); // 查询满足要求的总记录数
			$Page = new \Think\Page($count, 20); // 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show(); // 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $User->order('id')->where($where)->order("status desc,created desc")->limit($Page->firstRow . ',' . $Page->listRows)->select();
			// dump($list);die;
			$this->assign('list', $list); // 赋值数据集
			$this->assign('page', $show); // 赋值分页输出
			$this->assign('qstr', $qstr); // 赋值分页输出
			$b = "简历";
			$this->assign('passed',$passed);
			$this->assign('listname', $b);
			$this->display();
		} else {
			$qstr = $_POST['qstr'] && trim($_POST['qstr']) ? trim($_POST['qstr']) : '';
			$where='1 ';
			if ($qstr != "") {
				$where .= " and p_name like '%" . $qstr . "%' or company like '%" . $qstr . "%'";
			}
			if($_SESSION['role']=='company'){
				$where .= ' and uid='.$_SESSION['uid'];
			}else{
				$passed=1;
			}
			$User = M('position'); // 实例化User对象
			$count = $User->where($where)->count(); // 查询满足要求的总记录数
			$Page = new \Think\Page($count, 20); // 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show(); // 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $User->order('p_id')->where($where)->order('istop desc,type desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$this->assign('qstr', $qstr); // 赋值分页输出
			$this->assign('list', $list); // 赋值数据集
			$this->assign('page', $show); // 赋值分页输出
			$b = "职位";
			$this->assign('passed',$passed);
			$this->assign('listname', $b);
			$this->display('new_lists');
		}

		// dump($list);die;
		// $id=I('param.id');
		// if(!$id){
		// 	$this->redirect('Webadmin/index');
		// }
		// $artkinds = M('artkind');
		// $articles = M('article');
		// $condition['id'] = $id;
		// if ($_SESSION['role'] != 'admin') {
		// 	$condition['author'] = $_SESSION['uname'];
		// }
		// $artkind = $artkinds->where($condition)->find();
		// unset($condition);
		// $condition['artkind'] = $id;
		// if ($_SESSION['role'] != 'admin') {
		// 	$condition['author'] = $_SESSION['uname'];
		// }
		// if ($artkind['issingle']) {
		// 	$article = $articles->where($condition)->find();
		// 	if ($article) {
		// 		$url = U('Webadmin/list/edit', array('akid' => $id, 'arid' => $article['id']));
		// 	} else {
		// 		$url = U('Webadmin/list/edit', array('akid' => $id));
		// 	}
		// 	$this->success('即将前往单文章页', $url, 1);
		// } else {
		// 	$count = $articles->where($condition)->count();
		// 	$Page = new \Think\Page($count, C('VAR_NUM')); // 实例化分页类 传入总记录数和每页显示的记录数
		// 	//分页跳转的时候保证查询条件
		// 	$list = $articles->where($condition)->order('istop desc,released desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
		// 	// $p->lastSuffix=false;
		// 	// $p->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;每页<b>%LIST_ROW%</b>条&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
		// 	$Page->setConfig('prev', '上一页');
		// 	$Page->setConfig('next', '下一页');
		// 	$Page->setConfig('last', '末页');
		// 	$Page->setConfig('first', '首页');
		// 	$Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		// 	$show = $Page->show(); // 分页显示输出

	}
	// 编辑
	public function edit() {
		$id = I('param.id');
		$rs = M('user_profile')->where('id=' . $id)
			->find();
		$rt = M('user_army')->where('u_id=' . $id)->select();
		$ret = M('user_education')->where('u_id=' . $id)->select();
		$this->assign('body_title', $rs['user_name']);

		// }
		$passed=0;
		if($_SESSION['role']=='admin'){
			$passed=1;
		}
		$this->assign('passed',$passed);
		$this->assign('eid',$id);
		$this->assign('list', $rs);
		$this->assign('rt', $rt);
		$this->assign('ret', $ret);
		$this->display();
	}
	// 编辑
	public function save() {
		$data['reason'] = $_POST['reason'];
		$data['mobile'] = $_POST['mobile'];
		$rs = M('user_profile')->where('id=' . $_GET['id'])->save($data);
		if($rs){
			$this->success('修改成功', U('Webadmin/list/lists', array('name' => 1)), 3);
		}else {
			$this->error('未做任何修改', U('Webadmin/list/lists', array('name' => 1)), 3);
		}
	}
	public function passed_profile(){
		$id=I('param.id');
		$condition=array(
				'id'=>$id
			);
		$rs = M('user_profile')->where($condition)->save(array('status'=>1));
		$this->success('审核通过成功', U('Webadmin/list/lists/name/1'), 3);
	}
	// 删除
	public function delete() {
		$id = I('param.id');
		if ($id) {
			if ($_GET['name'] == 1) {
				$article = M('user_profile');
				$condition['id'] = $id;
				$result = $article->where($condition)->delete();
			} else {
				$article = M('position');
				$condition['p_id'] = $id;
				$result = $article->where($condition)->delete();
			}

			if (isset($result)) {
				echo '1';
			} else {
				echo '0';
			}
		} else {
			echo '0';
		}

	}
	// 审核通过
	public function passed_position() {
		$id = I('param.id');

		$condition=array(
				'p_id'=>$id
			);
		M('position')->where($condition)->save(array('type'=>1));
		$this->success('审核通过成功', U('Webadmin/list/lists'), 3);
	}
	// 编辑
	public function new_position() {
		$list = M('industry')->select();
		$list_company = M('area')->where('parent_id=0')->select();
		$id = $_GET['id'];
		if ($id) {
			$rs = M('position')->where('p_id=' . $id)->find();
			$addres = explode("|", $rs['location']);
			$this->assign('addres', $addres);
			$this->assign('list', $rs);
		}
		$passed=0;
		if($_SESSION['role']=='admin'){
			$passed=1;
		}
		$this->assign('passed',$passed);
		$this->assign('eid',$id);
		$this->assign('lists', $list);
		$this->assign('lists_company', $list_company);
		$this->display();
	}
	public function getaddress() {
		$list = M('area')->where('parent_id=' . $_GET['parent_id'])->select();
		foreach ($list as $key => $val) {
			$opt .= "<option value='" . $val['id'] . "'>" . $val['name'] . "</option>";
		}

		echo $opt;
		// echo json_encode($opt);
	}
	public function saveNew_position() {
		$data = I('post.');
		// dump($data);die;
		if ($_POST['p_name'] == "") {
			$this->error('请填写职位名称');
		}
		if ($_POST['company'] == "") {
			$this->error('请填写公司名称');
		}
		if (!$_POST['industry']) {
			$this->error('请选择行业名称');
		}
		if ($_POST['salary'] == "") {
			$this->error('请填写薪资');
		}
		if ($_POST['bright_spot'] == "") {
			$this->error('请填写职位亮点');
		}
		if ($_POST['description'] == "") {
			$this->error('请填写职位描述');
		}
		if ($_POST['company_info'] == "") {
			$this->error('请填写公司简介');
		}
		if ($_POST['employee_department'] == "0") {
			$this->error('请选择公司地址');
		}

		if (is_numeric($_POST['employee_department'])) {
			$rs = M('area')->where('id=' . $_POST['employee_department'])->find();
			if ($_POST['employee_position'] != '') {
				$rt = M('area')->where('id=' . $_POST['employee_position'])->find();
				$data['location'] = $rs['name'] . '|' . $rt['name'];
			} else {
				$data['location'] = $rs['name'] . '|';
			}

		}
		$data['uid']=$_SESSION['uid'];
		$data['type']=0;
		$data['pub_time'] = time();
		// dump($data);die;
		if ($_POST['id'] != '') {
			// dump($data);die;
			$rs = M('position')->where('p_id=' . $_POST['id'])->save($data);
			if ($rs) {
				$this->success('修改成功', U('Webadmin/list/lists', array('name' => 2)), 3);
			} else {
				$this->error('修改失败', U('Webadmin/list/lists', array('name' => 2)), 3);
			}
		} else {
			$rs = M('position')->add($data);
			if ($rs) {
				$this->success('新增成功', U('Webadmin/list/lists', array('name' => 2)), 3);
			} else {
				$this->error('新增失败', U('Webadmin/list/lists', array('name' => 2)), 3);
			}
		}

	}
	public function top_position(){
		$id = I('param.id');
		$condition=array(
				'p_id'=>$id
			);
		M('position')->where($condition)->save(array('istop'=>1));
		$this->success('置顶成功', U('Webadmin/list/lists'), 3);
	}
	public function download(){
		Vendor('PhpWord.PHPWord');
		// $PHPWord = new \PHPWord();
		// $document = $PHPWord->loadTemplate('./Public/Template.docx');
		// $PHPWord = new \PHPWord();

		// // New portrait section
		// $section = $PHPWord->createSection();

		// // Add table
		// $table = $section->addTable();
		// $id = I('param.id');
		// $rs = M('user_profile')->where('id=' . $id)
		// 	->find();
		// $rt = M('user_army')->where('u_id=' . $id)->select();
		// $ret = M('user_education')->where('u_id=' . $id)->select();
		// $this->assign('body_title', $rs['user_name']);

		// $this->assign('list', $rs);
		// $this->assign('rt', $rt);
		// $this->assign('ret', $ret);

		// $table->addRow();
		// $styleCell=array('gridSpan' => 6);
		// $table->addCell(600, $styleCell)->addText(iconv('utf-8', 'GB2312//IGNORE', $rs['user_name'].'的个人简历'));
		// $table->addCell(100)->addText('http://www.111cn.net');
		// $table->addRow();
		// $table->addCell(100)->addText('PHP');
		// $table->addCell(100)->addText('python');
		// $table->addCell(100)->addText('java');
		// $section->addTextBreak(10);



		// $objWriter = \PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		// $filename = './Public/'.time().'.docx'; 
		// $objWriter->save($filename);
		$PHPWord = new \PHPWord();

		// New portrait section
		$section = $PHPWord->createSection();

		// Define table style arrays
		$styleTable = array('borderSize'=> 0, 'borderColor' => 'ffffff', 'cellMargin' => 80 , 'marginLeft' => 1134,'marginRight' => 1134,'marginTop' => 1134,'marginBottom' => 1134,'align' => 'right','valign' => 'right');
		$styleFirstRow = array('borderBottomSize' => 18, 'borderBottomColor' => '000000', 'bgColor' => '666666','valign' => 'center');

		// Define cell style arrays
		$styleCell = array('align' => 'center','borderSize' => 1, 'bgColor' => ffffff, );
		$styleCellBTLR = array('valign'=>'center', 'textDirection'=> \PHPWord_Style_Cell::TEXT_DIR_BTLR);

		// Define font style for first row
		$fontStyle = array('bold'=>true, 'valign' => 'right' , 'align' => 'right' , 'size'=>24);

		$fontStyles = array('color'=>'000000', 'size'=>18, 'bold'=>true , 'align' => 'right' , 'valign' => 'right');

		$titleStyles = array('color'=> 000000 ,'size'=>24);
		$PHPWord->addFontStyle('myOwnStyle', $fontStyles);

		// Add table style
		$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

		// Add table
		$table = $section->addTable('myOwnTableStyle');

		// Add row


		$i=0;
		$table->addRow(100);
		$table->addCell(9600)->addText('各科室工作完成情况', array( 'size' => 30 ,'bold'=>true) , array( 'align' => 'center'));
		$table->addRow(100);

		$table->addCell(1500, $styleCell )->addText(iconv('utf-8', 'gbk', '各科室工作完成情况'), $fontStyles , array( 'align' => 'center'));
		$table->addCell(3300, $styleCell)->addText('各科室工作完成情况',$fontStyles, array( 'align' => 'center'));
		$table->addCell(3300, $styleCell)->addText('各科室工作完成情况', $fontStyles, array( 'align' => 'center'));
		$table->addCell(1500, $styleCell)->addText('各科室工作完成情况', $fontStyles, array( 'align' => 'center'));


		$time = time();
		$objWriter = \PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save("./Public/中文test.docx");


		
		//文件的类型 
		header('Content-type: application/docx'); 
		header('Content-Disposition: attachment; filename="'.$rs['user_name'].'.docx"'); 
		readfile("$filename"); 
	}
}