<?php

namespace WeMiniGrade\Api;

class Shop extends BaseApi
{
    /**
     * 获取接入状态
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/enter/enter_check.html
     * @return mixed
     */
    public function checkRegister()
    {
        $url = $this->getUrl(__FUNCTION__);
        return $this->sendRequestWithToken($url);
    }

    /**
     * 完成接入任务
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/enter/finish_access_info.html
     * @param int access_info_item  6:完成spu接口，7:完成订单接口，8:完成物流接口，9:完成售后接口，10:测试完成，11:发版完成
     * @return mixed
     */
    public function finishRegister(int $item_id)
    {
        $url = $this->getUrl(__FUNCTION__);
        $param = [
            'access_info_item' => $item_id
        ];
        return $this->sendRequestWithToken($url, $param);

    }

    /**
     * 场景接入申请
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/enter/scene_apply.html
     * @param int scene_group_id  1:视频号、公众号场景
     * @return mixed
     */
    public function appleScene(int $group_id)
    {
        $url = $this->getUrl(__FUNCTION__);
        $param = [
            'scene_group_id' => $group_id
        ];
        return $this->sendRequestWithToken($url, $param);
    }

    /**
     * 获取商家类目列表
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/category_list.html
     * @return mixed
     */
    public function getAccountCatList()
    {
        $url = $this->getUrl(__FUNCTION__);
        return $this->sendRequestWithToken($url);
    }

    /**
     * 获取商家品牌列表
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/brand_list.html
     * @return mixed
     */
    public function getAccountBrandList()
    {
        $url = $this->getUrl(__FUNCTION__);
        return $this->sendRequestWithToken($url);
    }

    /**
     * 更新商家信息
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/update_info.html
     * @param string $path 小程序path
     * @param string $phone 客服联系方式
     * @return mixed
     */
    public function updateAccount(string $path = '', string $phone = '')
    {
        $url = $this->getUrl(__FUNCTION__);
        $param = [];
        if ($path) {
            $param['service_agent_path'] = $path;
        } elseif ($phone) {
            $param['service_agent_phone'] = $phone;
        }

        return $this->sendRequestWithToken($url, $param);
    }

    /**
     * 获取商家信息
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/get_info.html
     * @return mixed
     */
    public function getAccount()
    {
        $url = $this->getUrl(__FUNCTION__);
        return $this->sendRequestWithToken($url);
    }

    /**
     * 获取三级类目列表
     * @return mixed
     */
    public function getCatList()
    {
        $key = 'cat_list';
        if (!$data = WeMiniCache::get($key)) {
            $url = $this->getUrl(__FUNCTION__);
            $data = $this->sendRequestWithToken($url);

            if ($data) {
                WeMiniCache::set($key, $data, 80000);
            }
        }

        return $data['third_cat_list'];

    }

    /**
     * 获取接口URL
     * @param string $method 方法名称
     * @return string
     */
    private function getUrl($method)
    {
        return ApiUrl::SHOP . '/' . ApiUrl::SHOP_URI[$method];
    }


}