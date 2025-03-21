<?php

namespace app\portal\controller;
use cmf\controller\HomeBaseController;
use think\facade\Db;

class PageController extends HomebaseController{
	public function index() {

        $data = $this->request->param();
        $id=$data['id'];
        $ish5=isset($data['ish5']) ? $data['ish5']: '0';
		$this->assign('ish5', $ish5);
        if(!$id){
            $reason=lang('信息错误');
            $this->assign('reason', $reason);
            return $this->fetch(':error');
        }

        $page=Db::name("portal_post")->where(['id'=>$id])->find();
        $page['post_content']=html_entity_decode($page['post_content']);

        //语言包
        $language=$this->language;
        if($language=='en'){
            $page['post_title']=$page['post_title_en'];
        }
        
        $this->assign('page', $page);
		
		return $this->fetch();
	}
}