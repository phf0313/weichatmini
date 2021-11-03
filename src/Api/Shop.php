<?php

namespace phf0313\WechatMini\Api;

class Shop extends BaseApi
{
    public function getCatList()
    {
        $url = ApiUrl::SHOP_CAT;

        $key = 'cat_list';
        if(!$list = WeCache::get($key)){
            $list = $this->sendRequestWithToken($url);

            if($list){
                WeCache::setTime(80000);
                WeCache::set($key, $list);
            }
        }

        return $list['third_cat_list'];

    }
}