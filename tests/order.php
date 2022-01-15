<?php

include '../vendor/autoload.php';

use WeMiniGrade\WeMiniGrade;

try {

    $cache_config = [
        'cache_type' => 'redis',
        'cache_time' => 100,
        'namespace' => 'weminicache_wx55081514835ce890',
        'cache_redis_host' => 'localhost'
    ];
    $wechat = new WeMiniGrade('wx55081514835ce890', '21c94af8487a75d71013a157597cba32', $cache_config);

    $order = [
        'create_time' => $order['create_time'] ?? '2021-11-10 11:38:01', //创建时间
        'out_order_id' => $order['out_order_id'] ?? '14256327878', //商家自定义订单ID
        'openid' => $order['openid'] ?? 'oqvFF5UH35S0-aUZSQyKR0WZqmis', //用户的openid
        'path' => $order['path'] ?? '', //商家小程序该订单的页面path，用于微信侧订单中心跳转
        'scene' => $order['scene'] ?? 1177, //下单时小程序的场景值，可通getLaunchOptionsSync或onLaunch/onShow拿到
        'out_user_id' => $order['out_user_id'] ?? '13071',
        'dg_id' => $order['dg_id'] ?? '', // 导购ID

        'product_infos' => [
            [
                "out_product_id" => "104688", // 商家自定义商品ID
                "out_sku_id" => "104688", //  商家自定义商品skuID，可填空字符串（如果这个product_id下没有sku）
                "product_cnt" => 1, // 购买的数量
                "sale_price" => 1,   //生成这次订单时商品的售卖价，可以跟上传商品接口的价格不一致
                "real_price" => 1,  // 扣除优惠后单件sku的分摊价格（单位：分），如果没优惠则与sale_price一致
                "path" => "pages/productDetail/productDetail?productId=2176180",
                "title" => "测试商品",
                "head_img" => "http://upload.goushihui168.com/mall/store/goods/1/1_06778723020807467_240.jpg" // 生成订单时商品的头图
            ]
        ],
        "pay_method_type" => $order['pay_method_type'] ?? 0,       // 0: 微信支付, 1: 货到付款, 2: 商家会员储蓄卡（默认0）
        "prepay_id" => $order['pay_method_type'] ?? 'wx101138018150167f4eb65607cdb3390000', // pay_method_type = 0时必填
        "prepay_time" => $order['prepay_time'] ?? '2021-11-10 11:38:01',


        "order_price" => $order['order_price'] ?? 1, // 该订单最终的实付金额（单位：分），order_price = 商品总价 + freight + additional_price - discounted_price
        "freight" => $order['order_price'] ?? 0,// 运费（单位：分）
        "discounted_price" => $order['order_price'] ?? 0, // 优惠金额（单位：分）
        "additional_price" => $order['order_price'] ?? 0, // 附加金额（单位：分）
        "additional_remarks" => $order['order_price'] ?? '', // 附加金额备注

        'delivery_type' => $order['delivery_type'] ?? 1, // 1: 正常快递, 2: 无需快递, 3: 线下配送, 4: 用户自提

        "receiver_name" => $order['receiver_name'] ?? '庞鹤峰', // 收件人姓名
        "detailed_address" => $order['detailed_address'] ?? '河南 洛阳市 洛龙区 东方今典观澜小区', // 详细收货地址信息
        "tel_number" => $order['tel_number'] ?? '18937901565', // 收件人手机号码
        "country" => $order['country'] ?? '中国',
        "province" => $order['province'] ?? '河南省',
        "city" => $order['city'] ?? '洛阳市',
        "town" => $order['town'] ?? '洛龙区',
        "buyer_message" => $order['buyer_message'] ?? '买家留言', // 买家留言
        "trade_memo" => $order['trade_memo'] ?? '卖家备注', // 卖家备注
    ];

//    dd($wechat->Shop()->addOrder($order));

    $wechat_order = [
        'order_id' => '2129420644017553409',
        'out_order_id' => '14256327878',
        'openid' => 'oqvFF5UH35S0-aUZSQyKR0WZqmis',
        'action_type' => 1,
        'transaction_id' => '4200001203202111100012276460',
        'pay_time' => '2021-11-10 11:38:09',
        'action_remark' => '',
        'final_price' => '11380',
        'ticket' => '8ad88524-181f-4439-8d2b-14142cba062c',
        'ticket_expire_time' => '2021-11-11 10:55:19',
    ];

//    dd($wechat->Shop()->payOrder($wechat_order));

//    print_r($wechat->Shop()->getOrder('14256327878', 'oqvFF5UH35S0-aUZSQyKR0WZqmis'));

//    dd($wechat->Shop()->getDeliveryCompanyList());

    $delivery = [
        'out_order_id' => '14256327878',
        'openid' => 'oqvFF5UH35S0-aUZSQyKR0WZqmis',
        'finish_all_delivery' => 1,
        'delivery_id' => 'YTO',
        'waybill_id' => 'YT6043285545491',
    ];
//    dd($wechat->Shop()->sendDelivery($delivery));
//    dd($wechat->Shop()->recieveDelivery($delivery['out_order_id'], $delivery['openid']));

    $aftersale = [
        'out_order_id' => $aftersale['out_order_id'] ?? '14256327878', // 商家自定义订单ID，与 order_id 二选一
        'openid' => $aftersale['openid'] ?? 'oqvFF5UH35S0-aUZSQyKR0WZqmis', // 用户的openid
        'out_aftersale_id' => $aftersale['finish_all_delivery'] ?? '1674101211110144802', // 商家自定义售后ID
        'path' => $aftersale['path'] ?? '', // 商家小程序该售后单的页面path，不存在则使用订单path
        'refund' => $aftersale['refund'] ?? 1, // 退款金额,单位：分
        'type' => $aftersale['type'] ?? 1, // 售后类型，1:退款,2:退款退货,3:换货
        'create_time' => $aftersale['create_time'] ?? '2021-11-10 14:49:04', // 发起申请时间，yyyy-MM-dd HH:mm:ss
        'status' => $aftersale['status'] ?? 2, // 0:未受理,1:用户取消,2:商家受理中,3:商家逾期未处理,4:商家拒绝退款,5:商家拒绝退货退款,6:待买家退货,7:退货退款关闭,8:待商家收货,11:商家退款中,12:商家逾期未退款,13:退款完成,14:退货退款完成,15:换货完成,16:待商家发货,17:待用户确认收货,18:商家拒绝换货,19:商家已收到货
        'finish_all_aftersale' => $aftersale['finish_all_aftersale'] ?? 0,// 0:订单可继续售后, 1:订单无继续售后
        'product_infos' => [
            [
//                'out_product_id' => $aftersale['out_product_id'] ?? '104688', //商家自定义商品ID
                'out_sku_id' => $aftersale['out_sku_id'] ?? '104688', //商家自定义sku ID, 如果没有则不填
                'product_cnt' => $aftersale['product_cnt'] ?? 1, //参与售后的商品数量
            ]
        ],
        'refund_reason' => $aftersale['product_cnt'] ?? '不想要了', //退款原因
        'refund_address' => $aftersale['product_cnt'] ?? '', //买家收货地址
        'orderamt' => $aftersale['product_cnt'] ?? 0, //退款金额??
    ];
//    dd($wechat->Shop()->addAftersale($aftersale));

//    dd($wechat->Shop()->getSpuList([], 1, 20));


    dd($wechat->Shop()->getAllOrderList());

//    dd($wechat->Shop()->getOrder('r13957335653'));

} catch (\Exception $ex) {
    echo $ex->getCode() . '...' . $ex->getMessage();
}
