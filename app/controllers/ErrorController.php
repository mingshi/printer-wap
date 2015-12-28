<?php
/**
 * @FileName    :   ErrorController.php
 * @QQ          :   224156865
 * @date        :   2015/12/28 21:06:11
 * @link
 * @Auth        :   Mingshi <fivemingshi@gmail.com>
 */

class ErrorController extends BaseController
{
    public function forbidden()
    {
        return View::make('errors.403');
    }
}

