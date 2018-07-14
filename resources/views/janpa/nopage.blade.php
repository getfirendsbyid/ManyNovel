<!DOCTYPE html>
<!-- saved from url=(0024)http://123123.janpn.com/ -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Not Found</title>
    <meta name="robots" content="noindex,nofllow">
    <meta name="baidu-deadlink" value="1">
    <link href="{{url('janpa/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('janpa/bootstrap-theme.min.css')}}" rel="stylesheet">
    <link href="{{url('janpa/list.css')}}" rel="stylesheet">
</head>
<body style="background:url(/janpa/bg35.jpg) fixed center center no-repeat;width:100%;margin:0 auto; padding:0 5px;">

<!---404-->
<div class="ad-1160px" style="color:#fff;text-align:center; margin:30px auto 20px;">
    <p style=""> 404 Not Found </p>
    <p style="">温馨提示：该网页已删除！推荐您访问以下栏目！</p>
</div>
<!--//404s--->

<!---m404-->
<div class="ad-480px" style="color:#fff;text-align:center; margin:10px auto 10px;">
    <p style=""> 404 Not Found </p>
    <p style="">温馨提示：该网页已删除！推荐您访问以下栏目！</p>
</div>
<!--//m404s--->

<div class="clear"></div>

<!--广告-->
<!--//广告-->

<div style="max-width:800px; margin:10px auto 100px; font-size:2em;">

    @foreach($nav as $item)
        <p class="janpn404"><a class="btn btn-lg btn-primary btn-block" href="http://www.{{$host}}/{{$item->enname}}/">{{$item->name}}</a></p>
    @endforeach

</div>

<div class="clear"></div>

<!--广告-->
<!--//广告-->

<p style="width:150px; text-align:center; margin:0 auto 30px;">
    <a href="http://www.{{$host}}/" class="btn btn-lg btn-primary btn-block" target="_blank" rel="nofollow"> 返回首页 </a>
</p>


</body>
</html>