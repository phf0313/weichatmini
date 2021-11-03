<?php

namespace WechatMini\Api;

class SessionKey extends BaseApi
{
	public function get($code){
		$url = ApiUrl::SESSION_KEY;
		$param = array(
			'appid'=>$this->appid,
			'secret'=>$this->secret,
			'js_code'=>$code,
			'grant_type'=>'authorization_code',
		);
		return file_get_contents($url.'?'.http_build_query($param));
	}
}