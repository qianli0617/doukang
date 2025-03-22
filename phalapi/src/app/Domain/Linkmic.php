<?php
namespace App\Domain;
use App\Model\Linkmic as Model_Linkmic;

class Linkmic {
    public function setMic($uid,$ismic) {
        $rs = array();

        $model = new Model_Linkmic();
        $rs = $model->setMic($uid,$ismic);

        return $rs;
    }

   	public function isMic($liveuid){

        $rs = array();

        $model = new Model_Linkmic();
        $rs = $model->isMic($liveuid);

        return $rs;
    }

}
