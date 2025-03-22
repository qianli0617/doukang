<?php
namespace App\Domain;
use App\Model\Family as Model_Family;

class Family {

    public function createFamily($info) {
        $rs = array();
        $model = new Model_Family();
        $rs = $model->createFamily($info);
        return $rs;
    }
		
}
