<?php
namespace app\api\service;
use app\lib\exception\WeChatException;
use think\Exception;

class WxMessage{
	private $sendUrl = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=%s';//小程序发送消息模板url
	private  $touser;
	private  $color = 'black';

	protected  $tplID;

	protected  $formID;
	protected  $page;
	protected  $emphasisKeyWord;
	protected  $data;

    /**
     *
     */
	public function __construct(){
		$accessToken = new AccessToken();
		$token = $accessToken->get();
		$this->sendUrl = sprintf($this->sendUrl,$token);
	}

    /**
     * @param $openid
     * @return bool
     * @throws WeChatException
     */
    public function sendMessage($openid){
        $data = [
            'touser' => $openid,
            'template_id' =>$this->tplID,
            'page' => $this->page,
            'form_id'=>$this->formID,
            'data' => $this->data,
//            'color' => $this->color,
            'emphasis_keyword' => $this->emphasisKeyWord,
        ];

        $result = curl_post($this->sendUrl,$data);
        $result = json_decode($result,true);
        if($result['errcode'] == 0){
            return true;
        }else{
//            throw new Exception('模板消息发送失败：'.$result['errmsg']);
            throw new WeChatException([
                'msg' =>'模板消息发送失败：'.$result['errmsg'],
                'errorCode' => $result['errcode']

            ]);
        }
    }
}