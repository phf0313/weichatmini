<?php

include '../vendor/autoload.php';

use WeMiniGrade\WeMiniGrade;

try {
//    $cache_config = [
//        'cache_type' => 'file',
//        'cache_dir' => dirname(__DIR__).'/tests/cache/',
//        'namespace' => 'weminicache_wx',
//        'cache_time' => 100
//    ];

    $app_id = '';
    $app_secret = '';
    $cache_config = [
        'cache_type' => 'redis',
        'cache_time' => 100,
        'namespace' => 'weminicache_'.$app_id,
        'cache_redis_host' => 'localhost'
    ];

    $wechat = new WeMiniGrade($app_id, $app_secret, $cache_config, ['log_path'=>'\log\wechatmini']);

    $access_token = json_decode(file_get_contents('https://token_url'));

    $wechat->Base()->setAccessToken($access_token->datas->token);

    // get access token
//    $access_token = $wechat->Base()->getAccessToken(1);
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

//    $image = [
//        'resp_type' =>1,
//        'upload_type' => 1,
//        'img_url' => 'https://m.goushihui168.com/Public/image/yingyezhizhao_wap.jpg',
//    ];

//    $image = [
//        'resp_type' =>1,
//        'upload_type' => 0,
//        'media' => 'C:\Users\phf03\Desktop\Temp\shipin.jpg'
//    ];
//    dd(($wechat->Shop()->uploadImage($image)));

//        dd(($wechat->Shop()->getAudit('RQAAAKrxReUQAAAAlFqbYQ')));

//    dd($wechat->Shop()->getSpuList([], 1, 20));
//    dd(($wechat->Shop()->onlineOfflineSpu(1, '100092')));


    $goods = [
        'out_product_id' => '100092',
        'skus' => [
            [
                'out_sku_id' => '100092',
                'sale_price' => 700,
                'market_price' => 800,
                'stock_num' => 100,
                'barcode' => '',
                'sku_code' => '0600054'

            ]
        ],
    ];
    dd(($wechat->Shop()->updateSpuNotAudit($goods)));

} catch (\Exception $ex) {
    echo $ex->getCode() . '...' . $ex->getMessage();
}

