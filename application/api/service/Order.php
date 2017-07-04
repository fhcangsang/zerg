<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/4 0004
 * Time: 9:38
 */

namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

class Order
{
    //订单的商品列表，也就是客户端传过来的products参数
    protected $oProducts;
    //数据库取出的商品信息
    protected $products;

    protected $uid;

    public function place($uid, $oProducts)
    {
        $this->oProducts = $oProducts;
        $this->uid = $uid;
        $this->products = $this->getProductsByOrder($oProducts);
        $status = $this->getOrderStatus();
        if(!$status['pass']){//订单检测不通过
            $status['order_id'] = -1;
            return $status;
        }
        //创建订单
    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'pStatusArray' => []
        ];
        foreach ($this->oProducts as $product) {
            $pStatus = $this->getProductStatus($product['product_id'],$product['count'],$this->products);
            if(!$pStatus['haveStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            array_push($status['pStatusArray'],$pStatus);
        }
        return $status;
    }

    /**
     * 设置单个商品的状态
     * @param $oPID -订单中某个商品的 product_id-
     * @param $oCount -订单中某个商品的购买数量-
     * @param $products -数据库查询出的商品-
     * @return array
     * @throws OrderException
     */
    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];
        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }
        if ($pIndex == -1) {
            throw new OrderException([
                'msg' => 'id为' . $oPID . '的商品不存在，创建订单失败'
            ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['count'] = $oCount;
            $pStatus['name'] = $product['name'];
            $pStatus['totalPrice'] = $product['price'] * $oCount;
            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }


    /**
     * 根据订单信息获取商品信息
     * @param $oProducts
     * @return mixed
     */
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        $products = Product::all($oPIDs)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();
        return $products;
    }

}