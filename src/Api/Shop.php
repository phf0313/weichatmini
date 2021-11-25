<?php

namespace WeMiniGrade\Api;

use Exception;
use GuzzleHttp\Psr7;

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
     * @param int $access_info_item 6:完成spu接口，7:完成订单接口，8:完成物流接口，9:完成售后接口，10:测试完成，11:发版完成
     * @return mixed
     */
    public function finishRegister(int $access_info_item)
    {
        $url = $this->getUrl(__FUNCTION__);
        $param = [
            'access_info_item' => $access_info_item
        ];
        return $this->sendRequestWithToken($url, $param);

    }

    /**
     * 场景接入申请
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/enter/scene_apply.html
     * @param int $scene_group_id 1:视频号、公众号场景
     * @return mixed
     */
    public function appleScene(int $scene_group_id)
    {
        $url = $this->getUrl(__FUNCTION__);
        $param = [
            'scene_group_id' => $scene_group_id
        ];
        return $this->sendRequestWithToken($url, $param);
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
     * 上传图片
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/public/upload_img.html
     * @param array $image 图片信息
     * @return mixed
     */
    public function uploadImage(array $image)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            [
                'name' => 'resp_type',
                'contents' => $image['resp_type'] ?? 1, // 0:此参数返回media_id，目前只用于品牌申请品牌和类目，推荐使用1：返回临时链接
            ],
            [
                'name' => 'upload_type',
                'contents' => $image['upload_type'] ?? 1, // 0:图片流，1:图片url
            ],
        ];
        switch ($image['upload_type']) {
            case 1:
                $param[] = [
                    'name' => 'img_url',
                    'contents' => $image['img_url'] ?? '', // upload_type=1时必传
                ];
                break;
            case 0:
                $param[] = [
                    'name' => 'media',
                    'contents' => Psr7\Utils::tryFopen($image['media'], 'r'), // 图片流
                ];
                break;
        }

        return $this->sendRequestWithToken($url, $param, 'form-data');

    }

    /**
     * 类目审核
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/audit/audit_category.html
     * @param array $cat 类目信息
     * @return mixed
     */
    public function auditCategory(array $cat)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'audit_req' => [
                'license' => $cat['license'] ?? [], // 营业执照或组织机构代码证，图片url
                'category_info' => [
                    'level1' => $cat['level1'] ?? 0, // 一级类目
                    'level2' => $cat['level2'] ?? 0, // 二级类目
                    'level3' => $cat['level3'] ?? 0, // 三级类目
                    'certificate' => $cat['certificate'] ?? [], // 资质材料，图片url
                ],
            ]
        ];

        return $this->sendRequestWithToken($url, $param);

    }

    /**
     * 获取审核结果
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/audit/audit_result.html
     * @param string $audit_id 审核单ID
     * @return mixed
     */
    public function getAudit(string $audit_id)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'audit_id' => $audit_id ?? 0,
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
     * @param string $service_agent_path 小程序path
     * @param string $service_agent_phone 客服联系方式
     * @return mixed
     */
    public function updateAccount(string $service_agent_path = '', string $service_agent_phone = '')
    {
        $url = $this->getUrl(__FUNCTION__);
        $param = [];
        if ($service_agent_path) {
            $param['service_agent_path'] = $service_agent_path;
        } elseif ($service_agent_phone) {
            $param['service_agent_phone'] = $service_agent_phone;
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
     * 增加商品
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/update_info.html
     * @param array $goods 商品信息
     * @return mixed
     */
    public function addSpu(array $goods)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'out_product_id' => $goods['out_product_id'] ?? '',
            'title' => $goods['title'] ?? '',
            'path' => $goods['path'] ?? '',
            'head_img' => $goods['head_img'] ?? [],
            'qualification_pics' => $goods['qualification_pics'] ?? [],
            'desc_info' => [
                'desc' => $goods['desc_info']['desc'] ?? '',
                'imgs' => $goods['desc_info']['imgs'] ?? '',
            ],
            'third_cat_id' => $goods['third_cat_id'] ?? '',
            'brand_id' => $goods['brand_id'] ?? '2100000000', // 没有品牌时使用2100000000
            'skus' => [],
            'express_fee' => $goods['express_fee'] ?? 0,
            'sell_time' => $goods['sell_time'] ?? '',
            'pick_up_type' => $goods['pick_up_type'] ?? [1], // 配送方式 1快递 2同城 3上门自提 4点餐
            'onsale' => $goods['onsale'] ?? 1, // 0-不在售 1-在售
        ];
        foreach ($goods['skus'] as $sku) {
            $tmp_sku = [
                'out_product_id' => $sku['out_product_id'] ?? '',
                'out_sku_id' => $sku['out_sku_id'] ?? '',
                'thumb_img' => $sku['thumb_img'] ?? '',
                'sale_price' => $sku['sale_price'] ?? 1000,// 售卖价格,以分为单位
                'market_price' => $sku['market_price'] ?? 2000,// 市场价格,以分为单位
                'stock_num' => $sku['stock_num'] ?? 10,// 库存
                'barcode' => $sku['barcode'] ?? '',// 条形码
                'sku_code' => $sku['sku_code'] ?? '',// 商品编码
            ];

            $param['skus'][] = $tmp_sku;
        }

        return $this->sendRequestWithToken($url, $param);
    }

    /**
     * 上架商品
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/update_info.html
     * @param int $type 1上架，0下架
     * @param string $out_product_id 商家自定义商品ID
     * @param string $product_id 交易组件平台内部商品ID
     * @return mixed
     */
    public function onlineOfflineSpu($type, $out_product_id = '', $product_id = '')
    {
        switch ($type) {
            case 1:
                $url = $this->getUrl('onlineSpu');
                break;
            case 0:
                $url = $this->getUrl('offlineSpu');
                break;
            default:
                throw new Exception('请选择上架还是下架');
        }
        $param = [];
        if($out_product_id){
            $param['out_product_id'] = (string)$out_product_id;
        }
        if($product_id){
            $param['product_id'] = (int)$product_id;
        }

        return $this->sendRequestWithToken($url, $param);

    }

    /**
     * 免审核更新商品
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/update_spu_without_audit.html
     * @param array $goods 商品信息
     * @return mixed
     */
    public function updateSpuNotAudit(array $goods)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [];
        if(isset($goods['out_product_id'])){
            $param['out_product_id'] = (string)$goods['out_product_id'];
        }
        if(isset($goods['product_id'])){
            $param['out_product_id'] = (int)$goods['product_id'];
        }
        if(isset($goods['path'])){
            $param['path'] = $goods['path'];
        }
        if(isset($goods['skus'])){
            $param['skus'] = [];
            foreach($goods['skus'] as $sku){
                $tmp_sku = [
                    'out_sku_id' => $sku['out_sku_id'],
                    'sale_price' => $sku['sale_price'],
                    'market_price' => $sku['market_price'],
                    'stock_num' => $sku['stock_num'],
                    'barcode' => $sku['barcode'],
                    'sku_code' => $sku['sku_code'],
                ];
                $param['skus'][] = $tmp_sku;
            }
        }

        return $this->sendRequestWithToken($url, $param);

    }



    /**
     * 获取商品列表
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/get_spu_list.html
     * @param array $condition 条件
     * @param int $page 页码
     * @param int $page_size 页面数量
     * @return mixed
     */
    public function getSpuList(array $condition = [], int $page = 1, int $page_size = 10)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'start_create_time' => $condition['start_create_time'] ?? '', // 时间范围 create_time 和 update_time 同时存在时，以 create_time 的范围为准
            'end_create_time' => $condition['end_create_time'] ?? '',
            'start_update_time' => $condition['start_update_time'] ?? '',
            'end_update_time' => $condition['end_update_time'] ?? '',
            'need_edit_spu' => $condition['need_edit_spu'] ?? 0, // 默认0:获取线上数据, 1:获取草稿数据
            'page' => $page,
            'page_size' => $page_size,
        ];
        if (isset($condition['status'])) {
            $param['status'] = $condition['status']; // 商品状态
        }

        return $this->sendRequestWithToken($url, $param);

    }

    /**
     * 更新商品
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/update_spu.html
     * @param array $goods 商品信息
     * @return mixed
     */
    public function updateSpu(array $goods)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'out_product_id' => $goods['out_product_id'] ?? '',
            'product_id' => $goods['product_id'] ?? '',
            'title' => $goods['title'] ?? '',
            'path' => $goods['path'] ?? '',
            'head_img' => $goods['head_img'] ?? [],
            'qualification_pics' => $goods['qualification_pics'] ?? [],
            'desc_info' => [
                'desc' => $goods['desc_info']['desc'] ?? '',
                'imgs' => $goods['desc_info']['imgs'] ?? '',
            ],
            'third_cat_id' => $goods['third_cat_id'] ?? '',
            'brand_id' => $goods['brand_id'] ?? '2100000000', // 没有品牌时使用2100000000
            'skus' => [],
            'express_fee' => $goods['express_fee'] ?? 0,
            'sell_time' => $goods['sell_time'] ?? '',
            'pick_up_type' => $goods['pick_up_type'] ?? [1], // 配送方式 1快递 2同城 3上门自提 4点餐
            'onsale' => $goods['onsale'] ?? 1, // 0-不在售 1-在售
        ];
        foreach ($goods['skus'] as $sku) {
            $tmp_sku = [
                'out_product_id' => $sku['out_product_id'] ?? '',
                'out_sku_id' => $sku['out_sku_id'] ?? '',
                'thumb_img' => $sku['thumb_img'] ?? '',
                'sale_price' => $sku['sale_price'] ?? 1000,// 售卖价格,以分为单位
                'market_price' => $sku['market_price'] ?? 2000,// 市场价格,以分为单位
                'stock_num' => $sku['stock_num'] ?? 10,// 库存
                'barcode' => $sku['barcode'] ?? '',// 条形码
                'sku_code' => $sku['sku_code'] ?? '',// 商品编码
            ];

            $param['skus'][] = $tmp_sku;
        }

        return $this->sendRequestWithToken($url, $param);
    }

    /**
     * 获取商品列表
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/get_spu_list.html
     * @param array $condition 条件 注意：目前只能搜到到status=5的已上架商品
     * @param int $page 页码
     * @param int $page_size 每页数量(不超过10,000)
     * @return mixed
     */
//    public function searchSpuList(array $condition = [], int $page = 1, int $page_size = 10000)
//    {
//        $url = $this->getUrl(__FUNCTION__);
//
//        $param = [
//            'keyword' => $condition['keyword']??'', // 商品标题，模糊搜索
//            'page' => $page,
//            'page_size' => $page_size,
//            'source' => $condition['source']??'', // 默认1, 1: 小商店自营商品, 2:带货商品
//        ];
//        if (isset($condition['status'])) {
//            $param['status'] = $condition['status']; // 商品状态,目前只能搜到到status=5的已上架商品
//        }
//
//        return $this->sendRequestWithToken($url, $param);
//
//    }

    /**
     * 获取商品
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/get_spu.html
     * @param array $condition 条件
     * @return mixed
     */
    public function getSpu(array $condition = [])
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'product_id' => $condition['product_id'] ?? '', //交易组件平台内部商品ID，与out_product_id二选一
            'out_product_id' => $condition['out_product_id'] ?? '', //商家自定义商品ID，与product_id二选一
            'need_edit_spu' => $condition['need_edit_spu'] ?? 0, // 默认0:获取线上数据, 1:获取草稿数据
        ];

        return $this->sendRequestWithToken($url, $param);

    }

    /**
     * 删除商品
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/del_spu.html
     * @param string $out_product_id 商家自定义商品ID，与product_id二选一
     * @param string $product_id 交易组件平台内部商品ID，与out_product_id二选一
     * @return mixed
     */
    public function delSpu(string $out_product_id = '', string $product_id = '')
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'product_id' => $product_id ?? '', //交易组件平台内部商品ID，与out_product_id二选一
            'out_product_id' => $out_product_id ?? '', //商家自定义商品ID，与product_id二选一
        ];

        return $this->sendRequestWithToken($url, $param);
    }

    /**
     * 获取SPU草稿状态
     * @return string[]
     */
    public function getSpuEditStatus(): array
    {
        return [
            1 => '未审核',
            2 => '审核中',
            3 => '审核失败',
            4 => '审核成功',
        ];
    }

    /**
     * 获取SPU审核状态
     * @return string[]
     */
    public function getSpuStatus(): array
    {
        return [
            0 => '',
            5 => '上架',
            11 => '自主下架',
            13 => '违规下架/风控系统下架',
        ];
    }

    /**
     * 生成订单
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/order/add_order.html
     * @param array $order 订单信息
     * @return mixed
     */
    public function addOrder(array $order)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'create_time' => $order['create_time'] ?? '', //创建时间
            'out_order_id' => $order['out_order_id'] ?? '', //商家自定义订单ID
            'openid' => $order['openid'] ?? '/pages/order.html', //用户的openid
            'path' => $order['path'] ?? '', //商家小程序该订单的页面path，用于微信侧订单中心跳转
            'scene' => $order['scene'] ?? 1177, //下单时小程序的场景值，可通getLaunchOptionsSync或onLaunch/onShow拿到
            'out_user_id' => $order['out_user_id'] ?? '',
            'dg_id' => $order['dg_id'] ?? '', // 导购ID

            'order_detail' => [
                "pay_info" => [
                    "pay_method_type" => $order['pay_method_type'] ?? 0,       // 0: 微信支付, 1: 货到付款, 2: 商家会员储蓄卡（默认0）
                    "prepay_id" => $order['pay_method_type'] ?? '', // pay_method_type = 0时必填
                    "prepay_time" => $order['prepay_time'] ?? date('Y-m-d H:i:s')
                ],

                "price_info" => [         // 注意价格字段的单价是分，不是元
                    "order_price" => $order['order_price'] ?? 0, // 该订单最终的实付金额（单位：分），order_price = 商品总价 + freight + additional_price - discounted_price
                    "freight" => $order['order_price'] ?? 0,// 运费（单位：分）
                    "discounted_price" => $order['order_price'] ?? 0, // 优惠金额（单位：分）
                    "additional_price" => $order['order_price'] ?? 0, // 附加金额（单位：分）
                    "additional_remarks" => $order['order_price'] ?? '', // 附加金额备注
                ],

                "remark_info" => [
                    "buyer_message" => $order['buyer_message'] ?? '', // 买家留言
                    "trade_memo" => $order['trade_memo'] ?? '', // 卖家备注
                ],


            ],
            "delivery_detail" => [
                'delivery_type' => $order['delivery_type'] ?? 1, // 1: 正常快递, 2: 无需快递, 3: 线下配送, 4: 用户自提
            ],

            "address_info" => [ // 地址信息，delivery_type = 2 无需设置, delivery_type = 4 填写自提门店地址
                "receiver_name" => $order['receiver_name'] ?? '', // 收件人姓名
                "detailed_address" => $order['detailed_address'] ?? '', // 详细收货地址信息
                "tel_number" => $order['tel_number'] ?? '', // 收件人手机号码
//                    "country" => $order['country']??'',
//                    "province" => $order['province']??'',
//                    "city" => $order['city']??'',
//                    "town" => $order['town']??''
            ],

        ];

        foreach ($order['product_infos'] as $product) {
            $param['order_detail']['product_infos'][] = [
                "out_product_id" => $product['output_product_id'] ?? '', // 商家自定义商品ID
                "out_sku_id" => $product['out_sku_id'] ?? '', //  商家自定义商品skuID，可填空字符串（如果这个product_id下没有sku）
                "product_cnt" => $product['product_cnt'] ?? 1, // 购买的数量
                "sale_price" => $product['sale_price'] ?? 100,   //生成这次订单时商品的售卖价，可以跟上传商品接口的价格不一致
                "real_price" => $product['real_price'] ?? 100,  // 扣除优惠后单件sku的分摊价格（单位：分），如果没优惠则与sale_price一致
                "path" => $product['path'] ?? '',
                "title" => $product['title'] ?? '',
                "head_img" => $product['head_img'] ?? 'https://cdn.dribbble.com/users/24613/screenshots/2560681/media/039f68d2e7cc988e0aa9c4fd852b073a.gif' // 生成订单时商品的头图
            ];
        }
        return $this->sendRequestWithToken($url, $param);
    }

    /**
     * 同步订单支付结果
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/order/pay_order.html
     * @param array $order 订单信息
     * @return mixed
     */
    public function payOrder(array $order)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'order_id' => $order['order_id'] ?? '', // 订单ID
            'out_order_id' => $order['out_order_id'] ?? '', // 商家自定义订单ID，与 order_id 二选一
            'openid' => $order['openid'] ?? '', // 用户的openid
            'action_type' => $order['action_type'] ?? 1, // 类型，默认1:支付成功,2:支付失败,3:用户取消,4:超时未支付;5:商家取消;10:其他原因取消
            'action_remark' => $order['action_remark'] ?? '', // 其他具体原因
            'transaction_id' => $order['transaction_id'] ?? '', // 支付订单号，action_type=1且order/add时传的pay_method_type=0时必填
            'pay_time' => $order['pay_time'] ?? '', // 支付完成时间，action_type=1时必填
        ];

        return $this->sendRequestWithToken($url, $param);

    }

    /**
     * 获取订单详情
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/update_info.html
     * @param string $out_order_id 商家自定义订单ID
     * @param string $openid 用户的openid
     * @return mixed
     */
    public function getOrder(string $out_order_id, string $openid)
    {
        $url = $this->getUrl(__FUNCTION__);
        $param = [
            'out_order_id' => $out_order_id,
            'openid' => $openid
        ];

        return $this->sendRequestWithToken($url, $param);
    }

    /**
     * 获取快递公司列表
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/delivery/get_company_list.html
     * @return mixed
     */
    public function getDeliveryCompanyList()
    {
        $key = 'delivery_company_list';
        if (!$data = WeMiniCache::get($key)) {
            $url = $this->getUrl(__FUNCTION__);
            $data = $this->sendRequestWithToken($url);

            if ($data) {
                WeMiniCache::set($key, $data, 80000);
            }
        }

        return $data['company_list'];

    }

    /**
     * 订单发货
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/delivery/send.html
     * @param array $delivery 物流信息
     * @return mixed
     */
    public function sendDelivery(array $delivery)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'order_id' => $delivery['order_id'] ?? '', // 订单ID
            'out_order_id' => $delivery['out_order_id'] ?? '', // 商家自定义订单ID，与 order_id 二选一
            'openid' => $delivery['openid'] ?? '', // 用户的openid
            'finish_all_delivery' => $order['finish_all_delivery'] ?? 1, // 发货完成标志位, 0: 未发完, 1:已发完

            'delivery_list' => [
                [
                    'delivery_id' => $delivery['delivery_id'], // 快递公司ID，通过获取快递公司列表获取
                    'waybill_id' => $delivery['waybill_id'], // 快递单号
                ]
            ],

        ];
        return $this->sendRequestWithToken($url, $param);
    }

    /**
     * 订单确认收货
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/delivery/recieve.html
     * @param string $out_order_id 商家自定义订单ID
     * @param string $openid 用户的openid
     * @return mixed
     */
    public function recieveDelivery(string $out_order_id, string $openid)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'out_order_id' => $out_order_id, // 商家自定义订单ID，与 order_id 二选一
            'openid' => $openid, // 用户的openid
        ];
        return $this->sendRequestWithToken($url, $param);
    }


    /**
     * 创建售后
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/aftersale/add.html
     * @param array $aftersale 售后信息
     * @return mixed
     */
    public function addAftersale(array $aftersale)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'out_order_id' => $aftersale['out_order_id'] ?? '', // 商家自定义订单ID，与 order_id 二选一
            'openid' => $aftersale['openid'] ?? '', // 用户的openid
            'out_aftersale_id' => $aftersale['finish_all_delivery'] ?? '', // 商家自定义售后ID
            'path' => $aftersale['path'] ?? '', // 商家小程序该售后单的页面path，不存在则使用订单path
            'refund' => $aftersale['refund'] ?? 1, // 退款金额,单位：分
            'type' => $aftersale['type'] ?? 2, // 售后类型，1:退款,2:退款退货,3:换货
            'create_time' => $aftersale['create_time'] ?? '', // 发起申请时间，yyyy-MM-dd HH:mm:ss
            'status' => $aftersale['status'] ?? 0, // 0:未受理,1:用户取消,2:商家受理中,3:商家逾期未处理,4:商家拒绝退款,5:商家拒绝退货退款,6:待买家退货,7:退货退款关闭,8:待商家收货,11:商家退款中,12:商家逾期未退款,13:退款完成,14:退货退款完成,15:换货完成,16:待商家发货,17:待用户确认收货,18:商家拒绝换货,19:商家已收到货
            'finish_all_aftersale' => $aftersale['finish_all_aftersale'] ?? 0,// 0:订单可继续售后, 1:订单无继续售后
            'product_infos' => [

            ],
            'refund_reason' => $aftersale['refund_reason'] ?? '', //退款原因
            'refund_address' => $aftersale['refund_address'] ?? '', //买家收货地址
            'orderamt' => $aftersale['orderamt'] ?? 0, //退款金额??


        ];

        foreach ($aftersale['product_infos'] as $product) {
            $param['product_infos'][] = [
                'out_product_id' => $product['out_product_id'] ?? '', //商家自定义商品ID
                'out_sku_id' => $product['out_sku_id'] ?? '', //商家自定义sku ID, 如果没有则不填
                'product_cnt' => $product['product_cnt'] ?? 1, //参与售后的商品数量
            ];
        }
        return $this->sendRequestWithToken($url, $param);
    }

    /**
     * 订单确认收货
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/aftersale/update.html
     * @param array $aftersale 售后信息
     * @return mixed
     */
    public function updateAftersale(array $aftersale)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'out_order_id' => $aftersale['out_order_id'] ?? '', // 商家自定义订单ID，与 order_id 二选一
            'openid' => $aftersale['openid'] ?? '', // 用户的openid
            'status' => $aftersale['status'] ?? '', // 0:未受理,1:用户取消,2:商家受理中,3:商家逾期未处理,4:商家拒绝退款,5:商家拒绝退货退款,6:待买家退货,7:退货退款关闭,8:待商家收货,11:商家退款中,12:商家逾期未退款,13:退款完成,14:退货退款完成,15:换货完成,16:待商家发货,17:待用户确认收货,18:商家拒绝换货,19:商家已收到货
            'finish_all_aftersale' => $aftersale['finish_all_aftersale'] ?? 0,//0:售后未结束, 1:售后结束且订单状态流转
        ];
        return $this->sendRequestWithToken($url, $param);
    }

    /**
     * 获取订单下售后单
     * @link https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/aftersale/get.html
     * @param string $out_order_id 商家自定义订单ID
     * @param string $openid 用户的openid
     * @return mixed
     */
    public function getAftersale(string $out_order_id, string $openid)
    {
        $url = $this->getUrl(__FUNCTION__);

        $param = [
            'out_order_id' => $out_order_id, // 商家自定义订单ID，与 order_id 二选一
            'openid' => $openid, // 用户的openid
        ];
        return $this->sendRequestWithToken($url, $param);
    }


    /**
     * 获取接口URL
     * @param string $method 方法名称
     * @return string
     */
    private function getUrl(string $method)
    {
        return ApiUrl::SHOP . '/' . ApiUrl::SHOP_URI[$method];
    }


}