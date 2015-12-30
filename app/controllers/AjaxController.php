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
}

