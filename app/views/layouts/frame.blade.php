<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0; user-scalable=no;"/>
  <meta name="apple-mobile-web-app-capable" content="no" />
  <meta content="telephone=no" name="format-detection" />
  <meta name="description" content="{{ @$pageDescription }}" />
<!--  <meta name="apple-mobile-web-app-status-bar-style" content="black">-->
  <title>{{ @$pageTitle }}</title>
  <link rel="stylesheet" href="/jqueryMobile/jquery.mobile-1.4.5.min.css"/>
  <link rel="stylesheet" href="/css/normalize.css"/>
  <link rel="stylesheet" href="/css/common.css"/>
  {{--<link rel="apple-touch-icon" href="" />--}}
  @yield('css')
  <style>
    .msg {
        background-color: #000;
        border-radius: 0.3125em;
        color: #fff;
        font-size: 1em;
        /*margin: -16em auto auto*/;
        margin: 0 auto;
        opacity: 0.8;
        text-align: center;
        text-shadow: none;
        line-height: 2.2em;
        padding-left: 10px;
        padding-right: 10px;
        position:fixed;
        width: 60%;
        left: 20%;
        top: 50%;
        z-index: 9;
    }
  </style>
</head>
<body>
  <section>
    @yield('content')
    <div id="msg" class="msg" style="display: none;">
        {{ @$msg }}
    </div>
  </section>

<script src="/js/jquery-1.10.2.min.js"></script>
<script src="/jqueryMobile/jquery.mobile-1.4.5.min.js"></script>
<script src="/lazyLoad/jquery.lazyload.min.js"></script>
@yield('js')

<script type="text/javascript">
    //$(document).ajaxStart(function() {
    //    $.mobile.loading('show');
    //});

    //$(document).ajaxStop(function() {
    //    $.mobile.loading('hide');
    //});

    $(function(){
      $("img.lazy").lazyload({
        effect:'fadeIn',
      });
      if ("{{ @$msg }}" != '') {
        $('#msg').fadeIn(1000);
        setTimeout(function() {$('#msg').fadeOut(1000);}, 2000);
      }
    });
</script>
</body>
</html>
