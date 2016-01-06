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
        
        $view = View::make('make.classes', [
            'msg'   =>  $msg,
            'lists' =>  $lists,
            'pageTitle' =>  '选择分类',
        ]);
        
        Session::put('album_id', 0);
        return Response::make($view);
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

        $view = View::make('make.templates', [
                'msg'   =>  $msg,
                'lists' =>  $lists,
                'sources'   =>  $sources,
                'pageTitle' =>  '选择模板'
            ]);
        return Response::make($view);
    }

    public function image()
    {
        $msg = '';
        $image_id = Input::get('id', 0);

        $image_info = callApi('1.0/album/image/info', ['image_id' => $image_id]);

        if ($image_info->status && !empty($image_info->result->image) && !empty($image_info->result->template) && !empty($image_info->result->class))   {
            $data = $image_info->result;
        } else {
            $msg = '获取数据错误';
        }
        
        return View::make('make.image', [
                'msg'   =>  $msg,
                'pageTitle' =>  '制作照片', 
                'data'  =>  $data,
            ]);
    }

}
