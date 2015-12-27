<?php
/**
 * @FileName    :   MakeController.php
 * @QQ          :   224156865
 * @date        :   2015/12/27 20:59:48
 * @link
 * @Auth        :   Mingshi <fivemingshi@gmail.com>
 */

class MakeController extends BaseController
{
    public function start()
    {
        return View::make('make.start', [
            'pageTitle' =>  '开始制作',
            ]);
    }

    public function classes()
    {
        $msg = '';
        $data = callApi('1.0/album/class/list', []);
        
        $lists = [];
        if ($data->status == 'success') {
            $lists = $data->result;
        } else {
            $msg = $data->message;
        }

        return View::make('make.classes', [
            'msg'   =>  $msg,
            'lists' =>  $lists,
            'pageTitle' =>  '选择分类',
        ]);
    }
}
