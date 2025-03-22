<?php
namespace App\Domain;
use App\Model\Game as Model_Game;
use App\Model\Backpack as Model_Backpack;

class Game {

	public function record($liveuid,$stream,$action,$time,$result,$bankerid=0,$bankercrad='') {
		$rs = array();
		$model = new Model_Game();
		$rs = $model->record($liveuid,$stream,$action,$time,$result,$bankerid,$bankercrad);
		return $rs;
	}
	public function endGame($liveuid,$gameid,$type,$ifset) {
		$rs = array();
		$model = new Model_Game();
		$rs = $model->endGame($liveuid,$gameid,$type,$ifset);
		return $rs;
  }
	public function gameBet($uid,$gameid,$coin,$action,$grade)
	{
		$rs = array();
		$model = new Model_Game();
		$rs = $model->gameBet($uid,$gameid,$coin,$action,$grade);
		return $rs;
	}
	public function settleGame($uid,$gameid)
	{
		$rs = array();
		$model = new Model_Game();
		$rs = $model->settleGame($uid,$gameid);
		return $rs;
	}
	public function checkGame($liveuid,$stream,$uid)
	{
		$rs = array();
		$model = new Model_Game();
		$rs = $model->checkGame($liveuid,$stream,$uid);
		return $rs;
	}

	public function getGameRecord($action,$stream)
	{
		$rs = array();
		$model = new Model_Game();
		$rs = $model->getGameRecord($action,$stream);
		return $rs;
	}

	public function getBankerProfit($bankerid,$action,$stream)
	{
		$rs = array();
		$model = new Model_Game();
		$rs = $model->getBankerProfit($bankerid,$action,$stream);
		return $rs;
	}

	public function getBanker($stream)
	{
		$rs = array();
		$model = new Model_Game();
		$rs = $model->getBanker($stream);
		return $rs;
	}

	public function setBanker($uid)
	{
		$rs = array();
		$model = new Model_Game();
		$rs = $model->setBanker($uid);
		return $rs;
	}

	public function setDeposit($uid,$deposit)
	{
		$rs = array();
		$model = new Model_Game();
		$rs = $model->setDeposit($uid,$deposit);
		return $rs;
	}

	public function quietBanker($uid,$data)
	{
		$rs = array();
		$model = new Model_Game();
		$rs = $model->quietBanker($uid,$data);
		return $rs;
	}
	
	
	
	//星球探宝玩游戏
	public function xqtbPlay($uid,$liveuid,$stream,$type,$nums) {
		$rs = array('code'=>0,'msg'=>'','info'=>array());

        $stream_arr=explode('_', $stream);
        $showid=$stream_arr[1];

        $configpri=\App\getConfigPri();
        $price=0;
        if($type==1){
            $price=$configpri['xqtb_mwx_price'];
        }else if($type==2){
            $price=$configpri['xqtb_twx_price'];
        }else if($type==3){
            $price=$configpri['xqtb_hwx_price'];
        }

        //获取星球探宝礼物列表
        $model = new Model_Game();
        $giftlist=$model->getGiftList('xqtb');

        if(!$giftlist){
            $rs['code']=1003;
            $rs['msg']=\Phalapi\T('暂无中奖礼物，请稍后再试');
            return $rs;
        }

        $spend_total=$price*$nums;

        if($spend_total){
            //扣除用户钻石
            $res = \App\upCoin($uid,$spend_total);
            if(!$res){
                $rs['code']=1004;
                $rs['msg']=\Phalapi\T('您的余额不足,请先去充值');
                return $rs;
            }

            //添加钻石消费记录
            $data=array(
                'type'=>0,
                'action'=>22, //星球探宝下注
                'uid'=>$uid,
                'touid'=>$liveuid,
                'giftid'=>0,
                'giftcount'=>1,
                'totalcoin'=>$spend_total,
                'addtime'=>time(),
                'showid'=>$showid
            );
            \App\addCoinRecord($data);
        }

        $options=[];
        
        for ($i=0; $i <$nums; $i++) {

            $arr=[];
            foreach ($giftlist as $k => $v) {

                //冥王星
                if($type==1){
                    $rate_num=$v['real_win_mwx'];
                }

                //天王星
                if($type==2){
                    $rate_num=$v['real_win_twx'];
                }

                //海王星
                if($type==3){
                    $rate_num=$v['real_win_hwx'];
                }

                $arr[$k]=floor($rate_num*100);
                
            }


            $rid = $this->get_rand($arr); //根据概率获取数组下标

            if($rid !=''){
                $gift_ok=$giftlist[$rid]; //根据礼物列表下标获取奖项信息

                if($gift_ok){
                    $options[]=$gift_ok['id']; //保存奖项记录id
                }                  
            } 
        }



        $user_coin=\App\getUserCoin($uid);

        if(empty($options)){
            $rs['msg']=\Phalapi\T("抱歉,您本次未中奖");
            $rs['info'][0]['gift_list']=[];
            $rs['info'][0]['coin']=$user_coin['coin'];
            return $rs;
        }  


        //获取数组中礼物id重复出现次数
        $options_ids=array_count_values($options);

        $configpub=\App\getCoinName();
        $name_coin=$configpub['name_coin'];
        $name_coin_en=$configpub['name_coin_en'];

        $win_giftlist=[];
        $gift_json=[];
        $win_total=0;

        //语言包
        $fields="id,giftname,giftname_en,gifticon,needcoin";

        $language=\Phalapi\DI()->language;

        foreach ($options_ids as $k => $v) {

            //$k记录id
            //$v数目
            $xqtb_gift=$model->getXqtbGift($k);

            if($xqtb_gift){

                $xqtb_gift_type=$xqtb_gift['type'];

                //////中奖项目为钻石//////
                if($xqtb_gift_type==0){

                    $win_coin=$v*$xqtb_gift['coin'];

                    //给用户增加钻石
                    \App\addCoin($uid,$win_coin,1);

                    //写入钻石记录
                    $coin_record=[
                        'type'=>1, //收入
                        'action'=>23,//星球探宝中奖钻石
                        'uid'=>$uid,
                        'touid'=>$liveuid,
                        'giftid'=>0,
                        'giftcount'=>$v,
                        'totalcoin'=>$win_coin,
                        'addtime'=>time(),
                        'showid'=>$showid
                    ];

                    \App\addCoinRecord($coin_record);

                    $gift_json[]=array(
                        'type'=>'coin',
                        'id'=>0,
                        'giftname'=>'',
                        'gifticon'=>'',
                        'needcoin'=>$xqtb_gift['coin'],
                        'nums'=>$v
                    );

                    $giftinfo=[
                        'id'=>'0',
                        'type'=>'coin',
                        'giftname'=>$name_coin,
                        'giftname_en'=>$name_coin_en,
                        'gifticon'=>\App\get_upload_path('/static/app/game/coin.png'),
                        'needcoin'=>(string)$xqtb_gift['coin'],
                        'nums'=>"x".$v,
                        'total'=>(string)$win_coin,
                        'coin_img'=>\App\get_upload_path('/static/app/game/coin.png'),
                    ];
                    $win_giftlist[]=$giftinfo;

                    $win_total+=$win_coin;


                }else{ //////中奖项目为礼物//////

                    $giftid=$xqtb_gift['giftid'];
                    $win_num=$v*$xqtb_gift['gift_num'];
                    $giftinfo=\App\getGiftInfo($giftid,$fields);
                    $giftinfo['id']=(string)$giftinfo['id'];
                    $giftinfo['needcoin']=(string)$giftinfo['needcoin'];
                    $giftinfo['nums']="x".$win_num;
                    $win_coin=$win_num*$giftinfo['needcoin'];
                    $giftinfo['total']=(string)($win_coin);
                    $giftinfo['coin_img']=\App\get_upload_path('/static/app/game/coin.png');
                    $giftinfo['type']='gift';

                    
                    $win_giftlist[]=$giftinfo;
                    $win_total+=$win_coin;

                    $gift_json[]=array(
                        'type'=>'gift',
                        'id'=>$giftid,
                        'giftname'=>$giftinfo['giftname'],
                        'gifticon'=>$giftinfo['thumb'],
                        'needcoin'=>(string)$giftinfo['needcoin'],
                        'nums'=>(string)$win_num
                    );

                    //添加到背包中
                    $model_backpack=new Model_Backpack();
                    $model_backpack->addBackPack($uid,$giftid,$win_num);

                }


            }

        }

        if($type==1){
            $star_type='mwx';
        }else if($type==2){
            $star_type='twx';
        }else if($type==3){
            $star_type='hwx';
        }

        //写入获奖记录
        $win_record=[
            'uid'=>$uid,
            'liveuid'=>$liveuid,
            'stream'=>$stream,
            'star_type'=>$star_type,
            'spend_coin'=>$spend_total,
            'win_coin'=>$win_total,
            'nums'=>$nums,
            'gift_list'=>json_encode($gift_json),
            'addtime'=>time()
        ];

        $model->addWinList('xqtb',$win_record);

        //更新用户星球探宝总中奖数
        $model->updateXqtbTotal($uid,$win_total);

        $rs['info'][0]['gift_list']=$win_giftlist;

        $rs['info'][0]['coin']=(string)$user_coin['coin'];
   
        return $rs;
            

	}

    //获取星球探宝中奖记录
    public function getXqtbWinList($uid,$p){
        $rs = array('code'=>0,'msg'=>'','info'=>array());
        $model = new Model_Game();
        $list = $model->getXqtbWinList($uid,$p);

        if(!empty($list)){

            foreach ($list as $k => $v) {

                $list[$k]['title']=\Phalapi\T('寻宝{num}次',['num'=>$v['nums']]);
                $list[$k]['addtime']=date("Y-m-d H:i",$v['addtime']);
                $gift_list = json_decode($v['gift_list'],true);

                foreach ($gift_list as $k1 => $v1) {
                    if($v1['type']=='gift'){
                        $gift_list[$k1]['gifticon']=\App\get_upload_path($v1['gifticon']);
                    }else{
                        $gift_list[$k1]['gifticon']=\App\get_upload_path('/static/app/game/coin.png');   
                    }
                    

                    if($v1['type']=='coin'){
                        $nums=$v1['needcoin'].'x'.$v1['nums'];
                    }else{
                        $nums='x'.$v1['nums']; 
                    }

                    $gift_list[$k1]['nums']=$nums;

                    unset($gift_list[$k1]['id']);
                    unset($gift_list[$k1]['giftname']);
                }
                $list[$k]['gift_list']=$gift_list;
                unset($list[$k]['nums']);
            }

            $rs['info'][0]['list']=$list;
        }else{
            $rs['msg']=\Phalapi\T('暂无中奖记录');
        }

        return $rs;
    }

    //获取星球探宝排行榜
    public function getXqtbTotalList($uid){
        $rs = array('code'=>0,'msg'=>'','info'=>array());
        $model = new Model_Game();
        $list = $model->getXqtbTotalList();

        $coin_img=\App\get_upload_path('/static/app/game/coin.png');

        foreach ($list as $k => $v) {
            $userinfo = \App\getUserInfo($v['uid']);
            $list[$k]['user_nickname']=$userinfo['user_nickname'];
            $list[$k]['avatar']=$userinfo['avatar'];
            $list[$k]['coin_img']=$coin_img;
            $list[$k]['total']=\App\NumberFormat($v['total']);
            unset($list[$k]['id']);
        }

        

        $userinfo = \App\getUserInfo($uid);
        $user_total = $model->getXqtbTotal($uid);

        if($user_total>0){
            $uids = array_column($list, 'uid');

            if(in_array($uid, $uids)){
                $current_num=array_search($uid,$uids)+1;
            }else{
                $current_num='100+';
            }

        }else{
            $current_num=\Phalapi\T('未上榜');
        }

        $current=[
            'num'=>(string)$current_num,
            'user_nickname'=>$userinfo['user_nickname'],
            'avatar'=>$userinfo['avatar'],
            'coin_img'=>$coin_img
        ];

        if($user_total>0){
            $current['total']=\App\NumberFormat($user_total);
        }else{ //未参与游戏
             $current['total']='0';
        }

        

        $rs['info'][0]['list']=$list;
        $rs['info'][0]['current']=$current;
        return $rs;
    }

    //获取星球探宝滚动中奖信息
    public function getXqtbRandList(){
        $model = new Model_Game();
        $info = $model->getXqtbRandList();

        $win_list=[];

        if(!empty($info)){
            
            $win_list=$this->giftListFormat($info);

        }else{ //随机获取
            $win_list=$this->getRandWinList();
        }
        
        return $win_list;
        
    }

    //获取幸运大转盘礼物列表
    public function getXydzpGiftList(){
        
        $model = new Model_Game();
        $giftlist=$model->getGiftList('xydzp');

        if(!$giftlist){
            return 1001;
        }

        $list=[];

        foreach ($giftlist as $k => $v) {
            if($v['type']==0){
                $list[]=[
                    'id'=>'0',
                    'type'=>'coin',
                    'nums'=>$v['coin'],
                    'gifticon'=>\App\get_upload_path('/static/app/game/coin.png')
                ];

            }else{
                $giftinfo = \App\getGiftInfo($v['giftid'],'gifticon');
                $list[]=[
                    'id'=>$v['giftid'],
                    'type'=>'gift',
                    'nums'=>$v['gift_num'],
                    'gifticon'=>$giftinfo['gifticon']
                ];
            }

            
        }
        return $list;
    }


    //获取幸运大转盘滚动中奖信息
    public function getXydzpRandList(){
        $model = new Model_Game();
        $info = $model->getXydzpRandList();

        $win_list=[];

        if(!empty($info)){
            
            $win_list=$this->giftListFormat($info);

        }else{ //随机获取
            $win_list=$this->getRandWinList();
        }
        
        return $win_list;
        
    }

    //幸运大转盘玩游戏
    public function xydzpPlay($uid,$liveuid,$stream,$type){
        $rs = array('code'=>0,'msg'=>'','info'=>array());

        $stream_arr=explode('_', $stream);
        $showid=$stream_arr[1];

        $configpri=\App\getConfigPri();
        $nums=0;
        $price=0;
        if($type=='one'){
            $nums=1;
            $price=$configpri['xydzp_one_price'];
        }else if($type=='ten'){
            $nums=10;
            $price=$configpri['xydzp_ten_price'];
        }else if($type=='hundred'){
            $nums=100;
            $price=$configpri['xydzp_hundred_price'];
        }

        //获取幸运大转盘礼物列表
        $model = new Model_Game();
        $giftlist=$model->getGiftList('xydzp');

        if(!$giftlist){
            $rs['code']=1001;
            $rs['msg']=\Phalapi\T('暂无中奖礼物，请稍后再试');
            return $rs;
        }

        if($price){
            //扣除用户钻石
            $res = \App\upCoin($uid,$price);

            if(!$res){
                $rs['code']=1002;
                $rs['msg']=\Phalapi\T('您的余额不足,请先去充值');
                return $rs;
            }

            //添加钻石消费记录
            $data=array(
                'type'=>0,
                'action'=>24, //幸运大转盘下注
                'uid'=>$uid,
                'touid'=>$liveuid,
                'giftid'=>0,
                'giftid'=>1,
                'totalcoin'=>$price,
                'addtime'=>time(),
                'showid'=>$showid
            );
            \App\addCoinRecord($data);
        }

        $options=[];

        for ($i=0; $i <$nums; $i++) {
            $arr=[];
            foreach ($giftlist as $k => $v) {

                //单击
                if($type=='one'){
                    $rate_num=$v['real_win_one'];
                }

                //十连击
                if($type=='ten'){
                    $rate_num=$v['real_win_ten'];
                }

                //100连击
                if($type=='hundred'){
                    $rate_num=$v['real_win_hundred'];
                }

                $arr[$k]=floor($rate_num*100);
            }

            $rid = $this->get_rand($arr); //根据概率获取数组下标

            if($rid !=''){
                $gift_ok=$giftlist[$rid]; //根据礼物列表下标获取奖项信息

                if($gift_ok){
                    $options[]=$gift_ok['id']; //保存奖项记录id
                }                  
            }
        }

        $user_coin=\App\getUserCoin($uid);

        if(empty($options)){
            $rs['msg']=\Phalapi\T("抱歉,您本次未中奖");
            $rs['info'][0]['gift_list']=[];
            $rs['info'][0]['coin']=$user_coin['coin'];
            return $rs;
        }

        
        //获取数组中礼物id重复出现次数
        $options_ids=array_count_values($options);

        $configpub=\App\getCoinName();
        $name_coin=$configpub['name_coin'];
        $name_coin_en=$configpub['name_coin_en'];

        $win_giftlist=[];
        $gift_json=[];
        $win_total=0;

        //语言包
        $fields="id,giftname,giftname_en,gifticon,needcoin";

        $language=\Phalapi\DI()->language;

        foreach ($options_ids as $k => $v) {

            //$k记录id
            //$v数目
            
            $xydzp_gift=$model->getXydzpGift($k);
            if($xydzp_gift){

                $xydzp_gift_type=$xydzp_gift['type'];

                //////中奖项目为钻石//////
                if($xydzp_gift_type==0){

                    $win_coin=$v*$xydzp_gift['coin'];
                    //给用户增加钻石
                    \App\addCoin($uid,$win_coin,1);

                    //写入钻石记录
                    $coin_record=[
                        'type'=>1, //收入
                        'action'=>25,//幸运大转盘中奖钻石
                        'uid'=>$uid,
                        'touid'=>$liveuid,
                        'giftid'=>0,
                        'giftcount'=>$v,
                        'totalcoin'=>$win_coin,
                        'addtime'=>time(),
                        'showid'=>$showid
                    ];

                    \App\addCoinRecord($coin_record);

                    $gift_json[]=array(
                        'type'=>'coin',
                        'id'=>0,
                        'giftname'=>'',
                        'gifticon'=>'',
                        'needcoin'=>$xydzp_gift['coin'],
                        'nums'=>$v
                    );

                    $giftinfo=[
                        'id'=>'0',
                        'type'=>'coin',
                        'giftname'=>$name_coin,
                        'giftname_en'=>$name_coin_en,
                        'gifticon'=>\App\get_upload_path('/static/app/game/coin.png'),
                        'needcoin'=>(string)$xydzp_gift['coin'],
                        'nums'=>"x".$v,
                        'total'=>(string)$win_coin,
                        'coin_img'=>\App\get_upload_path('/static/app/game/coin.png'),
                    ];
                    $win_giftlist[]=$giftinfo;

                    $win_total+=$win_coin;


                }else{ //////中奖项目为礼物//////

                    $giftid=$xydzp_gift['giftid'];
                    $win_num=$v*$xydzp_gift['gift_num'];
                    $giftinfo=\App\getGiftInfo($giftid,$fields);
                    $giftinfo['id']=(string)$giftinfo['id'];
                    $giftinfo['needcoin']=(string)$giftinfo['needcoin'];
                    $giftinfo['nums']="x".$win_num;
                    $win_coin=$win_num*$giftinfo['needcoin'];
                    $giftinfo['total']=(string)($win_coin);
                    $giftinfo['coin_img']=\App\get_upload_path('/static/app/game/coin.png');
                    $giftinfo['type']='gift';


                    $win_giftlist[]=$giftinfo;
                    $win_total+=$win_coin;

                    $gift_json[]=array(
                        'type'=>'gift',
                        'id'=>$giftid,
                        'giftname'=>$giftinfo['giftname'],
                        'gifticon'=>$giftinfo['thumb'],
                        'needcoin'=>(string)$giftinfo['needcoin'],
                        'nums'=>(string)$win_num
                    );

                    //添加到背包中
                    $model_backpack=new Model_Backpack();
                    $model_backpack->addBackPack($uid,$giftid,$win_num);
                }

                
            }
            
        }


        //写入获奖记录
        $win_record=[
            'uid'=>$uid,
            'liveuid'=>$liveuid,
            'stream'=>$stream,
            'btn_type'=>$type,
            'spend_coin'=>$price,
            'win_coin'=>$win_total,
            'gift_list'=>json_encode($gift_json),
            'addtime'=>time()
        ];

        $model->addWinList('xydzp',$win_record);

        //更新用户幸运大转盘总中奖数
        $model->updateXydzpTotal($uid,$win_total);

        $rs['info'][0]['gift_list']=$win_giftlist;
        $rs['info'][0]['coin']=(string)$user_coin['coin'];

        return $rs;
    }


    //获取幸运大转盘中奖记录
    public function getXydzpWinList($uid,$p){
        $rs = array('code'=>0,'msg'=>'','info'=>array());
        $model = new Model_Game();
        $list = $model->getXydzpWinList($uid,$p);

        if(!empty($list)){

            foreach ($list as $k => $v) {

                if($v['btn_type']=='one'){
                    $title=\Phalapi\T('单击');
                }else if($v['btn_type']=='ten'){
                    $title=\Phalapi\T('10连击');
                }else{
                    $title=\Phalapi\T('100连击'); 
                }


                $list[$k]['title']=$title;
                $list[$k]['addtime']=date("Y-m-d H:i",$v['addtime']);
                $gift_list = json_decode($v['gift_list'],true);

                foreach ($gift_list as $k1 => $v1) {
                    if($v1['type']=='gift'){
                        $gift_list[$k1]['gifticon']=\App\get_upload_path($v1['gifticon']);
                    }else{
                        $gift_list[$k1]['gifticon']=\App\get_upload_path('/static/app/game/coin.png');   
                    }
                    

                    if($v1['type']=='coin'){
                        $nums=$v1['needcoin'].'x'.$v1['nums'];
                    }else{
                        $nums='x'.$v1['nums']; 
                    }

                    $gift_list[$k1]['nums']=$nums;

                    unset($gift_list[$k1]['id']);
                    unset($gift_list[$k1]['giftname']);
                }
                $list[$k]['gift_list']=$gift_list;
                unset($list[$k]['btn_type']);
            }

            $rs['info'][0]['list']=$list;
        }else{
            $rs['msg']=\Phalapi\T('暂无中奖记录');
        }

        return $rs;
    }


    //获取幸运大转盘排行榜
    public function getXydzpTotalList($uid){
        $rs = array('code'=>0,'msg'=>'','info'=>array());
        $model = new Model_Game();
        $list = $model->getXydzpTotalList();

        $coin_img=\App\get_upload_path('/static/app/game/coin.png');

        foreach ($list as $k => $v) {
            $userinfo = \App\getUserInfo($v['uid']);
            $list[$k]['user_nickname']=$userinfo['user_nickname'];
            $list[$k]['avatar']=$userinfo['avatar'];
            $list[$k]['coin_img']=$coin_img;
            $list[$k]['total']=\App\NumberFormat($v['total']);
            unset($list[$k]['id']);
        }

        

        $userinfo = \App\getUserInfo($uid);
        $user_total = $model->getXydzpTotal($uid);

        if($user_total>0){
            $uids = array_column($list, 'uid');

            if(in_array($uid, $uids)){
                $current_num=array_search($uid,$uids)+1;
            }else{
                $current_num='100+';
            }

        }else{
            $current_num=\Phalapi\T('未上榜');
        }

        $current=[
            'num'=>(string)$current_num,
            'user_nickname'=>$userinfo['user_nickname'],
            'avatar'=>$userinfo['avatar'],
            'coin_img'=>$coin_img
        ];

        if($user_total>0){
            $current['total']=\App\NumberFormat($user_total);
        }else{ //未参与游戏
             $current['total']='0';
        }

        $rs['info'][0]['list']=$list;
        $rs['info'][0]['current']=$current;
        return $rs;
    }


    //计算中奖概率
    private function get_rand($arr) {
        $res = '';

        //file_put_contents("game.txt", "传入arr:".json_encode($arr)."\r\n",FILE_APPEND);

        //总概率精度
        $sum = array_sum($arr);
        //file_put_contents("game.txt", "sum:".$sum."\r\n",FILE_APPEND);
        
        //打乱数组顺序
        shuffle($arr);

        //file_put_contents("game.txt", "打乱后arr:".json_encode($arr)."\r\n",FILE_APPEND);
  
        foreach ($arr as $k => $v) {
            $rand_num = mt_rand(1, $sum);  //返回随机整数
            //file_put_contents("game.txt", "下标:".$k."\r\n",FILE_APPEND);
            //file_put_contents("game.txt", "变量v的值:".$v."\r\n",FILE_APPEND);
            //file_put_contents("game.txt", "随机数:".$rand_num."\r\n",FILE_APPEND);
            
            
            if ($rand_num <= $v) {
                //file_put_contents("game.txt", "随机数<变量v,获取到的值:".$k."\r\n",FILE_APPEND);
                $res = $k;
                break;
            } else {
                $sum -= $v;
                //file_put_contents("game.txt", "剩余sum:".$sum."\r\n",FILE_APPEND);
            }
        }
        unset($arr);
        //file_put_contents("game.txt", "返回结果:".$res."\r\n",FILE_APPEND);
        return $res;
    }

    //用户昵称格式化
    private function nicknameFormat($str){

        if($str){
            $username_len = mb_strlen($str);

            if($username_len<3){
                $username_len=3;
            }

            if($username_len>6){
                $username_len=6;
            }

            $replace_str = str_repeat("*",$username_len-1);

            $user_nickname = mb_substr($str,0,1).$replace_str;
        }else{
            $user_nickname='***';
        }
        

        return $user_nickname;
    }

    //中奖礼物列表格式化
    private function giftListFormat($arr){

        $win_list=[];

        $configpub=\App\getConfigPub();
        $name_coin=$configpub['name_coin'];

        foreach ($arr as $k => $v) {

            $userinfo=\App\getUserInfo($v['uid']);
            
            $user_nickname = $this->nicknameFormat($userinfo['user_nickname']);
            $gift_list=json_decode($v['gift_list'],true);

            foreach ($gift_list as $k1 => $v1) {

                if($v1['type']=='gift'){
                    $win_info=[
                        'gifticon'=>\App\get_upload_path($v1['gifticon']),
                        'title'=>\Phalapi\T('恭喜 {user}获得{giftname}x{num}',['user'=>$user_nickname,'giftname'=>$v1['giftname'],'num'=>$v1['nums']])
                    ];
                }else{
                    $win_info=[
                        'gifticon'=>\App\get_upload_path('/static/app/game/coin.png'),
                        'title'=>\Phalapi\T('恭喜 {user}获得{giftname}x{num}',['user'=>$user_nickname,'giftname'=>$name_coin,'num'=>$v1['nums']])
                    ];
                }
                

                $win_list[]=$win_info;
            }
            
        }

        return $win_list;
    }

    //随机用户获取中奖礼物
    private function getRandWinList(){
        $win_list=[];
        $model = new Model_Game();
        $user_list = $model->getUserRandList();
        foreach ($user_list as $k => $v) {
            $user_nickname = $this->nicknameFormat($v['user_nickname']);
            $gift_info=$model->getGiftRand();
            $win_info=[
                'gifticon'=>\App\get_upload_path($gift_info['gifticon']),
                'title'=>\Phalapi\T('恭喜 {user}获得{giftname}x{num}',['user'=>$user_nickname,'giftname'=>$gift_info['giftname'],'num'=>rand(1,5)])
            ];

            $win_list[]=$win_info;
        }

        return $win_list;
    }
}