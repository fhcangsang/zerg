<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/28 0028
 * Time: 9:15
 */
namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\service\Token as TokenService;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
use think\Controller;

class Token extends Controller
{
    /**
     * @param string $code
     * @return array
     * @throws \app\lib\exception\ParameterException
     * @throws \think\Exception
     * 获取token
     */
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return ['token' => $token];
    }

    /**
     * @param string $token
     * @return array
     * @throws ParameterException
     * 检查token
     */
    public function verifyToken($token=''){
        if(!$token){
            throw new ParameterException([
                'msg'=>'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }
}