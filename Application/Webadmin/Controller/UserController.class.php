<?php
namespace Webadmin\Controller;
use Think\Controller;
use Webadmin\Common\CommonController;
class UserController extends CommonController {
    public function index(){
    	print_r(I('param.id'));
    	// $this->show();
    }
    public function lists(){
    	$user=M('user');
		$p=getpage($user,'',C('VAR_PAGE'));
        $condition['name']=array('NEQ','lndx2016');
		$list=$user->where($condition)->select();
		$this->assign('page',$p->show());
    	$this->assign('users',$list);
    	$this->display();
    }

    public function edit(){
    	$id=I('param.id');
    	$user=M('user');
    	if($id){
    		$condition['id']=$id;
    		$user=$user->where($condition)->select();
    		$this->assign('isedit',1);
    		$this->assign('body_title','编辑'.$user[0]['name']);
    		$this->assign('user',$user[0]);
    	}else{
    		$this->assign('isedit',0);
    		$this->assign('body_title','新建用户');
    	}
    	$this->display();
    }

    // 保存
    public function save(){
    	$data=I('param.');
    	$user=M('user');
    	if(isset($data['id'])){
    		$result=$user->save($data);
    		if($result){
    			$this->success($data['name'].'更新成功',U('Webadmin/user/lists'),3);
    		}else{
    			$this->error($data['name'].'更新失败',U('Webadmin/user/lists'),3);
    		}

    	}else{
    		$data['pwd']=md5($data['pwd']);
    		$result=$user->add($data);
    		if($result){
    			$this->success($data['name'].'添加成功',U('Webadmin/user/lists'),3);
    		}else{
    			$this->error($data['name'].'添加失败',U('Webadmin/user/lists'),3);
    		}
    	}

    }

    // 删除
    public function delete(){
    	$id=I('param.id');
    	if($id){
    		$user=M('user');
    		$condition['id']=$id;
    		$result=$user->where($condition)->delete();
    		if(isset($result)){
    			echo '1';
    		}else{
    			echo '0';
    		}
    	}else{
    		echo '0';
    	}
    	
    }

    // 重置密码
    public function resetpwd(){
    	$data=I('param.');
    	$user=M('user');
    	if($data['id']){
	    	$condition['id']=$data['id'];
	    	$user=$user->where($condition)->select();
	    	$this->assign('user',$user[0]);
	    	$this->display();
    	}elseif($data['name']){
	    	$condition['name']=$data['name'];
	    	$user=$user->where($condition)->select();
	    	$this->assign('user',$user[0]);
	    	$this->display();
    	}
    }

    public function savepwd(){
    	$data=I('param.');
    	if($data['pwd']==$data['confirm_pwd']){
    		$user=M('user');
	    	$condition['id']=$data['id'];
	    	$update['pwd']=md5($data['pwd']);
	    	$update['id']=$data['id'];
	    	$result=$user->save($update);
	    	if($result){
    			$this->success($data['name'].'更新成功',U('Webadmin/user/lists'),3);
    		}else{
    			$this->error($data['name'].'更新失败',U('Webadmin/user/lists'),3);
    		}
    	}else{
            $this->error('两次密码不一致',U('Webadmin/user/lists'),3);
        }
    }
}