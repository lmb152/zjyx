<?php
namespace Webadmin\Controller;
use Think\Controller;
class DatatfController extends Controller {
    public function index(){
    	$article=M('article');
        $sql="select * from dede_archives ar  left join dede_addonarticle ao on ao.aid=ar.id where ar.typeid='31'";
        $from=M("","dede_","mysql://qdm180698380:lndx86daohe@qdm180698380.my3w.com:3306/qdm180698380_db");
        $data=$from->query($sql);
        foreach ($data as $key => $value) {
            $up_data=array(
                'title'=>$value['title'],
                'released'=>$value['pubdate'],
                'artkind'=>33,
                'imgurl'=>$value['litpic'],
                'author'=>$value['writer'],
                'clicknum'=>$value['click'],
                'content'=>$value['body'],
                'istop'=>1,
                'isindex'=>1,
                'briefinfo'=>$value['description'],
                );
            $article->add($up_data);
            $article->save($up_data);
        }
    }
}
