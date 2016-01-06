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

        $result = [
            'status'    =>  'err',
            'msg'       =>  '保存失败',
            ];
        $data_arr = explode(',', $image_data);
        $a = explode('/', $data_arr[0]);
        $b = explode(';', $a[1]);
        
        $blob = base64_decode($data_arr[1]);

        $source = '/images/' . md5($blob) . '.' .$b[0];
        $path = public_path() . '/images/' . md5($blob) . '.' .$b[0];

        //在这里直接把图片保存到磁盘//TODO 
        file_put_contents($path, $blob);

        $album_id = Session::get('album_id', 0);
        $user_id = Cookie::get('user_id', 0);
        if (empty($album_id)) {
            try {
                $r = callApi('1.0/album/create', ['user_id' => $user_id, 'class_id' => $class_id]);
                if ($r->status == 'success') {
                    $album_id = $r->result->id;
                    Session::put('album_id', $album_id); 
                } else {
                    $result['status'] = 'err';
                    $result['msg'] = $r->message;
                    echo json_encode($result);exit;
                }
            } catch (Exception $e) {
                $result['status'] = 'err';
                $result['msg'] = '保存失败';
                echo json_encode($result);exit;
            }
        }

        try {
            $res = callApi('1.0/image/create', [
                'user_id'   =>  $user_id,
                'album_id'  =>  $album_id,
                'source'    =>  $source
                ]);

            if ($res->status == 'success') {
                $result['status'] = 'success';
                $result['result'] = $res->result;
                echo json_encode($result);exit;
            } else {
                $result['status'] = 'err';
                $result['msg'] = '保存图片失败';
                echo json_encode($result);exit;
            }
        } catch (Exception $e) {
                $result['status'] = 'err';
                $result['msg'] = '创建图片记录失败';
                echo json_encode($result);exit;
        }

        echo json_encode($result);exit;
    }

}

