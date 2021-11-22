<?php


namespace WeMiniGrade\Api;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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
        $res = $this->sendHttpRequest($url, $param);
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
     * @param string $content_type
     * @return array|mixed
     * @throws \Exception
     */
    public function sendRequestWithToken($url, $body_param = '', $content_type = '')
    {
        $token = [
            'access_token' => $this->getAccessToken()
        ];
        return $this->sendHttpRequest($url, $token, $body_param, $content_type);
    }

    /**
     * 发送请求
     * @param string $url
     * @param array $url_param
     * @param array $body_param
     * @param string $content_type
     * @return mixed
     * @throws Exception
     */
    public function sendHttpRequest($url, $url_param = '', $body_param = '', $content_type = '')
    {
        if ($url_param) {
            $url .=  '?' . http_build_query($url_param);
        }
        try{
            $client = new Client(['timeout' => 3.0]);
            switch ($content_type) {
                case 'form-data':
                    $response = $client->request('POST', $url, [
                        'multipart' => $body_param
                    ]);
                    break;
                default:
                    $response = $client->request('POST', $url, [
                        'json' => $body_param
                    ]);

            }
            $array_data = $response->getBody()->getContents();
            $array_data = json_decode($array_data, true);
            if ((isset($array_data['errcode']) && $array_data['errcode'] == 0) || isset($array_data['access_token'])) {
                return $array_data;
            } else {
                throw new \Exception($array_data['errmsg'], $array_data['errcode']);
            }
        }catch(\Exception $ex){
            throw $ex;
        }

    }


}