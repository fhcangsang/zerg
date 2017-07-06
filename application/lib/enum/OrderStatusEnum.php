<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/6 0006
 * Time: 10:38
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    const UNPAID = 1; //未支付
    const PAID = 2; //已支付
    const DELIVERED = 3; //已发货
    const PAID_BUT_OUT_OF = 4; //已支付，但库存不足
}