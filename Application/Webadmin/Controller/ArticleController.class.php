<?php
namespace Webadmin\Controller;
use Think\Controller;
class ArticleController extends Controller {
    public function index(){
    	echo "1214";
    	print_r(I('param.id'));
    	// $this->show();
    }
    public function lists(){
    	$artkind=M('artkind');
    	$artkinds=$artkind->where('1')->order('parent')->select();
    	foreach ($artkinds as $key => $value) {
    		if($value['parent']==0){
    			$artkinds[$key]['parent']='主类别';
    		}else{
    			$condition['id']=$value['parent'];
    			$parent=$artkind->where($condition)->select();
    			$artkinds[$key]['parent']=$parent[0]['name'];
    		}
    		$artkinds[$key]['issingle']=$value['issingle']=='1'?'是':'否';
    	}
    	$this->assign('article',$artkinds);
    	$this->display();
    }
    // 编辑
    public function edit(){
    	$id=I('param.id');
    	$artkind=M('artkind');
    	$condition['parent']=0;
    	$artkind_parents=$artkind->where($condition)->select();
    	if($id){
    		$condition_p['id']=$id;
    		$art=$artkind->where($condition_p)->select();
    		if($art[0]['parent']){
    			unset($condition);
    			$condition['id']=$art[0]['parent'];
    			$pname=$artkind->where($condition)->select();
    			$art[0]['pname']=$pname[0]['name'];
    		}else{
    			$art[0]['pname']='主类别';
    		}
    		$this->assign('isedit',1);
    		$this->assign('body_title','编辑'.$art[0]['name']);
    		$this->assign('artkind',$art[0]);
    	}else{
    		$this->assign('isedit',0);
    		$this->assign('body_title','新建类别');
    	}
    	$this->assign('artkind_parents',$artkind_parents);
    	$this->display();
    }
    // 删除
    public function delete(){
    	$id=I('param.id');
    	if($id){
    		$artkind=M('artkind');
    		$condition['parent']=$id;
    		$check=$artkind->where($condition)->select();
    		if(!$check){
    			unset($condition);
    			$condition['id']=$id;
    			$result=$artkind->where($condition)->delete();
    		}
    		if(isset($result)){
    			echo '1';
    		}else{
    			echo '0';
    		}
    	}
    	
    }
    // 保存
    public function save(){
    	$data=I('param.');
    	$artkind=M('artkind');
    	if(isset($data['id'])){
    		if(isset($data['issingle'])){
    			$data['issingle']='1';
    		}else{
                $data['issingle']='0';
            }
    		$result=$artkind->save($data);
    		if($result){
    			$this->success($data['name'].'更新成功',U('Webadmin/article/lists'),3);
    		}else{
    			$this->error($data['name'].'更新失败',U('Webadmin/article/lists'),3);
    		}

    	}else{
            if(isset($data['issingle'])){
                $data['issingle']='1';
            }else{
                $data['issingle']='0';
            }
    		$result=$artkind->add($data);
    		if($result){
    			$this->success($data['name'].'添加成功',U('Webadmin/article/lists'),3);
    		}else{
    			$this->error($data['name'].'添加失败',U('Webadmin/article/lists'),3);
    		}
    	}

    }
}