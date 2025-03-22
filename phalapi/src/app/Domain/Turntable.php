<?php
namespace App\Domain;
use App\Model\Turntable as Model_Turntable;
use App\Domain\Live as Domain_Live;
use App\Domain\Backpack as Domain_Backpack;

class Turntable {
    
    /* 价格配置 */
    public function getConfig(){
        
        $key='turntable_con';
		$list=\App\getcaches($key);
		if(!$list){
			$model = new Model_Turntable();
            $list = $model->getConfig();
            if($list){
                \App\setcaches($key,$list);
            }
						 
		}
        return $list;
    }
    
    /* 奖品规则 */
    public function getTurntables(){
        
        $key='turntable';
		$list=\App\getcaches($key);
		if(!$list){
			$model = new Model_Turntable();
            $list = $model->getTurntables();
            if($list){
                \App\setcaches($key,$list);
            }
					 
		}
        return $list;
    }
    
    
    /* 奖品列表 */
    public function getTurntable($live_type){
        
        $domain = new Domain_Live();
        $giftlist=$domain->getGiftList($live_type);

		$list=$this->getTurntables();

        //语言包
        $language=\PhalApi\DI()->language;
        
        foreach($list as $k=>$v){
            unset($v['rate']);
            
            $thumb='';
            
            if($v['type']==3){
                $thumb=\App\get_upload_path($v['thumb']);

                if($language=='en'){
                    $v['type_val']=$v['type_val_en'];
                }
            }
            

            if($v['type']==2){
                foreach($giftlist as $k2=>$v2){
                    if($v['type_val']==$v2['id']){
                        $thumb=$v2['gifticon'];
                        $v['type_val']=$v2['giftname'];
                        break;
                    }
                }
            }
            if($v['type']==1){
                $thumb=\App\get_upload_path('/static/app/pay/coin.png');
            }
            $v['thumb']=$thumb;

            if($v['type']==0){
                $v['type_val']=\PhalApi\T('再接再厉');
            }
            $list[$k]=$v;
        }

        return $list;
    }
    
    
    /* 转奖 */
	public function turn($uid,$id,$liveuid,$stream) {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
        
        
        $turntable_con=$this->getConfig();
        
        $times=0;
        $total=0;
        
        foreach($turntable_con as $k=>$v){
            if($v['id']==$id){
                $times=$v['times'];
                $total=$v['coin'];
                break;
            }
        }
        
        if($times<=0){
            $rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('信息错误');
			return $rs;
        }
        
        if($total<=0){
            $rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('信息错误');
			return $rs;
        }
        
        /* 更新用户余额 消费 */
		$ifok =\PhalApi\DI()->notorm->user
				->where('id = ? and coin >=?', $uid,$total)
				->update(array('coin' => new \NotORM_Literal("coin - {$total}"),'consumption' => new \NotORM_Literal("consumption + {$total}") ) );
        
        if(!$ifok){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('余额不足');
			return $rs;
        }
        
        $showid=0;
        if($stream!=''){
            $stream_a=explode('_',$stream);
            $showid=isset($stream_a[1])?$stream_a[1]:0;
        }
        
        $nowtime=time();
        
        $insert=array("type"=>'0',"action"=>'16',"uid"=>$uid,"touid"=>$uid,"giftid"=>0,"giftcount"=>$times,"totalcoin"=>$total,"addtime"=>$nowtime );
        
		\PhalApi\DI()->notorm->user_coinrecord->insert($insert);
        
        $model = new Model_Turntable();
        
        /* 转盘记录 */
        $insert2=array("uid"=>$uid,"liveuid"=>$liveuid,"showid"=>$showid,"coin"=>$total,"nums"=>$times,"addtime"=>$nowtime );
        
		$log=$model->setlog($insert2);
        
        $logid=$log['id'];
        
        $domain_pack = new Domain_Backpack();
        
        $live_type=\App\getLiveType($liveuid,$stream);
        $domain = new Domain_Live();
        $giftlist=$domain->getGiftList($live_type);
        
        
        $configpub=\App\getConfigPub();
        
        $list=$this->getTurntables();
        
        $win_list=[];

        //语言包
        $language=\PhalApi\DI()->language;
        
        for($i=0;$i<$times;$i++){
            $win=rand(1,100*1000);
            $rate=0;
            foreach($list as $k=>$v){
                if($v['type']!=0){
                    $rate+=$v['rate']*1000;
                    
                    if($win <= $rate){
                        if(isset($win_list[$v['id']])){
                            $win_list[$v['id']]['nums']++;
                        }else{
                            $data=[
                                'id'=>$v['id'],
                                'type'=>$v['type'],
                                'type_val'=>$v['type_val'],
                                'name'=>'',
                                'thumb'=>'',
                                'nums'=>'1',
                            ];
                            if($v['type']==1){
                                $data['name']=$configpub['name_coin'].$v['type_val'];
                                $data['thumb']='/static/app/pay/coin.png';
                            }
                            
                            if($v['type']==2){
                                foreach($giftlist as $k2=>$v2){
                                    if($v['type_val']==$v2['id']){
                                        $data['name']=$v2['giftname'];
                                        $data['thumb']=$v2['gifticon'];
                                    }
                                }
                            }
                            
                            if($v['type']==3){
                                if($language=='en'){
                                    $data['name']=$v['type_val_en'];
                                }else{
                                    $data['name']=$v['type_val'];
                                }
                                
                                $data['thumb']=$v['thumb'];
                            }
                            
                            $win_list[$v['id']]=$data;
                        }
                        break;
                    }
                }
            }
            
        }
        
        $win_list=array_values($win_list);
        
        if($win_list){
            $model->uplogwin($logid,1);
        }
        
        /* 写入中奖纪录 */
        foreach($win_list as $k=>$v){

            $data=[
                'logid'=>$logid,
                'uid'=>$uid,
                'type'=>$v['type'],
                'type_val'=>$v['type_val'],
                'nums'=>$v['nums'],
                'addtime'=>$nowtime,
            ];
            if($v['type']==3){
                /* 线下奖品 */
                $data['thumb']=$v['thumb'];
            }
            $model->setWin($data);
            
            if($v['type']==1){
                /* 钻石奖品 添加余额 */
                $win_coin=$v['type_val'] * $v['nums'];
                \PhalApi\DI()->notorm->user
                    ->where('id = ?', $uid)
                    ->update(array('coin' => new \NotORM_Literal("coin + {$win_coin}") ) );
                $insert=array("type"=>'1',"action"=>'17',"uid"=>$uid,"touid"=>$uid,"giftid"=>0,"giftcount"=>1,"totalcoin"=>$win_coin,"showid"=>$showid,"addtime"=>$nowtime );
                \PhalApi\DI()->notorm->user_coinrecord->insert($insert);
            }
            
            if($v['type']==2){
                /* 礼物放进背包 */
                $domain_pack->addBackpack($uid,$v['type_val'],$v['nums']);
            }
            
            unset($v['type']);
            unset($v['type_val']);
            
            $v['thumb']=\App\get_upload_path($v['thumb']);
            
            $win_list[$k]=$v;
        }
        
        /* 余额 */
        $userinfo2 =\PhalApi\DI()->notorm->user
				->select('consumption,coin')
				->where('id = ?', $uid)
				->fetchOne();

        $userinfo=\App\getUserInfo($uid);
        
        $rs['info'][0]['coin']=$userinfo2['coin'];
        $rs['info'][0]['level']=$userinfo['level'];
        $rs['info'][0]['level_anchor']=$userinfo['level_anchor'];
        $rs['info'][0]['list']=$win_list;
		return $rs;
	}

    /* 中奖记录 */
    public function getWin($uid,$p,$live_type){
        
        $domain = new Domain_Live();
        $giftlist=$domain->getGiftList($live_type);
        
		$model = new Model_Turntable();
        $list = $model->getWin($uid,$p);
        
        foreach($list as $k=>$v){
            $v['addtime']=date('Y-m-d H:i',$v['addtime']);
            $thumb='';
            if($v['type']==3){
                $thumb=\App\get_upload_path($v['thumb']);
            }
            
            if($v['type']==2){
                foreach($giftlist as $k2=>$v2){
                    if($v['type_val']==$v2['id']){
                        $thumb=$v2['gifticon'];
                        break;
                    }
                }
            }
            if($v['type']==1){
                $v['nums']=$v['type_val'] * $v['nums'];
                $thumb=\App\get_upload_path('/static/app/pay/coin.png');
            }
            
            $v['thumb']=$thumb;
            
            $list[$k]=$v;
        }

        return $list;
    }
}
