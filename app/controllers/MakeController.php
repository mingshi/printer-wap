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

    public function templates()
    {
        $msg = '';
        $class_id = Input::get('id', 0); 
        $lists = callApi('1.0/album/template/list', ['class_id' => $class_id]);

        if ($lists->status == 'error') {
            $msg = $lists->message;
        }

        if (empty($lists->result)) {
            $msg = '没有数据';
        }

        $sources = [];
        if (!empty($lists->result)) {
            $first_temp = $lists->result[0];
            $first_temp_id = $first_temp->id;
            $sources = callApi('1.0/album/template/images', ['template_id' => $first_temp_id]);
            if ($sources->status == 'error') {
                $msg = $sources->message;
            }

            if (empty($sources->result)) {
                $msg = '没有数据';
            }
        }

        return View::make('make.templates', [
                'msg'   =>  $msg,
                'lists' =>  $lists,
                'sources'   =>  $sources,
                'pageTitle' =>  '选择模板'
            ]);
    }

    public function image()
    {
    }
}
