<?php
/**
 * @FileName    :   AjaxController.php
 * @QQ          :   224156865
 * @date        :   2015/12/30 20:15:58
 * @link
 * @Auth        :   Mingshi <fivemingshi@gmail.com>
 */

class AjaxController extends BaseController
{
    public function get_images()
    {
        $template_id = Input::get('template_id', 0);
        $sources = callApi('1.0/album/template/images', ['template_id' => $template_id]);

        $res = [];
        if ($sources->status == 'success' && !empty($sources->result)) {
            $res['status'] = 'success';
            $res['result'] = $sources->result;
        } else {
            $res['status'] = 'err';
            $res['msg'] = '没有数据';
        }

        echo json_encode($res);exit;
    }

    public function save()
    {
        $image_id = Input::get('image_id', 0);
        $template_id = Input::get('template_id', 0);
        $class_id = Input::get('class_id', 0);
        $image_data = Input::get('image_data', '');

        $data_arr = explode(',', $image_data);
        $a = explode('/', $data_arr[0]);
        $b = explode(';', $a[1]);
        
        $blob = base64_decode($data_arr[1]);

        $path = public_path() . '/images/' . md5($blob) . '.' .$b[0];
        file_put_contents($path, $blob);
    }
}

