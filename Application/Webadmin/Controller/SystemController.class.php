<?php
namespace Webadmin\Controller;
use Think\Controller;
use Webadmin\Common\CommonController;
class SystemController extends CommonController {
	// 投资者确认配置
	public function investconfig(){
		$system=M('system');
		$condition['confname']='invest';
		$investconf=$system->where($condition)->find();
		$this->assign('body_title','风险提示设置');
		$this->assign('investconfig',$investconf);
		$this->assign('config','invest');
		$this->display('system');
	}
	// 网络协议配置
	public function npconfig(){
		$system=M('system');
		$condition['confname']='np';
		$conf=$system->where($condition)->find();
		$this->assign('body_title','网络协议配置');
		$this->assign('investconfig',$conf);
		$this->assign('config','np');
		$this->display('system');
	}
	// 合格投资者配置
	public function qfiiconfig(){
		$system=M('system');
		$condition['confname']='qfii';
		$conf=$system->where($condition)->find();
		$this->assign('body_title','合格投资者配置');
		$this->assign('investconfig',$conf);
		$this->assign('config','qfii');
		$this->display('system');
	}
	
	
	public function save(){
		$data=I('param.');
		$system=M('system');
		if($data['sysid']){
			$result=$system->save($data);
		}else{
			$result=$system->add($data);
		}
		$url=U('Webadmin/system/'.$data['confname'].'config');
		if($result){
			$this->success('更新成功',$url,3);
		}else{
			$this->error('更新失败',$url,3);
		}
	}
}