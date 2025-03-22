<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\Game as Domain_Game;
/**
 * 游戏
 */
class Game extends Api {
	public function getRules() {
		return array(
			'settleGame' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'gameid' => array('name' => 'gameid', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '游戏ID'),
			),
			'checkGame' => array(
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '流名'),
			),
			/* 智勇三张 */
			'Jinhua' => array(
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '流名'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => 'token'),
			),
			'endGame' => array(
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'gameid' => array('name' => 'gameid', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '游戏ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => 'token'),
				'type' => array('name' => 'type', 'type' => 'string', 'min' => 0, 'require' => true, 'desc' => '结束类型，1为正常结束，2为主播关闭，3为意外断开'),
				'ifset' => array('name' => 'ifset', 'type' => 'int', 'default'=>0,'desc' => '是否设置'),
			),
			'JinhuaBet' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'gameid' => array('name' => 'gameid', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '游戏ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => 'token'),
				'coin'=>array('name' => 'coin', 'type' => 'string', 'min' => 0, 'require' => true, 'desc' => '下注金额'),
				'grade'=>array('name' => 'grade', 'type' => 'string', 'min' => 0, 'require' => true, 'desc' => '下注位置，1,2,3'),
			),
			
			/* 转盘 */
			'Dial' => array(
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '流名'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => 'token'),
			),
			'Dial_end' => array(
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'gameid' => array('name' => 'gameid', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '游戏ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => 'token'),
				'type' => array('name' => 'type', 'type' => 'string', 'min' => 0, 'require' => true, 'desc' => '结束类型，1为正常结束，2为主播关闭，3为意外断开'),
				'ifset' => array('name' => 'ifset', 'type' => 'int', 'default'=>0,'desc' => '是否设置'),
			),
			'Dial_Bet' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'gameid' => array('name' => 'gameid', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '游戏ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => 'token'),
				'coin'=>array('name' => 'coin', 'type' => 'string', 'min' => 0, 'require' => true, 'desc' => '下注金额'),
				'grade'=>array('name' => 'grade', 'type' => 'string', 'min' => 0, 'require' => true, 'desc' => '下注位置，1,2,3,4,5,6'),
			),
			
			
			'getGameRecord' => array(
				'action' => array('name' => 'action', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '游戏类别'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '流名'),
			),
			'getBankerProfit' => array(
				'bankerid' => array('name' => 'bankerid', 'type' => 'int', 'require' => true, 'desc' => '庄家ID'),
				/* 'action' => array('name' => 'action', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '游戏类别'), */
				'stream' => array('name' => 'stream', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '流名'),
			),
			
			'getBanker' => array(
				'stream' => array('name' => 'stream', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '流名'),
			),
			
			'setBanker' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户token'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '流名'),
				'deposit' => array('name' => 'deposit', 'type' => 'string', 'desc' => '押金'),
			),
			
			'quietBanker' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '流名'),
			),
			
			
			'getXqtbRandList' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户token'),
			
			),
			'xqtbPlay' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'desc' => '主播用户id'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'desc' => '房间流名'),
				'type' => array('name' => 'type', 'type' => 'int',  'desc' => '星球类型 1 冥王星 2 天王星 3 海王星'),
				'nums' => array('name' => 'nums', 'type' => 'int', 'desc' => '寻宝次数 1 10 50'),
			),
			'getXqtbWinList'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户token'),
				'p' => array('name' => 'p', 'type' => 'int','default'=>1, 'desc' => '页码'),
			),
			'getXqtbTotalList'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户token'),

			),
			'getXydzpRandList'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户token'),

			),

			'xydzpPlay'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'desc' => '主播用户id'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'desc' => '房间流名'),
				'type' => array('name' => 'type', 'type' => 'string',  'desc' => '点击类型 one 单击 ten 十连击 hundred 100连击'),
			),

			'getXydzpWinList'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户token'),
				'p' => array('name' => 'p', 'type' => 'int','default'=>1, 'desc' => '页码'),
			),
			
			'getXydzpTotalList'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户token'),
			),
			
		);
	}
    /**
     * 游戏结算
     * @desc 用于游戏结算
     * @return int code 操作码，0表示成功
     * @return array info[0] 
     * @return string info[0].gamecoin 用户中奖金额
     * @return string info[0].coin 用户余额
     * @return string info[0].banker_profit 庄家收益
     * @return string info[0].isshow 是否显示自动下庄通知，0表示不显示，1表示显示

     * @return string msg 提示信息
     */
	public function settleGame(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$gameid=\App\checkNull($this->gameid);
		$domain = new Domain_Game();
		$settleGame=$domain->settleGame($uid,$gameid);
		if($settleGame==1000){
			$rs['code'] = 1000;
			$rs['msg'] = \PhalApi\T('游戏信息不存在');
			return $rs;
		}

		$rs['info'][0]=$settleGame;
		return $rs;
	}

    /**
     * 检测游戏状态
     * @desc 用于检测游戏状态
     * @return int code 操作码，0表示成功
     * @return array info[0] 
     * @return string info[0].gamecoin 用户中奖金额
     * @return string info[0].coin 用户余额
     * @return string msg 提示信息
     */
	public function checkGame(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$liveuid=\App\checkNull($this->liveuid);
		$stream=\App\checkNull($this->stream);
		
		$domain = new Domain_Game();
		$info=$domain->checkGame($liveuid,$stream);
		return $rs;
	}
	
    /**
     * 智勇三张游戏开启
     * @desc 用于智勇三张游戏开启
     * @return int code 操作码，0表示成功
     * @return array info 
     * @return string info[0].time 倒计时间
     * @return string info[0].Jinhuatoken 游戏token
     * @return string info[0].gameid 游戏记录ID
     * @return string msg 提示信息
     */
	public function Jinhua() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$liveuid=\App\checkNull($this->liveuid);
		$stream=\App\checkNull($this->stream);
		$token=\App\checkNull($this->token);
        
        if($liveuid<1 || $token=='' || $stream==''){
            $rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('信息错误');
			return $rs;
        }
        
        $checkToken=\App\checkToken($liveuid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
        
        $domain = new Domain_Game();
		$info=$this->Jinhua_info();
        
		$time=time();
		if($info[0][3]=="1"){
			$result="1";
		}else if($info[1][3]=="1"){
			$result="2";
		}else{
			$result="3";
		}
		$record=$domain->record($liveuid,$stream,"1",$time,$result);
		if($record==1000)
		{
			$rs['code'] = 1000;
			$rs['msg'] = \PhalApi\T('本轮游戏还未结束');
			return $rs;
		}
		if($record==1001)
		{
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('游戏开启失败');
			return $rs;
		}
		$gameToken=$stream."_1_".$time;
	 	\App\setcaches($gameToken."_Game",$info);	
		$Jinhua['time']="30";
		$Jinhua['token']=$gameToken;
		$Jinhua['gameid']=$record['id'];
		$rs['info'][0]=$Jinhua;
		return $rs;
	}

    /**
     * 智勇三张游戏关闭
     * @desc 用于智勇三张游戏关闭
     * @return int code 操作码，0表示成功
     * @return array info 
     * @return string msg 提示信息
     */
	public function endGame(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$liveuid=\App\checkNull($this->liveuid);
		$gameid=\App\checkNull($this->gameid);
		$ifset=\App\checkNull($this->ifset);
		$token=\App\checkNull($this->token);
		$type=\App\checkNull($this->type);
		
		$checkToken=\App\checkToken($liveuid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
        
        $domain = new Domain_Game();
		$info=$domain->endGame($liveuid,$gameid,$type,$ifset);

		if($info==1000){
			$rs['code'] = 1000;
			$rs['msg'] = \PhalApi\T('该游戏已经被关闭');
			return $rs;	
		}

		$rs['info']=$info;
		return $rs;	
	}

    /**
     * 智勇三张游戏下注
     * @desc 用于智勇三张游戏下注
     * @return int code 操作码，0表示成功
     * @return array info[0] 
     * @return string info[0].uid 用户ID
     * @return string info[0].coin 用户余额
     * @return string info[0].level 用户等级
     * @return string msg 提示信息
     */
	public function JinhuaBet(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$gameid=\App\checkNull($this->gameid);
		$token=\App\checkNull($this->token);
		$coin=\App\checkNull($this->coin);
		$grade=\App\checkNull($this->grade);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
        
        $domain = new Domain_Game();
		$info=$domain->gameBet($uid,$gameid,$coin,"1",$grade);
        
        //file_put_contents('./gameBet.txt',date('Y-m-d H:i:s').' 提交参数信息 info:'.json_encode($info)."\r\n",FILE_APPEND);
		if($info==1000){
			$rs['code'] = 1000;
			$rs['msg'] = \PhalApi\T('你的余额不足，无法下注');
			return $rs;
		}else if($info==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('本轮游戏已经结束');
			return $rs;
		}else if($info==1002){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('下注失败');
			return $rs;
		}else if($info==1003){
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('下注金额已达上限');
			return $rs;
		}

		$gameToken=$info['stream']."_1_".$info['gametime']."_Game";
		$BetRedis=\App\getcaches($gameToken);

		$grade=$grade-1;

		$BetRedis[$grade][5]=(string)($coin+$BetRedis[$grade][5]);

		\App\setcaches($gameToken,$BetRedis);
		$JinhuaBet['uid']=(string)$uid;
		$JinhuaBet['coin']=$info['coin'];

		$userinfo=\App\getUserInfo($uid);
		$JinhuaBet['level']=$userinfo['level'];

		$rs['info'][0]=$JinhuaBet;
		/* $rs['info']['gameid']=$info['gameid']; */
        
        //file_put_contents('./gameBet.txt',date('Y-m-d H:i:s').' 提交参数信息 rs:'.json_encode($rs)."\r\n",FILE_APPEND);
		return $rs;
	}
	

    /**
     * 转盘游戏开启
     * @desc 用于转盘游戏开启
     * @return int code 操作码，0表示成功
     * @return array info 
     * @return string info[0].time 倒计时间
     * @return string info[0].token 游戏token
     * @return string info[0].gameid 游戏记录ID
     * @return string msg 提示信息
     */
	public function Dial(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$liveuid=\App\checkNull($this->liveuid);
		$stream=\App\checkNull($this->stream);
		$token=\App\checkNull($this->token);
        
        if($liveuid<1 || $token=='' || $stream==''){
            $rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('信息错误');
			return $rs;
        }
        
        $checkToken=\App\checkToken($liveuid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
        
		$domain = new Domain_Game();
		$result=rand(1,4);
		$time=time();
		$record=$domain->record($liveuid,$stream,"3",$time,$result);
		
		if($record==1000){
			$rs['code'] = 1000;
			$rs['msg'] = \PhalApi\T('本轮游戏还未结束');
			return $rs;
		}
		if($record==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('游戏开启失败');
			return $rs;
		}
		$gameToken=$stream."_3_".$time;
		$info=array($result,'0','0','0','0');
	 	\App\setcaches($gameToken."_Game",$info);	
		$Taurus['time']="30";
		$Taurus['token']=$gameToken;
		$Taurus['gameid']=$record['id'];
		$rs['info'][0]=$Taurus;
		return $rs;
	}

    /**
     * 转盘游戏关闭
     * @desc 用于转盘游戏关闭
     * @return int code 操作码，0表示成功
     * @return array info 
     * @return string msg 提示信息
     */
	public function Dial_end(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$liveuid=\App\checkNull($this->liveuid);
		$gameid=\App\checkNull($this->gameid);
		$ifset=\App\checkNull($this->ifset);
		$token=\App\checkNull($this->token);
		$type=\App\checkNull($this->type);
		
		$checkToken=\App\checkToken($liveuid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
        $domain = new Domain_Game();
		$info=$domain->endGame($liveuid,$gameid,$type,$ifset);
		if($info==1000){
			// $rs['code'] = 1000;
			// $rs['msg'] = '该游戏已经被关闭';
			return $rs;	
		}
		$rs['info']=$info;
		return $rs;	
	}
	
    /**
     * 转盘游戏下注
     * @desc 用于转盘游戏下注
     * @return int code 操作码，0表示成功
     * @return array info[0] 
     * @return string info[0].uid 用户ID
     * @return string info[0].coin 用户余额
     * @return string info[0].level 用户等级
     * @return string msg 提示信息
     */
	public function Dial_Bet(){

		//file_put_contents('./111111.txt',date('Y-m-d H:i:s')." 进入接口Dial_Bet：\r\n",FILE_APPEND);
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$gameid=\App\checkNull($this->gameid);
		$token=\App\checkNull($this->token);
		$coin=\App\checkNull($this->coin);
		$grade=\App\checkNull($this->grade);
		
		$checkToken=\App\checkToken($uid,$token);
		//file_put_contents('./111111.txt',date('Y-m-d H:i:s')." checkToken:\r\n",FILE_APPEND);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
        	
        //file_put_contents('./111111.txt',date('Y-m-d H:i:s')." 请求model:\r\n",FILE_APPEND);
        $domain = new Domain_Game();
		$info=$domain->gameBet($uid,$gameid,$coin,"3",$grade);
		//file_put_contents('./111111.txt',date('Y-m-d H:i:s')." 返回info".json_encode($info).":\r\n",FILE_APPEND);
		if($info==1000){
			$rs['code'] = 1000;
			$rs['msg'] = \PhalApi\T('你的余额不足，无法下注');
			return $rs;
		}

		if($info==1001){
			$rs['code'] = 1001;
			$rs['msg'] =  \PhalApi\T('本轮游戏已经结束');
			return $rs;
		}

		if($info==1002){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('下注失败');
			return $rs;
		}

		if($info==1003){
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('下注金额已达上限');
			return $rs;
		}

		$gameToken=$info['stream']."_3_".$info['gametime']."_Game";
		$BetRedis=\App\getcaches($gameToken);
		//file_put_contents('./121212.txt',date('Y-m-d H:i:s').' 获取redis数据：'.$BetRedis."\r\n",FILE_APPEND);

		$grade=$grade;
		$BetRedis[$grade]=(string)($coin+$BetRedis[$grade]);

		//file_put_contents('./121212.txt',date('Y-m-d H:i:s').' 用户下注:'.$grade.',金额为：'.$coin.'下注后的数据：'.json_encode($BetRedis)."\r\n",FILE_APPEND);

		\App\setcaches($gameToken,$BetRedis);
		$TaurusBet['uid']=$info['uid'];
		$TaurusBet['coin']=$info['coin'];

		$userinfo=\App\getUserInfo($uid);
		$TaurusBet['level']=$userinfo['level'];
		
		$rs['info'][0]=$TaurusBet;
		
		return $rs;
	}
	/* 转盘 end */
	
    
	
	/* 智勇三张牌面处理 */
    /**
     * 智勇三张牌面
     * @desc 用于获取智勇三张牌面
     * @return array info[][0] 第一张牌
     * @return array info[][1] 第二张牌
     * @return array info[][2] 第三张牌
     * @return array info[][3] 是否最大
     * @return array info[][4] 牌组类型名称
     * @return array info[][5] 
     * @return array info[][6] 牌组类型
     * @return string msg 提示信息
     */
	protected function Jinhua_info() {
		 /* 花色	4表示黑桃 3表示红桃 2表示方片  1表示梅花 */
		/* 牌面 格式 花色-数字 14代表1(PS：请叫它A (jian))*/
		$cards=array('1-14','1-2','1-3','1-4','1-5','1-6','1-7','1-8','1-9','1-10','1-11','1-12','1-13','2-14','2-2','2-3','2-4','2-5','2-6','2-7','2-8','2-9','2-10','2-11','2-12','2-13','3-14','3-2','3-3','3-4','3-5','3-6','3-7','3-8','3-9','3-10','3-11','3-12','3-13','4-14','4-2','4-3','4-4','4-5','4-6','4-7','4-8','4-9','4-10','4-11','4-12','4-13');
		shuffle($cards);
		$card1=array_slice($cards,0,3);
		$card2=array_slice($cards,3,3);
		$card3=array_slice($cards,6,3);
        
		$Card_one=$this->Jinhua_Card($card1);
		$Card_two=$this->Jinhua_Card($card2);
		$Card_three=$this->Jinhua_Card($card3);
		$compare=$this->Jinhua_compare($Card_one,$Card_two,$Card_three);
		$card1[]=(string)$compare['one_bright'];
		$card1[]=$Card_one['name'];
		$card1[]="0";
		$card1[]=(string)$Card_one['card'];
		$card2[]=(string)$compare['two_bright'];
		$card2[]=$Card_two['name'];
		$card2[]="0";
		$card2[]=(string)$Card_two['card'];
		$card3[]=(string)$compare['three_bright'];
		$card3[]=$Card_three['name'];
		$card3[]="0";
		$card3[]=(string)$Card_three['card'];
		$rs[]=$card1;
		$rs[]=$card2;
		$rs[]=$card3;
		return $rs;
	}
	/*分析牌面 类型*/
	protected function Jinhua_Card($deck){
		$deck_rs=array();
		foreach($deck as $k=>$v){
			$carde=explode('-',$v);
			$deck_rs[$k]['color']=$carde[0];
			$deck_rs[$k]['brand']=$carde[1];
			$order[$k]=$carde[1];
			array_multisort($order, SORT_DESC,$deck_rs);
		}
	/* 	return $deck_rs; */
	 	$brand_one=$deck_rs[0]['brand'];
		$brand_two=$deck_rs[1]['brand'];
		$brand_three=$deck_rs[2]['brand'];
		$color_one=$deck_rs[0]['color'];
		$color_two=$deck_rs[1]['color'];
		$color_three=$deck_rs[2]['color'];
		$rs=array();
		$rs['val_one']=$brand_one;
		$rs['val_two']=$brand_two;
		$rs['val_three']=$brand_three;
		$rs['color']=0;
		$along=0;
		$people = array(array(14,3,2),array(14,2,3),array(3,2,14),array(3,14,2),array(2,14,3),array(2,3,14));
		if(in_array(array($brand_one,$brand_two,$brand_three),$people)){
			$along=1;
		}
		if($brand_one==$brand_two && $brand_two==$brand_three){	//豹子
			$rs['card']=6;
			$rs['name']=\PhalApi\T("豹子");
		}else if($color_one==$color_two && $color_two==$color_three &&(($brand_one-2)==$brand_three || $along==1)){//同花顺
			$rs['color']=$color_three;
			$rs['card']=5;
			$rs['name']=\PhalApi\T("同花顺");
		}else if($color_one==$color_two && $color_two==$color_three){	//同花
			$rs['color']=$color_three;
			$rs['card']=4;
			$rs['name']=\PhalApi\T("同花");
		}else if($brand_one==$brand_two||$brand_two==$brand_three||$brand_one==$brand_three){//对子
			$rs['card']=2;
			$rs['name']=\PhalApi\T("对子");
			if($brand_one==$brand_two)//1==2
			{
				$rs['val_one']=$brand_two;
				$rs['val_three']=$brand_three;
				$rs['color']=$color_three;
			}else if($brand_three==$brand_two){//2==3
				$rs['val_one']=$brand_three;
				$rs['val_three']=$brand_one;
				$rs['color']=$color_one;
			}else{//1==3
				$rs['val_one']=$brand_one;
				$rs['val_three']=$brand_two;
				$rs['color']=$color_two;
			}
		}else if((($brand_one-2)==$brand_three||$along==1)&&($brand_one!=$brand_two||$brand_two!=$brand_three||$brand_one!=$brand_three)){//顺子
			$rs['color']=$color_one;
			$rs['card']=3;
			$rs['name']=\PhalApi\T("顺子");
		}else{//单张
			$rs['color']=$color_one;
			$rs['card']=1;
			$rs['name']=\PhalApi\T("单牌");
		}
			return $rs;
	}
	/**
	判断三副牌的类型大小 找出类型最大的牌
	val_one为三张牌中最大的那一张
	$rs['one_bright'] 是否为最大 0为否 1为是
	$null设置一个空数组 当只有2副牌 是相同是 传null 这个数组替代
	**/
	protected function Jinhua_compare($one,$two,$three){
		$rs=array();
		$null=array(
			"val_one"=>'0',
			"val_two"=>'0',
			"val_three"=>'0',
			"color"=>'0',
			"card"=>'0',
		);
		$rs['one_bright']=0;
		$rs['two_bright']=0;
		$rs['three_bright']=0;
		if($one['card']==$two['card']&&$two['card']==$three['card']){//三张牌的类型一致
				$belongTo=$this->Jinhua_belongTo($one['card'],$one,$two,$three,0);
				if($belongTo=="2"){
					$rs['two_bright']=1;
				}else if($belongTo=="1"){
					$rs['one_bright']=1;
				}else{
					$rs['three_bright']=1;
				}
		}else if($one['card']==$two['card']){//一号牌与二号牌的类型一致
			if($one['card']<$three['card']){
				$rs['three_bright']=1;
			}else{
				$belongTo=$this->Jinhua_belongTo($one['card'],$one,$two,$null,1);
				if($belongTo==2){
					$rs['two_bright']=1;
				}else{
					$rs['one_bright']=1;
				}
			}
		}else if($one['card']==$three['card']){//一号牌与三号牌的类型一致
			if($one['card']<$two['card']){
				$rs['two_bright']=1;
			}else{
				$belongTo=$this->Jinhua_belongTo($one['card'],$one,$null,$three,1);
				if($belongTo==3){
					$rs['three_bright']=1;
				}else{
					$rs['one_bright']=1;
				}
			}
		}else if($two['card']==$three['card']){//二号牌与三号牌的类型一致
			if($two['card']<$one['card']){
				$rs['one_bright']=1;
			}else{
				$belongTo=$this->Jinhua_belongTo($one['card'],$null,$two,$three,1);
				if($belongTo==2){
					$rs['two_bright']=1;
				}else{
					$rs['three_bright']=1;
				}
			}
		}else{//三种牌的类型都不一致
			if($one['card']>$two['card'])
			{
				if($one['card']>$three['card']){
					$rs['one_bright']=1;
				}else{
					$rs['three_bright']=1;
				}
			}else{
				if($two['card']>$three['card']){
					$rs['two_bright']=1;
				}else{
					$rs['three_bright']=1;
				}
			}
		}
		return $rs;
	}
	/**
	判断相同类型的牌
	val_one 为三张牌中最大的 那一张
	type 0代表三副牌的类型一致 1代表只有两副牌的类型一致
	**/
	protected function Jinhua_belongTo($card,$one,$two,$three,$type){
		$rs=array();
		if($card==6){//三副牌都是豹子比较
			$rs=$this->leopard_than($one,$two,$three);
		}else if($card==5){//三副牌都是同花顺比较
			$rs=$this->flush_than($one,$two,$three);
		}else if($card==4){//同花
			$rs=$this->flower_than($one,$two,$three);
		}else if($card==3){//顺子
			$rs=$this->along_than($one,$two,$three);
		}else if($card==2){//对子
			$rs=$this->sub_than($one,$two,$three);
		}else{//单张
			$rs=$this->single_than($one,$two,$three);
		}
		return $rs;
	}
	/**
	豹子比较
	**/
	protected function leopard_than($one,$two,$three){
		if($one['val_one']>$two['val_one']){
			if($one['val_one']>$three['val_one']){
				return 1;
			}else{
				return 3;
			}
		}else{
			if($two['val_one']>$three['val_one']){
				return 2;
			}else{
				return 3;
			}
		}
	}
	/**
	同花顺比较
	**/
	protected function flush_than($one,$two,$three){
		if($two['val_one']==$three['val_one']&&$one['val_one']==$three['val_one']){//三副牌的牌面数字大小一致
			if($one['color']>$two['color'])
			{
				if($one['color']>$three['color']){
					return 1;
				}else{
					return 3;
				}
			}else{
				if($two['color']>$three['color']){
					return 2;
				}else{
					return 3;
				}
			}
		}else if($two['val_one']==$one['val_one']){//一号牌和二号牌的牌面大小一致
			if($two['val_one']>$three['val_one']){
				if($two['color']>$one['color'])
				{
					return 2;
				}else{
						return 1;
				}
			}else{
					return 3;
			}
		}else if($one['val_one']==$three['val_one']){//一号牌和三号牌的牌面大小一致
			if($one['val_one']>$two['val_one']){
				if($one['color']>$three['color'])
				{
					return 1;
				}else{
					return 3;
				}
			}else{
					return 2;
			}
		}else if($two['val_one']==$three['val_one']){//二号牌和三号牌的牌面大小一致
			if($two['val_one']>$one['val_one']){
				if($two['color']>$three['color'])
				{
					return 2;
				}else{
					return 3;
				}
			}else{
				return 1;
			}
		}else{//三副牌的牌面大小均不一致
			if($one['val_one']>$two['val_one']){
				if($one['val_one']>$three['val_one']){
					return 1;
				}else{
					return 3;
				}
			}else{
				if($two['val_one']>$three['val_one']){
					return 2;
				}else{
					return 3;
				}
			}
		}
	}
	/**
	同花比较
	**/
	protected function flower_than($one,$two,$three){
		if($two['val_one']==$three['val_one']&&$one['val_one']==$three['val_one']){//三副牌的第一张牌的牌面一致
			if($two['val_two']==$three['val_two']&&$one['val_two']==$three['val_two']){//三副牌的第二张牌的牌面一致
					//三副牌的第三张牌的牌面一致(一致用 花色比较  不一致比较大小)
					if($two['val_three']==$three['val_three']&&$one['val_three']==$three['val_three']){
						$common=$this->than($one['color'],$two['color'],$three['color']);
						return $common;
					}else if($two['val_three']==$one['val_three']){//一号牌和二号牌的第三张牌牌面一样
						if($two['val_three']>$three['val_three'])
						{
							if($two['color']>$one['color'])
							{
								return 2;
							}else{
								return 1;
							}
						}else{
							return 3;
						}
					}else if($three['val_three']==$one['val_three']){//一号牌和三号牌的第三张牌牌面一样
						if($one['val_three']>$two['val_three'])
						{
							if($three['color']>$one['color'])
							{
								return 3;
							}else{
								return 1;
							}
						}else{
							return 2;
						}
					}else if($two['val_three']==$three['val_three']){//二号牌和三号牌的第三张牌牌面一样
						if($two['val_three']>$one['val_three'])
						{
							if($two['color']>$three['color'])
							{
								return 3;
							}else{
								return 2;
							}
						}else{
							return 1;
						}
					}else{//三副牌的第三张拍的牌面均不一致
						$common=$this->than($one['val_three'],$two['val_three'],$three['val_three']);
						return $common;
					}
			}else if($two['val_two']==$one['val_two']){//一号牌和二号牌的第二张牌牌面一样
				if($two['val_two']>$three['val_two'])
				{
					if($two['val_three']==$one['val_three'])
					{
						if($two['color']>$one['color'])
						{
							return 2;
						}else{
							return 1;
						}
					}else{
						if($two['val_three']>$one['val_three']){
							return 2;
						}else{
							return 1;
						}
					}
				}else{
					return 3;
				}
			}else if($three['val_two']==$one['val_two']){//一号牌和三号牌的第二张牌牌面一样
				if($three['val_two']>$two['val_two'])
				{
					if($three['val_three']==$one['val_three'])
					{
						if($three['color']>$one['color'])
						{
							return 3;
						}else{
							return 1;
						}
					}else{
						if($three['val_three']>$one['val_three']){
							return 3;
						}else{
							return 1;
						}
					}
				}else{
					return 2;
				}
			}else if($three['val_two']==$two['val_two']){//二号牌和三号牌的第二张牌牌面一样
				if($three['val_two']>$one['val_two'])
				{
					if($three['val_three']==$two['val_three'])
					{
						if($three['color']>$two['color'])
						{
							return 3;
						}else{
							return 2;
						}
					}else{
						if($three['val_three']>$two['val_three']){
							return 3;
						}else{
							return 2;
						}
					}
				}else{
					return 1;
				}
			}else{
				
			}
		}else if($two['val_one']==$one['val_one']){//一号牌和二号牌的第一张牌牌面一样
			if($two['val_one']>$three['val_one'])
			{
				if($two['val_two']==$one['val_two']){
						if($two['val_three']==$one['val_three'])
						{
							if($two['color']>$one['color'])
							{
								return 2;
							}else{
								return 1;
							}
						}else{
							if($two['val_three']>$one['val_three'])
							{
								return 2;
							}else{
								return 1;
							}
						}
				}else{
					if($two['val_two']>$one['val_two'])
					{
						return 2;
					}else{
						return 1;
					}
				}
			}else{
				return 3;
			}
		}else if($three['val_one']==$one['val_one']){//一号牌和三号牌的第一张牌牌面一样
			if($two['val_one']>$one['val_one'])
			{
				if($three['val_two']==$one['val_two']){
						if($three['val_three']==$one['val_three'])
						{
							if($three['color']>$one['color'])
							{
								return 3;
							}else{
								return 1;
							}
						}else{
							if($three['val_three']>$one['val_three'])
							{
								return 3;
							}else{
								return 1;
							}
						}
				}else{
					if($three['val_two']>$one['val_two'])
					{
						return 3;
					}else{
						return 1;
					}
				}
			}else{
				return 2;
			}
		}else if($three['val_one']==$two['val_one']){//二号牌和三号牌的第一张牌牌面一样
			if($two['val_one']>$one['val_one'])
			{
				if($three['val_two']==$two['val_two']){
						if($three['val_three']==$two['val_three'])
						{
							if($three['color']>$two['color'])
							{
								return 3;
							}else{
								return 2;
							}
						}else{
							if($three['val_three']>$two['val_three'])
							{
								return 3;
							}else{
								return 2;
							}
						}
				}else{
					if($three['val_two']>$two['val_two'])
					{
						return 3;
					}else{
						return 2;
					}
				}
			}else{
				return 1;
			}
		}else{
			$common=$this->than($one['val_one'],$two['val_one'],$three['val_one']);
			return $common;
		}
	}

	protected function than($one,$two,$three){
		if($one>$two)
		{
			if($one>$three){
				return 1;
			}else{
				return 3;
			}
		}else{
			if($two>$three){
				return 2;
			}else{
				return 3;
			}
		}
	}

	/**
	顺子比较
	流程 一次比较最大 如果三张牌相同 则比较嘴的牌的花色
	**/
	protected function along_than($one,$two,$three){

		if($two['val_one']==$three['val_one']&&$one['val_one']==$three['val_one'])
		{
			$common=$this->than($one['color'],$two['color'],$three['color']);
			return $common;
		}else if($one['val_one']==$two['val_one']){//一号牌和二号牌牌面一直
			if($one['val_one']>$three['val_one'])
			{
				$common=$this->than($one['color'],$two['color'],0);
				return $common;
			}else{
				return 3;
			}
		}else if($one['val_one']==$three['val_one']){//一号牌和三号牌牌面一直
			if($one['val_one']>$two['val_one'])
			{
				$common=$this->than($one['color'],0,$two['color']);
				return $common;
			}else{
				return 2;
			}
		}else if($three['val_one']==$two['val_one']){//二号牌和三号牌牌面一直
			if($two['val_one']>$one['val_one'])
			{
				$common=$this->than(0,$two['color'],$two['color']);
				return $common;
			}else{
				return 1;
			}
		}else{
			$common=$this->than($one['val_one'],$two['val_one'],$three['val_one']);
			return $common;
		}
	}


	/*对子比较*/
	protected function sub_than($one,$two,$three){
		if($one['val_one']==$two['val_one']){//一号牌和二号牌牌面一致
			if($one['val_one']>$three['val_one']){
				if($one['val_three']==$two['val_three']){
					if($one['color']>$two['color']){
						return 1;
					}else{
						return 2;
					}
				}else{
					if($one['val_three']>$two['val_three']){
						return 1;
					}else{
						return 2;
					}
				}
			}else{
				return 3;
			}
		}else if($one['val_one']==$three['val_one']){//一号牌和三号牌牌面一致
			if($one['val_one']>$two['val_one']){
				if($one['val_three']==$three['val_three']){
					if($one['color']>$three['color']){
						return 1;
					}else{
						return 3;
					}
				}else{
					if($one['val_three']>$three['val_three']){
						return 1;
					}else{
						return 3;
					}
				}
			}else{
				return 2;
			}
		}else if($two['val_one']==$three['val_one']){//二号牌和三号牌牌面一致
			if($two['val_one']>$one['val_one']){
				if($two['val_three']==$three['val_three']){
					if($two['color']>$three['color']){
						return 2;
					}else{
						return 3;
					}
				}else{
					if($two['val_three']>$three['val_three']){
						return 2;
					}else{
						return 3;
					}
				}
			}else{
				return 1;
			}
		}else{
			$common=$this->than($one['val_one'],$two['val_one'],$three['val_one']);
			return $common;
		}
	}

	/**比较单张
	**/
	protected function single_than($one,$two,$three){
		if($two['val_one']==$three['val_one']&&$one['val_one']==$three['val_one']){//三副牌的第一张牌的牌面一致
			if($two['val_two']==$three['val_two']&&$one['val_two']==$three['val_two']){//三副牌的第二张牌的牌面一致
					//三副牌的第三张牌的牌面一致(一致用 花色比较  不一致比较大小)
					if($two['val_three']==$three['val_three']&&$one['val_three']==$three['val_three']){
						$common=$this->than($one['color'],$two['color'],$three['color']);
						return $common;
					}else if($two['val_three']==$one['val_three']){//一号牌和二号牌的第三张牌牌面一样
						if($two['val_three']>$three['val_three'])
						{
							if($two['color']>$one['color'])
							{
								return 2;
							}else{
								return 1;
							}
						}else{
							return 3;
						}
					}else if($three['val_three']==$one['val_three']){//一号牌和三号牌的第三张牌牌面一样
						if($one['val_three']>$two['val_three'])
						{
							if($three['color']>$one['color'])
							{
								return 3;
							}else{
								return 1;
							}
						}else{
							return 2;
						}
					}else if($two['val_three']==$three['val_three']){//二号牌和三号牌的第三张牌牌面一样
						if($two['val_three']>$one['val_three'])
						{
							if($two['color']>$three['color'])
							{
								return 3;
							}else{
								return 2;
							}
						}else{
							return 1;
						}
					}else{//三副牌的第三张拍的牌面均不一致
						$common=$this->than($one['val_three'],$two['val_three'],$three['val_three']);
						return $common;
					}
			}else if($two['val_two']==$one['val_two']){//一号牌和二号牌的第二张牌牌面一样
				if($two['val_two']>$three['val_two'])
				{
					if($two['val_three']==$one['val_three'])
					{
						if($two['color']>$one['color'])
						{
							return 2;
						}else{
							return 1;
						}
					}else{
						if($two['val_three']>$one['val_three']){
							return 2;
						}else{
							return 1;
						}
					}
				}else{
					return 3;
				}
			}else if($three['val_two']==$one['val_two']){//一号牌和三号牌的第二张牌牌面一样
				if($three['val_two']>$two['val_two'])
				{
					if($three['val_three']==$one['val_three'])
					{
						if($three['color']>$one['color'])
						{
							return 3;
						}else{
							return 1;
						}
					}else{
						if($three['val_three']>$one['val_three']){
							return 3;
						}else{
							return 1;
						}
					}
				}else{
					return 2;
				}
			}else if($three['val_two']==$two['val_two']){//二号牌和三号牌的第二张牌牌面一样
				if($three['val_two']>$one['val_two'])
				{
					if($three['val_three']==$two['val_three'])
					{
						if($three['color']>$two['color'])
						{
							return 3;
						}else{
							return 2;
						}
					}else{
						if($three['val_three']>$two['val_three']){
							return 3;
						}else{
							return 2;
						}
					}
				}else{
					return 1;
				}
			}else{//三副牌的第二张牌都不一样
				$common=$this->than($one['val_two'],$two['val_two'],$three['val_two']);
				return $common;
			}
		}else if($two['val_one']==$one['val_one']){//一号牌和二号牌的第一张牌牌面一样
			if($two['val_one']>$three['val_one'])
			{
				if($two['val_two']==$one['val_two']){
						if($two['val_three']==$one['val_three'])
						{
							if($two['color']>$one['color'])
							{
								return 2;
							}else{
								return 1;
							}
						}else{
							if($two['val_three']>$one['val_three'])
							{
								return 2;
							}else{
								return 1;
							}
						}
				}else{
					if($two['val_two']>$one['val_two'])
					{
						return 2;
					}else{
						return 1;
					}
				}
			}else{
				return 3;
			}
		}else if($three['val_one']==$one['val_one']){//一号牌和三号牌的第一张牌牌面一样
			if($one['val_one']>$two['val_one'])
			{
				if($three['val_two']==$one['val_two']){
						if($three['val_three']==$one['val_three'])
						{
							if($three['color']>$one['color'])
							{
								return 3;
							}else{
								return 1;
							}
						}else{
							if($three['val_three']>$one['val_three'])
							{
								return 3;
							}else{
								return 1;
							}
						}
				}else{
					if($three['val_two']>$one['val_two'])
					{
						return 3;
					}else{
						return 1;
					}
				}
			}else{
				return 2;
			}
		}else if($three['val_one']==$two['val_one']){//二号牌和三号牌的第一张牌牌面一样
			if($two['val_one']>$one['val_one'])
			{
				if($three['val_two']==$two['val_two']){
						if($three['val_three']==$two['val_three'])
						{
							if($three['color']>$two['color'])
							{
								return 3;
							}else{
								return 2;
							}
						}else{
							if($three['val_three']>$two['val_three'])
							{
								return 3;
							}else{
								return 2;
							}
						}
				}else{
					if($three['val_two']>$two['val_two'])
					{
						return 3;
					}else{
						return 2;
					}
				}
			}else{
				return 1;
			}
		}else{
			$common=$this->than($one['val_one'],$two['val_one'],$three['val_one']);
			return $common;
		}
	}	
	/* 智勇三张牌面处理 */
	

	protected function translate($deck){
		$deck_rs=array();
		foreach($deck as $k=>$v){
			$carde=explode('-',$v);
			$deck_rs[$k]['color']=$carde[0];
			$deck_rs[$k]['brand']=$carde[1];
			$order[$k]=$carde[1];
			array_multisort($order, SORT_DESC,$deck_rs);
		}
		return $deck_rs;
	}
    
		
    /**
     * 游戏记录
     * @desc 用于获取本次直播对应 游戏的中奖情况
     * @return int code 操作码，0表示成功
     * @return array info 游戏记录列表
     * @return string info[][0] 第一个位置中奖情况，0表示输，1表示赢
     * @return string info[][1] 第二个位置中奖情况，0表示输，1表示赢
     * @return string info[][2] 第三个位置中奖情况，0表示输，1表示赢
     * @return string info[][3] 第四个位置中奖情况，0表示输，1表示赢
     * @return string msg 提示信息
     */
	public function getGameRecord(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$action=$this->action;
		$stream=\App\checkNull($this->stream);
		
		$domain = new Domain_Game();
		$list=$domain->getGameRecord($action,$stream);

		$rs['info']=$list;
		return $rs;
	}

    /**
     * 庄家流水
     * @desc 用于获取庄家流水
     * @return int code 操作码，0表示成功
     * @return array info 记录列表
     * @return string info[].banker_profit 收益
     * @return string msg 提示信息
     */
	public function getBankerProfit(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$bankerid=$this->bankerid;
		//$action=$this->action;
		$action=4;
		$stream=\App\checkNull($this->stream);
		
		$domain = new Domain_Game();
		$list=$domain->getBankerProfit($bankerid,$action,$stream);

		$rs['info']=$list;
		return $rs;
	}
	
    /**
     * 上庄列表
     * @desc 用于获取上庄列表
     * @return int code 操作码，0表示成功
     * @return array info 列表
     * @return string info[].id 用户ID
     * @return string info[].user_nickname 用户ID
     * @return string info[].avatar 用户ID
     * @return string info[].coin 用户ID
     * @return string msg 提示信息
     */
	protected function getBanker(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$action=4;
		$stream=\App\checkNull($this->stream);

		$key='banker_'.$action.'_'.$stream;
		$uidlist=array();
		$list=\App\hVals($key);
		foreach($list as $v){
			$bankerinfo=json_decode($v,true);
            if($bankerinfo['isout']==0){
                $uidlist[]=$bankerinfo;
                $order1[]=$bankerinfo['addtime'];
            }
		}
        
        array_multisort($order1, SORT_ASC, $uidlist);
        
		$domain = new Domain_Game();
		$info=$domain->getBanker($stream);
		$uidlist[]=$info;
		$rs['info']=$uidlist;
		return $rs;
	}
	
    /**
     * 用户上庄
     * @desc 用于用户上庄
     * @return int code 操作码，0表示成功
     * @return array info 
     * @return string info[].coin 账户余额
     * @return string info[].msg 提示信息
     * @return string msg 提示信息
     */
	protected function setBanker(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$stream=\App\checkNull($this->stream);
		$deposit=\App\checkNull($this->deposit);
		$action=4;
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		$key='banker_'.$action.'_'.$stream;
		
		$isexist=\App\hGet($key,$uid);
		if($isexist){
            $bankerinfo=json_decode($isexist,1);
            if($bankerinfo['isout']==0){
                $rs['code'] = 1001;
                $rs['msg'] = \PhalApi\T('已经申请了');
                return $rs;
            }
		}
		
		$domain = new Domain_Game();
		$info=$domain->setBanker($uid);
		
		$configpri= \App\getConfigPri();
		$limit=$configpri['game_banker_limit'];
        
        if($deposit > $info['coin']){
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('押金超过余额,无法上庄');
			return $rs;
		}
        
		if($limit > $deposit){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('押金不足{num},无法上庄',['num'=>\App\NumberFormat($limit)]);
			return $rs;
		}
		
		$info['coin']=\App\NumberFormat($deposit);
		$info['deposit']=$deposit;
		$info['isout']=0;
		$info['addtime']=time();
        
		\App\hSet($key,$uid,json_encode($info));
        
        $userinfo=$domain->setDeposit($uid,$deposit);
		
		$rs['info'][0]['coin']=(string)$userinfo['coin']; 
		$rs['info'][0]['msg']=\PhalApi\T('申请成功'); 
		
		return $rs;
	}

    /**
     * 用户下庄
     * @desc 用于用户上庄
     * @return int code 操作码，0表示成功
     * @return array info 
	 * @return string info[].msg 提示信息
     * @return string msg 提示信息
     */
	protected function quietBanker(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$stream=\App\checkNull($this->stream);
		$action=4;
		$key='banker_'.$action.'_'.$stream;
        
        $isexist=\App\hGet($key,$uid);
        if($isexist){
            
            $banker=json_decode($isexist,true);
            
            $banker['isout']=1;
            
            \App\hSet($key,$uid,json_encode($banker));
            
        }
		$rs['info'][0]['msg']=\PhalApi\T('下庄成功'); 

		return $rs;
	}
	
	
	
	/**
	 * 获取星球探宝随机滚动列表、星球列表和钻石余额
	 * @desc 获取星球探宝随机滚动列表、星球列表和钻石余额
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string info[0].win_list 滚动随机中奖列表
	 * @return string info[0].win_list[]['gifticon'] 中奖礼物图标
	 * @return string info[0].win_list[]['title'] 中奖信息
	 * @return array  info[0].star_list 星球列表
	 * @return string info[0].star_list[]['name'] 星球名称
	 * @return string info[0].star_list[]['price'] 星球价格
	 * @return int    info[0].coin 用户钻石余额
	 * @return string msg 提示信息
	 */
	public function getXqtbRandList(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		//游戏价格
		$configpri=\App\getConfigPri();

		$star_list=[
			['name'=>\PhalApi\T('冥王星'),'price'=>$configpri['xqtb_mwx_price']],
			['name'=>\PhalApi\T('天王星'),'price'=>$configpri['xqtb_twx_price']],
			['name'=>\PhalApi\T('海王星'),'price'=>$configpri['xqtb_hwx_price']]
		];

		$user_coin=\App\getUserCoin($uid);

		$domain = new Domain_Game();
		$info=$domain->getXqtbRandList();

		$rs['info'][0]['win_list']=$info;
		$rs['info'][0]['star_list']=$star_list;
		$rs['info'][0]['coin']=$user_coin['coin'];
		
		return $rs;
	}
	
	
	/**
	 * 星球探宝下注玩游戏
	 * @desc 星球探宝下注玩游戏
	 * @return int    code 操作码，0表示成功
	 * @return array  info 返回中奖礼物信息
	 * @return array  info[0].gift_list 中奖礼物列表
	 * @return int    info[0].gift_list[]['id'] 中奖礼物id
	 * @return string info[0].gift_list[]['giftname'] 中奖礼物名称
	 * @return string info[0].gift_list[]['gifticon'] 中奖礼物图片
	 * @return string info[0].gift_list[]['nums'] 中奖礼物个数
	 * @return int 	  info[0].gift_list[]['total'] 中奖礼物总价格
	 * @return string info[0].gift_list[]['coin_img'] 钻石图标
	 * @return int 	  info[0].coin 钻石余额
	 * @return string msg 提示信息
	 */
	public function xqtbPlay() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $liveuid=\App\checkNull($this->liveuid);
        $stream=\App\checkNull($this->stream);
        $type=\App\checkNull($this->type);
        $nums=\App\checkNull($this->nums);
        
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		if(!in_array($type, ['1','2','3'])){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('类型错误');
			return $rs;
		}

		if(!in_array($nums, ['1','10','50'])){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('寻宝次数错误');
			return $rs;
		}
		
		$domain = new Domain_Game();
		$info = $domain->xqtbPlay($uid,$liveuid,$stream,$type,$nums);
	 
		return $info;
	}

	/**
	 * 星球探宝中奖记录
	 * @desc 星球探宝中奖记录
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string info[0].addtime 中奖时间
	 * @return string info[0].title 中奖标题
	 * @return array  info[0].gift_list 中奖礼物列表
	 * @return string info[0].gift_list[]['gifticon'] 中奖礼物图片
	 * @return string info[0].gift_list[]['nums'] 中奖礼物个数
	 * @return string msg 提示信息
	 */
	public function getXqtbWinList(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $p=\App\checkNull($this->p);

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain = new Domain_Game();
		$info = $domain->getXqtbWinList($uid,$p);

		return $info;
	}

	/**
	 * 星球探宝中奖排行榜
	 * @desc 星球探宝中奖排行榜
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string info[0].list[].uid 用户ID
	 * @return string info[0].list[].total 总额
	 * @return string info[0].list[].user_nickname 用户昵称
	 * @return string info[0].list[].avatar 用户头像
	 * @return string info[0].list[].coin_img 金额图标
	 * @return string info[0].current.title 排名
	 * @return string info[0].current.user_nickname 用户昵称
	 * @return string info[0].current.avatar 用户头像
	 * @return string info[0].current.coin_img 金额图标
	 * @return string info[0].current.total 金额
	 * @return string msg 提示信息
	 */
	public function getXqtbTotalList(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain = new Domain_Game();
		$info = $domain->getXqtbTotalList($uid);
		return $info;
	}

	


	/**
	 * 获取幸运大转盘随机滚动列表、礼物列表和钻石余额
	 * @desc 获取幸运大转盘随机滚动列表、礼物列表和钻石余额
	 * @return int code 操作码，0表示成功
	 * @return array info 
	 * @return string info[0].win_list 滚动随机中奖列表
	 * @return string info[0].win_list[]['gifticon'] 中奖礼物图标
	 * @return string info[0].win_list[]['title'] 中奖信息
	 * @return string info[0].price_list['xydzp_one_price'] 1次价格
	 * @return string info[0].price_list['xydzp_ten_price'] 10次价格
	 * @return string info[0].price_list['xydzp_hundred_price'] 100次价格
	 * @return int 	  info[0].coin 用户钻石余额
	 * @return string info[0].center_icon 中间图标
	 * @return string msg 提示信息
	 */
	public function getXydzpRandList(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$user_coin=\App\getUserCoin($uid);

		$domain = new Domain_Game();
		$info=$domain->getXydzpRandList();

		$gift_list=$domain->getXydzpGiftList();

		if($gift_list==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('赞无中奖礼物，请稍后再试');
			return $rs;
		}

		$configpri=\App\getConfigPri();
		$price_list=[
			'xydzp_one_price'=>$configpri['xydzp_one_price'],
			'xydzp_ten_price'=>$configpri['xydzp_ten_price'],
			'xydzp_hundred_price'=>$configpri['xydzp_hundred_price']
		];

		$rs['info'][0]['win_list']=$info;
		$rs['info'][0]['gift_list']=$gift_list;
		$rs['info'][0]['price_list']=$price_list;
		$rs['info'][0]['center_icon']=\App\get_upload_path('/static/app/game/center.png');
		$rs['info'][0]['coin']=$user_coin['coin'];

		return $rs;
	}

	/**
	 * 幸运大转盘玩游戏
	 * @desc 幸运大转盘玩游戏
	 * @return int 		code 状态码,0表示成功
	 * @return string 	msg 提示信息
	 * @return array 	info 返回信息
	 * @return array 	info[0]['gift_list'] 返回中奖礼物列表
	 * @return int 		info[0]['gift_list'][]['id'] 返回中奖礼物id
	 * @return string 	info[0]['gift_list'][]['type'] 返回中奖礼物类型 coin 钻石 gift 礼物
	 * @return string 	info[0]['gift_list'][]['giftname'] 返回中奖礼物名称
	 * @return int 		info[0]['gift_list'][]['needcoin'] 返回中奖礼物单价
	 * @return int 		info[0]['gift_list'][]['nums'] 返回中奖礼物个数
	 * @return int 		info[0]['gift_list'][]['total'] 返回中奖礼物总价值
	 * @return string 	info[0]['gift_list'][]['coin_img'] 返回钻石图标
	 * @return int 		info[0]['coin'] 返回用户剩余钻石数
	 */
	public function xydzpPlay(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $liveuid=\App\checkNull($this->liveuid);
        $stream=\App\checkNull($this->stream);
        $type=\App\checkNull($this->type);

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		if(!in_array($type, ['one','ten','hundred'])){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('类型错误');
			return $rs;
		}

		$domain = new Domain_Game();
		$info = $domain->xydzpPlay($uid,$liveuid,$stream,$type);

		return $info;
	}

	/**
	 * 获取幸运大转盘获奖记录
	 * @desc 获取幸运大转盘获奖记录
	 * @return int    code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array  info 返回信息
	 * @return array  info[0]['list'] 返回中奖列表
	 * @return string info[0]['list'][]['addtime'] 返回中奖时间
	 * @return string info[0]['list'][]['title'] 返回中奖标题
	 * @return array  info[0]['list'][]['gift_list'] 返回中奖礼物列表
	 * @return string info[0]['list'][]['gift_list'][]['type'] 返回中奖礼物的类型 coin 钻石 gift 礼物
	 * @return string info[0]['list'][]['gift_list'][]['gifticon'] 返回中奖礼物的图标
	 * @return int 	  info[0]['list'][]['gift_list'][]['needcoin'] 返回中奖钻石数/礼物价值
	 * @return string info[0]['list'][]['gift_list'][]['nums'] 返回中奖礼物个数
	 */
	public function getXydzpWinList(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $p=\App\checkNull($this->p);

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain = new Domain_Game();
		$info = $domain->getXydzpWinList($uid,$p);

		return $info;
	}

	/**
	 * 获取幸运大转盘排行榜
	 * @desc 获取幸运大转盘排行榜
	 * @return int 	  code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array  info 返回信息
	 */
	public function getXydzpTotalList(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);

         $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		} 

		$domain = new Domain_Game();
		$info = $domain->getXydzpTotalList($uid);
		return $info;
	}
    


}