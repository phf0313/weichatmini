<?php

namespace WeMiniGrade\Api;

class Shop extends BaseApi
{
    private $uri = [
        // 介入流程
        'checkRegister' => 'register/check', // 获取接入状态
        'finishRegister' => 'register/finish_access_info', // 完成介入任务
        'appleScene' => 'register/apply_scene', // 场景接入申请

        // 类目、品牌
        'getCatList' => 'cat/get', //类目
        'uploadImage' => 'img/upload', // 上传图片
        'auditBrand' => 'audit/audit_brand', // 品牌审核
        'auditCategory' => 'audit/audit_category', // 类目审核
        'getAudit' => 'audit/result', // 获取审核结果

         // 商家
        'getAccountCatList' => 'account/get_category_list', // 获取商家类目列表
        'getAccountBrandList' => 'account/get_brand_list', // 获取商家品牌列表
        'updateAccount' => 'account/update_info', // 更新商家信息
        'getAccount' => 'account/get_info', // 获取商家信息

        // 商品
        'addSpu' => 'spu/add', // 添加商品
        'delSpu' => 'spu/del', // 删除商品
        'delSpuAudit' => 'spu/del_audit', //撤回商品审核
        'getSpu' => 'spu/get', // 获取商品
        'getSpuList' => 'spu/get_list', // 获取商品列表
        'updateSpu' => 'spu/update', // 更新商品
        'onlineSpu' => 'spu/listing', // 上架商品
        'offlineSpu' => 'spu/delisting', // 下架商品
        'updateSpuNotAudit' => 'spu/update_without_audit', // 免审核更新商品

        // 订单
        'checkOrderScene' => 'scene/check', // 检查场景值是否在支付校验范围内
        'addOrder' => 'order/add', // 生成订单
        'payOrder' => 'order/pay', // 同步订单支付结果
        'getOrder' => 'order/get', // 获取订单详情
        'getFinderOrderList' => 'order/get_list_by_finder', // 按照推广员获取订单
        'getSharerOrderList' => 'order/get_list_by_sharer', // 按照分享员获取订单

        // 物流
        'getDeliveryCompanyList' => 'delivery/get_company_list', // 获取快递公司列表
        'sendDelivery' => 'delivery/send', // 订单发货
        'recieveDelivery' => 'delivery/recieve', // 订单确认收货

        // 优惠券（略）

        // 售后
        'addAftersale' => 'aftersale/add', // 创建售后
        'getAftersale' => 'aftersale/get', // 获取订单下售后单
        'updateAftersale' => 'aftersale/update', // 更新售后

        // 推广员
        'getPromoterList' => 'promoter/list', // 获取推广员列表
    ];

    /**
     * 获取接口URL
     * @param $method
     * @return string
     */
    private function getUrl($method)
    {
        return ApiUrl::SHOP.'/'.$this->uri[$method];
    }

    public function getCatList()
    {
        $key = 'cat_list';
        if(!$list = WeMiniCache::get($key)){
            $url = $this->getUrl(__FUNCTION__);
            $list = $this->sendRequestWithToken($url);

            if($list){
                WeMiniCache::setTime(80000);
                WeMiniCache::set($key, $list);
            }
        }

        return $list['third_cat_list'];

    }
}