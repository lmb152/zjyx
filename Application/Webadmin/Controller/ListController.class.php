<?php
namespace Webadmin\Controller;
use Think\Controller;
use Webadmin\Common\CommonController;
class ListController extends CommonController {
    public function index(){
    	echo "124";
    	$this->show();
    }
    // 列表
    public function lists(){
    	$id=I('param.id');
    	if(!$id){
    		$this->redirect('Webadmin/index');
    	}
    	$artkinds=M('artkind');
    	$articles=M('article');
    	$condition['id']=$id;
        if($_SESSION['role']!='admin'){
            $condition['author']=$_SESSION['uname'];
        }
    	$artkind=$artkinds->where($condition)->find();
    	unset($condition);
    	$condition['artkind']=$id;
        if($_SESSION['role']!='admin'){
            $condition['author']=$_SESSION['uname'];
        }
    	if($artkind['issingle']){
    		$article=$articles->where($condition)->find();
    		if($article){
    			$url=U('Webadmin/list/edit',array('akid' => $id, 'arid'=>$article['id']));
    		}else{
    			$url=U('Webadmin/list/edit',array('akid' => $id));
    		}
    		$this->success('即将前往单文章页',$url,1);
    	}else{
            $count=$articles->where($condition)->count();
            $Page =  new \Think\Page($count,C('VAR_NUM'));// 实例化分页类 传入总记录数和每页显示的记录数
            //分页跳转的时候保证查询条件
            $list=$articles->where($condition)->order('istop desc,released desc')->limit($Page->firstRow.','.$Page->listRows)->select();
            // $p->lastSuffix=false;
            // $p->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;每页<b>%LIST_ROW%</b>条&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
            $Page->setConfig('prev','上一页');
            $Page->setConfig('next','下一页');
            $Page->setConfig('last','末页');
            $Page->setConfig('first','首页');
            $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            $show = $Page->show();// 分页显示输出
	        $this->assign('listname',$artkind['name']);
	        $this->assign('akid',$id);
	        $this->assign('page',$show);
	        $this->assign('articles',$list);
	        $this->display();
    	}
    }
    // 编辑
    public function edit(){
    	$akid=I('param.akid');
    	$arid=I('param.arid');
    	$article=M('article');
    	if(!$akid){
    		$this->error('并不知道你要编辑哪个类别下的文章，只好返回首页',U('Webadmin/index'),3);
    	}
    	if($arid){
    		$condition['id']=$arid;
    		$article=$article->where($condition)->find();
    		if($article){
    			$article['released']=date('Y-m-d',$article['released']);
    			$this->assign('article',$article);
    			$this->assign('body_title',$article['title']);
    		}else{
    			$this->error('无此文章',U('Webadmin/list/lists',array('id'=>$akid)),3);
    		}
    	}else{
    		$this->assign('article','');
    		$this->assign('body_title','新建文章');
    	}
    	$this->assign('akid',$akid);
    	$this->display();
    }
    // 编辑
    public function save(){
    	$data=I('param.');
    	$article=M('article');
    	$data['released']=strtotime($data['released']);
        $data['author']=$_SESSION['uname'];
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/uploads/'; // 设置附件上传根目录
        $upload->savePath  =     'images/'; // 设置附件上传（子）目录
        // 上传文件 
        if(!$_FILES['img']['error']){
            $info=$upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功
                $data['imgurl']=$info['img']['savepath'].$info['img']['savename'];
            }
        }
        
    	if($data['id']){
    		$result=$article->save($data);
    	}else{
    		$result=$article->add($data);
    	}
    	if($result){
    		$this->success('操作成功',U('Webadmin/list/lists',array('id'=>$data['artkind'])),3);
		}else{
			$this->error('操作失败',U('Webadmin/list/lists',array('id'=>$data['artkind'])),3);
		}
    }
     // 删除
    public function delete(){
        $id=I('param.id');
        if($id){
            $article=M('article');
            $condition['id']=$id;
            $result=$article->where($condition)->delete();
            if(isset($result)){
                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo '0';
        }
        
    }
    // 审核通过
    public function passed(){
        $id=I('param.id');
        if($id){
            $article=M('article');
            $data['ispassed']=1;
            $data['id']=$id;
            $result=$article->save($data);
            if(isset($result)){
                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo '0';
        }
        
    }
}