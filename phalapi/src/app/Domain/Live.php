<?php
namespace App\Domain;
use App\Model\Live as Model_Live;

class Live {
	
	public function checkBan($uid) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->checkBan($uid);
		return $rs;
	}

	public function createRoom($uid,$data) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->createRoom($uid,$data);
		return $rs;
	}
	
	public function getFansIds($touid) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->getFansIds($touid);
		return $rs;
	}
	
	public function changeLive($uid,$stream,$status) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->changeLive($uid,$stream,$status);
		return $rs;
	}
	
	public function changeLiveType($uid,$stream,$data) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->changeLiveType($uid,$stream,$data);
		return $rs;
	}

	public function stopRoom($uid,$stream) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->stopRoom($uid,$stream);
		return $rs;
	}
	
	public function stopInfo($stream) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->stopInfo($stream);
		return $rs;
	}
	
	public function checkLive($uid,$liveuid,$stream) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->checkLive($uid,$liveuid,$stream);
		return $rs;
	}
	
	public function roomCharge($uid,$liveuid,$stream) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->roomCharge($uid,$liveuid,$stream);
		return $rs;
	}
	
	public function getUserCoin($uid) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->getUserCoin($uid);
		return $rs;
	}
	
	public function isZombie($uid) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->isZombie($uid);
		return $rs;
	}
	
	public function getZombie($stream,$where) {
        $rs = array();
				
        $model = new Model_Live();
        $rs = $model->getZombie($stream,$where);

        return $rs;
    }

	public function getPop($touid) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->getPop($touid);
		return $rs;
	}

	public function getGiftList($live_type) {

        $key='getGiftList';
		$list=\App\getcaches($key);

		if(!$list){
			$model = new Model_Live();
            $list = $model->getGiftList();
            if($list){
                \App\setcaches($key,$list);
            }
		}
  
		//语言包
		$language=\PhalApi\DI()->language;

        foreach($list as $k=>$v){
			$list[$k]['gifticon']=\App\get_upload_path($v['gifticon']);
			if($live_type==1 && $v['mark']==3){ //语音聊天室
				$list[$k]['mark']=0;
			}

			if($language=='en'){
				$list[$k]['giftname']=$v['giftname_en'];
			}

			$list[$k]['id']=(string)$v['id'];
			$list[$k]['type']=(string)$v['type'];
			$list[$k]['mark']=(string)$v['mark'];
			$list[$k]['needcoin']=(string)$v['needcoin'];
			$list[$k]['sticker_id']=(string)$v['sticker_id'];
			$list[$k]['isplatgift']=(string)$v['isplatgift'];
		}
  
		return $list;
	}

	//道具列表
	public function getPropgiftList() {

        $key='getPropgiftList';
		$list=\App\getcaches($key);

		if(!$list){
			$model = new Model_Live();
            $list = $model->getPropgiftList();
            if($list){
                \App\setcaches($key,$list);
            }
		}
        
        foreach($list as $k=>$v){
			$list[$k]['gifticon']=\App\get_upload_path($v['gifticon']);

			$list[$k]['id']=(string)$v['id'];
			$list[$k]['type']=(string)$v['type'];
			$list[$k]['mark']=(string)$v['mark'];
			$list[$k]['needcoin']=(string)$v['needcoin'];
			$list[$k]['sticker_id']=(string)$v['sticker_id'];
			$list[$k]['isplatgift']=(string)$v['isplatgift'];
		}
  
		return $list;
    }
	
	public function sendGift($uid,$liveuid,$stream,$giftid,$giftcount,$ispack,$touids) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->sendGift($uid,$liveuid,$stream,$giftid,$giftcount,$ispack,$touids);
		return $rs;
	}

	public function sendBarrage($uid,$liveuid,$stream,$giftid,$giftcount,$content) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->sendBarrage($uid,$liveuid,$stream,$giftid,$giftcount,$content);
		return $rs;
	}
	
	public function setAdmin($liveuid,$touid) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->setAdmin($liveuid,$touid);
		return $rs;
	}
	
	public function getAdminList($liveuid) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->getAdminList($liveuid);
		return $rs;
	}
	
	public function getUserHome($uid,$touid) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->getUserHome($uid,$touid);
		return $rs;
	}
 
	public function getReportClass() {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->getReportClass();
		return $rs;
	}

	public function setReport($uid,$touid,$content) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->setReport($uid,$touid,$content);
		return $rs;
	}

	public function getVotes($liveuid) {
		$rs = array();

		$model = new Model_Live();
		$rs = $model->getVotes($liveuid);
		return $rs;
	}
 
	public function checkShut($uid,$liveuid) {
		$rs = array();
		$model = new Model_Live();
		$rs = $model->checkShut($uid,$liveuid);
		return $rs;
	}
    
    public function setShutUp($uid,$liveuid,$touid,$showid) {
		$rs = array();
		$model = new Model_Live();
		$rs = $model->setShutUp($uid,$liveuid,$touid,$showid);
		return $rs;
	}

	public function kicking($uid,$liveuid,$touid) {
		$rs = array();
		$model = new Model_Live();
		$rs = $model->kicking($uid,$liveuid,$touid);
		return $rs;
	}
	
	public function kickingList($liveuid) {
		$rs = array();
		$model = new Model_Live();
		$rs = $model->kickingList($liveuid);
		return $rs;
	}
    
    public function superStopRoom($uid,$liveuid,$type,$banruleid) {
		$rs = array();
		$model = new Model_Live();
		$rs = $model->superStopRoom($uid,$liveuid,$type,$banruleid);
		return $rs;
	}

	public function getContribut($uid,$liveuid,$showid) {
		$rs = array();
		$model = new Model_Live();
		$rs = $model->getContribut($uid,$liveuid,$showid);
		return $rs;
	}
 
	public function checkLiveing($uid,$stream) {
		$rs = array();
		$model = new Model_Live();
		$rs = $model->checkLiveing($uid,$stream);
		return $rs;
	}
    
    public function getLiveInfo($liveuid) {
		$rs = array();
		$model = new Model_Live();
		$rs = $model->getLiveInfo($liveuid);
		return $rs;
	}

	public function setLiveGoodsIsShow($uid,$goodsid){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->setLiveGoodsIsShow($uid,$goodsid);
		return $rs;
	}

	public function getLiveShowGoods($liveuid){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->getLiveShowGoods($liveuid);
		return $rs;
	}

	public function applyVoiceLiveMic($uid,$stream){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->applyVoiceLiveMic($uid,$stream);
		return $rs;
	}
	public function cancelVoiceLiveMicApply($uid,$stream){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->cancelVoiceLiveMicApply($uid,$stream);
		return $rs;
	}
	public function handleVoiceMicApply($uid,$stream,$apply_uid,$status){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->handleVoiceMicApply($uid,$stream,$apply_uid,$status);
		return $rs;
	}
	public function getVoiceMicApplyList($uid,$stream){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->getVoiceMicApplyList($uid,$stream);
		return $rs;
	}
	public function changeVoiceEmptyMicStatus($uid,$stream,$position,$status){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->changeVoiceEmptyMicStatus($uid,$stream,$position,$status);
		return $rs;
	}

	public function anchorGetVoiceMicList($uid,$stream){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->anchorGetVoiceMicList($uid,$stream);
		return $rs;
	}

	public function changeVoiceMicStatus($uid,$stream,$position,$status){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->changeVoiceMicStatus($uid,$stream,$position,$status);
		return $rs;
	}

	public function userCloseVoiceMic($uid,$stream){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->userCloseVoiceMic($uid,$stream);
		return $rs;
	}

	public function closeUserVoiceMic($uid,$liveuid,$stream,$touid){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->closeUserVoiceMic($uid,$liveuid,$stream,$touid);
		return $rs;
	}

	public function getVoiceMicStream($uid,$liveuid,$stream){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->getVoiceMicStream($uid,$liveuid,$stream);
		return $rs;
	}


	public function getVoiceLivePullStreams($uid,$stream){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->getVoiceLivePullStreams($uid,$stream);
		return $rs;
	}

	public function userGetVoiceMicList($liveuid,$stream){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->userGetVoiceMicList($liveuid,$stream);
		return $rs;
	}

	public function getLiveBanInfo($uid){
		$rs = array();
		$model = new Model_Live();
		$rs = $model->getLiveBanInfo($uid);
		return $rs;
	}
	
	public function isDefaultAddress($uid)
	{
		$rs = array();
		$model = new Model_Live();
		$rs = $model->isDefaultAddress($uid);
		return $rs;
	}
	
	public function addAddress($data)
	{
		$rs = array();
		$model = new Model_Live();
		$rs = $model->addAddress($data);
		return $rs;
	}
	
	public function isLiveSatisfy($uid)
	{
		$rs = array();
		$model = new Model_Live();
		$rs = $model->isLiveSatisfy($uid);
		return $rs;
	}
	
	public function isGoLive($uid)
	{
		$rs = array();
		$model = new Model_Live();
		$rs = $model->isGoLive($uid);
		return $rs;
	}
	
	public function setLiveReport($data)
	{
		$rs = array();
		$model = new Model_Live();
		$rs = $model->setLiveReport($data);
		return $rs;
	}
	
	public function shareLiveAdd($stream)
	{
		$rs = array();
		$model = new Model_Live();
		$rs = $model->shareLiveAdd($stream);
		return $rs;
	}
}
