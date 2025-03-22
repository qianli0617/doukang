<?php

namespace App\Domain;
use App\Model\Home as Model_Home;

class Home {

    public function getSlide($where) {
        $rs = array();
        $model = new Model_Home();
        $rs = $model->getSlide($where);
        return $rs;
    }
		
	public function getRecommendVoiceLive() {
        $rs = array();

        $model = new Model_Home();
        $rs = $model->getRecommendVoiceLive();
				
        return $rs;
    }
	
	public function getHot($p) {
        $rs = array();

        $model = new Model_Home();
        $rs = $model->getHot($p);
				
        return $rs;
    }
		
	public function getFollow($uid,$live_type,$p) {
        $rs = array();
				
        $model = new Model_Home();
        $rs = $model->getFollow($uid,$live_type,$p);
				
        return $rs;
    }
		
	public function search($uid,$key,$p) {
        $rs = array();

        $model = new Model_Home();
        $rs = $model->search($uid,$key,$p);
				
        return $rs;
    }	
	
	public function getNearby($lng,$lat,$live_type,$p) {
        $rs = array();

        $model = new Model_Home();
        $rs = $model->getNearby($lng,$lat,$live_type,$p);
				
        return $rs;
    }
	
	public function getRecommend() {
        $rs = array();

        $model = new Model_Home();
        $rs = $model->getRecommend();
				
        return $rs;
    }
	
	public function attentRecommend($uid,$touid) {
        $rs = array();

        $model = new Model_Home();
        $rs = $model->attentRecommend($uid,$touid);
				
        return $rs;
    }

    public function profitList($uid,$type,$p){
        $rs = array();

        $model = new Model_Home();
        $rs = $model->profitList($uid,$type,$p);
                
        return $rs;
    }

    public function consumeList($uid,$type,$p){
        $rs = array();

        $model = new Model_Home();
        $rs = $model->consumeList($uid,$type,$p);
                
        return $rs;
    }

    public function getClassLive($liveclassid,$p){
        $rs = array();

        $model = new Model_Home();
        $rs = $model->getClassLive($liveclassid,$p);
                
        return $rs;
    }
	
	
	public function getShopList($p){
        $rs = array();

        $model = new Model_Home();
        $rs = $model->getShopList($p);
                
        return $rs;
    }
	
	public function getShopClassList($shopclassid,$sell,$price,$isnew,$p){
        $rs = array();

        $model = new Model_Home();
        $rs = $model->getShopClassList($shopclassid,$sell,$price,$isnew,$p);
                
        return $rs;
    }
	
	public function searchShop($key,$sell,$price,$isnew,$p) {
        $rs = array();

        $model = new Model_Home();
        $rs = $model->searchShop($key,$sell,$price,$isnew,$p);
				
        return $rs;
    }

    public function getVoiceLiveList($p) {
        $rs = array();

        $model = new Model_Home();
        $rs = $model->getVoiceLiveList($p);
                
        return $rs;
    }

    public function getRecommendAttentLive($uid){
        $rs = array();

        $model = new Model_Home();
        $rs = $model->getRecommendAttentLive($uid);
                
        return $rs;
    }

    public function updateCity($uid,$city){
        $rs = array();

        $model = new Model_Home();
        $rs = $model->updateCity($uid,$city);
                
        return $rs;
    }
	

}
