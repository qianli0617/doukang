<?php

/**
 * 家族
 */
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\facade\Db;

class FamilyController extends AdminbaseController {
    
    protected function getState($k=''){
        $status=array(
            '0'=>'未审核',
            '1'=>'审核失败',
            '2'=>'审核通过',
        );
        if($k===''){
            return $status;
        }
        
        return $status[$k] ?? '';
    }

    protected function getState2($k=''){
        $status=array(
            '0'=>'未处理',
            '1'=>'提现成功',
            '2'=>'拒绝提现',
        );
        if($k===''){
            return $status;
        }

        return $status[$k] ?? '';
    }
    
    function index(){
        
        $data = $this->request->param();
        $map=[];
        $map[]=['state','<>',3];
        
        $start_time= $data['start_time'] ?? '';
        $end_time= $data['end_time'] ?? '';
        
        if($start_time!=""){
           $map[]=['addtime','>=',strtotime($start_time)];
        }

        if($end_time!=""){
           $map[]=['addtime','<=',strtotime($end_time) + 60*60*24];
        }
        
        $state= $data['state'] ?? '';
        if($state!=''){
            $map[]=['state','=',$state];
        }

        $uid=$data['uid'] ?? '';
        if($uid!=''){
            $lianguid=getLianguser($uid);
            if($lianguid){
                
                array_push($lianguid,$uid);
                $map[]=['uid','in',$lianguid];
            }else{
                $map[]=['uid','=',$uid];
            }
        }
        
        $keyword= $data['keyword'] ?? '';
        if($keyword!=''){
            $map[]=['name','like','%'.$keyword.'%'];
        }

    	$lists = Db::name("family")
                ->where($map)
                ->order("addtime DESC")
                ->paginate(20);
        
        $lists->each(function($v,$k){
			$v['userinfo']=getUserInfo($v['uid']);
			$v['badge']=get_upload_path($v['badge']);
            return $v;           
        });
        
        $lists->appends($data);
        $page = $lists->render();

    	$this->assign('lists', $lists);
    	$this->assign("page", $page);
    	$this->assign("state", $this->getState());
    	
    	return $this->fetch();
	}
    
    function disable()
	{
        $id = $this->request->param('id', 0, 'intval');
        
        $rs = DB::name('family')->where("id={$id}")->update(['disable'=>1]);
        if($rs===false){
            $this->error("禁用失败！");
        }
        
        $action="禁用家族：{$id}";
        setAdminLog($action);
        
        $this->success("禁用成功！");
        	
	}

	function enable()
	{
        $id = $this->request->param('id', 0, 'intval');
        
        $rs = DB::name('family')->where("id={$id}")->update(['disable'=>0]);
        if($rs===false){
            $this->error("启用失败！");
        }
        
        $action="启用家族：{$id}";
        setAdminLog($action);
        
        $this->success("启用成功！");
        		
	}

	function del()
	{
        $id = $this->request->param('id', 0, 'intval');
        
        $rs = DB::name('family')->where("id={$id}")->update(['state'=>3]);
        if($rs===false){
            $this->error("删除失败！");
        }
        
        DB::name("family_profit")->where(["familyid"=>$id])->delete();
        
        $data=array(
            'state'=>3,
            'signout'=>2,
            'signout_istip'=>2,
        );
        DB::name("family_user")->where(["familyid"=>$id])->update($data);	

        $action="删除家族：{$id}";
        setAdminLog($action);
        
        $this->success("删除成功！");	
					
	}
    
    function profit(){
        $data = $this->request->param();
        $uid = $this->request->param('uid', 0, 'intval');
        
		$map=array();

		$ufamilyinfo=DB::name("family_user")->where(["uid"=>$uid])->find();
		if($ufamilyinfo){
			$map['uid']=$uid;
		}else{
			$familyinfo=DB::name("family")->where(["uid"=>$uid])->find();
			$map['familyid']=$familyinfo['id'];
		}

        $lists = Db::name("family_profit")
                ->where($map)
                ->order("id DESC")
                ->paginate(20);
        $lists->each(function($v,$k){
			$v['userinfo']=getUserInfo($v['uid']);
            return $v;           
        });
        
        $lists->appends($data);
        $page = $lists->render();

        $total_family=Db::name("family_profit")->where($map)->sum("profit");
        if(!$total_family){
			$total_family=0;
		}

		$total_anthor=Db::name("family_profit")->where($map)->sum("profit_anthor");
		if(!$total_anthor){
			$total_anthor=0;
		}
        $this->assign('total_family', $total_family);
        $this->assign('total_anthor', $total_anthor);
        $this->assign('lists', $lists);
        $this->assign("page", $page);
    	return $this->fetch();
	}

    function cash(){
        $data = $this->request->param();
        $uid = $this->request->param('uid', 0, 'intval');
        
		$map=[];
        $map[]=['uid','=',$uid];
        
		$ufamilyinfo=DB::name("family_user")->where(["uid"=>$uid])->find();
		if($ufamilyinfo){
            $map[]=['addtime','>',$ufamilyinfo['addtime']];
		}

        $lists = Db::name("cash_record")
                ->where($map)
                ->order("id DESC")
                ->paginate(20);
        $lists->each(function($v,$k){
			$v['userinfo']=getUserInfo($v['uid']);
            return $v;           
        });
        
        $lists->appends($data);
        $page = $lists->render();

        $total=Db::name("cash_record")->where('status=1')->where($map)->sum("money");
        if(!$total){
			$total=0;
		}
        $this->assign('total', $total);
        $this->assign("state", $this->getState2());
        $this->assign('lists', $lists);
        $this->assign("page", $page);
    	return $this->fetch();
		
	}

    function edit(){
        $id   = $this->request->param('id', 0, 'intval');
        $data=Db::name('family')
            ->where("id={$id}")
            ->find();
        if(!$data){
            $this->error("信息错误");
        }
        
        $data['userinfo']=getUserInfo($data['uid']);
        $this->assign('data', $data);
        $this->assign("state", $this->getState());
        
        return $this->fetch();
        
	}

	function editPost(){
		if ($this->request->isPost()) {
            $data = $this->request->param();
            
			$data['istip']=1;
            
			$rs = DB::name('family')->update($data);
            if($rs===false){
                $this->error("修改失败！");
            }
            
            $action="修改家族信息：{$data['id']}";
            setAdminLog($action);
            $this->success("修改成功！");
            				 
		}		
	}


	
}