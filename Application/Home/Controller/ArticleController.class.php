<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends Controller {
    public function index(){
        $this->display();
    }  
    public function search(){
        $keyword=I('param.search_key');
        if(!$keyword){
            $this->error('搜索的关键词不能为空',U('Index'),3);
        }else{
            $articles=M('article');
            $condition["title"] = array('like', '%'.$keyword.'%');            $p=getpage($articles,$condition,C('VAR_NUM'));
            $list=$articles->where($condition)->order('released desc')->select();
            $this->assign('articles',$list);
            $this->assign('page',$p->show());
            $this->display();
        }
    }
    public function lists(){
        $artkind=I('param.artkind');
        if(!$artkind){
            $this->redirect('/index');
        }
        $articles=M('article');
        $artkinds=M('artkind');
        $condition['id']=$artkind;
        $artkind=$artkinds->where($condition)->find();
        if($artkind['parent']!=0){
            unset($condition);
            $condition['id']=$artkind['parent'];
            $artkind_parent=$artkinds->where($condition)->find();
        }
        if(isset($artkind_parent)){
            $bread_crumb=array(
                array('id'=>$artkind_parent['id'],'name'=>$artkind_parent['name']),
                array('id'=>$artkind['id'],'name'=>$artkind['name']),
            );
        }else{
            $bread_crumb=array(
                array('id'=>$artkind['id'],'name'=>$artkind['name']),
            );
        }
        if($artkind['issingle']==1){
            unset($condition);
            $condition['artkind']=$artkind['id'];
            $condition['ispassed']='1';
            $article_single=$articles->where($condition)->find();
            if(!empty($article_single)){
                $this->redirect('/Article/details/article/'.$article_single['id']);
            }else{
                $this->redirect('/index');
            }
        }
        unset($condition);
        $condition['artkind']=$artkind['id'];
        $condition['parent']=$artkind['id'];
        import('ORG.Util.Page');// 导入分页类
        $count = $articles->where($condition)->count();// 查询满足要求的总记录数
        // 文章为空则查询子类文章
        if($count==0){
            unset($condition);
            $condition['parent']=$artkind['id'];
            $artkind_temp=$artkinds->field('id')->where($condition)->select();
            foreach ($artkind_temp as $key => $value) {
                if(($key+1)==count($artkind_temp)){
                    $temp .=$value['id'];
                }else{
                   $temp .=$value['id'].','; 
                } 
            }
            unset($condition);
            $condition['artkind']=array('in',$temp);
            $condition['ispassed']=1;
            $condition['parent']=$artkind['id'];
            $count=$articles->where($condition)->count();
            $Page =  new \Think\Page($count,C('VAR_NUM'));// 实例化分页类 传入总记录数和每页显示的记录数
            $list=$articles->where($condition)->order('istop desc,released desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        }else{
            $Page =  new \Think\Page($count,C('VAR_NUM'));// 实例化分页类 传入总记录数和每页显示的记录数
            //分页跳转的时候保证查询条件
            $list=$articles->where($condition)->order('istop desc,released desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        }
        // $p->lastSuffix=false;
        // $p->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;每页<b>%LIST_ROW%</b>条&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $show = $Page->show();// 分页显示输出
        $this->assign('listname',$artkind['name']);
        $this->assign('bread_crumb',$bread_crumb);
        $this->assign('artkind',$id);
        $this->assign('articles',$list);
        $this->assign('page',$show);
        $this->display();
    }
    public function details(){
        $id=I('param.article');
        if(!$id){
            $this->error('查无此文章,直接跳回首页',U('Home/index'),3);
        }
        $articles=M('article');
        $artkinds=M('artkind');
        $condition['id']=$id;$condition['parent']=$artkind['id'];
        $article=$articles->where($condition)->find();
        if(!$article){
            $this->error('此文章不允许查看,直接跳回首页',U('Home/index'),3);
        }
        unset($condition);
        $condition['id']=$article['artkind'];
        $artkind=$artkinds->where($condition)->find();
        if($artkind['parent']!=0){
            unset($condition);
            $condition['id']=$artkind['parent'];
            $artkind_parent=$artkinds->where($condition)->find();
        }
        if(isset($artkind_parent)){
            $bread_crumb=array(
                array('id'=>$artkind_parent['id'],'name'=>$artkind_parent['name']),
                array('id'=>$artkind['id'],'name'=>$artkind['name']),
            );
        }else{
            $bread_crumb=array(
                array('id'=>$artkind['id'],'name'=>$artkind['name']),
            );
        }
        $this->assign('bread_crumb',$bread_crumb);
        $this->assign('article',$article);
        $this->display();
    }
    // left tree
    public function left(){
        $artkind_id=I('param.artkind');
        $artkind=M('artkind');
        $artkind_content=array();
        // 获取主分类
        $condition['parent']=0;
        $condition['name']=array('neq', '其他活动');
        $artkind_parents=$artkind->where($condition)->select();
        unset($condition);
        foreach ($artkind_parents as $k => $v) {
            $artkind_content[$k][0]=$v;
            $condition['parent']=$v['id'];
            $artkind_childs=$artkind->where($condition)->select();
            if($artkind_childs){
                $artkind_content[$k][1]=$artkind_childs;
            }else{
                $artkind_content[$k][1][]=$v;
            }
        }
        $this->assign('artkind_id',$artkind_id);
        $this->assign('leftmenu',$artkind_content);
        $this->display('/left');
    }
}