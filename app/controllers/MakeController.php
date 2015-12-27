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
        return View::make('make.start');
    }
}

