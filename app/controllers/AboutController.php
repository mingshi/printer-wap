<?php
/**
 * @FileName    :   AboutController.php
 * @QQ          :   224156865
 * @date        :   2016/01/07 22:48:34
 * @link
 * @Auth        :   Mingshi <fivemingshi@gmail.com>
 */

class AboutController extends BaseController
{
    public function index()
    {
        return View::make('about.index', [
            'pageTitle' =>  '关于我们'
            ]);
    }

    public function product()
    {
        return View::make('about.product', [
            'pageTitle' =>  '产品介绍',
            ]);
    }
}

