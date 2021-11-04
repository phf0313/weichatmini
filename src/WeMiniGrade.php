<?php

namespace WeMiniGrade;

use WeMiniGrade\Api\BaseApi;
use WeMiniGrade\Api\CustomMsg;
use WeMiniGrade\Api\QRCode;
use WeMiniGrade\Api\SessionKey;
use WeMiniGrade\Api\Shop;
use WeMiniGrade\Api\Statistic;
use WeMiniGrade\Api\TemplateMsg;

use WeMiniGrade\Api\WeMiniCache;

class WeMiniGrade
{
	private $appid;
	private $secret;
	private $instance;

	public function __construct($appid,$secret,$token_cache_dir){
		$this->appid = $appid;
		$this->secret = $secret;
		$this->instance = [];
        WeMiniCache::init($token_cache_dir);
	}

    /**
     * @return BaseApi 基础框架
     */
    public function Base(){
        if(!isset($this->instance['base'])){
            $this->instance['base'] = new BaseApi($this->appid,$this->secret);
        }
        return $this->instance['base'];
    }

	/**
	 * @param $code
	 * @return mixed sessionkey相关数组
	 */
	public function getSessionKey($code){
		if(!isset($this->instance['sessionkey'])){
			$this->instance['sessionkey'] = new SessionKey($this->appid,$this->secret);
		}
		return $this->instance['sessionkey']->get($code);
	}

	/**
	 * @return TemplateMsg 模板消息对象
	 */
	public function TemplateMsg(){
		if(!isset($this->instance['template'])){
			$this->instance['template'] = new TemplateMsg($this->appid,$this->secret);
		}
		return $this->instance['template'];
	}

	/**
	 * @return QRCode 二维码对象
	 */
	public function QRCode(){
		if(!isset($this->instance['qrcode'])){
			$this->instance['qrcode'] = new QRCode($this->appid,$this->secret);
		}
		return $this->instance['qrcode'];
	}

	/**
	 * @return Statistic 数据统计对象
	 */
	public function Statistic(){
		if(!isset($this->instance['statistic'])){
			$this->instance['statistic'] = new Statistic($this->appid,$this->secret);
		}
		return $this->instance['statistic'];
	}

	/**
	 * @return CustomMsg 客户消息对象
	 */
	public function CustomMsg(){
		if(!isset($this->instance['custommsg'])){
			$this->instance['custommsg'] = new CustomMsg($this->appid,$this->secret);
		}
		return $this->instance['custommsg'];
	}

    /**
     * @return Shop 商品类目对象
     */
    public function Shop(){
        if(!isset($this->instance['shop'])){
            $this->instance['shop'] = new Shop($this->appid,$this->secret);
        }
        return $this->instance['shop'];
    }

}