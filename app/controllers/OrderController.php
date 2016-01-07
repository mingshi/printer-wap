<?php
/**
 * @FileName    :   OrderController.php
 * @QQ          :   224156865
 * @date        :   2016/01/07 15:44:59
 * @link
 * @Auth        :   Mingshi <fivemingshi@gmail.com>
 */

class OrderController extends BaseController
{
    public function create()
    {
        $user_id = Cookie::get('user_id', 0);
        $user_id = 9;//TODO
        $album_id = Input::get('album_id', 0);

        $user_info = [];
        $user = callApi('1.0/user/info', ['user_id' => $user_id]);
        if ($user->status == 'success') {
            $user_info = $user->result;
        } else {
            $msg = $user->message;
        }

        return View::make('order.create', [
            'album_id'  =>  $album_id,
            'user'  =>  $user_info
        ]);
    }

}

