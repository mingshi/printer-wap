<?php
/**
 * @FileName    :   global_functions.php
 * @QQ          :   224156865
 * @date        :   2015/12/27 22:40:27
 * @link
 * @Auth        :   Mingshi <fivemingshi@gmail.com>
 */

function assets_versioned($path, $secure=null) {
    $file = public_path($path);
    if(file_exists($file)){
        $versionFilePath = '/tmp/web_assets_version';
        if (file_exists($versionFilePath)) {
            $version = file_get_contents($versionFilePath);
            return asset($path, $secure) . '?' . $version;
        }
        return asset($path, $secure) . '?' . filemtime($file);
    }else{
        throw new \Exception('The file "'.$path.'" cannot be found in the public folder');
    }
}

function callApi($action, Array $params, $json = false)
{
    $host = Config::get('app.api_host');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host.$action);
    curl_setopt($ch, CURLOPT_COOKIE, "ganbadie_printer=1");
    curl_setopt($ch, CURLOPT_POST, count($params));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = preg_replace('/^\xEF\xBB\xBF/', '', $result);

    return $json ? $result : json_decode($result);
}

function setUrlMd5()
{
    $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $url_md5_pos = strpos($url, '&md5=');
    if (!$url_md5_pos) {
        $url_md5_pos = strpos($url, '?md5=');
    }
    $url_md5_len = strlen('&md5=') + 6;
    $url_head = substr($url, 0, $url_md5_pos);
    $url_body = strstr($url, $url_md5_len, -1);
    $current_url = $url_head . $url_body;
    $md5_check = substr(md5($current_url), 0, 6);

    return $md5_check;
}

