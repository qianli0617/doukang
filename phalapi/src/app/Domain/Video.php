<?php
namespace App\Domain;
use App\Model\Video as Model_Video;

class Video {
	public function setVideo($data,$music_id) {
		$rs = array();

		$model = new Model_Video();
		$rs = $model->setVideo($data,$music_id);

		return $rs;
	}
	
    public function setComment($data) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->setComment($data);

        return $rs;
    }
    public function addView($uid,$videoid) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->addView($uid,$videoid);

        return $rs;
    }
    public function addLike($uid,$videoid) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->addLike($uid,$videoid);

        return $rs;
    }
	
	public function addCollect($uid,$videoid) {
		$rs = array();
		
		$model = new Model_Video();
		$rs = $model->addCollect($uid,$videoid);
		
		return $rs;
	}
	
	public function collectList($touid,$p)
	{
		$rs = array();
		
		$model = new Model_Video();
		$rs = $model->collectList($touid,$p);
		
		return $rs;
	}

    public function addShare($uid,$videoid) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->addShare($uid,$videoid);

        return $rs;
    }

    public function setBlack($uid,$videoid) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->setBlack($uid,$videoid);

        return $rs;
    }

    public function addCommentLike($uid,$commentid) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->addCommentLike($uid,$commentid);

        return $rs;
    }
	public function getVideoList($uid,$p) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getVideoList($uid,$p);

        return $rs;
    }
	public function getVideoSearchList($uid,$keyword,$p)
	{
		$rs = array();
		
		$model = new Model_Video();
		$rs = $model->getVideoSearchList($uid,$keyword,$p);
		
		return $rs;
	}
	public function getAttentionVideo($uid,$p) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getAttentionVideo($uid,$p);

        return $rs;
    }
	public function getVideo($uid,$videoid) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getVideo($uid,$videoid);

        return $rs;
    }
	public function getComments($uid,$videoid,$p) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getComments($uid,$videoid,$p);

        return $rs;
    }

	public function getReplys($uid,$commentid,$p) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getReplys($uid,$commentid,$p);

        return $rs;
    }

	public function getMyVideo($uid,$p) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getMyVideo($uid,$p);

        return $rs;
    }
	
	public function del($uid,$videoid) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->del($uid,$videoid);

        return $rs;
    }
 
	public function getHomeVideo($uid,$touid,$p) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getHomeVideo($uid,$touid,$p);

        return $rs;
    }
 
    public function report($data) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->report($data);

        return $rs;
    }


    public function getNearby($uid,$city,$lng,$lat,$p){
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getNearby($uid,$city,$lng,$lat,$p);
        
        return $rs;
    }
	
	public function getRandom($uid,$p)
	{
		$rs = array();
		
		$model = new Model_Video();
		$rs = $model->getRandom($uid,$p);
		
		return $rs;
	}
	
	public function getFocuson($uid,$p)
	{
		$rs = array();
		
		$model = new Model_Video();
		$rs = $model->getFocuson($uid,$p);
		
		return $rs;
	}
	
	public function getFriend($uid,$p)
	{
		$rs = array();
		
		$model = new Model_Video();
		$rs = $model->getFriend($uid,$p);
		
		return $rs;
	}

    public function getReportContentlist() {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getReportContentlist();

        return $rs;
    }

    public function setConversion($videoid){
        $rs = array();

        $model = new Model_Video();
        $rs = $model->setConversion($videoid);

        return $rs;
    }
	public function getClassVideo($videoclassid,$uid,$p){
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getClassVideo($videoclassid,$uid,$p);

        return $rs;
    }
	
	public function delComments($uid,$videoid,$commentid,$commentuid) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->delComments($uid,$videoid,$commentid,$commentuid);

        return $rs;
    }

    public function getLikeVideos($uid,$touid,$p,$key) {
        $rs = array();

        $model = new Model_Video();
        $rs = $model->getLikeVideos($uid,$touid,$p,$key);

        return $rs;
    }
	
	public function addWatchVideoLog($uid,$videoid,$status)
	{
		$rs = array();
		
		$model = new Model_Video();
		$rs = $model->addWatchVideoLog($uid,$videoid,$status);
		
		return $rs;
	}
	
	public function getWatchVideoLog($uid,$key,$status,$p)
	{
		$rs = array();
		
		$model = new Model_Video();
		$rs = $model->getWatchVideoLog($uid,$key,$status,$p);
		
		return $rs;
	}
	
	public function delWatchVideoLog($uid)
	{
		$rs = array();
		
		$model = new Model_Video();
		$rs = $model->delWatchVideoLog($uid);
		
		return $rs;
	}
	public function searchTopics($key,$p)
	{
		$rs = array();
		
		$model = new Model_Video();
		$rs = $model->searchTopics($key,$p);
		
		return $rs;
	}
	
}
