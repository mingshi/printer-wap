<?php
/**
 * @FileName    :   WxController.php
 * @QQ          :   224156865
 * @date        :   2015/12/28 20:57:08
 * @link
 * @Auth        :   Mingshi <fivemingshi@gmail.com>
 */

class WxController extends BaseController
{
    public function scope_base()
    {
        $code = Input::get('code', '');
        $state = Input::get('state', '');

        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxe7d58fa8d7ae3416&secret=2204083b829c499d245a46849b2befb2&code=" . $code . "&grant_type=authorization_code";

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            $uri = urldecode($state);
            $res = json_decode($result, TRUE);
            $open_id = $res['openid'];

            $data = callApi('1.0/user/wx/info', ['wx_id' => $open_id]);
            if ($data->status == 'success') {
                if (!empty($data->result)) {
                    $id_cookie = Cookie::forever('user_id', $data->result->id);
                    $open_id_cookie = Cookie::forever('open_id', $open_id);
                    return Redirect::to($uri)->withCookie($id_cookie)->withCookie($open_id_cookie);;
                } else {
                    return Redirect::route('forbidden');
                }
            } else {
                return Redirect::route('forbidden');    
            }
        } catch (Exception $e) {
            return Redirect::route('forbidden');
        }
    }
}

