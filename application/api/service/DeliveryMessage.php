<?php
namespace app\api\service;
use app\api\model\User;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;

/**
* 
*/
class DeliveryMessage extends WxMessage
{
	
	const DELIVERY_MSG_ID = "6pqcCLWzcBsW6euLVcYxJ5f5USNq9ksAK6KktHVWcKw";

    /**
     * @param $order
     * @param string $tplJumpPage
     * @return bool
     * @throws OrderException
     * @throws \app\lib\exception\WeChatException
     */
	public function sendDeliveryMessage($order,$tplJumpPage = '')
	{
		if(!$order){
			throw new OrderException();
		}
		$this->tplID = self::DELIVERY_MSG_ID;
		$this->formID = $order->prepay_id;
		$this->page = $tplJumpPage;
		$this->preparMessageData($order);
		$this->emphasisKeyWord = 'keyword2.DATA';
		return parent::sendMessage($this->getUserOpenID($order->user_id));
	}

    /**
     * @param $order
     */
	private function preparMessageData($order)
	{
		$dt = new \DateTime();
		$data = [
			
			'keyword1' => ['value'=>'造舰快递'],
			'keyword2' => ['value'=>$dt->format("Y-m-d H:i")],
			'keyword3' => ['value'=>$order->create_time],
			'keyword4' => ['value'=>$order->snap_name],
			'keyword5' => ['value'=>$order->order_no],
			'keyword6' => ['value'=>'零食商贩'],
			'keyword7' => ['value'=>$order->snap_address],
			'keyword8' => ['value'=>'201100902105'],
			'keyword9' => ['value'=>$order->total_price]
		];
		$this->data = $data;
	}

    private function getUserOpenID($userId){
        $user = User::getUserInfoByID($userId);
        if(!$user){
            throw new UserException();
        }

        return $user->openid;
    }
}