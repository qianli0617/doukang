<?php
/**
 * 退款协商历史
 */
namespace app\appapi\controller;

use cmf\controller\HomeBaseController;

class GoodsorderrefundController extends HomebaseController{


    function index(){
        $data = $this->request->param();
        $uid= $data['uid'] ?? '';
        $token= $data['token'] ?? '';
        $orderid= $data['orderid'] ?? '';
        $user_type= $data['user_type'] ?? ''; //用户身份 buyer 买家 seller 卖家 platform 平台
        
        $uid=(int)checkNull($uid);
        $token=checkNull($token);
        $orderid=checkNull($orderid);


        if($user_type!='platform'){
            if( !$uid || !$token || checkToken($uid,$token)==700 ){
                $reason=lang('您的登陆状态失效，请重新登陆！');
                $this->assign('reason', $reason);
                return $this->fetch(':error');
            }
        } 
        

        if(!$orderid || !$user_type ||!in_array($user_type, ['buyer','seller','platform'])){
            $reason=lang('参数错误');
            $this->assign('reason', $reason);
            return $this->fetch(':error');
        }

        $where=[];
        if($user_type=='buyer'){
            $where=array( 
                'id'=>$orderid,
                'uid'=>$uid,
            );

            $where1=array(
                'uid'=>$uid,
                'orderid'=>$orderid
                
            );
        }else if($user_type=='sellers'){
            $where=array( 
                'id'=>$orderid,
                'shop_uid'=>$uid,
            );

            $where1=array(
                'orderid'=>$orderid,
                'shop_uid'=>$uid,
                
            );
        }else{
            $where=array(
                'id'=>$orderid
            );

            $where1=array(
                'orderid'=>$orderid
            );
        }

        

        $orderinfo=getShopOrderInfo($where,"total");

        if(!$orderinfo){
            $reason=lang('订单不存在');
            $this->assign('reason', $reason);
            return $this->fetch(':error');
        }


        $refund_info=getShopOrderRefundInfo($where1);

        if(!$refund_info){
            $reason=lang('订单没有发起退款申请');
            $this->assign('reason', $reason);
            return $this->fetch(':error');
        }

        $language_type=$this->language_type;

        if($language_type=="en"){
            $refund_info['reason']=$refund_info['reason_en'];
            $refund_info['platform_interpose_reason']=$refund_info['platform_interpose_reason_en'];
        }

        //查询退款协商历史
        $refund_list=getShopOrderRefundList(['orderid'=>$orderid]);

        $refund_info['total']=$orderinfo['total'];

        $this->assign("refund_info",$refund_info);
        $this->assign("refund_list",$refund_list); //协商历史
        return $this->fetch();
    }
    
    

    

    
}