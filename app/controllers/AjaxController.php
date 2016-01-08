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
        $album_id = Input::get('album_id', 0);

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

        $user_id = Cookie::get('user_id', 0);
        if (empty($album_id)) {
            try {
                $r = callApi('1.0/album/create', ['user_id' => $user_id, 'class_id' => $class_id, 'template_id' => $template_id]);
                if ($r->status == 'success') {
                    $album_id = $r->result->id;
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
                'source'    =>  $source,
                'template_id'   =>  $template_id
                ]);

            if ($res->status == 'success') {
                $result['status'] = 'success';
                $result['result'] = $res->result;
                $result['album_id'] = $album_id;
                echo json_encode($result);exit;
            } else {
                $result['status'] = 'err';
                $result['msg'] = $res->message;
                echo json_encode($result);exit;
            }
        } catch (Exception $e) {
                $result['status'] = 'err';
                $result['msg'] = '创建图片记录失败';
                echo json_encode($result);exit;
        }

        echo json_encode($result);exit;
    }
    
    public function del_image()
    {
        $ids = Input::get('ids', '');
        $ids = trim($ids, ',');
        $user_id = Cookie::get('user_id', 0); 
        
        $res = callApi('1.0/my/del/image', ['user_id' => $user_id, 'ids' => $ids]);
        $result = [];
        if ($res->status == 'success') {
            $result['status'] = 'success';
        } else {
            $result['status'] = 'err';
            $result['msg'] = $res->message;
        }

        echo json_encode($result);exit;
    }

    public function createOrder()
    {
        $params = Input::all();
        $params['user_id'] = Cookie::get('user_id', 0);
        
        $result = [];
        try { 
            $data = callApi('1.0/my/create/order', $params);

            if ($data->status == 'success') {
                $result['status'] = 'success';
            } else {
                $result['status'] = 'err';
                $result['msg'] = $data->message;
            }
        } catch (Exception $e) {
            $result['status'] = 'err';
            $result['msg'] = '订单创建失败';
        }

        echo json_encode($result);exit;
    }
    
    public function createPay()
    {
        $id = Input::get('id', 0);
        $user_id = Cookie::get('user_id', 0);
        $openid = Cookie::get('open_id', '');
        $result = [];
        try {
            $res = callApi('1.0/pay/create', ['order_id' => $id, 'user_id' => $user_id, 'open_id' => $openid]);
            if ($res->status == 'success') {
                $result['status']  = 'success';
                $result['result']  = $res->result;
                echo json_encode($result);exit;
            } else {
                $result['status'] = 'err';
                $result['msg'] = $res->message;
                echo json_encode($result);exit;
            }
        } catch (Exception $e) {
            $result['status']  = 'err';
            $result['message'] = '创建支付订单出错';
            echo json_encode($result);exit;           
        }
    } 
}

