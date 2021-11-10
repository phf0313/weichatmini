<?php

include '../vendor/autoload.php';

use WeMiniGrade\WeMiniGrade;

try {
//    $cache_config = [
//        'cache_type' => 'file',
//        'cache_dir' => dirname(__DIR__).'/tests/cache/',
//        'namespace' => 'weminicache_wx55081514835ce890',
//        'cache_time' => 100
//    ];

    $cache_config = [
        'cache_type' => 'redis',
        'cache_time' => 100,
        'namespace' => 'weminicache_wx55081514835ce890',
        'cache_redis_host' => 'localhost'
    ];
    $wechat = new WeMiniGrade('wx55081514835ce890', '21c94af8487a75d71013a157597cba32', $cache_config);

    // get access token
//    $access_token = $wechat->Base()->getAccessToken();
//    echo $access_token;

//    echo json_encode(($wechat->Shop()->checkRegister()));
//    echo json_encode(($wechat->Shop()->finishRegister(6)));
//    dd($wechat->Shop()->appleScene(1));

//    echo json_encode($cat = $wechat->Shop()->getCatList());

//    dd(($wechat->Shop()->getAccountCatList()));
//    dd(($wechat->Shop()->getAccountBrandList()));
//    dd(($wechat->Shop()->updateAccount('', '18937901565')));

//    dd($wechat->Shop()->updateAccount('home/index/index', '0379-66778866'));
//    $goods = array(
//        'out_product_id' => '105017',
//        'title' => '爱媛橙 约5斤/箱',
//        'path' => 'home/goods/detailed?goods_id=105017',
//        'head_img' => [
//            'http://upload.goushihui168.com/mall/store/goods/1/1_06887585560416156_720.jpg',
//            'http://upload.goushihui168.com/mall/store/goods/1/1_06887585579436865_720.jpg'
//        ],
//        'qualification_pics' =>
//            array(),
//        'desc_info' =>
//            array(
//                'desc' => '',
//                'imgs' => [
//                    'http://upload.goushihui168.com/mall/store/goods/1/1_06887585208830502_1280.jpg',
//                    'http://upload.goushihui168.com/mall/store/goods/1/1_06887585257687350_1280.jpg',
//                    'http://upload.goushihui168.com/mall/store/goods/1/1_06887585313864634_1280.jpg',
//                    'http://upload.goushihui168.com/mall/store/goods/1/1_06887585341055953_1280.jpg'
//                ],
//            ),
//        'third_cat_id' => '6644',
//        'brand_id' => '2100000000',
//        'skus' =>
//            [
//                [
//                    'out_product_id' => '105017',
//                    'out_sku_id' => '105017',
//                    'thumb_img' => 'http://upload.goushihui168.com/mall/store/goods/1/1_06887585560416156_720.jpg',
//                    'sale_price' => 1000,// 售卖价格,以分为单位
//                    'market_price' => 2000,// 市场价格,以分为单位
//                    'stock_num' => 10,// 库存
//                    'barcode' => '',// 条形码
//                    'sku_code' => '0100000',// 商品编码
//                ]
//            ],
//        'express_fee' => 300,
//        'sell_time' => '',
//        'pick_up_type' => [1],
//        'onsale' => 1,
//    );
//    dd($wechat->Shop()->addSpu($goods));
//    dd($wechat->Shop()->onlineOfflineSpu(1,'105017'));



} catch (\Exception $ex) {
    echo $ex->getCode() . '...' . $ex->getMessage();
}

