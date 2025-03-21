<?php

/**
 * 游戏记录
 */
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\facade\Db;
    
class GameController extends AdminbaseController {
    
    protected function getTypes($k=''){
        $type=array(
            '0'=>'否',
            '1'=>'是',
        );
        if($k===''){
            return $type;
        }
        
        return $type[$k] ?? '';
    }
    
    protected function getStatus($k=''){
        $type=array(
            "0"=>"进行中",
            "1"=>"正常结束",
            "2"=>"主播关闭",
            "3"=>"意外结束"
        );
        if($k===''){
            return $type;
        }
        
        return $type[$k] ?? '';
    }
    
    protected function getAction($k=''){
        $type=array(
            "1"=>"智勇三张",
            //"2"=>"海盗船长",
            "3"=>"转盘",
            /* "4"=>"开心牛仔", */
            //"5"=>"二八贝"
        );
        if($k===''){
            return $type;
        }
        
        return $type[$k] ?? '';
    }
    
    protected function getRs($k=''){
        $type=array(
            "1"=>"未中奖",
            "2"=>"中奖"
        );
        if($k===''){
            return $type;
        }
        
        return $type[$k] ?? '';
    }
	
	
	

    private function getType($k=''){
        $configpub=getConfigPub();
        $type=array(
            '0'=>$configpub['name_coin'],
            '1'=>'礼物'
        );

        if($k===''){
            return $type;
        }

        return $type[$k] ?? '';
    }
    var $status=array("0"=>"未处理","1"=>"已完成","2"=>"已拒绝");
	var $votestype=array("0"=>"订单收益提现","1"=>"礼物收益提现");
    
    function index(){

		$data = $this->request->param();
        $map=[];
		
        $action= $data['action'] ?? '';
        if($action!=''){
            $map[]=['action','=',$action];
        }

        $liveuid=$data['liveuid'] ?? '';
        if($liveuid!=''){
            $lianguid=getLianguser($liveuid);
            if($lianguid){
                
                array_push($lianguid,$liveuid);
                $map[]=['liveuid','in',$lianguid];
            }else{
                $map[]=['liveuid','=',$liveuid];
            }
        }

    	$lists = Db::name("game")
			->where($map)
			->order("id DESC")
			->paginate(20);
        $lists->each(function($v,$k){
			$v['userinfo']=getUserInfo($v['liveuid']);
            return $v;           
        });
			
    	$lists->appends($data);
        $page = $lists->render();

    	$this->assign('lists', $lists);
    	$this->assign("page", $page);
    	$this->assign("action", $this->getAction());
    	$this->assign("status", $this->getStatus());
    	$this->assign("type", $this->getTypes());
    	
    	return $this->fetch();
    }

    function index2(){

		$data = $this->request->param();
        $map=[];
		
        $this->result=$result= $data['result'] ?? '';
        
        $gameid= $data['gameid'] ?? '';
        if($gameid!=''){
            $map[]=['gameid','=',$gameid];
        }
        
        $result_n=$result;
		if(strstr($result,',')){
			$result_a=explode(',',$result);
			$result_n='';
			foreach($result_a as $k=>$v){
				if($v==3){
					$result_n.=($k+1).':赢 ';
				}else{
					$result_n.=($k+1).':输 ';
				}
			}
		}
        
        
        $rs= $data['rs'] ?? '';
        if($rs!=''){
            if(strstr($result,',')){
				$result_a=explode(',',$result);
				$string=1;
				foreach($result_a as $k=>$v){
					$n=$k+1;
					if($rs==2){
						if($v==3){
							$map[]=["coin_{$n}",'>','0'];
                            $string=0;
						}
					}else{
						if($v==3){
							$map[]=["coin_{$n}",'=','0'];
                            $string=0;
						}
					}
					
				}
				if($string==1){
					if($rs==1){
                        $map[]=["coin_4",'=','0'];
					}else{
                        $map[]=["coin_4",'>','0'];
					}
				}
				
			}else{
				if($rs==1){
                    $map[]=["coin_{$result}",'=','0'];
				}else{
                    $map[]=["coin_{$result}",'>','0'];
				}
				
			}
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
        
        $configpri=getConfigPri();
        $this->game_pump=$configpri['game_pump'];

    	$lists = Db::name("gamerecord")
			->where($map)
			->order("id DESC")
			->paginate(20);
            
        $lists->each(function($v,$k){

			$v['userinfo']=getUserInfo($v['uid']);
            
            $total=0;
            $total2=0;
            $result=$this->result;
            if(strstr($result,',')){
                $result_a=explode(',',$result);
                foreach($result_a as $k1=>$v1){
                    $total2+=$v['coin_'.($k1+1)];
                    if($v1==3){
                        $total+=$v['coin_'.($k1+1)];
                    }
                }
            }else{
                $total=$v['coin_'.$result];
            }
            
            $win=$total + floor($total*(2-1)*(100 - $this->game_pump)*0.01) - $total2;
            
            $v['win']=$win;
            
            return $v;           
        });
			
    	$lists->appends($data);
        $page = $lists->render();

    	$this->assign('lists', $lists);
    	$this->assign("page", $page);
        $this->assign("action", $this->getAction());
    	$this->assign("rs", $this->getRs());
    	$this->assign("gameid", $gameid);
    	$this->assign("result", $result);
    	$this->assign("result_n", $result_n);
    	
    	return $this->fetch();
    }
	
	
	//星球探宝奖品列表
    public function xqtbgift(){

        $list = Db::name('xqtb_gift')
            ->order("list_order asc")
            ->paginate(20);

        $list->each(function($v,$k){
            if($v['type']==1){
                $v['giftinfo']= $this->getGiftInfo($v['giftid']);
            }else{
                $v['giftinfo']=[];
            }
           
           return $v; 
        });
        
        $page = $list->render();

        $configpub=getConfigPub();

        $this->assign('list', $list);
        $this->assign("page", $page);
        $this->assign("name_coin", $configpub['name_coin']);
        $this->assign("type", $this->getType());

        return $this->fetch();
    }

    public function getGiftInfo($giftid){

        $giftinfo = Db::name("gift")->where(['id'=>$giftid])->field("giftname,gifticon,needcoin")->find();
		if(!$giftinfo){
			$giftinfo=[
				'giftname'=>'礼物已被删除',
				'gifticon'=>'',
				'needcoin'=>'0',
			];
		}

        return $giftinfo;
    }

    public function xqtbadd(){
        $giftlist = Db::name("gift")->where("type !=2")->order("list_order")->select();
        $configpub=getConfigPub();
        $this->assign("giftlist", $giftlist);
        $this->assign("name_coin", $configpub['name_coin']);
        return $this->fetch();
    }

    public function xqtbaddPost(){
        $data=$this->request->param();
        $type=$data['type'];
        $coin=$data['coin'];
        $giftid=$data['giftid'];
        $gift_num=$data['gift_num'];
        $show_win_prob=$data['show_win_prob'];
        $real_win_mwx=$data['real_win_mwx'];
        $real_win_twx=$data['real_win_twx'];
        $real_win_hwx=$data['real_win_hwx'];

        $configpub=getConfigPub();
        $name_coin=$configpub['name_coin'];

        if($type==0){
            if($coin<1){
                $this->error("奖励".$name_coin."数量错误");
            }

            $data['giftid']=0;
            $data['gift_num']=0;
        }

        if($type==1){

            $data['coin']=0;

            if(!$giftid){
                $this->error("请选择礼物");
            }

            if($gift_num<1){
                $this->error("礼物数量错误");
            }

            $info = Db::name("xqtb_gift")->where(['giftid'=>$giftid])->find();

            if($info){
                $this->error("礼物奖品已存在");
            }
        }

        if(!$show_win_prob){
            $this->error("请填写展示中奖概率区间值");
        }

        //
        if(!$real_win_mwx){
            $this->error("请填写冥王星实际中奖概率");
        }

        if($real_win_mwx<0){
            $this->error("冥王星实际中奖概率错误");
        }


        //
        if(!$real_win_twx){
            $this->error("请填写天王星实际中奖概率");
        }

        if($real_win_twx<0){
            $this->error("天王星实际中奖概率错误");
        }

        
        //
        if(!$real_win_hwx){
            $this->error("请填写海王星实际中奖概率");
        }

        if($real_win_hwx<0){
            $this->error("海王星实际中奖概率错误");
        }

        

        $data['addtime']=time();

        $res = Db::name("xqtb_gift")->insert($data);

        if(!$res){
            $this->error("保存失败");
        }

        $this->success("保存成功");
    }

    public function xqtblistOrder() {
        $model = DB::name('xqtb_gift');
        parent::listOrders($model);
        
        $this->success("排序更新成功！");
    }

    public function xqtbedit(){

        $data=$this->request->param();
        $id=$data['id'];
        $info=Db::name("xqtb_gift")->where(['id'=>$id])->find();
        $giftlist = Db::name("gift")->order("list_order")->select();
        $configpub=getConfigPub();
        $this->assign("giftlist", $giftlist);
        $this->assign("name_coin", $configpub['name_coin']);
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function xqtbeditPost(){
        $data=$this->request->param();
        $id=$data['id'];
        $type=$data['type'];
        $coin=$data['coin'];
        $giftid=$data['giftid'];
        $gift_num=$data['gift_num'];
        $show_win_prob=$data['show_win_prob'];
        $real_win_mwx=$data['real_win_mwx'];
        $real_win_twx=$data['real_win_twx'];
        $real_win_hwx=$data['real_win_hwx'];

        $configpub=getConfigPub();
        $name_coin=$configpub['name_coin'];

        if($type==0){
            if($coin<1){
                $this->error("奖励".$name_coin."数量错误");
            }

            $data['giftid']=0;
            $data['gift_num']=0;
        }

        if($type==1){

            $data['coin']=0;

            if(!$giftid){
                $this->error("请选择礼物");
            }

            if($gift_num<1){
                $this->error("礼物数量错误");
            }

            $info = Db::name("xqtb_gift")->where(['giftid'=>$giftid])->where("id <> {$id}")->find();

            if($info){
                $this->error("礼物奖品已存在");
            }
        }

        if(!$show_win_prob){
            $this->error("请填写展示中奖概率区间值");
        }

        //
        if(!$real_win_mwx){
            $this->error("请填写冥王星实际中奖概率");
        }

        if($real_win_mwx<0){
            $this->error("冥王星实际中奖概率错误");
        }

        

        //
        if(!$real_win_twx){
            $this->error("请填写天王星实际中奖概率");
        }

        if($real_win_twx<0){
            $this->error("天王星实际中奖概率错误");
        }

        

        //
        if(!$real_win_hwx){
            $this->error("请填写海王星实际中奖概率");
        }

        if($real_win_hwx<0){
            $this->error("海王星实际中奖概率错误");
        }


        $data['edittime']=time();

        $res = Db::name("xqtb_gift")->update($data);

        if($res===false){
            $this->error("保存失败");
        }

        $this->success("保存成功");
    }

    public function xqtbdel(){
        $id = $this->request->param('id', 0, 'intval');
        if($id){
            $res = Db::name("xqtb_gift")->where(['id'=>$id])->delete();
            if(!$res){
                $this->error("删除失败");
            }

            $this->success("删除成功");
        }else{
            $this->error("参数错误");
        }
    }
        
    public function xydzpgift(){
        $list = Db::name('xydzp_gift')
            ->order("list_order asc")
            ->paginate(20);

        $list->each(function($v,$k){
            if($v['type']==1){
                $v['giftinfo']= $this->getGiftInfo($v['giftid']);
            }else{
                $v['giftinfo']=[];
            }
           
           return $v; 
        });
        
        $page = $list->render();

        $configpub=getConfigPub();
		
		

        $this->assign('list', $list);
        $this->assign("page", $page);
        $this->assign("name_coin", $configpub['name_coin']);
        $this->assign("type", $this->getType());

        return $this->fetch();
    }

    public function xydzplistOrder() {
        $model = DB::name('xydzp_gift');
        parent::listOrders($model);
        
        $this->success("排序更新成功！");
    }

    public function xydzpedit(){

        $data=$this->request->param();
        $id=$data['id'];
        $info=Db::name("xydzp_gift")->where(['id'=>$id])->find();
        $giftlist = Db::name("gift")->where("type !=2")->order("list_order")->select();
        $configpub=getConfigPub();
        $this->assign("giftlist", $giftlist);
        $this->assign("name_coin", $configpub['name_coin']);
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function xydzpeditPost(){
        $data=$this->request->param();
        $id=$data['id'];
        $type=$data['type'];
        $coin=$data['coin'];
        $giftid=$data['giftid'];
        $gift_num=$data['gift_num'];
        $show_win_prob=$data['show_win_prob'];
        $real_win_one=$data['real_win_one'];
        $real_win_ten=$data['real_win_ten'];
        $real_win_hundred=$data['real_win_hundred'];

        $configpub=getConfigPub();
        $name_coin=$configpub['name_coin'];

        if($type==0){
            if($coin<1){
                $this->error("奖励".$name_coin."数量错误");
            }

            $data['giftid']=0;
            $data['gift_num']=0;
        }

        if($type==1){

            $data['coin']=0;

            if(!$giftid){
                $this->error("请选择礼物");
            }

            if($gift_num<1){
                $this->error("礼物数量错误");
            }

            $info = Db::name("xydzp_gift")->where(['giftid'=>$giftid])->where("id <> {$id}")->find();

            if($info){
                $this->error("礼物奖品已存在");
            }
        }

        if(!$show_win_prob){
            $this->error("请填写展示中奖概率区间值");
        }

        //
        if(!$real_win_one){
            $this->error("请填写单击实际中奖概率");
        }

        if($real_win_one<0){
            $this->error("单击实际中奖概率错误");
        }

        

        //
        if(!$real_win_ten){
            $this->error("请填写10连击实际中奖概率");
        }

        if($real_win_ten<0){
            $this->error("10连击实际中奖概率错误");
        }


        //
        if(!$real_win_hundred){
            $this->error("请填写100连击实际中奖概率");
        }

        if($real_win_hundred<0){
            $this->error("100连击实际中奖概率错误");
        }


        $data['edittime']=time();

        $res = Db::name("xydzp_gift")->update($data);

        if($res===false){
            $this->error("保存失败");
        }

        $this->success("保存成功");
    }

    //获取星球类型
    private function getStarType($k=''){
        $type=[
            'twx'=>'天王星',
            'mwx'=>'冥王星',
            'hwx'=>'海王星',
        ];

        if($k===''){
            return $type;
        }

        return isset($type[$k]) ? $type[$k]: '';
    }

    //获取幸运大转盘点击类型
    private function getBtnType($k=''){
        $type=[
            'one'=>'单击',
            'ten'=>'10连击',
            'hundred'=>'100连击',
        ];

        if($k===''){
            return $type;
        }

        return isset($type[$k]) ? $type[$k]: '';
    }

    //星球探宝中奖记录
    public function xqtbwinlist(){
        $data = $this->request->param();
        $map=[];

        $start_time=isset($data['start_time']) ? $data['start_time']: '';
        $end_time=isset($data['end_time']) ? $data['end_time']: '';
        
        if($start_time!=""){
           $map[]=['addtime','>=',strtotime($start_time)];
        }

        if($end_time!=""){
           $map[]=['addtime','<=',strtotime($end_time) + 60*60*24];
        }
        
        $uid=isset($data['uid']) ? $data['uid']: '';
        if($uid!=''){
            $map[]=['uid','=',$uid];
        }

        $liveuid=isset($data['liveuid']) ? $data['liveuid']: '';
        if($liveuid!=''){
            $map[]=['liveuid','=',$liveuid];
        }

        $lists = Db::name("xqtb_win_list")
                ->where($map)
                ->order("id DESC")
                ->paginate(20);

        $configpub=getConfigPub();
        $name_coin=$configpub['name_coin'];

        $lists->each(function($v,$k) use ($name_coin){
            $v['userinfo']=getUserInfo($v['uid']);
            $v['liveinfo']=getUserInfo($v['liveuid']);
            $v['star_type']=$this->getStarType($v['star_type']);
            $v['addtime']=date('Y-m-d H:i',$v['addtime']);
            $gift_list = json_decode($v['gift_list'],true);
            foreach ($gift_list as $k1 => $v1) {
                if($v1['type']=='coin'){
                    $v1['giftname']=$name_coin;
                    $v1['gifticon']=get_upload_path('/static/app/game/coin.png');
                }else{
                    $v1['gifticon']=get_upload_path($v1['gifticon']);
                }

                $gift_list[$k1]=$v1;
            }
            $v['gift_list']=$gift_list;
            return $v;           
        });


        $lists->appends($data);
        $page = $lists->render();

        $this->assign('lists', $lists);
        $this->assign("page", $page);
        $this->assign("name_coin", $name_coin);
        return $this->fetch();
    }

    //幸运大转盘中奖记录
    public function xydzpwinlist(){
        $data = $this->request->param();
        $map=[];

        $start_time=isset($data['start_time']) ? $data['start_time']: '';
        $end_time=isset($data['end_time']) ? $data['end_time']: '';
        
        if($start_time!=""){
           $map[]=['addtime','>=',strtotime($start_time)];
        }

        if($end_time!=""){
           $map[]=['addtime','<=',strtotime($end_time) + 60*60*24];
        }
        
        $uid=isset($data['uid']) ? $data['uid']: '';
        if($uid!=''){
            $map[]=['uid','=',$uid];
        }

        $liveuid=isset($data['liveuid']) ? $data['liveuid']: '';
        if($liveuid!=''){
            $map[]=['liveuid','=',$liveuid];
        }

        $lists = Db::name("xydzp_win_list")
                ->where($map)
                ->order("id DESC")
                ->paginate(20);

        $configpub=getConfigPub();
        $name_coin=$configpub['name_coin'];

        $lists->each(function($v,$k) use ($name_coin){
            $v['userinfo']=getUserInfo($v['uid']);
            $v['liveinfo']=getUserInfo($v['liveuid']);
            $v['btn_type']=$this->getBtnType($v['btn_type']);
            $v['addtime']=date('Y-m-d H:i',$v['addtime']);
            $gift_list = json_decode($v['gift_list'],true);
            foreach ($gift_list as $k1 => $v1) {
                if($v1['type']=='coin'){
                    $v1['giftname']=$name_coin;
                    $v1['gifticon']=get_upload_path('/static/app/game/coin.png');
                }else{
                    $v1['gifticon']=get_upload_path($v1['gifticon']);
                }

                $gift_list[$k1]=$v1;
            }
            $v['gift_list']=$gift_list;
            return $v;           
        });


        $lists->appends($data);
        $page = $lists->render();

        $this->assign('lists', $lists);
        $this->assign("page", $page);
        $this->assign("name_coin", $name_coin);
        return $this->fetch();
    }

		
}
