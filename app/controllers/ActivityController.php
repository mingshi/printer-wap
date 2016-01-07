<?php
/**
 * @FileName    :   ActivityController.php
 * @QQ          :   224156865
 * @date        :   2016/01/07 23:51:30
 * @link
 * @Auth        :   Mingshi <fivemingshi@gmail.com>
 */

class ActivityController extends BaseController
{
    public function lists()
    {
        $data = callApi('1.0/activity/list', []);
        $result = [];
        $msg = '';
        if ($data->status == 'success') {
            if (!empty($data->result)) {
                foreach ($data->result as $a) {
                    if ($a->expire > date('Y-m-d H:i:s')) {
                        $result['active'][] = $a;
                    } else {
                        $result['stop'][] = $a;
                    }
                }
            } else {
                $msg = '没有数据';
            }
        } else {
            $msg = $data->message;
        }

        return View::make('activity.list', [
                'lists' =>  $result,
                'msg'   =>  $msg,
                'pageTitle' =>  '活动列表'
            ]);
    }

    public function info()
    {
        $msg = '';
        $activity_id = Input::get('id', 0);
        $data = [];
        $res = callApi('1.0/activity/info', ['activity_id' => $activity_id]);
    
        if ($res->status == 'success') {
            $data = $res->result;
        } else {
            $msg = $res->message;
        }

        return View::make('activity.info', [
                'data'  =>  $data,
                'msg'   =>  $msg,
                'pageTitle' =>  '活动详情'
            ]);
    }
}

