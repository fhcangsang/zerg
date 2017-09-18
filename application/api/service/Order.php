<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/4 0004
 * Time: 9:38
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;
use think\Exception;

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
        //根据用户订单传过来的product_id查找出商品信息
        $this->products = $this->getProductsByOrder($oProducts);
        $status = $this->getOrderStatus();
        if (!$status['pass']) {//订单检测不通过
            $status['order_id'] = -1;
            return $status;
        }
        //创建订单（生成订单快照-->写入数据库生成订单）
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }

    //生成订单
    private function createOrder($snap)
    {
        Db::startTrans();
        try {
            $orderNo = $this->makeOrderNo();
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();
            $orderID = $order->id;
            $createTime = $order->create_time;
            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID; //重组数组 将订单Order_id加入oProducts中
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $createTime
            ];
        } catch (Exception $e) {
            Db::rollback();
            throw $e;
        }
    }

    //生成订单号
    public static function makeOrderNo()
    {
        $yCode = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        $orderSn = $yCode[intval(date('Y') - 2017)] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

    //生成订单快照
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapImg' => '',
            'snapName' => ''
        ];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapImg'] = $this->products[0]['main_img_url'];
        $snap['snapName'] = $this->products[0]['name'];
        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }
        return $snap;
    }

    /**
     * @return array
     * @throws UserException
     * 获取用户地址
     */
    private function getUserAddress()
    {
        $userAddress = (new UserAddress())->where('user_id', '=', $this->uid)->find();
        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户地址不存在，下单失败',
                'errorCode' => 60001
            ]);
        }
        return $userAddress->toArray();
    }

    /**
     * 支付pay用,根据orderID查询出oProduct(用户下单商品)去找出对应的真实商品
     * 然后获取订单状态
     * @param $orderID
     * @return array
     */
    public function checkOrderStock($orderID)
    {
        $orderProduct = new OrderProduct();
        $this->oProducts = $orderProduct->where('order_id','=',$orderID)->select();//根据orderID查询出oProduct(用户下单商品)
        $this->products = $this->getProductsByOrder($this->oProducts); //出对应的真实商品
        $status = $this->getOrderStatus();//获取订单状态
        return $status;
    }

    /**
     * 订单状态,库存检查
     * @return array
     * @throws OrderException
     */
    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    /**
     * 设置单个商品的状态，库存检查
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
            'price' => 0,
            'main_img_url' => '',
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
            $pStatus['price'] = $product['price'];
            $pStatus['main_img_url'] = $product['main_img_url'];
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

    /**
     * @param $orderId
     * @return bool
     * @throws OrderException
     */
    public function delivery($orderId,$jumPage=''){
        $order = \app\api\model\Order::get($orderId);
        if(!$order){
            throw new OrderException();
        }
        if($order->status != OrderStatusEnum::PAID){
            throw new OrderException([
                'msg' => '还没付款呢',
                'errorCode'=>80002,
                'code'=>403
            ]);
        }
        $order->status = OrderStatusEnum::DELIVERED;
        $order->save();
        $delivery = new DeliveryMessage();
        $res = $delivery->sendDeliveryMessage($order,$jumPage);
        return $res;
    }
}