<?php


namespace WeMiniGrade\Api;

use http\Params;

class BaseApi
{
    protected $appid;
    protected $secret;

    public function __construct($appid, $secret)
    {
        $this->appid = $appid;
        $this->secret = $secret;
    }

    /**
     * 获取access token
     * @param int $refresh
     * @return mixed|string
     * @throws \Exception
     */
    public function getAccessToken(int $refresh = 0)
    {
        $token = WeMiniCache::get($this->appid . '_token', false);
        if ($token) {
            return $token;
        }
        $url = ApiUrl::ACCESS_TOKEN;
        $param = array(
            'grant_type' => 'client_credential',
            'appid' => $this->appid,
            'secret' => $this->secret,
        );
        $res = $this->sendHttpRequest($url, $param, '', false);
        if (!isset($res['access_token'])) {
            throw new \Exception($res['errcode'] . ':' . $res['errmsg'], $res['errcode']);
        }
        WeMiniCache::set($this->appid . '_token', $res['access_token'], $res['expires_in'] - 200);
        return $res['access_token'];
    }

    /**
     * 重新获取access token
     * @return mixed|string
     * @throws \Exception
     */
    public function refreshAccessToken()
    {
        return $this->getAccessToken(1);
    }

    /**
     * 带access token 请求
     * @param $url
     * @param string $body_param
     * @param bool $is_post
     * @return array|mixed
     * @throws \Exception
     */
    public function sendRequestWithToken($url, $body_param = '', $is_post = true)
    {
        $token = [
            'access_token' => $this->getAccessToken()
        ];
        return $this->sendHttpRequest($url, $token, $body_param, $is_post);
    }

    /**
     * 发送请求
     * @param string $url
     * @param array $url_param
     * @param array $body_param
     * @param bool $is_post
     * @return mixed
     * @throws Exception
     */
    public function sendHttpRequest($url, $url_param = '', $body_param = '', $is_post = true)
    {
        if ($url_param) {
            $url_param = '?' . http_build_query($url_param);
        }
        if ($body_param) {
            $body_param = json_encode($body_param, JSON_UNESCAPED_UNICODE);
        } else {
            $body_param = '{}';
        }
        $header = array();
        $ch = curl_init($url . $url_param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        if ($is_post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body_param);
        }
        $data = curl_exec($ch);
        curl_close($ch);
        $array_data = json_decode($data, true);
        if ($array_data && is_array($array_data)) {
            if ((isset($array_data['errcode']) && $array_data['errcode'] == 0) || isset($array_data['access_token'])) {
                return $array_data;
            } else {
                throw new \Exception($array_data['errmsg'], $array_data['errcode']);
            }
        } else {
            throw new \Exception($array_data);
        }
    }


}