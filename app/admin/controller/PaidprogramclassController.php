<?php

/**
 * 付费内容分类
 */
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\facade\Db;

class PaidprogramclassController extends AdminbaseController {

    protected function getStatus($k=''){
        $type=[
            '0'=>'不显示',
            '1'=>'显示',
        ];
        if($k===''){
            return $type;
        }
        return $type[$k] ?? '';
    }

    /*分类列表*/
    function index(){
        $data = $this->request->param();
        $map=[];

        $keyword= $data['keyword'] ?? '';
        if($keyword!=''){
            $map[]=['name','like','%'.$keyword.'%'];
        }

        $lists = Db::name("paidprogram_class")
                ->where($map)
                ->order("list_order asc,id DESC")
                ->paginate(20);

        $lists->appends($data);
        $page = $lists->render();

        $this->assign('lists', $lists);
        $this->assign('status', $this->getStatus());
        $this->assign("page", $page);
        
        return $this->fetch();
    }


    //分类排序
    function listOrder() { 
        $model = DB::name('paidprogram_class');
        parent::listOrders($model);
        
        $this->resetcache();

		$action="更新付费内容分类列表排序 ";
        setAdminLog($action);

        $this->success("排序更新成功！");
    }


    /*分类删除*/
    function del(){
        $id = $this->request->param('id', 0, 'intval');
        
        $rs = DB::name('paidprogram_class')->where("id={$id}")->delete();
        if(!$rs){
            $this->error("删除失败！");
        }

        $this->resetcache();

		$action="删除付费内容分类列表ID: ".$id;
        setAdminLog($action);

        Db::name("paidprogram")->where("classid={$id}")->update(array("classid"=>0));
        $this->success("删除成功！");
    }

    /*分类添加*/
    function add(){
        $this->assign("status", $this->getStatus());
        return $this->fetch();
    }

    /*分类添加提交*/
    function addPost(){
        if ($this->request->isPost()) {
            
            $data = $this->request->param();
            
            $name=trim($data['name']); //去除左右两边空格
            $name_en=trim($data['name_en']); //去除左右两边空格

            if($name==""){
                $this->error("请填写分类中文名称");
            }
            
            $isexist=DB::name('paidprogram_class')->where(['name'=>$name])->find();
            if($isexist){
                $this->error("分类中文名称已存在");
            }

            if($name_en==""){
                $this->error("请填写分类英文名称");
            }
            
            $isexist=DB::name('paidprogram_class')->where(['name_en'=>$name_en])->find();
            if($isexist){
                $this->error("分类英文名称已存在");
            }
            
            $data['addtime']=time();
            
            $id = DB::name('paidprogram_class')->insertGetId($data);
            if(!$id){
                $this->error("添加失败！");
            }
			
			$action="添加付费内容分类列表ID: ".$id;
			setAdminLog($action);

            $this->resetcache();
            $this->success("添加成功！");
        }
    }

    /*分类编辑*/
    function edit(){
        
        $id = $this->request->param('id', 0, 'intval');
        
        $data=Db::name('paidprogram_class')
            ->where("id={$id}")
            ->find();
        if(!$data){
            $this->error("信息错误");
        }
        
        $this->assign('status',$this->getStatus());
        $this->assign('data', $data);
        return $this->fetch();
    }

    /*分类编辑提交*/
    function editPost(){
        if ($this->request->isPost()){
            
            $data = $this->request->param();
            
            $name=trim($data['name']);  //去除左右两边空格
            $name_en=trim($data['name_en']);  //去除左右两边空格
            $id=$data['id'];

            if($name==""){
                $this->error("请填写分类名称");
            }
            
            $isexist=DB::name('paidprogram_class')->where([['id','<>',$id],['name','=',$name]])->find();
            if($isexist){
                $this->error("分类名称已存在");
            }
            
            if(mb_strlen($name)>30){
                $this->error("字数不超过30字");
            }

            if($name_en==""){
                $this->error("请填写分类英文名称");
            }
            
            $isexist=DB::name('paidprogram_class')->where([['id','<>',$id],['name_en','=',$name_en]])->find();
            if($isexist){
                $this->error("分类英文名称已存在");
            }
            
            if(mb_strlen($name_en)>100){
                $this->error("字数不超过100字");
            }

            $data['edittime']=time();
            
            $rs = DB::name('paidprogram_class')->update($data);
            if($rs===false){
                $this->error("修改失败！");
            }

			$action="修改付费内容分类列表ID: ".$id;
			setAdminLog($action);

            $this->resetcache();
            $this->success("修改成功！");
        }

    }


    // 写入付费项目分类缓存
    function resetcache(){
        $key='getPaidClass';
        
        $rs=DB::name('paidprogram_class')
            ->field("id,name,name_en")
            ->where('status=1')
            ->order("list_order asc,id desc")
            ->select();
        if($rs){
            setcaches($key,$rs);
        }   
        return 1;
    }
}
