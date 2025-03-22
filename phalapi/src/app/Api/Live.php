<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\User as Domain_User;
use App\Domain\Live as Domain_Live;
use App\Domain\Guard as Domain_Guard;
/**
 * 直播
 */

class Live extends Api {

	public function getRules() {
		return array(
			'getSDK' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'desc' => '用户ID'),
			),
			'isGoLive' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
			),
			'createRoom' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'title' => array('name' => 'title', 'type' => 'string','default'=>'', 'desc' => '直播标题 url编码'),
				'province' => array('name' => 'province', 'type' => 'string', 'default'=>'', 'desc' => '省份'),
				'city' => array('name' => 'city', 'type' => 'string', 'default'=>'', 'desc' => '城市'),
				'lng' => array('name' => 'lng', 'type' => 'string', 'default'=>'0', 'desc' => '经度值'),
				'lat' => array('name' => 'lat', 'type' => 'string', 'default'=>'0', 'desc' => '纬度值'),
				'type' => array('name' => 'type', 'type' => 'int', 'default'=>'0', 'desc' => '直播房间类型，0是普通房间，1是私密房间，2是收费房间，3是计时房间'),
				'type_val' => array('name' => 'type_val', 'type' => 'string', 'default'=>'', 'desc' => '类型值'),
				'anyway' => array('name' => 'anyway', 'type' => 'int', 'default'=>'0', 'desc' => '直播类型 1 PC, 0 app'),
				'liveclassid' => array('name' => 'liveclassid', 'type' => 'int', 'default'=>'0', 'desc' => '直播分类ID'),
                'deviceinfo' => array('name' => 'deviceinfo', 'type' => 'string', 'default'=>'', 'desc' => '设备信息'),
                'isshop' => array('name' => 'isshop', 'type' => 'int', 'default'=>'0', 'desc' => '是否开启购物车'),
                'thumb' => array('name' => 'thumb', 'type' => 'string',  'desc' => '开播封面'),
                'live_type' => array('name' => 'live_type', 'type' => 'int', 'default'=>'0', 'desc' => '直播类型 0视频直播 1语音聊天室'),
			),
			'changeLive' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
				'status' => array('name' => 'status', 'type' => 'int', 'require' => true, 'desc' => '直播状态 0关闭 1直播'),
			),
			'changeLiveType' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
				'type' => array('name' => 'type', 'type' => 'int', 'default'=>'0', 'desc' => '直播类型，0是一般直播，1是私密直播，2是收费直播，3是计时直播'),
				'type_val' => array('name' => 'type_val', 'type' => 'string', 'default'=>'', 'desc' => '类型值'),
			),
			'stopRoom' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
				'type' => array('name' => 'type', 'type' => 'int', 'default'=>'0', 'desc' => '类型'),
				'source' => array('name' => 'source', 'type' => 'string', 'desc' => '访问来源 socekt:断联socket，app传值空'),
				'time' => array('name' => 'time', 'type' => 'string', 'desc' => '当前时间戳'),
                'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名'),
			),
			
			'stopInfo' => array(
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
			),
			
			'checkLive' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
			),
			
			'roomCharge' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
			),
			'timeCharge' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
			),
			
			'enterRoom' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
				'mobileid' => array('name' => 'mobileid', 'type' => 'string','default'=>'', 'desc' => '实际唯一识别码'),
			),
			
			'showVideo' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
                'touid' => array('name' => 'touid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '上麦会员ID'),
                'pull_url' => array('name' => 'pull_url', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '连麦用户播流地址'),
            ),
			
			'getZombie' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '流名'),
            ),

			'getUserLists' => array(
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
				'key' => array('name' => 'key', 'type' => 'string', 'require' => false, 'desc' => 'key 搜索值'),
				'p' => array('name' => 'p', 'type' => 'int', 'min' => 1, 'default'=>1,'desc' => '页数'),
			),
			
			'getPop' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'touid' => array('name' => 'touid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '对方ID'),
			),
			
			'getGiftList' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'live_type' => array('name' => 'live_type', 'type' => 'int', 'default' => 0, 'desc' => '直播间类型 0视频直播 1语音聊天室'),
			),
			
			'sendGift' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
				'giftid' => array('name' => 'giftid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '礼物ID'),
				'giftcount' => array('name' => 'giftcount', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '礼物数量'),
				'ispack' => array('name' => 'ispack', 'type' => 'int', 'default'=>'0', 'desc' => '是否背包'),
				'is_sticker' => array('name' => 'is_sticker', 'type' => 'int', 'default'=>'0', 'desc' => '是否为贴纸礼物：0：否；1：是'),
				'touids' => array('name' => 'touids', 'type' => 'string', 'require' => true, 'desc' => '接收送礼物的麦上用户组/主播'),
			),
			
			'sendBarrage' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
				'content' => array('name' => 'content', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '弹幕内容'),
			),
			
			'setAdmin' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'touid' => array('name' => 'touid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '对方ID'),
			),
			
			'getAdminList' => array(
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
			),
			
			'setReport' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'touid' => array('name' => 'touid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '对方ID'),
				'content' => array('name' => 'content', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '举报内容'),
			),
			
			'setLiveReport' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => 'token'),
				'touid' => array('name' => 'touid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '被举报人ID'),
				'stream' => array('name' => 'stream', 'require' => true, 'desc' => '直播流名'),
				'reason' => array('name' => 'reason', 'require' => true, 'desc' => '举报原因'),
				'content' => array('name' => 'content', 'type' => 'string','desc' => '举报内容'),
				'content_json' => array('name' => 'content_json', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '举报截图,多图片使用 , 隔开'),
			),
			
			'getVotes' => array(
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
			),
			
			'setShutUp' => array(
                'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户token'),
                'touid' => array('name' => 'touid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '禁言用户ID'),
                'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'type' => array('name' => 'type', 'type' => 'int', 'default'=>'0', 'desc' => '禁言类型,0永久，1本场'),
                'stream' => array('name' => 'stream', 'type' => 'string', 'default'=>'0', 'desc' => '流名，0永久'),
            ),
			
			'kicking' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'touid' => array('name' => 'touid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '对方ID'),
			),
			
			'kickingList' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户token'),
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
			),
			
			'superStopRoom' => array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '会员ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'type' => array('name' => 'type', 'type' => 'int','default'=>0, 'desc' => '关播类型 0表示关闭当前直播 1表示禁播，2表示封禁账号'),
				'banruleid'=>array('name' => 'banruleid', 'type' => 'int', 'min' => 1, 'desc' => '当type=1时房间禁播规则id'),
            ),
			'searchMusic' => array(
				'key' => array('name' => 'key', 'type' => 'string','require' => true,'desc' => '关键词'),
				'p' => array('name' => 'p', 'type' => 'int', 'min' => 1, 'default'=>1,'desc' => '页数'),
            ),
			
			'getDownurl' => array(
				'audio_id' => array('name' => 'audio_id', 'type' => 'int','require' => true,'desc' => '歌曲ID'),
            ),
			
			'getCoin' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '会员ID'),
                'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'min' => 1, 'desc' => '会员token'),
            ),
            
            'checkLiveing' => array(
				'uid' => array('name' => 'uid', 'type' => 'int','desc' => '会员ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '流名'),
            ),

            'getLiveInfo' => array(
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'desc' => '主播ID'),
            ),

            'setLiveGoodsIsShow'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '会员ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'goodsid' => array('name' => 'goodsid','type' => 'int', 'require' => true, 'min' => 1, 'desc' => '商品ID'),

            ),
            'signOutWatchLive'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '会员ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
            ),
			'shareLiveRoom'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '会员ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
				'stream' => array('name' => 'stream', 'type' => 'string' , 'desc' => '流名'),
            ),
			
			'likeLiveRoom'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '会员ID'),
				'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
			),
			
            'applyVoiceLiveMic'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '会员ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '流名'),
            ),
            'cancelVoiceLiveMicApply'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '会员ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '流名'),
            ),
            'handleVoiceMicApply'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '流名'),
                'apply_uid' => array('name' => 'apply_uid', 'require' => true, 'min' => 1, 'desc' => '申请上麦用户ID'),
                'status' => array('name' => 'status', 'require' => true, 'desc' => '处理状态 0拒绝 1 同意'),
            ),
            'getVoiceMicApplyList'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '流名'),
            ),
            'changeVoiceEmptyMicStatus'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '流名'),
                'position' => array('name' => 'position', 'type' => 'int','desc' => '麦位 从0开始，最大到7'),
                'status' => array('name' => 'status', 'require' => true, 'desc' => '处理状态 0禁麦 1 取消禁麦'),
            ),
            'anchorGetVoiceMicList'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '流名'),
            ),
            'changeVoiceMicStatus'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '流名'),
                'position' => array('name' => 'position', 'type' => 'int','desc' => '麦位 从0开始，最大到7'),
                'status' => array('name' => 'status', 'require' => true, 'desc' => '处理状态 0闭麦 1 开麦'),
            ),
            'userCloseVoiceMic'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '流名'),
            ),
            'closeUserVoiceMic'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '流名'),
                'touid' => array('name' => 'touid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '连麦用户ID'),
            ),
            'getVoiceMicStream'=>array(
            	'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '语音聊天室主播流名'),
            ),

			'getVoiceLivePullStreams'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '语音聊天室主播流名'),
			),

			'getLiveBanRules'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
			),

			'getLiveBanInfo'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
			),

			'checkUserRedis'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
                'mobileid' => array('name' => 'mobileid', 'type' => 'string','default'=>'', 'desc' => '实际唯一识别码'),
			),

			'getMicPullUrl'=>array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
                'stream' => array('name' => 'stream', 'type' => 'string','desc' => '上麦用户的流名'),
			),

			'getUserRank'=>array(
				'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'require' => true, 'desc' => '流名'),
			),
			
			'IsDefaultAddress' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'token' => array('name' => 'token', 'require' => true, 'min' => 1, 'desc' => '会员token'),
			),
			
			'addAddress' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string',  'require' => true, 'desc' => '用户Token'),
				'username' => array('name' => 'username', 'type' => 'string',  'require' => true, 'desc' => '姓名'),
				'country_code' => array('name' => 'country_code', 'type' => 'int', 'default' => '86', 'desc' => '国家代号'),
				'phone' => array('name' => 'phone', 'type' => 'string', 'require' => true, 'desc' => '联系电话'),
				'province' => array('name' => 'province', 'type' => 'string',  'require' => true, 'desc' => '省份'),
				'city' => array('name' => 'city', 'type' => 'string',  'require' => true, 'desc' => '城市'),
				'area' => array('name' => 'area', 'type' => 'string', 'require' => true, 'desc' => '地区'),
				'address' => array('name' => 'address', 'type' => 'string', 'desc' => '详细地址'),
				'is_default' => array('name' => 'is_default', 'type' => 'int', 'default'=>'0', 'desc' => '是否是默认地址 0 否 1 是'),
				'time' => array('name' => 'time', 'type' => 'string', 'desc' => '时间戳'),
				'sign' => array('name' => 'sign', 'type' => 'string', 'desc' => '签名'),
			),
			
			'isLiveSatisfy' => array(
				'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
				'token' => array('name' => 'token', 'type' => 'string', 'require' => true, 'desc' => '用户Token'),
			),
			
		);
	}
	/**
	 * 获取SDK及直播配置及直播间封禁
	 * @desc 用于获取SDK类型及直播配置及直播间封禁
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string msg 提示信息
	 */
	public function isGoLive(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		$domain = new Domain_Live();
		$isLive = $domain->isGoLive($uid);
		$rs['info'] = $isLive;
		return $rs;
	}

    /**
	 * 获取SDK及直播配置及直播间封禁
	 * @desc 用于获取SDK类型及直播配置及直播间封禁
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].live_sdk SDK类型，0金山SDK 1腾讯SDK
	 * @return object info[0].android 安卓CDN配置
	 * @return object info[0].ios IOS CDN配置
	 * @return string info[0].isshop 是否有店铺，0否1是
	 * @return string msg 提示信息
	 */
	public function getSDK() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
        $uid=\App\checkNull($this->uid);
        $configpri=\App\getConfigPri();
        
        //$info['live_sdk']=$configpri['live_sdk'];
		
        $cdnset=include API_ROOT.'/config/cdnset.php';
   
        $cdnset['live_sdk']=$configpri['live_sdk'];
        
        /* 店铺信息 */
		$isshop = \App\checkShopIsPass($uid);

		$cdnset['live_isban']='0';
		$cdnset['liveban_title']='';

		$live_ban=\App\getLiveBan($uid);

		if($live_ban['is_ban']){
			$cdnset['live_isban']='1';
			if($live_ban['endtime']){
				$cdnset['liveban_title']=\PhalApi\T('您直播间已被封禁,截止日期：').date("Y-m-d H:i",$live_ban['endtime']);
			}else{
				$cdnset['liveban_title']=\PhalApi\T('您直播间已被永久封禁');
			}
			
		}
        
        $cdnset['isshop']=$isshop;
		$rs['info'][0]=$cdnset;


		return $rs;
	}

     /**
	 * 创建开播
	 * @desc 用于用户开播生成记录
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].userlist_time 用户列表请求间隔
	 * @return string info[0].barrage_fee 弹幕价格
	 * @return string info[0].votestotal 主播映票
	 * @return string info[0].stream 流名
	 * @return string info[0].push 推流地址
	 * @return string info[0].pull 播流地址
	 * @return string info[0].chatserver socket地址
	 * @return array info[0].game_switch 游戏开关
	 * @return string info[0].game_switch[][0] 开启的游戏类型
	 * @return string info[0].game_bankerid 庄家ID
	 * @return string info[0].game_banker_name 庄家昵称
	 * @return string info[0].game_banker_avatar 庄家头像
	 * @return string info[0].game_banker_coin 庄家余额
	 * @return string info[0].game_banker_limit 上庄限额
	 * @return object info[0].liang 用户靓号信息
	 * @return string info[0].liang.name 号码，0表示无靓号
	 * @return object info[0].vip 用户VIP信息
	 * @return string info[0].vip.type VIP类型，0表示无VIP，1表示有VIP
	 * @return string info[0].guard_nums 守护数量
	 * @return string info[0].thumb 直播封面
	 * @return string msg 提示信息
	 */
	public function createRoom() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid = \App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$configpub=\App\getConfigPub();
		if($configpub['maintain_switch']==1){
			$rs['code']=1002;
			$rs['msg']=$configpub['maintain_tips'];
			return $rs;

		}
        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		$isban = \App\isBan($uid);
		if(!$isban){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('该账号已被禁用');
			return $rs;
		}
		

		$live_ban=\App\getLiveBan($uid);

		if($live_ban['is_ban']){
			$rs['code'] = 1015;
			$rs['msg'] = \PhalApi\T('您暂无直播权限');
			return $rs;
		}


		$configpri=\App\getConfigPri();
		if($configpri['auth_islimit']==1){
			$isauth=\App\isAuth($uid);
			if(!$isauth){
				$rs['code']=1002;
				$rs['msg']=\PhalApi\T('请先进行身份认证或等待审核');
				return $rs;
			}
		}
		$userinfo=\App\getUserInfo($uid);
		
		if($configpri['level_islimit']==1){
			if( $userinfo['level'] < $configpri['level_limit'] ){
				$rs['code']=1003;
				$rs['msg']=\PhalApi\T('等级小于{num}级，不能直播',['num'=>$configpri['level_limit']]);
				return $rs;
			}
		}
		
		$nowtime=time();
		
		$showid=$nowtime;
		$starttime=$nowtime;
		$title=\App\checkNull($this->title);
		$province=\App\checkNull($this->province);
		$city=\App\checkNull($this->city);
		$lng=\App\checkNull($this->lng);
		$lat=\App\checkNull($this->lat);
		$type=\App\checkNull($this->type);
		$type_val=\App\checkNull($this->type_val);
		$anyway=\App\checkNull($this->anyway);
		$liveclassid=\App\checkNull($this->liveclassid);
		$deviceinfo=\App\checkNull($this->deviceinfo);
		$isshop=\App\checkNull($this->isshop);
		$thumb_str=\App\checkNull($this->thumb);
		$live_type=\App\checkNull($this->live_type);

		if(!in_array($live_type, ['0','1'])){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('直播类型错误');
			return $rs;
		}

		$sensitivewords=\App\sensitiveField($title);
		if($sensitivewords==1001){
			$rs['code'] = 10011;
			$rs['msg'] = \PhalApi\T('输入非法，请重新输入');
			return $rs;
		}
		
		
		if( $type==1 && $type_val=='' ){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('密码不能为空');
			return $rs;
		}else if($type > 1 && $type_val<=0){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('价格不能小于等于0');
			return $rs;
		}
		
		
		$stream=$uid.'_'.$nowtime;
        $wy_cid='';
		if($configpri['cdn_switch']==5){

			$wyinfo=\App\PrivateKeyA('rtmp',$stream,1);
			$pull=$wyinfo['ret']["rtmpPullUrl"];
			$wy_cid=$wyinfo['ret']["cid"];
			$push=$wyinfo['ret']["pushUrl"];
		}else{
			$push=\App\PrivateKeyA('rtmp',$stream,1);
			$pull=\App\PrivateKeyA('rtmp',$stream,0);
		}
	


		if(!$city){
			$city=\PhalApi\T('好像在火星');
		}
		if(!$lng && $lng!=0){
			$lng='';
		}
		if(!$lat && $lat!=0){
			$lat='';
		}


		//APP原生上传后请求接口保存start
		$thumb="";
		if($thumb_str){
			$cloudtype=$configpri['cloudtype'];
			if($cloudtype==1){ //七牛云存储
				$thumb=  $thumb_str.'?imageView2/2/w/600/h/600';
			}else{
				$thumb=$thumb_str;
			}
		}
		//APP原生上传后请求接口保存end
		
		
		// 主播靓号
		$liang=\App\getUserLiang($uid);
		$goodnum=0;
		if($liang['name']!='0'){
			$goodnum=$liang['name'];
		}
		$info['liang']=$liang;


		
		// 主播VIP
		$vip=\App\getUserVip($uid);
		$info['vip']=$vip;


		
		$dataroom=array(
			"uid"=>$uid,
			"showid"=>$showid,
			"starttime"=>$starttime,
			"title"=>$title,
			"province"=>$province,
			"city"=>$city,
			"stream"=>$stream,
			"thumb"=>$thumb,
			"pull"=>$pull,
			"lng"=>$lng,
			"lat"=>$lat,
			"type"=>$type,
			"type_val"=>$type_val,
			"goodnum"=>$goodnum,
			"isvideo"=>0,
			"islive"=>0,
            "wy_cid"=>$wy_cid,
			"anyway"=>$anyway,
			"liveclassid"=>$liveclassid,
			"deviceinfo"=>$deviceinfo,
			"isshop"=>$isshop,
			"hotvotes"=>0,
			"pkuid"=>0,
			"pkstream"=>'',
			"banker_coin"=>10000000,
			"live_type"=>$live_type
		);


		$domain = new Domain_Live();
		$result = $domain->createRoom($uid,$dataroom);


		if($result===false){
			$rs['code'] = 1011;
			$rs['msg'] = \PhalApi\T('开播失败，请重试');
			return $rs;
		}
		$data=array('city'=>$city);
		$domain2 = new Domain_User();
		$info2 = $domain2->userUpdate($uid,$data);
		
		$userinfo['city']=$city;
		$userinfo['usertype']=50;
		$userinfo['sign']='0';

		\App\setcaches($token,$userinfo);



		$votestotal=$domain->getVotes($uid);
		
		$info['userlist_time']=$configpri['userlist_time'];
		$info['barrage_fee']=$configpri['barrage_fee'];
		$info['chatserver']=$configpri['chatserver'];

		$info['votestotal']=$votestotal;
		$info['stream']=$stream;
		$info['push']=$push;
		$info['pull']=$pull;

		// 游戏配置信息start
		$info['game_switch']=$configpri['game_switch'];
		$info['game_bankerid']='0';
		$info['game_banker_name']=\PhalApi\T('吕布');
		$info['game_banker_avatar']='';
		$info['game_banker_coin']=\App\NumberFormat(10000000);
		$info['game_banker_limit']=$configpri['game_banker_limit'];
		// 游戏配置信息end
        
        // 守护数量
        $domain_guard = new Domain_Guard();
		$guard_nums = $domain_guard->getGuardNums($uid);
        $info['guard_nums']=$guard_nums;
        
        // 腾讯APPID
        $info['tx_appid']=$configpri['tx_appid'];
        
        // 奖池
        $info['jackpot_level']='-1';
		$jackpotset = \App\getJackpotSet();
        if($jackpotset['switch']){
            $jackpotinfo = \App\getJackpotInfo();
            $info['jackpot_level']=$jackpotinfo['level'];
        }
		// 敏感词集合
		$dirtyarr=array();
		if($configpri['sensitive_words']){
            $dirtyarr=explode(',',$configpri['sensitive_words']);
        }
		$info['sensitive_words']=$dirtyarr;

		//返回直播封面
		if($thumb){
			$info['thumb']=\App\get_upload_path($thumb);
		}else{
			$info['thumb']=$userinfo['avatar_thumb'];
		}

		//每日任务开关
		$info['dailytask_switch']=$configpri['dailytask_switch'];
		
		$rs['info'][0] = $info;
        
        
        // 清除连麦PK信息
        \App\hSet('LiveConnect',$uid,0);
        \App\hSet('LivePK',$uid,0);
        \App\hSet('LivePK_gift',$uid,0);

        // 后台禁用后再启用，恢复发言
       \App\hDel($uid . 'shutup',$uid);
		return $rs;
	}
	

	/**
	 * 修改直播状态
	 * @desc 用于主播修改直播状态
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].msg 成功提示信息
	 * @return string msg 提示信息
	 */
	public function changeLive() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid = \App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$stream=\App\checkNull($this->stream);
		$status=\App\checkNull($this->status);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		$domain = new Domain_Live();
		$info=$domain->changeLive($uid,$stream,$status);

		//腾讯云推送
		$userinfo=\App\getUserInfo($uid);
		
		$anthorinfo=array(
			"uid"=>$info['uid'],
			"avatar"=>$userinfo['avatar'],
			"avatar_thumb"=>$userinfo['avatar_thumb'],
			"user_nickname"=>$userinfo['user_nickname'],
			"title"=>$info['title'],
			"city"=>$info['city'],
			"stream"=>$info['stream'],
			"pull"=>$info['pull'],
			"thumb"=>$info['thumb'],
			"isvideo"=>'0',
			"type"=>$info['type'],
			"type_val"=>$info['type_val'],
			"game_action"=>'0',
			"goodnum"=>$info['goodnum'],
			"anyway"=>$info['anyway'],
			"nums"=>0,
			"level_anchor"=>$userinfo['level_anchor'],
            "game"=>'',
		);

		//type=1 直播开播消息
		$sendinfo=array(
			'type'=>1,
			'userinfo'=>$anthorinfo,
		);

		//语言包
		$title="你的好友：".$anthorinfo['user_nickname']."正在直播，邀请你速来观看";
		$title_en="Your friend: ".$anthorinfo['user_nickname']." is live broadcasting, invite you to watch";


		$fans=$domain->getFansIds($uid);


		if(!empty($fans)){

			$nums=count($fans);
			if($nums==1){
				\App\txMessageTpns('主播开播',$title,'single',$fans[0]['uid'],[],json_encode($sendinfo),'zh-cn');
				sleep(2);
				\App\txMessageTpns('Anchor starts broadcasting',$title,'single',$fans[0]['uid'],[],json_encode($sendinfo),'en');

			}else{
				for($i=0;$i<$nums;){
					$alias=array_slice($fans,$i,900);
                	$i+=900;

                	$uids=array_column($alias,'uid');

                	\App\txMessageTpns('主播开播',$title,'account_list',0,$uids,json_encode($sendinfo),'zh-cn');
                	sleep(2);
                	\App\txMessageTpns('Anchor starts broadcasting',$title_en,'account_list',0,$uids,json_encode($sendinfo),'en');
				}
				
			}
		}
  

		$rs['info'][0]['msg']=\PhalApi\T('成功');
		return $rs;
	}

	/**
	 * 修改直播类型
	 * @desc 用于主播修改直播类型
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].msg 成功提示信息
	 * @return string msg 提示信息
	 */
	public function changeLiveType() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid = \App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$stream=\App\checkNull($this->stream);
		$type=\App\checkNull($this->type);
		$type_val=\App\checkNull($this->type_val);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		if( $type==1 && $type_val=='' ){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('密码不能为空');
			return $rs;
		}else if($type > 1 && $type_val<=0){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('价格不能小于等于0');
			return $rs;
		}
		
		
		$data=array(
			"type"=>$type,
			"type_val"=>$type_val,
		);
		
		$domain = new Domain_Live();
		$info=$domain->changeLiveType($uid,$stream,$data);

		$rs['info'][0]['msg']=\PhalApi\T('成功');
		return $rs;
	}
	
	/**
	 * 关闭直播
	 * @desc 用于用户结束直播
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].msg 成功提示信息
	 * @return string msg 提示信息
	 */
	public function stopRoom() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

//        file_put_contents(API_ROOT.'/../log/phalapi/live_stoproom_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 _REQUEST:'.json_encode($_REQUEST)."\r\n",FILE_APPEND);
		$uid = \App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$stream=\App\checkNull($this->stream);
		$type=\App\checkNull($this->type);
		$source=\App\checkNull($this->source);
		$time=\App\checkNull($this->time);
		$sign=\App\checkNull($this->sign);

		if(!$source){ //非socket来源，app访问

			if(!$time){
				$rs['code'] = 1001;
				$rs['msg'] = \PhalApi\T('参数错误,请重试');
				return $rs;
			}

			$now=time();
			if($now-$time>300){
				$rs['code']=1001;
				$rs['msg']=\PhalApi\T('参数错误');
				return $rs;
			}

			if(!$sign){
				$rs['code']=1001;
				$rs['msg']=\PhalApi\T('参数错误,请重试');
				return $rs;
			}
	        
	        $checkdata=array(
	            'uid'=>$uid,
	            'token'=>$token,
	            'time'=>$time,
	            'stream'=>$stream,
	        );
	        
	        $issign=\App\checkSign($checkdata,$sign);
	        if(!$issign){
	            $rs['code']=1001;
	            $rs['msg']=\PhalApi\T('签名错误');
	            return $rs;
	        }
		}
		
		$key='stopRoom_'.$stream;
		$isexist=\App\getcaches($key);

		if(!$isexist ){

			$domain = new Domain_Live();

			$checkToken=\App\checkToken($uid,$token);

            \App\setcaches($key,'1',10);

			if($checkToken==700){

				$domain->stopRoom($uid,$stream);

				$rs['code'] = $checkToken;
				$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
				return $rs;
			}
            
            $info=$domain->stopRoom($uid,$stream);
            
		}
		
		$rs['info'][0]['msg']=\PhalApi\T('关播成功');
//        file_put_contents(API_ROOT.'/../log/phalapi/live_stoproom_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 关播结束:'."\r\n\r\n",FILE_APPEND);

		return $rs;
	}
	
	/**
	 * 直播结束信息
	 * @desc 用于直播结束页面信息展示
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].nums 人数
	 * @return string info[0].length 时长
	 * @return string info[0].votes 映票数
	 * @return string msg 提示信息
	 */
	public function stopInfo() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$stream=\App\checkNull($this->stream);
		
		$domain = new Domain_Live();
		$info=$domain->stopInfo($stream);

		$rs['info'][0]=$info;
		return $rs;
	}
	
	/**
	 * 检查直播状态
	 * @desc 用于用户进房间时检查直播状态
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].type 房间类型
	 * @return string info[0].type_val 收费房间价格，默认0
	 * @return string info[0].type_msg 提示信息
	 * @return string info[0].live_type 房间类型 0 视频直播 1 语音聊天室
	 * @return string msg 提示信息
	 */
	public function checkLive() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$liveuid=\App\checkNull($this->liveuid);
		$stream=\App\checkNull($this->stream);
		
		$configpub=\App\getConfigPub();
		if($configpub['maintain_switch']==1){
			$rs['code']=1002;
			$rs['msg']=$configpub['maintain_tips'];
			return $rs;

		}

		if($uid>0){
			$checkToken=\App\checkToken($uid,$token);
			if($checkToken==700){
				$rs['code'] = $checkToken;
				$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
				return $rs;
			}

			$isban = \App\isBan($uid);
			if(!$isban){
				$rs['code']=1001;
				$rs['msg']=\PhalApi\T('该账号已被禁用');
				return $rs;
			}


		}
        
        
        if($uid==$liveuid){
			$rs['code'] = 1011;
			$rs['msg'] = \PhalApi\T('不能进入自己的直播间');
			return $rs;
		}
		

		$domain = new Domain_Live();
		$info=$domain->checkLive($uid,$liveuid,$stream);
		
		if($info==1005){
			$rs['code'] = 1005;
			$rs['msg'] = \PhalApi\T('直播已结束');
			return $rs;
		}else if($info==1007){
            $rs['code'] = 1007;
			$rs['msg'] = \PhalApi\T('超管不能进入1v1房间');
			return $rs;
        }else if($info==1008){
            $rs['code'] = 1004;
			$rs['msg'] = \PhalApi\T('您已被踢出房间');
			return $rs;
        }
        
        
        $configpri=\App\getConfigPri();
        
        $info['live_sdk']=$configpri['live_sdk'];
        
		$rs['info'][0]=$info;
		
		
		return $rs;
	}
	
	/**
	 * 房间扣费
	 * @desc 用于房间扣费
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].coin 用户余额
	 * @return string info[0].level 用户等级
	 * @return string msg 提示信息
	 */
	public function roomCharge() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$liveuid=\App\checkNull($this->liveuid);
		$stream=\App\checkNull($this->stream);
		
        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		$domain = new Domain_Live();
		$info=$domain->roomCharge($uid,$liveuid,$stream);
		
		if($info==1005){
			$rs['code'] = 1005;
			$rs['msg'] = \PhalApi\T('直播已结束');
			return $rs;
		}else if($info==1006){
			$rs['code'] = 1006;
			$rs['msg'] = \PhalApi\T('该房间非扣费房间');
			return $rs;
		}else if($info==1007){
			$rs['code'] = 1007;
			$rs['msg'] = \PhalApi\T('房间费用有误');
			return $rs;
		}else if($info==1008){
			$rs['code'] = 1008;
			$rs['msg'] = \PhalApi\T('您的余额不足');
			return $rs;
		}
		$rs['info'][0]['coin']=$info['coin'];
		$rs['info'][0]['level']=$info['level'];
	
		return $rs;
	}

	/**
	 * 房间计时扣费
	 * @desc 用于房间计时扣费
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].coin 用户余额
	 * @return string msg 提示信息
	 */
	public function timeCharge() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$liveuid=\App\checkNull($this->liveuid);
		$stream=\App\checkNull($this->stream);
        
        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
  
		$domain = new Domain_Live();
		
		$key='timeCharge_'.$stream.'_'.$uid;
		$cache=\App\getcaches($key);
		if($cache){
			$coin=$domain->getUserCoin($uid);
			$rs['info'][0]['coin']=$coin['coin'];
			return $rs;
		}
  
  
		
		$info=$domain->roomCharge($uid,$liveuid,$stream);
		
		if($info==1005){
			$rs['code'] = 1005;
			$rs['msg'] = \PhalApi\T('直播已结束');
			return $rs;
		}else if($info==1006){
			$rs['code'] = 1006;
			$rs['msg'] = \PhalApi\T('该房间非扣费房间');
			return $rs;
		}else if($info==1007){
			$rs['code'] = 1007;
			$rs['msg'] = \PhalApi\T('房间费用有误');
			return $rs;
		}else if($info==1008){
			$rs['code'] = 1008;
			$rs['msg'] = \PhalApi\T('您的余额不足');
			return $rs;
		}
		$rs['info'][0]['coin']=$info['coin'];
		
		\App\setcaches($key,1,50);
	
		return $rs;
	}
	

	/**
	 * 进入直播间
	 * @desc 用于用户进入直播
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].votestotal 直播映票
	 * @return string info[0].barrage_fee 弹幕价格
	 * @return string info[0].userlist_time 用户列表获取间隔
	 * @return string info[0].chatserver socket地址
	 * @return string info[0].isattention 是否关注主播，0表示未关注，1表示已关注
	 * @return string info[0].nums 房间人数
	 * @return string info[0].pull_url 播流地址
	 * @return string info[0].linkmic_uid 连麦用户ID，0表示未连麦
	 * @return string info[0].linkmic_pull 连麦播流地址
	 * @return array info[0].userlists 用户列表
	 * @return array info[0].game 押注信息
	 * @return array info[0].gamebet 当前用户押注信息
	 * @return string info[0].gametime 游戏剩余时间
	 * @return string info[0].gameid 游戏记录ID
	 * @return string info[0].gameaction 游戏类型，1表示炸金花，2表示牛牛，3表示转盘
	 * @return string info[0].game_bankerid 庄家ID
	 * @return string info[0].game_banker_name 庄家昵称
	 * @return string info[0].game_banker_avatar 庄家头像
	 * @return string info[0].game_banker_coin 庄家余额
	 * @return string info[0].game_banker_limit 上庄限额
	 * @return object info[0].vip 用户VIP信息
	 * @return string info[0].vip.type VIP类型，0表示无VIP，1表示普通VIP，2表示至尊VIP
	 * @return object info[0].liang 用户靓号信息
	 * @return string info[0].liang.name 号码，0表示无靓号
     * @return object info[0].guard 守护信息
	 * @return string info[0].guard.type 守护类型，0表示非守护，1表示月守护，2表示年守护
	 * @return string info[0].guard.endtime 到期时间
	 * @return string info[0].guard_nums 主播守护数量
     * @return object info[0].pkinfo 主播连麦/PK信息
	 * @return string info[0].pkinfo.pkuid 连麦用户ID
	 * @return string info[0].pkinfo.pkpull 连麦用户播流地址
	 * @return string info[0].pkinfo.ifpk 是否PK
	 * @return string info[0].pkinfo.pk_time 剩余PK时间（秒）
	 * @return string info[0].pkinfo.pk_gift_liveuid 主播PK总额
	 * @return string info[0].pkinfo.pk_gift_pkuid 连麦主播PK总额
	 * @return string info[0].isred 是否显示红包
	 * @return string info[0].show_goods 直播间在售商品展示
	 * @return string info[0].show_goods['goodsid'] 直播间展示的在售商品ID
	 * @return string info[0].show_goods['goods_name'] 直播间展示的在售商品名称
	 * @return string info[0].show_goods['goods_thumb'] 直播间展示的在售商品封面
	 * @return string info[0].show_goods['goods_price'] 直播间展示的在售商品价格
	 * @return string info[0].show_goods['goods_type'] 直播间展示的在售商品 商品类型 0 站内商品 1 站外商品
	 * @return string msg 提示信息
	 */
	public function enterRoom() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$liveuid=\App\checkNull($this->liveuid);
		$stream=\App\checkNull($this->stream);
		$mobileid=\App\checkNull($this->mobileid);
        
        if($uid>0){
        	$checkToken=\App\checkToken($uid,$token);
			if($checkToken==700){
				$rs['code'] = $checkToken;
				$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
				return $rs;
			}
	  
	  
			$isban = \App\isBan($uid);
			if(!$isban){
				$rs['code']=1001;
				$rs['msg']=\PhalApi\T('该账号已被禁用');
				return $rs;
			}
        }
        

		$domain = new Domain_Live();
        
        if($uid>0){
        	$domain->checkShut($uid,$liveuid);
        }
        
		$userinfo=$this->getRoomUserInfo($uid,$liveuid);
		
        if($uid<0){
        	$userinfo['id']=$mobileid;
        	$token=$mobileid;
        }
		
		\App\setcaches($token,$userinfo);
		
        /* 用户列表 */
        $userlists=$this->getUserList($liveuid,$stream);
        
        /* 用户连麦 */
		$linkmic_uid='0';
		$linkmic_pull='';
		$showVideo=\App\hGet('ShowVideo',$liveuid);
//      file_put_contents(API_ROOT.'/../log/phalapi/live_enterroom_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 用户连麦提交信息 liveuid:'.json_encode($liveuid)."\r\n",FILE_APPEND);
//		file_put_contents(API_ROOT.'/../log/phalapi/live_enterroom_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 用户连麦提交信息 showVideo:'.json_encode($showVideo)."\r\n",FILE_APPEND);
		if($showVideo){
            $showVideo_a=json_decode($showVideo,true);
			$linkmic_uid=$showVideo_a['uid'];
			$linkmic_pull=$this->getPullWithSign($showVideo_a['pull_url']);
		}
        
        /* 主播连麦 */
        $pkinfo=array(
            'pkuid'=>'0',
            'pkpull'=>'0',
            'ifpk'=>'0',
            'pk_time'=>'0',
            'pk_gift_liveuid'=>'0',
            'pk_gift_pkuid'=>'0',
        );
        $pkuid=\App\hGet('LiveConnect',$liveuid);
//      file_put_contents(API_ROOT.'/../log/phalapi/live_enterroom_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 主播连麦提交信息 进房间:'."\r\n",FILE_APPEND);
//      file_put_contents(API_ROOT.'/../log/phalapi/live_enterroom_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 主播连麦提交信息 uid:'.json_encode($uid)."\r\n",FILE_APPEND);
//      file_put_contents(API_ROOT.'/../log/phalapi/live_enterroom_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 主播连麦提交信息 liveuid:'.json_encode($liveuid)."\r\n",FILE_APPEND);
        if($pkuid){
            $pkinfo['pkuid']=$pkuid;
            /* 在连麦 */
            $pkpull=\App\hGet('LiveConnect_pull',$pkuid);
            $pkinfo['pkpull']=$this->getPullWithSign($pkpull);
            $ifpk=\App\hGet('LivePK',$liveuid);
            if($ifpk){
                $pkinfo['ifpk']='1';
                $pk_time=\App\hGet('LivePK_timer',$liveuid);
                if(!$pk_time){
                    $pk_time=\App\hGet('LivePK_timer',$pkuid);
                }
                $nowtime=time();
                if($pk_time && $pk_time >0 && $pk_time< $nowtime){
                    $cha=5*60 - ($nowtime - $pk_time);
                    $pkinfo['pk_time']=(string)$cha;
                    
                    $pk_gift_liveuid=\App\hGet('LivePK_gift',$liveuid);
                    if($pk_gift_liveuid){
                        $pkinfo['pk_gift_liveuid']=(string)$pk_gift_liveuid;
                    }
                    $pk_gift_pkuid=\App\hGet('LivePK_gift',$pkuid);
                    if($pk_gift_pkuid){
                        $pkinfo['pk_gift_pkuid']=(string)$pk_gift_pkuid;
                    }
                    
                }else{
                    $pkinfo['ifpk']='0';
                }
            }

        }
//		file_put_contents(API_ROOT.'/../log/phalapi/live_enterroom_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 主播连麦提交信息 pkinfo:'.json_encode($pkinfo)."\r\n\r\n",FILE_APPEND);
		$configpri=\App\getConfigPri();
  
		$game = array(
			"brand"=>array(),
			"bet"=>array('0','0','0','0'),
			"time"=>"0",
			"id"=>"0",
			"action"=>"0",
			"bankerid"=>"0",
			"banker_name"=>\PhalApi\T("吕布"),
			"banker_avatar"=>"",
			"banker_coin"=>"0",
        );

	    $info=array(
			'votestotal'=>$userlists['votestotal'],
			'barrage_fee'=>$configpri['barrage_fee'],
			'userlist_time'=>$configpri['userlist_time'],
			'chatserver'=>$configpri['chatserver'],
			'linkmic_uid'=>$linkmic_uid,
			'linkmic_pull'=>$linkmic_pull,
			'nums'=>$userlists['nums'],
			'game'=>$game['brand'],
			'gamebet'=>$game['bet'],
			'gametime'=>$game['time'],
			'gameid'=>$game['id'],
			'gameaction'=>$game['action'],
			'game_bankerid'=>$game['bankerid'],
			'game_banker_name'=>$game['banker_name'],
			'game_banker_avatar'=>$game['banker_avatar'],
			'game_banker_coin'=>$game['banker_coin'],
			'game_banker_limit'=>$configpri['game_banker_limit'],
			'speak_limit'=>$configpri['speak_limit'],
			'barrage_limit'=>$configpri['barrage_limit'],
			'vip'=>$userinfo['vip'],
			'liang'=>$userinfo['liang'],
			'issuper'=>(string)$userinfo['issuper'],
			'usertype'=>(string)$userinfo['usertype'],
			'turntable_switch'=>(string)$configpri['turntable_switch'],
			'level'=>$userinfo['level']
		);
		$info['isattention']=(string)\App\isAttention($uid,$liveuid);
		$info['userlists']=$userlists['userlist'];
        
        /* 用户余额 */
        
    	$domain2 = new Domain_User();
		$usercoin=$domain2->getBalance($uid);
        
        $info['coin']=(string)$usercoin['coin'];
        
        /* 守护 */
        $domain_guard = new Domain_Guard();

		$guard_info=$domain_guard->getUserGuard($uid,$liveuid);
		$guard_nums=$domain_guard->getGuardNums($liveuid);

        $info['guard']=$guard_info;
        $info['guard_nums']=$guard_nums;
        
        /* 主播连麦/PK */
        $info['pkinfo']=$pkinfo;
        
        /* 红包 */
        $key='red_list_'.$stream;
        $nums=\App\lSize($key);
        $isred='0';
        if($nums>0){
            $isred='1';
        }
		$info['isred']=$isred;
        
        /* 奖池 */
        $info['jackpot_level']='-1';
		$jackpotset = \App\getJackpotSet();
        if($jackpotset['switch']){
            $jackpotinfo = \App\getJackpotInfo();
            $info['jackpot_level']=$jackpotinfo['level'];
        }
        /** 敏感词集合*/
		$dirtyarr=array();
		if($configpri['sensitive_words']){
            $dirtyarr=explode(',',$configpri['sensitive_words']);
        }
		$info['sensitive_words']=$dirtyarr;

		//获取直播间在售商品的正在展示的商品
		$info['show_goods']=$domain->getLiveShowGoods($liveuid);
		$pull=\App\getPull($stream);
		$info['pull']=$pull;
		
		$configpri=\App\getConfigPri();
		$dailytask_switch=$configpri['dailytask_switch'];

		if($uid<0){
			$dailytask_switch=0;
		}
		
		if($dailytask_switch){
			//观看直播计时---用于每日任务--记录用户进入时间
			$daily_tasks_key='watch_live_daily_tasks_'.$uid;
			$enterRoom_time=time();
			\App\setcaches($daily_tasks_key,$enterRoom_time);
		}
		

		$mic_list=[];
		$live_type=\App\getLiveType($liveuid,$stream);
		if($live_type==1){ //语音聊天室
			$mic_list=$domain->userGetVoiceMicList($liveuid,$stream);
		}

		$info['mic_list']=$mic_list;

		//每日任务开关
		$info['dailytask_switch']=(string)$dailytask_switch;


		\App\zIncrBy('user_'.$stream,0,(string)$uid);

		$info['game_xqtb_switch']=$configpri['game_xqtb_switch'];
		$info['game_xydzp_switch']=$configpri['game_xydzp_switch'];

		$rs['info'][0]=$info;
		return $rs;
	}
	
    /**
     * 连麦信息
     * @desc 用于主播同意连麦 写入redis
     * @return int code 操作码，0表示成功
     * @return array info
     * @return string msg 提示信息
     */
		 
    public function showVideo() {
        $rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$touid=\App\checkNull($this->touid);
		$pull_url=\App\checkNull($this->pull_url);
		
//        file_put_contents(API_ROOT.'/../log/phalapi/live_showvideo_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 uid:'.json_encode($uid)."\r\n",FILE_APPEND);
//        file_put_contents(API_ROOT.'/../log/phalapi/live_showvideo_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 token:'.json_encode($token)."\r\n",FILE_APPEND);
//        file_put_contents(API_ROOT.'/../log/phalapi/live_showvideo_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 touid:'.json_encode($touid)."\r\n",FILE_APPEND);
//        file_put_contents(API_ROOT.'/../log/phalapi/live_showvideo_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 pull_url:'.json_encode($pull_url)."\r\n",FILE_APPEND);
  
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
        
        $data=array(
            'uid'=>$touid,
            'pull_url'=>$pull_url,
        );
		
//        file_put_contents(API_ROOT.'/../log/phalapi/live_showvideo_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息:'.json_encode($data)."\r\n\r\n",FILE_APPEND);
  
		\App\hSet('ShowVideo',$uid,json_encode($data));
					
        return $rs;
    }

    /**
     * 获取最新流地址
     * @desc 用于连麦获取最新流地址
     * @return int code 操作码，0表示成功
     * @return array info
     * @return string msg 提示信息
     */
		 
    protected function getPullWithSign($pull) {
        $rs = array('code' => 0, 'msg' => '', 'info' => array());
		
        if($pull==''){
            return '';
        }
		$list1 = preg_split ('/\?/', $pull);
        $originalUrl=$list1[0];
        
        $list = preg_split ('/\//', $originalUrl);
        $url = preg_split ('/\./', end($list));
        
        $stream=$url[0];

        $play_url=\App\PrivateKeyA('rtmp',$stream,0);
					
        return $play_url;
    }

	
    /**
     * 获取僵尸粉
     * @desc 用于获取僵尸粉
     * @return int code 操作码，0表示成功
     * @return array info 僵尸粉信息
     * @return string msg 提示信息
     */
		 
    public function getZombie() {
        $rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$stream=\App\checkNull($this->stream);
		
		$stream2=explode('_',$stream);
		$liveuid=$stream2[0];
		
	
		$domain = new Domain_Live();
		
		$iszombie=$domain->isZombie($liveuid);
		
		if($iszombie==0){
			$rs['code']=1001;
			$rs['info']=\PhalApi\T('未开启僵尸粉');
			$rs['msg']=\PhalApi\T('未开启僵尸粉');
			return $rs;
			
		}

		/* 判断用户是否进入过 */
		$isvisit=\App\sIsMember($liveuid.'_zombie_uid',$uid);

		if($isvisit){
			$rs['code']=1003;
			$rs['info']=\PhalApi\T('用户已访问');
			$rs['msg']=\PhalApi\T('用户已访问');
			return $rs;
			
		}
	
		$times=\App\getcaches($liveuid.'_zombie');
		
		if($times && $times>10){
			$rs['code']=1002;
			$rs['info']=\PhalApi\T('次数已满');
			$rs['msg']=\PhalApi\T('次数已满');
			return $rs;
		}else if($times){
			$times=$times+1;
			
		}else{
			$times=0;
		}
	
		\App\setcaches($liveuid.'_zombie',$times);
		\App\sAdd($liveuid.'_zombie_uid',$uid);
		
		/* 用户列表 */

        $uidlist=\App\zRevRange('user_'.$stream,0,-1);
	
		$uid=implode(",",$uidlist);

		$where='0';
		if($uid){
			$where.=','.$uid;
		}
  
		$where=str_replace(",,",',',$where);
		$where=trim($where, ",");
		$list=$domain->getZombie($stream,$where);
		if($list){
			$rs['info'][0]['list'] = $list;
			$nums=\App\zCard('user_'.$stream);
			if(!$nums){
				$nums=0;
			}
			$rs['info'][0]['nums']=(string)$nums;
		}
		
        return $rs;
    }
	/**
	 * 用户列表
	 * @desc 用于直播间顶部获取用户列表
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].userlist 用户列表
	 * @return string info[0].nums 房间人数
	 * @return string info[0].votestotal 主播映票
	 * @return string info[0].guard_type 守护类型
	 * @return string msg 提示信息
	 */
	public function getUserLists() {
        $rs = array('code' => 0, 'msg' => '', 'info' => array());

		$liveuid=\App\checkNull($this->liveuid);
		$stream=\App\checkNull($this->stream);
		$key=\App\checkNull($this->key);
		$p=$this->p;

		/* 用户列表 */
		$info=$this->getUserListNew($liveuid,$stream,$key,$p);

		$rs['info'][0]=$info;

        return $rs;
	}

    protected function getUserList($liveuid,$stream,$p=1) {
		/* 用户列表 */

		$pnum=20;
		$start=($p-1)*$pnum;
        
        $domain_guard = new Domain_Guard();
		
		/* $key="getUserLists_".$stream.'_'.$p;
		$list=getcaches($key);
		if(!$list){  */
            $list=array();

            $uidlist=\App\zRevRange('user_'.$stream,$start,$pnum-1,true);
            
            foreach($uidlist as $k=>$v){
                $userinfo=\App\getUserInfo($k);
                /*$info=explode(".",$v);
                $userinfo['contribution']=(string)$info[0];*/
                $userinfo['contribution']=(string)$v;
                
                /* 守护 */
                $guard_info=$domain_guard->getUserGuard($k,$liveuid);
                $userinfo['guard_type']=$guard_info['type'];
                
                $list[]=$userinfo;
            }
            
        /*     if($list){
                setcaches($key,$list,30);
            }
		} */
        
        if(!$list){
            $list=array();
        }
        
		$nums=\App\zCard('user_'.$stream);
        if(!$nums){
            $nums=0;
        }

		$rs['userlist']=$list;
		$rs['nums']=(string)$nums;

		/* 主播信息 */
		$domain = new Domain_Live();
		$rs['votestotal']=$domain->getVotes($liveuid);
		

        return $rs;
    }
		

		
	/**
	 * 弹窗
	 * @desc 用于直播间弹窗信息
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].consumption 消费总数
	 * @return string info[0].votestotal 票总数
	 * @return string info[0].follows 关注数
	 * @return string info[0].fans 粉丝数
	 * @return string info[0].isattention 是否关注，0未关注，1已关注
	 * @return string info[0].action 操作显示，0表示自己，30表示普通用户，40表示管理员，501表示主播设置管理员，502表示主播取消管理员，60表示超管管理主播，70表示对方是超管
	 * @return object info[0].vip 用户VIP信息
	 * @return string info[0].vip.type VIP类型，0表示无VIP，1表示普通VIP，2表示至尊VIP
	 * @return object info[0].liang 用户靓号信息
	 * @return string info[0].liang.name 号码，0表示无靓号
	 * @return array info[0].label 印象标签
	 * @return string msg 提示信息
	 */
	public function getPop() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$liveuid=\App\checkNull($this->liveuid);
		$touid=\App\checkNull($this->touid);

        $info=\App\getUserInfo($touid);
		if(!$info){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('用户信息不存在');
			return $rs;
		}
		$info['follows']=\App\getFollows($touid);
		$info['fans']=\App\getFans($touid);
  
		$info['isattention']=(string)\App\isAttention($uid,$touid);
		if($uid==$touid){
			$info['action']='0';
		}else{
			$uid_admin=\App\isAdmin($uid,$liveuid);
			$touid_admin=\App\isAdmin($touid,$liveuid);

			if($uid_admin==40 && $touid_admin==30){
				$info['action']='40';
			}else if($uid_admin==50 && $touid_admin==30){
				$info['action']='501';
			}else if($uid_admin==50 && $touid_admin==40){
				$info['action']='502';
			}else if($uid_admin==60 && $touid_admin<50){
				$info['action']='40';
			}else if($uid_admin==60 && $touid_admin==50){
				$info['action']='60';
			}else if($touid_admin==60){
				$info['action']='70';
			}else{
				$info['action']='30';
			}
			
		}
        
        /* 标签 */
        $labels=array();
        if($touid==$liveuid){
            $key="getMyLabel_".$touid;
            $label=\App\getcaches($key);
			
            if(!$label){
                $domain2 = new Domain_User();
                $label = $domain2->getMyLabel($touid);

                \App\setcaches($key,$label);
            }

            //语言包
            $language=\PhalApi\DI()->language;
            foreach ($label as $k => $v) {
            	if($language=='en'){
            		$label[$k]['name']=$v['name_en'];
            	}
            }
            
            $labels=array_slice($label,0,2);
        }
        $info['label']=$labels;
        
		$rs['info'][0]=$info;
		return $rs;
	}

	/**
	 * 礼物列表
	 * @desc 用于获取礼物列表
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].coin 余额
	 * @return array info[0].giftlist 礼物列表
	 * @return string info[0].giftlist[].id 礼物ID
	 * @return string info[0].giftlist[].type 礼物类型
	 * @return string info[0].giftlist[].mark 礼物标识
	 * @return string info[0].giftlist[].giftname 礼物名称
	 * @return string info[0].giftlist[].needcoin 礼物价格
	 * @return string info[0].giftlist[].gifticon 礼物图片
	 * @return string msg 提示信息
	 */
	public function getGiftList() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$live_type=\App\checkNull($this->live_type);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		$domain = new Domain_Live();
        $giftlist=$domain->getGiftList($live_type);
        $proplist=$domain->getPropgiftList();
		
		$domain2 = new Domain_User();
		$coin=$domain2->getBalance($uid);
		
		$rs['info'][0]['giftlist']=$giftlist;
		$rs['info'][0]['proplist']=$proplist;
		$rs['info'][0]['coin']=(string)$coin['coin'];
		return $rs;
	}

	/**
	 * 赠送礼物
	 * @desc 用于赠送礼物
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].gifttoken 礼物token
	 * @return string info[0].level 用户等级
	 * @return string info[0].coin 用户余额
	 * @return string msg 提示信息
	 */
	public function sendGift() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$liveuid=\App\checkNull($this->liveuid);
		$stream=\App\checkNull($this->stream);
		$giftid=\App\checkNull($this->giftid);
		$giftcount=\App\checkNull($this->giftcount);
		$ispack=\App\checkNull($this->ispack);
		$is_sticker=\App\checkNull($this->is_sticker);
		$touids=\App\checkNull($this->touids);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
        
        $domain = new Domain_Live();
		if($is_sticker=='1'){
			$giftlist=$domain->getPropgiftList();

			$gift_info=array();
			foreach($giftlist as $k=>$v){
				if($giftid == $v['id']){
				   $gift_info=$v;
				}
			}
		}else{

			$live_type=\App\getLiveType($liveuid,$stream);
			$giftlist=$domain->getGiftList($live_type);
			$gift_info=array();
			foreach($giftlist as $k=>$v){
				if($giftid == $v['id']){
				   $gift_info=$v;
				}
			}
		}

        if(!$gift_info){
            $rs['code']=1002;
			$rs['msg']=\PhalApi\T('礼物信息不存在');
			return $rs;
        }
        
        if($gift_info['mark']==2){
            // 守护
            $domain_guard = new Domain_Guard();
            $guard_info=$domain_guard->getUserGuard($uid,$liveuid);
            if($guard_info['type']!=2){
               	$rs['code']=1002;
                $rs['msg']=\PhalApi\T('该礼物是年守护专属礼物');
                return $rs;
            }else{ //年守护

            	//判断直播间类型，如果是语音聊天室，判断被送礼物的人里面是否包含主播
            	$touids_arr=explode(',', $touids);
            	if(count($touids_arr)>1){ //被送礼物是多人时，不能送守护礼物
            		$rs['code']=1002;
	                $rs['msg']=\PhalApi\T('守护礼物只能赠送守护主播');
	                return $rs;
            	}else if(count($touids_arr)==1){
            		if($touids_arr[0]!=$liveuid){ //被送礼物是一个人，且不是主播
            			$rs['code']=1002;
		                $rs['msg']=\PhalApi\T('守护礼物只能赠送守护主播');
		                return $rs;
            		}
            	}else{
            		$rs['code']=1002;
	                $rs['msg']=\PhalApi\T('请选择接收礼物用户');
	                return $rs;
            	}

            }
        }

		$result=$domain->sendGift($uid,$liveuid,$stream,$giftid,$giftcount,$ispack,$touids);
	
		if($result==1001){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('您的余额不足');
			return $rs;
		}else if($result==1002){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('礼物信息不存在');
			return $rs;
		}else if($result==1003){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('背包中数量不足');
			return $rs;
		}else if($result==1004){
			$rs['code']=1004;
			$rs['msg']=\PhalApi\T('请选择接收礼物用户');
			return $rs;
		}
		
		$rs['info'][0]['gifttoken']=$result['gifttoken'];
        $rs['info'][0]['level']=$result['level'];
        $rs['info'][0]['coin']=(string)$result['coin'];
		
		unset($result['gifttoken']);
		unset($result['level']);
		unset($result['coin']);

		
		\App\setcaches($rs['info'][0]['gifttoken'],$result['list']);
		
		return $rs;
	}
	
	/**
	 * 发送弹幕
	 * @desc 用于发送弹幕
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].barragetoken 礼物token
	 * @return string info[0].level 用户等级
	 * @return string info[0].coin 用户余额
	 * @return string msg 提示信息
	 */
	public function sendBarrage() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$liveuid=\App\checkNull($this->liveuid);
		$stream=\App\checkNull($this->stream);
		$giftid=0;
		$giftcount=1;
		
		$content=\App\checkNull($this->content);
		if($content==''){
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('弹幕内容不能为空');
			return $rs;
		}
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		$domain = new Domain_Live();

		$isshut=$domain->checkShut($uid,$liveuid);

		if($isshut){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('已被禁言,不能发弹幕');
			return $rs;
		}

		$result=$domain->sendBarrage($uid,$liveuid,$stream,$giftid,$giftcount,$content);
		
		if($result==1001){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('您的余额不足');
			return $rs;
		}else if($result==1002){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('礼物信息不存在');
			return $rs;
		}
		
		$rs['info'][0]['barragetoken']=$result['barragetoken'];
        $rs['info'][0]['level']=$result['level'];
        $rs['info'][0]['coin']=$result['coin'];
		
		unset($result['barragetoken']);

		\App\setcaches($rs['info'][0]['barragetoken'],$result);

		return $rs;
	}

	/**
	 * 设置/取消管理员
	 * @desc 用于设置/取消管理员
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].isadmin 是否是管理员，0表示不是管理员，1表示是管理员
	 * @return string msg 提示信息
	 */
	public function setAdmin() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$liveuid=\App\checkNull($this->liveuid);
		$touid=\App\checkNull($this->touid);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		if($uid!=$liveuid){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('你不是该房间主播，无权操作');
			return $rs;
		}
		
		$domain = new Domain_Live();
		$info=$domain->setAdmin($liveuid,$touid);
		
		if($info==1004){
			$rs['code'] = 1004;
			$rs['msg'] = \PhalApi\T('最多设置5个管理员');
			return $rs;
		}else if($info==1003){
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('操作失败，请重试');
			return $rs;
		}
		
		$rs['info'][0]['isadmin']=$info;
		return $rs;
	}
	
	/**
	 * 管理员列表
	 * @desc 用于获取管理员列表
	 * @return int code 操作码，0表示成功
	 * @return array info 管理员列表
	 * @return array info[0]['list'] 管理员列表
	 * @return array info[0]['list'][].userinfo 用户信息
	 * @return string info[0]['nums'] 当前人数
	 * @return string info[0]['total'] 总数
	 * @return string msg 提示信息
	 */
	public function getAdminList() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$liveuid=\App\checkNull($this->liveuid);
		$domain = new Domain_Live();
		$info=$domain->getAdminList($liveuid);
		
		$rs['info'][0]=$info;
		return $rs;
	}

	/**
	 * 举报类型
	 * @desc 用于获取举报类型
	 * @return int code 操作码，0表示成功
	 * @return array info 列表
	 * @return string info[].name 类型名称
	 * @return string msg 提示信息
	 */
	public function getReportClass() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$domain = new Domain_Live();
		$info=$domain->getReportClass();

		
		$rs['info']=$info;
		return $rs;
	}

	
	/**
	 * 用户举报
	 * @desc 用于用户举报
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].msg 举报成功
	 * @return string msg 提示信息
	 */
	public function setReport() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$touid=\App\checkNull($this->touid);
		$content=\App\checkNull($this->content);

		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		if(!$content){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('举报内容不能为空');
			return $rs;
		}
        
        if(mb_strlen($content)>200){
            $rs['code'] = 1002;
            $rs['msg'] = \PhalApi\T('账号长度不能超过{num}个字符',['num'=>200]);
            return $rs;
        }
		
		$domain = new Domain_Live();
		$info=$domain->setReport($uid,$touid,$content);
		if($info===false){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('举报失败，请重试');
			return $rs;
		}
		
		$rs['info'][0]['msg']=\PhalApi\T("举报成功");
		return $rs;
	}
	
	/**
	 * 主播映票
	 * @desc 用于获取主播映票
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].votestotal 用户总数
	 * @return string msg 提示信息
	 */
	public function getVotes() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$liveuid=\App\checkNull($this->liveuid);
		$domain = new Domain_Live();
		$info=$domain->getVotes($liveuid);
		
		$rs['info'][0]=$info;
		return $rs;
	}
	
    /**
     * 禁言
     * @desc 用于 禁言操作
     * @return int code 操作码，0表示成功
     * @return array info
     * @return string msg 提示信息
     */
		 
    public function setShutUp() {
        $rs = array('code' => 0, 'msg' => \PhalApi\T('禁言成功'), 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$liveuid=\App\checkNull($this->liveuid);
		$touid=\App\checkNull($this->touid);
		$type=\App\checkNull($this->type);
		$stream=\App\checkNull($this->stream);
  
//        file_put_contents(API_ROOT.'/../log/phalapi/live_setshutup_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 request:'.json_encode($_REQUEST)."\r\n\r\n",FILE_APPEND);

		$checkToken = \App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code']=700;
			$rs['msg']= \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
						
        $uidtype = \App\isAdmin($uid,$liveuid);

		if($uidtype==30 ){
			$rs["code"]=1001;
			$rs["msg"]=\PhalApi\T('无权操作');
			return $rs;
		}

        $touidtype = \App\isAdmin($touid,$liveuid);
		
		if($touidtype==60){
			$rs["code"]=1001;
			$rs["msg"]=\PhalApi\T('对方是超管，不能禁言');
			return $rs;
		}

		if($uidtype==40){
			if( $touidtype==50){
				$rs["code"]=1002;
				$rs["msg"]=\PhalApi\T('对方是主播，不能禁言');
				return $rs;
			}
			if($touidtype==40 ){
				$rs["code"]=1002;
				$rs["msg"]=\PhalApi\T('对方是管理员，不能禁言');
				return $rs;
			}
            
            /* 守护 */
            $domain_guard = new Domain_Guard();
            $guard_info=$domain_guard->getUserGuard($touid,$liveuid);

            if($uid != $liveuid && $guard_info && $guard_info['type']==2){
                $rs["code"]=1004;
                $rs["msg"]=\PhalApi\T('对方是尊贵守护，不能禁言');
                return $rs;
            }
			
		}
		$showid=0;
        if($type ==1 || $stream){
            $showid=1;
        }
        $domain = new Domain_Live();
		$result = $domain->setShutUp($uid,$liveuid,$touid,$showid);
        
        if($result==1002){
            $rs["code"]=1003;
            $rs["msg"]=\PhalApi\T('对方已被禁言');
            return $rs;
            
        }else if(!$result){
            $rs["code"]=1005;
            $rs["msg"]=\PhalApi\T('操作失败，请重试');
            return $rs;
        }
        
        \App\hSet($liveuid . 'shutup',$touid,1);
        
        return $rs;
    }
	
	/**
	 * 踢人
	 * @desc 用于直播间踢人
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].msg 踢出成功
	 * @return string msg 提示信息
	 */
	public function kicking() {
		$rs = array('code' => 0, 'msg' => '踢人成功', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$liveuid=\App\checkNull($this->liveuid);
		$touid=\App\checkNull($this->touid);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$admin_uid=\App\isAdmin($uid,$liveuid);
		if($admin_uid==30){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('无权操作');
			return $rs;
		}
		$admin_touid=\App\isAdmin($touid,$liveuid);
		
		if($admin_touid==60){
			$rs["code"]=1002;
			$rs["msg"]=\PhalApi\T('对方是超管，不能被踢出');
			return $rs;
		}
		
		if($admin_uid!=60){
			if($admin_touid==50 ){
				$rs['code']=1001;
				$rs['msg']=\PhalApi\T('对方是主播，不能被踢出');
				return $rs;
			}
            
            if($admin_touid==40 ){
				$rs['code']=1002;
				$rs['msg']=\PhalApi\T('对方是管理员，不能被踢出');
				return $rs;
			}
            /* 守护 */
            $domain_guard = new Domain_Guard();
            $guard_info=$domain_guard->getUserGuard($touid,$liveuid);

            if($uid != $liveuid && $guard_info && $guard_info['type']==2){
                $rs["code"]=1004;
                $rs["msg"]=\PhalApi\T('对方是尊贵守护，不能被踢出');
                return $rs;
            }
		}
        
        $domain = new Domain_Live();
        
		$result = $domain->kicking($uid,$liveuid,$touid);
        if($result==1002){
            $rs["code"]=1005;
			$rs["msg"]=\PhalApi\T('对方已被踢出');
			return $rs;
        }else if(!$result){
            $rs["code"]=1006;
			$rs["msg"]=\PhalApi\T('操作失败，请重试');
			return $rs;
        }

		$rs['info'][0]['msg']=\PhalApi\T('踢出成功');
		return $rs;
	}
	
	/**
	 * 踢人列表
	 * @desc 用于直播间踢人列表
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].msg 踢出成功
	 * @return string msg 提示信息
	 */
	public function kickingList()
	{
		$rs = array('code' => 0, 'msg' => '踢人列表', 'info' => array());
		
		$uid = \App\checkNull($this->uid);
		$token = \App\checkNull($this->token);
		$liveuid = \App\checkNull($this->liveuid);
		
		$checkToken = \App\checkToken($uid, $token);
		if ($checkToken == 700) {
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$admin_uid = \App\isAdmin($uid, $liveuid);
		if ($admin_uid == 30) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('无权查看');
			return $rs;
		}
		
		
		$domain = new Domain_Live();
		
		$result = $domain->kickingList($liveuid);
		$rs['info'] = $result;
		return $rs;
	}
	
	
	/**
     * 超管关播
     * @desc 用于超管关播
     * @return int code 操作码，0表示成功
     * @return array info
     * @return string info[0].msg 提示信息
     * @return string msg 提示信息
     */
		
	public function superStopRoom(){

		$rs = array('code' => 0, 'msg' => \PhalApi\T('关闭成功'), 'info' =>array());
        
        $uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $liveuid=\App\checkNull($this->liveuid);
        $type=\App\checkNull($this->type);
        $banruleid=\App\checkNull($this->banruleid);
        
        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		if($type==1){

			if(!$banruleid){
				$rs['code'] = 1003;
				$rs['msg'] = \PhalApi\T('请选择封禁时间');
				return $rs;
			}

			$rules=\App\getLiveBanRules();
			$rule_ids=array_column($rules,'id');
			if(!in_array($banruleid,$rule_ids)){
				$rs['code'] = 1004;
				$rs['msg'] = \PhalApi\T('封禁时间不正确');
				return $rs;
			}

		}else{
			$banruleid=0;
		}
  
		
		$domain = new Domain_Live();
		
		$result = $domain->superStopRoom($uid,$liveuid,$type,$banruleid);
		if($result==1001){
			$rs['code'] = 1001;
            $rs['msg'] = \PhalApi\T('你不是超管，无权操作');
			$rs['info'][0]['msg'] = \PhalApi\T('你不是超管，无权操作');
            return $rs;
		}else if($result==1002){
			$rs['code'] = 1002;
            $rs['msg'] = \PhalApi\T('该主播已被禁播');
			$rs['info'][0]['msg'] = \PhalApi\T('该主播已被禁播');
            return $rs;
		}
		$rs['info'][0]['msg']=\PhalApi\T('关闭成功');
 
    	return $rs;
	}

	/**
	 * 用户余额
	 * @desc 用于获取用户余额
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].coin 余额
	 * @return string msg 提示信息
	 */
	public function getCoin() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		
		$domain2 = new Domain_User();
		$coin=$domain2->getBalance($uid);

		$rs['info'][0]['coin']=$coin['coin'];
		return $rs;
	}

	/**
	 * 检测房间状态
	 * @desc 用于检测房间状态
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string info[0].status 状态 0关1开
	 * @return string msg 提示信息
	 */
	public function checkLiveing() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$stream=\App\checkNull($this->stream);

		$domain = new Domain_Live();

		$checkToken=\App\checkToken($uid,$token);

		if($checkToken==700){

			//将主播关播
			$domain->stopRoom($uid,$stream);

			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
//		file_put_contents(API_ROOT.'/../log/phalapi/live_checkliveing_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 uid:'.json_encode($uid)."\r\n",FILE_APPEND);
//		file_put_contents(API_ROOT.'/../log/phalapi/live_checkliveing_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 提交参数信息 stream:'.json_encode($stream)."\r\n",FILE_APPEND);
  
		$info=$domain->checkLiveing($uid,$stream);
  
//        file_put_contents(API_ROOT.'/../log/phalapi/live_checkliveing_'.date('Y-m-d').'.txt',date('Y-m-d H:i:s').' 返回信息 info:'.json_encode($info)."\r\n\r\n",FILE_APPEND);

		$rs['info'][0]['status']=$info;
		return $rs;
	}

	/**
	 * 获取直播信息
	 * @desc 用于个人中心进入直播间获取直播信息
	 * @return int code 操作码，0表示成功
	 * @return array info  直播信息
	 * @return string msg 提示信息
	 */
	public function getLiveInfo() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$liveuid=\App\checkNull($this->liveuid);
		
        if($liveuid<1){
            $rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('参数错误');
			return $rs;
        }
		
		
		$domain2 = new Domain_Live();
		$info=$domain2->getLiveInfo($liveuid);
        if(!$info){
            $rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('直播已结束');
			return $rs;
        }

		$rs['info'][0]=$info;
		return $rs;
	}

	/**
	 * 直播间在售商品列表是否正在展示状态
	 * @desc 用于主播改变直播间在售商品列表是否正在展示状态
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return int info[0]['status'] 商品是否展示 0 不展示 1 展示
	 * @return int info[0]['goods_type'] 商品类型 0 站内商品 1 站外商品
	 */
	public function setLiveGoodsIsShow(){
		$rs = array('code' => 0, 'msg' => \PhalApi\T('设置成功'), 'info' => array());
		
		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $goodsid=\App\checkNull($this->goodsid);

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->setLiveGoodsIsShow($uid,$goodsid);
		if($res==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('商品不存在');
			return $rs;
		}else if($res==1002){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('商品不可售');
			return $rs;
		}else if($res==1003){
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('商品取消展示失败');
			return $rs;
		}else if($res==1004){
			$rs['code'] = 1004;
			$rs['msg'] = \PhalApi\T('商品设置展示失败');
			return $rs;
		}

		$rs['info'][0]=$res;

		return $rs;
	}

	/**
	 * 用户离开直播间
	 * @desc 用于每日任务统计用户观看时长
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 */
	public function signOutWatchLive(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);


        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$type='1';  //用户观看直播间时长任务
		/*观看直播计时---每日任务--取出用户进入时间*/
		$key='watch_live_daily_tasks_'.$uid;
		$starttime=\App\getcaches($key);
		if($starttime){
			$endtime=time();  //当前时间
			$data=[
				'type'=>$type,
				'starttime'=>$starttime,
				'endtime'=>$endtime,
			];
			
			\App\dailyTasks($uid,$data);
			
			//删除当前存入的时间
			\App\delcache($key);
		}

		return $rs;
	}
	
	
	/**
	 * 用户分享直播间
	 * @desc 用于每日任务统计分享次数
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 */
	public function shareLiveRoom(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$stream = \App\checkNull($this->stream);
		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$configpri=\App\getConfigPri();
		$dailytask_switch=$configpri['dailytask_switch'];
		if($dailytask_switch){
			$data=[
				'type'=>'5',
				'nums'=>'1',

			];
			\App\dailyTasks($uid,$data);
		}
		
		if (!empty($stream)){
			$domain=new Domain_Live();
			$domain->shareLiveAdd($stream);
		}
	
		
		return $rs;
	}
	
	/**
	 * 用户申请上麦
	 * @desc 用于用户申请上麦
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 */
	public function applyVoiceLiveMic(){
		$rs = array('code' => 0, 'msg' => \PhalApi\T('上麦申请成功'), 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);

        if(!$stream){
        	$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->applyVoiceLiveMic($uid,$stream);
		if($res==1001){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('主播未开播,无法申请上麦');
			return $rs;
		}
		if($res==1002){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('非语音聊天室,无法申请上麦');
			return $rs;
		}
		if($res==1003){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('已申请上麦,请耐心等待');
			return $rs;
		}
		if($res==1004){
			$rs['code']=1004;
			$rs['msg']=\PhalApi\T('申请上麦失败,请重试');
			return $rs;
		}
		if($res==1005){
			$rs['code']=1005;
			$rs['msg']=\PhalApi\T('申请上麦人数已达上限');
			return $rs;
		}
		return $rs;

	}

	/**
	 * 用户取消语音聊天室上麦申请
	 * @desc 用于用户取消语音聊天室上麦申请
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 */
	public function cancelVoiceLiveMicApply(){
		$rs = array('code' => 0, 'msg' => \PhalApi\T('上麦申请取消成功'), 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);

        if(!$stream){
        	$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->cancelVoiceLiveMicApply($uid,$stream);
		if($res==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('未申请上麦');
			return $rs;
		}

		if($res==1002){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('上麦申请取消失败');
			return $rs;
		}

		return $rs;
	}

	/**
	 * 主播处理语音聊天室用户上麦申请
	 * @desc 用于主播处理语音聊天室用户上麦申请
	 * @return int code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return array info[0]['position'] 返回用户上麦的麦位
	 */
	public function handleVoiceMicApply(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);
        $apply_uid=\App\checkNull($this->apply_uid);
        $status=\App\checkNull($this->status);

        if(!$stream || !$apply_uid){
        	$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
        }

        if(!in_array($status, ['0','1'])){
        	$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->handleVoiceMicApply($uid,$stream,$apply_uid,$status);
		if($res==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('未开启直播');
			return $rs;
		}
		if($res==1002){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('用户已取消上麦');
			return $rs;
		}

		if($res==1003){
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('拒绝用户上麦失败');
			return $rs;
		}

		if($res==1004){
			$rs['code'] = 1004;
			$rs['msg'] = \PhalApi\T('当前麦位已满,无法上麦');
			return $rs;
		}

		if($res==1005){
			$rs['code'] = 1005;
			$rs['msg'] = \PhalApi\T('同意用户上麦失败');
			return $rs;
		}

		if($res==1006){
			$rs['code'] = 1006;
			$rs['msg'] = \PhalApi\T('用户已经上麦,不可重复处理');
			return $rs;
		}

		$position=$res['position'];
		if($position=='-1'){
			$rs['msg'] = \PhalApi\T('拒绝用户上麦成功');
			$rs['info']=$res;
			return $rs;
		}else{
			$rs['msg'] = \PhalApi\T('同意用户上麦成功');
			$rs['info']=$res;
			return $rs;
		}
	}

	/**
	 * 获取当前语音聊天室内正在申请连麦的用户列表
	 * @desc 用于获取当前语音聊天室内正在申请连麦的用户列表
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return array info[0].apply_list 返回申请列表
	 * @return array info[0].apply_list[].id 申请上麦用户的id
	 * @return array info[0].apply_list[].user_nickname 申请上麦用户的昵称
	 * @return array info[0].apply_list[].avatar 申请上麦用户的头像
	 * @return array info[0].apply_list[].avatar_thumb 申请上麦用户的小头像
	 * @return array info[0].apply_list[].sex 申请上麦用户的性别
	 * @return array info[0].position 当前用户申请上麦的顺位 -1代表没有申请
	 */
	public function getVoiceMicApplyList(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);

        if(!$stream){
        	$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->getVoiceMicApplyList($uid,$stream);
		$rs['info'][0]=$res;
		return $rs;

	}

	/**
	 * 主播对空麦位设置禁麦或取消禁麦
	 * @desc 用于主播对空麦位设置禁麦或取消禁麦
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 */
	public function changeVoiceEmptyMicStatus(){
		$rs = array('code' => 0, 'msg' => \PhalApi\T('麦位设置成功'), 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);
        $position=\App\checkNull($this->position);
        $status=\App\checkNull($this->status);

        if(!$stream){
        	$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
        }

        if(!in_array($status, ['0','1'])){
        	$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
        }

        if(!is_numeric($position) || floor($position)!=$position){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('麦位错误');
			return $rs;
		}

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		

		if(!in_array($status, ['0','1'])){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->changeVoiceEmptyMicStatus($uid,$stream,$position,$status);
		
		if($res==1001){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('该麦位有用户上麦,无法操作');
			return $rs;
		}

		if($res==1002){
			$rs['code']=1002;
			$rs['msg']=\PhalApi\T('麦位设置失败');
			return $rs;
		}

		if($res==1003){
			$rs['code']=1003;
			$rs['msg']=\PhalApi\T('未开启直播');
			return $rs;
		}

		if($res==1004){
			$rs['code']=1004;
			$rs['msg']=\PhalApi\T('{num}号麦已经禁麦,不可重复处理',['num'=>$position+1]);
			return $rs;
		}

		if($res==1005){
			$rs['code']=1005;
			$rs['msg']=\PhalApi\T('{num}号麦已经取消禁麦,不可重复处理',['num'=>$position+1]);
			return $rs;
		}

		if($status==0){
			$rs['msg']=\PhalApi\T('{num}号麦禁麦成功',['num'=>$position+1]);
		}else{
			$rs['msg']=\PhalApi\T('{num}号麦取消禁麦成功',['num'=>$position+1]);
		}

		return $rs;
	}

	/**
	 * 主播获取语音聊天室麦位列表信息
	 * @desc 用于主播获取语音聊天室麦位列表信息
	 * @return int code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return int info[0].id 返回麦上用户的ID
	 * @return array info[0].user_nickname 返回麦上用户的昵称
	 * @return array info[0].avatar 返回麦上用户的头像
	 * @return array info[0].sex 返回麦上用户的性别
	 * @return array info[0].level 返回麦上用户的等级
	 * @return array info[0].mic_status 返回麦上用户的麦位状态 -1 关麦；  0无人； 1开麦 ； 2 禁麦；
	 * @return array info[0].position 返回麦上用户的麦位0表示第一位，以此类推,最大是7
	 */
	public function anchorGetVoiceMicList(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);

        if(!$stream){
        	$rs['code']=1001;
			$rs['msg']=\PhalApi\T('参数错误');
			return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->anchorGetVoiceMicList($uid,$stream);

		if($res==1001){
			$rs['code']=1001;
			$rs['msg']=\PhalApi\T('主播未开播');
			return $rs;
		}
		$rs['info']=$res;

		return $rs;
	}

	/**
	 * 语音聊天室中主播对麦上用户设置闭麦/开麦或者用户对自己设置闭麦/开麦
	 * @desc 用于语音聊天室中主播对麦上用户设置闭麦/开麦或者用户对自己设置闭麦/开麦
	 * @return int code 状态码,0表示成功
	 * @return string msg 返回提示信息
	 * @return array info 返回信息
	 */
	public function changeVoiceMicStatus(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);
        $position=\App\checkNull($this->position);
        $status=\App\checkNull($this->status);

        if(!$stream || !in_array($status, ['0','1'])){
        	$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('参数错误');
			return $rs;
        }

        if(!is_numeric($position) || floor($position)!=$position || $position<0 || $position>7){
        	$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('参数错误');
			return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->changeVoiceMicStatus($uid,$stream,$position,$status);

		if($res==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('未开启直播');
			return $rs;
		}

		if($res==1002){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('此麦位无人上麦');
			return $rs;
		}

		if($res==1003){
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('此麦位已经禁麦');
			return $rs;
		}

		if($res==1004){
			$rs['code'] = 1004;
			$rs['msg'] = \PhalApi\T('此麦位已经关麦');
			return $rs;
		}

		if($res==1005){
			$rs['code'] = 1005;
			$rs['msg'] = \PhalApi\T('此麦位已经开麦');
			return $rs;
		}

		if($res==1006){
			if($status==0){
				$rs['msg']=\PhalApi\T('关麦失败,请重试');
			}else{
				$rs['msg']=\PhalApi\T('开麦失败,请重试');
			}
			return $rs;
		}

		if($res==1007){
			$rs['code'] = 1007;
			$rs['msg'] = \PhalApi\T('用户已关麦,暂不可开麦');
			return $rs;
		}

		if($res==1008){
			$rs['code'] = 1008;
			$rs['msg'] = \PhalApi\T('只有本麦位用户或主播才可关麦');
			return $rs;
		}

		if($res==1009){
			$rs['code'] = 1009;
			$rs['msg'] = \PhalApi\T('主播已关麦,暂不可开麦');
			return $rs;
		}

		if($res==1010){
			$rs['code'] = 1010;
			$rs['msg'] = \PhalApi\T('只有本麦位用户或主播才可开麦');
			return $rs;
		}

		if($status==0){
			$rs['msg']=\PhalApi\T('{num}号麦位关麦成功',['num'=>$position+1]);
		}else{
			$rs['msg']=\PhalApi\T('{num}号麦位开麦成功',['num'=>$position+1]);
		}

		return $rs;
	}

	/**
	 * 用户主动下麦
	 * @desc 用于用户主动下麦
	 * @return int code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 */
	public function userCloseVoiceMic(){
		$rs = array('code' => 0, 'msg' => \PhalApi\T('下麦成功'), 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);

        if(!$stream){
        	$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('参数错误');
			return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->userCloseVoiceMic($uid,$stream);

		if($res==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('主播未开播');
			return $rs;
		}

		if($res==1002){
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('您未上麦');
			return $rs;
		}

		if($res==1003){
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('此麦位已禁麦');
			return $rs;
		}

		if($res==1004){
			$rs['code'] = 1004;
			$rs['msg'] = \PhalApi\T('下麦失败,请重试');
			return $rs;
		}

		return $rs;
	}

	/**
	 * 语音聊天室主播或管理员将连麦用户下麦
	 * @desc 语音聊天室主播或管理员将连麦用户下麦
	 * @return int code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 */
	public function closeUserVoiceMic(){
		$rs = array('code' => 0, 'msg' => \PhalApi\T('下麦成功'), 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream);
        $touid=\App\checkNull($this->touid);

        if(!$stream || !$touid){
        	$rs['code']=1001;
        	$rs['msg']=\PhalApi\T('参数错误');
        	return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$stream_arr=explode('_', $stream);
		$liveuid=$stream_arr[0];

		//判断语音聊天室主播是否开播
    	$voice_islive=\App\checkVoiceIsLive($liveuid,$stream);

    	if(!$voice_islive){
    		$rs["code"]=1001;
			$rs["msg"]= \PhalApi\T('主播未开播');
			return $rs;
    	}

		if($liveuid!=$uid){//非主播

			//判断用户是否是超管或房间管理员
			$uidtype = \App\isAdmin($uid,$liveuid);

			if($uidtype==30 ){
				$rs["code"]=1001;
				$rs["msg"]=\PhalApi\T('无权操作');
				return $rs;
			}

	        $touidtype = \App\isAdmin($touid,$liveuid);
			
			if($touidtype==60){
				$rs["code"]=1001;
				$rs["msg"]=\PhalApi\T('对方是超管,不能被下麦');
				return $rs;
			}

			if($uidtype==40){ //当前用户是管理员
				
				if($touidtype==40 ){
					$rs["code"]=1002;
					$rs["msg"]=\PhalApi\T('对方是管理员,不能被下麦');
					return $rs;
				}
			}
			
		}else{

			$touidtype = \App\isAdmin($touid,$liveuid);
			
			if($touidtype==60){
				$rs["code"]=1001;
				$rs["msg"]=\PhalApi\T('对方是超管,不能被下麦');
				return $rs;
			}

		}

		$domain=new Domain_Live();
		$res=$domain->closeUserVoiceMic($uid,$liveuid,$stream,$touid);
		if($res==1001){
			$rs["code"]=1001;
			$rs["msg"]=\PhalApi\T('没有连麦信息');
			return $rs;
		}

		if($res==1002){
			$rs["code"]=1002;
			$rs["msg"]=\PhalApi\T('此麦位已禁麦');
			return $rs;
		}

		if($res==1003){
			$rs["code"]=1003;
			$rs["msg"]=\PhalApi\T('该用户下麦失败,请重试');
			return $rs;
		}

		return $rs;
	}

	/**
	 * 语音聊天室上麦用户获取推拉流地址【低延迟流】
	 * @desc 用于语音聊天室上麦用户获取推拉流地址【低延迟流】
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return array info[0].push 连麦用户推流地址
	 */
	public function getVoiceMicStream(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$uid=\App\checkNull($this->uid);
        $token=\App\checkNull($this->token);
        $stream=\App\checkNull($this->stream); //主播房间流名

        if(!$stream){
        	$rs['code']=1001;
        	$rs['msg']=\PhalApi\T('参数错误');
        	return $rs;
        }

        $checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$stream_arr=explode('_', $stream);
		$liveuid=$stream_arr[0];

		//判断语音聊天室主播是否开播
    	$voice_islive=\App\checkVoiceIsLive($liveuid,$stream);

    	if(!$voice_islive){
    		$rs["code"]=1001;
			$rs["msg"]=\PhalApi\T('主播未开播');
			return $rs;
    	}

		$domain=new Domain_Live();
		$res=$domain->getVoiceMicStream($uid,$liveuid,$stream);

		if($res==1001){
			$rs["code"]=1001;
			$rs["msg"]=\PhalApi\T('未上麦');
			return $rs;
		}

		if($res==1002){
			$rs["code"]=1002;
			$rs["msg"]=\PhalApi\T('此麦位已禁麦');
			return $rs;
		}

		$rs['info'][0]=$res;
		return $rs;
	}

	

	/**
	 * 语音聊天室上麦用户获取主播和麦上用户的低延迟播流地址
	 * @desc 语音聊天室上麦用户获取主播和麦上用户的低延迟播流地址
	 * @return int code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return array info[0].uid 用户id
	 * @return array info[0].isanchor 该用户是否是主播 0 否 1 是
	 * @return array info[0].pull 该用户的低延迟播流地址
	 */
	public function getVoiceLivePullStreams(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$stream=\App\checkNull($this->stream);

		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->getVoiceLivePullStreams($uid,$stream);

		if($res==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('未开启直播');
			return $rs;
		}

		$rs['info']=$res;
		return $rs;

	}

	/**
	 * 获取封禁直播间规则列表
	 * @desc 用于获取封禁直播间规则列表
	 * @return int code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return array info[].id 规则id
	 * @return array info[].name 规则名称
	 * @return array info[].type 规则类型
	 */
	public function getLiveBanRules(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);

		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$rules=\App\getLiveBanRules();

		$rs['info']=$rules;
		return $rs;
	}

	/**
	 * 获取主播被封禁信息
	 * @desc 获取主播被封禁信息
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return string info[0]['ban_num'] 封禁时间数字
	 * @return string info[0]['ban_msg'] 封禁提示语
	 */
	public function getLiveBanInfo(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);

		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->getLiveBanInfo($uid);
		$rs['info'][0]=$res;

		return $rs;
	}


	/**
	 * Android用户从后台将app切回前台时检测用户信息redis是否存在
	 * @desc Android用户从后台将app切回前台时检测用户信息redis是否存在
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return array info[0]['is_exist'] 是否存在redis信息 如果不存在的话Android端会重连socket
	 */
	public function checkUserRedis(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$liveuid=\App\checkNull($this->liveuid);
		$mobileid=\App\checkNull($this->mobileid);

		if($uid>0){
			$checkToken=\App\checkToken($uid,$token);
			if($checkToken==700){
				$rs['code'] = $checkToken;
				$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
				return $rs;
			}
		}

		if($uid<0){
        	$token=$mobileid;
        }

        $user_redis= \App\getcaches($token);

        $is_exist="1";

        if(!$user_redis){

        	$userinfo=$this->getRoomUserInfo($uid,$liveuid);

        	if($uid<0){
        		$userinfo['id']=$mobileid;
        	}
			
			\App\setcaches($token,$userinfo);

			$is_exist="0";

        }

        $rs['info'][0]['is_exist']=$is_exist;

        return $rs;

		
	}

	/**
	 * 麦位上其他人获取上麦用户的trtc播流地址
	 * @desc 麦位上其他人获取上麦用户的trtc播流地址
	 * @return int code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return array info[0]['play_url'] 返回播流地址
	 */
	public function getMicPullUrl(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$stream=\App\checkNull($this->stream);

		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$play_url=\App\getTxTrtcUrl($uid,$stream,0);
		$rs['info'][0]['play_url']=$play_url;
		return $rs;
	}

	/**
	 * 获取直播间用户送礼物排行榜
	 * @desc 获取直播间用户送礼物排行榜
	 * @return int code 状态码,0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 * @return array info[]['contribution'] 本场直播贡献值
	 */
	public function getUserRank(){
		$rs = array('code' => 0, 'msg' => '', 'info' => array());

		$stream=\App\checkNull($this->stream);
		$liveuid=\App\checkNull($this->liveuid);

		$domain_guard = new Domain_Guard();

		$list=array();

        $uidlist=\App\zRevRange('user_'.$stream,0,99,true);
	
        foreach($uidlist as $k=>$v){
	        $isExit=\App\zValueExists('user_'.$stream.'_backup',$k);
	        if($isExit==1){
		        $score=\App\zScore('user_'.$stream.'_backup',$k);
		        \App\zAdd('user_'.$stream,$score,$k);
	        }
            $userinfo=\App\getUserInfo($k);
            $info=explode(".",$v);
            $userinfo['contribution']=(string)$info[0];
            
            /* 守护 */
            $guard_info=$domain_guard->getUserGuard($k,$liveuid);
            $userinfo['guard_type']=$guard_info['type'];
            
            $list[]=$userinfo;
        }
        
        if(!$list){
            $list=array();
        }
        
		$rs['info']=$list;

        return $rs;
	}


	//获取进入房间的用户信息
	private function getRoomUserInfo($uid,$liveuid){

		$userinfo=\App\getUserInfo($uid);
		
		$carinfo=\App\getUserCar($uid);
		$userinfo['car']=$carinfo;
		$issuper='0';
		if($userinfo['issuper']==1){
			$issuper='1';
			\App\hSet('super',$userinfo['id'],'1');
		}else{
			\App\hDel('super',$userinfo['id']);
		}

		$usertype = \App\isAdmin($uid,$liveuid);
		$userinfo['usertype'] = $usertype;
		$nowtime=time(); //改
		$stream=$uid.'_'.$nowtime;//改
        $stream2=explode('_',$stream);
		$showid=$stream2[1];
        
        $contribution='0';
		$domain = new Domain_Live();//改
        if($showid && $uid>0){
            $contribution=$domain->getContribut($uid,$liveuid,$showid);
        }

		$userinfo['contribution'] = $contribution;

		//守护
        $domain_guard = new Domain_Guard();
		$guard_info=$domain_guard->getUserGuard($uid,$liveuid);

        $userinfo['guard_type']=$guard_info['type'];
        /* 等级+100 保证等级位置位数相同，最后拼接1 防止末尾出现0 */
        //$userinfo['sign']=$userinfo['contribution'].'.'.($userinfo['level']+100).'1';

        return $userinfo;
	
	}
	/**
	 * 获取主播是否设置默认收货地址
	 * @desc 获取主播是否设置默认收货地址
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 */
	public function isDefaultAddress()
	{
		$rs = array('code' => 0, 'msg' => \PhalApi\T('已设置地址'), 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}
		
		$domain=new Domain_Live();
		$res=$domain->isDefaultAddress($uid);
		
		if($res==1001){
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('未设置地址');
			return $rs;
		}
		
		$rs['info']=$res;
		return $rs;
		
	}
	
	/**
	 * 主播直播添加收货地址
	 * @desc 用于主播直播添加收货地址
	 * @return int code 操作码，0表示成功
	 * @return array info
	 * @return string msg 提示信息
	 */
	public function addAddress()
	{
		$rs = array('code' => 0, 'msg' => \PhalApi\T('地址添加成功'), 'info' => array());
		
		$uid = \App\checkNull($this->uid);
		$token = \App\checkNull($this->token);
		$username = \App\checkNull($this->username);
		$country_code = \App\checkNull($this->country_code);
		$phone = \App\checkNull($this->phone);
		$province = \App\checkNull($this->province);
		$city = \App\checkNull($this->city);
		$area = \App\checkNull($this->area);
		$address = \App\checkNull($this->address);
		$is_default = \App\checkNull($this->is_default);
		$time = \App\checkNull($this->time);
		$sign = \App\checkNull($this->sign);
		$addtime = time();
		
		$checkToken = \App\checkToken($uid, $token);
		if ($checkToken == 700) {
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		if (!$time || !$sign) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('参数错误');
			return $rs;
		}

		$now = time();
		if ($now - $time > 300) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('参数错误');
			return $rs;
		}

		$checkdata = array(
			'uid' => $uid,
			'token' => $token,
			'time' => $time,
			'is_default' => $is_default,
		);
		
		$issign = \App\checkSign($checkdata, $sign);
		if (!$issign) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('签名错误');
			return $rs;
		}

		if ($username == '') {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('请输入姓名');
			return $rs;
		}
		
		if (mb_strlen($username) > 10) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('姓名长度在10个字内');
			return $rs;
		}
		
		$checkmobile = \App\checkMobile($phone);
		
		if (!$checkmobile) {
			$rs['code'] = 1002;
			$rs['msg'] = \PhalApi\T('手机号码不正确');
			return $rs;
		}
		
		if ($province == '') {
			$rs['code'] = 1003;
			$rs['msg'] = \PhalApi\T('请选择省份');
			return $rs;
		}
		
		if ($city == '') {
			$rs['code'] = 1004;
			$rs['msg'] = \PhalApi\T('请选择所在市');
			return $rs;
		}
		
		if ($area == '') {
			$rs['code'] = 1005;
			$rs['msg'] = \PhalApi\T('请选择地区');
			return $rs;
		}
		
		if (!$address) {
			$rs['code'] = 1006;
			$rs['msg'] = \PhalApi\T('请填写详细地址');
			return $rs;
		}
		
		
		$data = array(
			'uid' => $uid,
			'name' => $username,
			'country' => \PhalApi\T('中国'),
			'province' => $province,
			'city' => $city,
			'area' => $area,
			'address' => $address,
			'phone' => $phone,
			'country_code' => $country_code,
			'is_default' => $is_default,
			'addtime' => $addtime
		);
		
		
		$domain = new Domain_Live();
		$result = $domain->addAddress($data);
		
		if ($result == 1001) {
			$rs['code'] = 1001;
			$rs['msg'] = \PhalApi\T('地址添加失败');
			return $rs;
		}
		
		return $rs;
	}
	
	/**
	 * 直播权限说明
	 * @desc 用于展示开启直播功能需要满足的条件完成情况
	 * @return int code 状态码，0表示成功
	 * @return string msg 提示信息
	 * @return array info 返回信息
	 */
	public function isLiveSatisfy()
	{
		$rs = array('code' => 0, 'msg' => \PhalApi\T('获取成功'), 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$domain=new Domain_Live();
		$res=$domain->isLiveSatisfy($uid);
		
		$rs['info']=$res;
		return $rs;
		
	}
	
	/**
	 * 举报直播
	 * @desc 用于举报直播
	 * @return int code 操作码，0表示成功
	 * @return string msg 提示信息
	 */
	public function setLiveReport() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		
		$uid=\App\checkNull($this->uid);
		$token=\App\checkNull($this->token);
		$touid=\App\checkNull($this->touid);
		$stream=\App\checkNull($this->stream);
		$reason=\App\checkNull($this->reason);
		$content=\App\checkNull($this->content);
		$content_json=\App\checkNull($this->content_json);
		
		$checkToken=\App\checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = \PhalApi\T('您的登陆状态失效，请重新登陆！');
			return $rs;
		}

		$data=array(
			'uid'=>$uid,
			'touid'=>$touid,
			'stream'=>$stream,
			'reason'=>$reason,
			'content'=>$content,
			'content_json'=>$content_json,
			'addtime'=>time(),
		);
		$domain = new Domain_Live();
		$info = $domain->setLiveReport($data);
		
		if($info==1000){
			$rs['code'] = 1000;
			$rs['msg'] = \PhalApi\T('直播不存在');
			return $rs;
		}
		$rs['msg'] = \PhalApi\T('举报成功');
		$rs['info'] = [];
		return $rs;
	}
	
	public function getUserListNew($liveuid, $stream, $key, $p)
	{
		/* 用户列表 */
		
		$pnum = 20; // 每页显示的用户数量
		$start = ($p - 1) * $pnum; // 当前页的起始位置
		
		$domain_guard = new Domain_Guard(); // 实例化一个 Domain_Guard 对象
		
		$list = array(); // 初始化用户列表
		
		// 获取所有用户 ID
		$uidlist = \App\zRevRange('user_' . $stream, 0, -1, true);
		
		// 使用 $key 作为搜索关键词
		$search = trim($key);
		
		$filtered_uidlist = [];
		$total_nums = 0;
		$current_index = 0;
		
		// 过滤用户 ID 并统计符合条件的用户总数
		foreach ($uidlist as $k => $v) {
			$userinfo = \App\getUserInfo($k);
			if ($search === '' || stripos($userinfo['user_nickname'], $search) !== false) {
				$isExit=\App\zValueExists('user_'.$stream.'_backup',$k);
				if($isExit==1){
					$score=\App\zScore('user_'.$stream.'_backup',$k);
					\App\zAdd('user_'.$stream,$score,$k);
					$filtered_uidlist[$k] = (string)$score;
					$total_nums++;
				}else{
					$filtered_uidlist[$k] = $v;
					$total_nums++;
				}
				
			}
		}
		
		// 分页处理
		while (count($list) < $pnum && $current_index < count($filtered_uidlist)) {
			$current_user_id = array_keys($filtered_uidlist)[$current_index];
			$userinfo = \App\getUserInfo($current_user_id);
			$isExit=\App\zValueExists('user_'.$stream.'_backup',$current_user_id);
			if($isExit==1){
				$score=\App\zScore('user_'.$stream.'_backup',$current_user_id);
				\App\zAdd('user_'.$stream,$score,$current_user_id);
				$userinfo['contribution'] = (string)$score;
			}else{
				$userinfo['contribution'] = (string)$filtered_uidlist[$current_user_id];
			}
			
			
			// 获取守护信息
			$guard_info = $domain_guard->getUserGuard($current_user_id, $liveuid);
			$userinfo['guard_type'] = $guard_info['type'];
			
			$list[] = $userinfo; // 将用户信息添加到列表中
			
			$current_index++;
		}
		
		// 如果没有用户信息，初始化为空数组
		if (!$list) {
			$list = array();
		}
		
		// 返回结果
		$rs['userlist'] = $list; // 设置用户列表
		$rs['nums'] = (string)$total_nums; // 设置符合条件的用户总数
		
		return $rs; // 返回结果
	}


}
