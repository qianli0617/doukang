<?php

/**
 * 直播分类
 */
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\facade\Db;

class LiveclassController extends AdminbaseController {
    function index(){
			
    	$lists = Db::name("live_class")
            ->order("list_order asc, id desc")
            ->paginate(20);
        $page = $lists->render();
    	$this->assign('lists', $lists);
    	$this->assign("page", $page);
    	
    	return $this->fetch();
    }

    /**
     * @desc 删除
     * @return void
     * @throws \think\db\exception\DbException
     */
    function del(){
        
        $id = $this->request->param('id', 0, 'intval');
        
        $rs = DB::name('live_class')->where("id={$id}")->delete();
        if(!$rs){
            $this->error("删除失败！");
        }

        Db::name("live")->where(['liveclassid'=>$id])->update(['liveclassid'=>0]);
        Db::name("live_record")->where(['liveclassid'=>$id])->update(['liveclassid'=>0]);
        
        $action="删除直播分类：{$id}";
        setAdminLog($action);
                    
        $this->resetcache();
        $this->success("删除成功！");				
    }		
    //排序
    public function listOrder() { 
		
        $model = DB::name('live_class');
        parent::listOrders($model);
        
        $action="更新直播分类排序";
        setAdminLog($action);
        
        $this->resetcache();
        $this->success("排序更新成功！");
    }

    /**
     * @desc 添加
     * @return mixed
     */
    function add(){        
        return $this->fetch();
    }

    /**
     * @desc 添加保存
     * @return void
     */
    function addPost(){
        if ($this->request->isPost()) {
            
            $data = $this->request->param();
            
			$name=$data['name'];
            $name_en=$data['name_en'];

			if($name==""){
				$this->error("请填写中文名称");
			}

            if($name_en==""){
                $this->error("请填写英文名称");
            }

			$thumb=$data['thumb'];
			if($thumb==""){
				$this->error("请上传图标");
			}

            $data['thumb']=set_upload_path($thumb);

            $des=$data['des'];
            $des_en=$data['des_en'];
            if($des==''){
                $this->error("请填写直播分类中文描述");
            }

            if(mb_strlen($des)>200){
                $this->error("直播分类中文描述在200字以内");
            }

            if($des_en==''){
                $this->error("请填写直播分类英文描述");
            }

            if(mb_strlen($des_en)>200){
                $this->error("直播分类英文描述在200字以内");
            }
            
			$id = DB::name('live_class')->insertGetId($data);
            if(!$id){
                $this->error("添加失败！");
            }
            
            $action="添加直播分类：{$id}";
            setAdminLog($action);
            
            $this->resetcache();
            $this->success("添加成功！");
		}
    }

    /**
     * @desc 编辑直播分类
     * @return mixed
     */
    function edit(){
        
        $id   = $this->request->param('id', 0, 'intval');
        
        $data=Db::name('live_class')
            ->where("id={$id}")
            ->find();
        if(!$data){
            $this->error("信息错误");
        }
        
        $this->assign('data', $data);
        return $this->fetch(); 			
    }
    
    function editPost(){
        if ($this->request->isPost()) {
            
            $data      = $this->request->param();
            
			$name=$data['name'];
            $name_en=$data['name_en'];

			if($name==""){
				$this->error("请填写中文名称");
			}

            if($name_en==""){
                $this->error("请填写英文名称");
            }

			$thumb=$data['thumb'];
			if($thumb==""){
				$this->error("请上传图标");
			}

			$des=$data['des'];
            $des_en=$data['des_en'];
            if($des==''){
                $this->error("请填写直播分类中文描述");
            }

            if(mb_strlen($des)>200){
                $this->error("直播分类中文描述在200字以内");
            }

            if($des_en==''){
                $this->error("请填写直播分类英文描述");
            }

            if(mb_strlen($des_en)>200){
                $this->error("直播分类英文描述在200字以内");
            }

            $thumb_old=$data['thumb_old'];
            if($thumb_old!=$thumb){
                $data['thumb']=set_upload_path($thumb);
            }

            unset($data['thumb_old']);
            
			$id = DB::name('live_class')->update($data);
            if($id===false){
                $this->error("修改失败！");
            }
            
            $action="修改直播分类：{$data['id']}";
            setAdminLog($action);
            
            $this->resetcache();
            $this->success("修改成功！");
		}	
    }
    
    function resetcache(){
        $key='getLiveClass';
        $rules= DB::name('live_class')
                ->order('list_order asc,id desc')
                ->select();
        if($rules){
			
			
            setcaches($key,$rules);
        }else{
			delcache($key);
		}
        
        return 1;
    }
}
