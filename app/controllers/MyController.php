<?php
/**
 * @FileName    :   MyController.php
 * @QQ          :   224156865
 * @date        :   2016/01/07 12:12:10
 * @link
 * @Auth        :   Mingshi <fivemingshi@gmail.com>
 */
class MyController extends BaseController
{
    public function albumList()
    {
        $user_id = Cookie::get('user_id', 0);

        $msg = '';
        $lists = [];
        $data = callApi('1.0/my/album/list', [
            'user_id'   =>  $user_id,
        ]);

        if ($data->status == 'success') {
            if (!empty($data->result)) {
                $lists = $data->result;
            } else {
                $msg = '没有数据';
            }
        } else {
            $msg = $data->message;
        }

        return View::make('my.albumList', [
            'msg'   =>  $msg,
            'lists' =>  $lists,
            'pageTitle' =>  '相册列表'
        ]);
    }

    public function albumInfo()
    {
        $msg = '';
        $user_id = Cookie::get('user_id', 0);
        $album_id = Input::get('id', 0);

        $res = [];
        $data = callApi('1.0/my/album/info', ['user_id' => $user_id, 'album_id' => $album_id]);
        if ($data->status == 'success') {
            $res = $data->result;
            if (empty($res->images))  {
                $msg = '没有数据';
            }
        } else {
            $msg = $data->message;
        }

        return View::make('my.albumInfo', [
            'msg'   =>  $msg,
            'data'  =>  $res,
            'pageTitle' =>  '相册详情'
        ]);
    }

    public function orderList()
    {
        $msg = '';
        $user_id = Cookie::get('user_id', 0);

        $res = [];
        $data = callApi('1.0/my/order/list', ['user_id' =>  $user_id]);
        if ($data->status == 'success') {
            if (empty($data->result)) {
                $msg = '没有数据';
            } else {
                $res = $data->result;
            }
        } else {
            $msg = $data->message;
        }
        
        return View::make('my.orderList', [
            'msg'   =>  $msg,
            'data'  =>  $res,
            'pageTitle' =>  '订单列表',
        ]);
    }
}

