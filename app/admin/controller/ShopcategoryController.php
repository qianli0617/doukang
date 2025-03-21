<?php

/**
 * 店铺经营类目申请
 */
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\facade\Db;

class ShopcategoryController extends AdminbaseController {

    protected function getStatus($k=''){
        $status=array(
            '0'=>'待处理',
            '1'=>'审核成功',
            '2'=>'审核失败',
        );
        if($k===''){
            return $status;
        }
        return $status[$k] ?? '';
    }
    
    function index(){
        $data = $this->request->param();
        $map=[];
        
        $start_time= $data['start_time'] ?? '';
        $end_time= $data['end_time'] ?? '';
        
        if($start_time!=""){
           $map[]=['addtime','>=',strtotime($start_time)];
        }

        if($end_time!=""){
           $map[]=['addtime','<=',strtotime($end_time) + 60*60*24];
        }

        $status=$data['status'] ?? '';
        if($status!=''){
            $map[]=['status','=',$status];
        }

        $uid=$data['uid'] ?? '';
        if($uid!=''){
            $lianguid=getLianguser($uid);
            if($lianguid){
                //$map[]=['uid',['=',$uid],['in',$lianguid],'or'];
                array_push($lianguid,$uid);
                $map[]=['uid','in',$lianguid];
            }else{
                $map[]=['uid','=',$uid];
            }
        }

    	$lists = Db::name("apply_goods_class")
                ->where($map)
                ->order("addtime DESC")
                ->paginate(20);
                
        $lists->each(function($v,$k){
            $v['userinfo']= getUserInfo($v['uid']);
            $v['classname']='';

            //获取商家经营类目
            $class_list=explode(",",$v['goods_classid']);
            $num=count($class_list);
            foreach ($class_list as $k1 => $v1) {
                $gc_name=Db::name("shop_goods_class")->where("gc_id={$v1}")->value('gc_name');
                
                $v['classname'].=$gc_name;
                if($num>1&&$k1<($num-1)){
                    $v['classname'].=' | ';
                }
                
            }
            return $v;           
        });
                
        $lists->appends($data);
        $page = $lists->render();


    	$this->assign('lists', $lists);

    	$this->assign("page", $page);
        
    	$this->assign("status", $this->getStatus());
    	
    	return $this->fetch();			
    }
    
	function del(){
        
        $id = $this->request->param('id', 0, 'intval');
        
        $rs = DB::name('apply_goods_class')->where("id={$id}")->delete();
        if(!$rs){
            $this->error("删除失败！");
        }

		$action="删除店铺经营类目申请：{$id}";
        setAdminLog($action);

        $this->success("删除成功！",url("Shopcategory/index"));
	}
	
    
    function edit(){
        $id   = $this->request->param('id', 0, 'intval');
        
        $data=Db::name('apply_goods_class')
            ->where("id={$id}")
            ->find();
        if(!$data){
            $this->error("信息错误");
        }

        $data['userinfo']= getUserInfo($data['uid']);

        //获取一级店铺分类
        $oneGoodsClass=getcaches("oneGoodsClass");

        if(!$oneGoodsClass){
            $oneGoodsClass=Db::name("shop_goods_class")
                ->field("gc_id,gc_name,gc_isshow")
                ->where("gc_parentid=0")
                ->order("gc_sort")
                ->select()
                ->toArray();

            setcaches("oneGoodsClass",$oneGoodsClass);
        }

        //获取用户的经营类目
        $seller_class_arr=Db::name("seller_goods_class")
            ->where("uid={$data['uid']}")
            ->select()
            ->toArray();
        $seller_class_arr=array_column($seller_class_arr, 'goods_classid');
		
		
		foreach($oneGoodsClass as $ks=>$vs){
			if(in_array($vs['gc_id'],$seller_class_arr)){
				$oneGoodsClass[$ks]['gc_isshow']=3; //已存在的类目
			}
		}
		
        $this->assign('data', $data);
        $this->assign('oneGoodsClass', $oneGoodsClass);        
        $this->assign("status", $this->getStatus());
        return $this->fetch();
    }
    
	function editPost(){
		if ($this->request->isPost()) {
            
            $data = $this->request->param();

            $classids= $data['classids'] ?? [];
            $uid=$data['uid'];

            $shop_status=$data['status'];

            $reason=$data['reason'];
            $reason_en=$data['reason_en'];

            if($shop_status==2){ //审核失败
                if(trim($reason)==""){
                    $this->error("请填写中文审核失败原因");
                }

                if(trim($reason_en)==""){
                    $this->error("请填写英文审核失败原因");
                }
            }

            $data['goods_classid']=implode(",",$classids);
            $data['uptime']=time();
			
			unset($data['classids']);
			$rs = DB::name('apply_goods_class')->update($data);
            if($rs===false){
                $this->error("修改失败！");
            }
			$action="修改店铺经营类目";
            if($shop_status>0){
                $title='';
                if($shop_status==1){ //审核通过
                    $title='你申请的经营类目审核已通过。';
                    $title_en='The business category review you applied for has been approved.';

					//更新用户经营类目 
					foreach ($classids as $k => $v){
						//获取一级分类的状态
						$status=Db::name("shop_goods_class")->where("gc_id={$v}")->value('gc_isshow');

						$data1=array(
							'uid'=>$uid,
							'goods_classid'=>$v,
							'status'=>$status
						);
						Db::name("seller_goods_class")->insert($data1);
					}
					
                }else if($shop_status==2){ //审核失败
                    $title='你申请的经营类目审核失败。';
                    $title_en='The business category you applied for failed to be reviewed.';
                    if($reason){
                        $title.='失败原因：'.$reason;
                    }

                    if($reason_en){
                        $title_en.='Reason for failure:'.$reason_en;
                    }
                }
				
				$action.=$title;

                //写入记录
                addSysytemInfo($uid,$title,$title_en,1);
                //发送腾讯云推送
                //type=2 非直播开播消息
                
                $tpns_title=[
                    'zh-cn'=>'经营类目申请',
                    'en'=>'Business Category Application'
                ];

                $tpns_arr=[
                    'zh-cn'=>$title,
                    'en'=>$title_en
                ];

                txMessageTpns('经营类目申请',$title,'single',$uid,[],json_encode(['type'=>2]),'zh-cn');
                sleep(2);
                txMessageTpns('Business Category Application',$title_en,'single',$uid,[],json_encode(['type'=>2]),'en');

            }
			
			$action.=" UID：{$uid}";
			setAdminLog($action);

            $this->success("修改成功！",url("Shopcategory/index"));
		}
	}    
}
